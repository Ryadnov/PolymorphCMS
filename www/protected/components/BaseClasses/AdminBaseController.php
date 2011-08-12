<?php
class AdminBaseController extends Controller
{
	public function init()
	{
		if(Y::isGuest())
			Y::redir(Admin::url('login'));
		if(!Y::checkAccess('moderator'))
			Y::end($this->render('accessDenied'));

        parent::init();

        Y::clientScript()
            ->registerCoreScript('jquery.ui')
            ->registerScriptFile('/js/plugins/jquery.form.js')
//            ->registerScriptFile('/js/plugins/cms/deleteLi.js')
//            ->registerScriptFile('/js/plugins/cms/openLi.js')
//            ->registerScriptFile('/js/plugins/chosen/chosen.js')
//            ->registerCssFile('/js/plugins/chosen/chosen.css')
            ->registerScriptFile('/js/plugins/cms/asc.js');

        if (Yii::app()->request->isAjaxRequest) {
            Y::clientScript()->scriptMap = array(
                'jquery.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.css' => false,

                //treeview
                'jquery.treeview.js' => false,
                'jquery.cookie.js' => false,
                'jquery.treeview.edit.js' => false,
                'jquery.treeview.async.js' => false,

                'jquery.form.js'=>false,
                'asc.js'=>false
            );
        }
	}
	
	public $layout='//layouts/admin';
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function accessRules()
	{
		return array(
	        array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','admin'),
				'roles'=>array('writer'),
			),
			array('deny',  // deny all users
		        'actions'=>array('*'),    
		        'users'=>array('*'),
	        ),
	    );
	}
	
	public function getSystemMenu()
	{
		return array(
		    array('text'=>Admin::link('Категории', 'categories/admin')),
		    array('text'=>Admin::link('Настройки Сайта', 'settings/admin')),
		    array('text'=>Admin::link('Пользователи', 'users/admin')),
			array(
				'text'=>'Списки', 
				'children'=>array(
					array('text'=>Admin::link('Проделанные работы', 'portfolioWorks/admin')),
					array('text'=>Admin::link('Виды деятельности', 'portfolioWorkTypes/admin')),
					array('text'=>Admin::link('Города', 'cities/admin')),
				)
			),
			array('text'=> Users::link('Выход', 'logout'))
		);
	}
	
	public function getCategoryMenu()
	{
		$root = Category::model()->menuRoot('main');
		return $this->getTree($root);
	}
	
	public function getTree($node, $type = null) 
	{
		$children = $node->children()->findAll();
		$res = array();
        
		foreach ($children as $child) {
			$tmp = array();
			$tmp['text'] = ModelFactory::adminViewCategoryLink($child);
			$tmp['active'] = true;
			if($type)
				$tmp['visible'] = $child->type == $type ? true : false ;
			if(!$child->isLeaf())
	 			$tmp['children'] = $this->getTree($child);
	 			
 			$res[] = $tmp;
		}
		
		return $res;
	}
	
	public function getOtherMenus()
	{
		$root = Category::model()->root();
		$root->dbCriteria->mergeWith(array('condition'=>'alias!="main"'));
		$roots = $root->children()->findAll();
		$res = array();
		foreach ($roots as $root) {
			$res[] = array(
				'text' => ModelFactory::adminViewCategoryLink($root),
				'children' => $this->getTree($root)
			);
		}
		return $res;
	}
	
	public function actionUpdate($pk, $otherParams = array()) 
	{
		$model=$this->loadModel($pk, 'update');
		
		$this->performAjaxValidation($model);

		if (isset($_POST[get_class($model)])) {
			$model->attributes = $_POST[get_class($model)];
			
			if (method_exists($this, 'saveRelations'))
				$this->saveRelations($model);
		
			if ($model->save()) 
				$this->redirect($model->adminUrl);	
		}
		
		$opts = CMap::mergeArray($otherParams, array(
			'model' => $model
		));
		
		if (!isset($opts['cat']) && isset($model->category)) 
			$opts['cat'] = $model->category;
	
		$this->render('update', $opts);
	}

	public function actionCreate($catId = null)
	{
		$isCategoryModel = true;
		if ($catId === null)
			$isCategoryModel = false;
		
		if ($isCategoryModel)	
			$cat = Category::model()->findByPk($catId);
		$model=$this->loadModel(null, 'create');
		
		$this->performAjaxValidation($model);

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			
			if ($isCategoryModel)	
				$model->category_id = $cat->pk;
			
			if (method_exists($this, 'saveRelations'))
				$this->saveRelations($model);
				
			if ($model->save())
				$this->redirect($model->adminUrl);
		}
			
		$opts = array('model'=>$model);
    	if ($isCategoryModel)	
			$opts['cat'] = $cat;
    	
		$this->render('create',$opts);
	}

	public function actionDelete($pk)
	{
		// we only allow deletion via POST request
		$model = $this->loadModel($pk);

		//save admin url for redirect
		if (isset($model->adminUrl))
			$adminUrl = $model->adminUrl;
			
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!Y::isAjaxRequest()) {
        	if(isset($_POST['returnUrl'])) 
        		$this->redirect($_POST['returnUrl']);
        	else
        		$this->redirect($adminUrl);
		}
	}
	
	public function actionAdmin($catId = null, $opts = array())
	{
		$isCategoryModel = !($catId === null);
		
		if ($isCategoryModel)	
			$cat = Category::model()->findByPk($catId);
		
		$model = $this->loadModel(null, 'search');
		
		$this->ajaxSetNextValue('published', $model, 'published', array(BaseDataType::PUBLISHED, BaseDataType::NOT_PUBLISHED));
		$model->unsetAttributes();  // clear any default values
		
		if ($isCategoryModel)	
			$model = $model->current($cat);
		
		if (isset($_GET[get_class($model)]))
			$model->attributes=$_GET[get_class($model)];
		
		$opts['model'] = $model;
    	if ($isCategoryModel)	
			$opts['cat'] = $cat;
    	
		if (isset($_GET['ajax'])) {
			$this->renderPartial('admingrid',$opts);
		}else 
    		$this->render('admin',$opts);
	}
	
	public static $tabs = array();
	public static $curTabName;
	
	public function beginTab($tabName)
	{
		ob_start();
		ob_implicit_flush(false);	
		self::$curTabName = $tabName;
	}

	public function endTab() 
	{
		self::$tabs[self::$curTabName] = array('content' => ob_get_contents());
		ob_end_clean();
	}

    public function tab($tabName, $tabContent)
    {
        self::$tabs[$tabName] = $tabContent;
    }

	public function getTabs($id = null, $return = false)
	{
        return Y::controller()->widget(
            'FormTabs', array(
                'tabs'=>self::$tabs,
                'options'=>array(
                    'collapsible'=>false,
                ),
                'id' => $id,
                'htmlOptions' => array('class'=>'widget_settings_tabs', 'style'=>'height:495px'),
                'buttons' => array (
                    $this->widget('JuiButton', array  (
                        'id' =>'widget-form-save-button',
                        'htmlOptions' => array ('class'=>'save-button'),
                        'name'=>'submit',
                        'caption'=>'Сохранить'
                    ), true)
                ),
                'extHeaderHtml' => '<div class="submit-form-result"></div>'
            ),
            $return
        );
	}

    public function getTabsWithScripts($id = null, $return = false)
	{
        $output = $this->getTabs('cssFileForm', true);
        Y::clientScript()->render($output);
        
        if ($return)
            return $output;
        else
            echo $output;
	}

	public function actionMovePosition($pk, $to)
	{
		$pk = explode('_',$pk);
		$to = explode('_', $to);
		$model = $this->loadModel($pk[1]);
		$model2 = $this->loadModel($to[1]);

		$c = $model->sort < $model2->sort;
		$l = $c ? '>' : '<';
		$r = $c ? '<=' : '>=';
		$models = $model->findAll(array(
			'condition'=>"sort $l $model->sort AND sort $r $model2->sort"
		));

		$transaction=Yii::app()->db->beginTransaction();
		try {
			$model->sort = $model2->sort;
			$model->scenario = 'movePosition';
			$model->save();

			foreach ($models as $item) {
				echo $c;
				echo $item->sort;
				$c ? --$item->sort : ++$item->sort;
				$item->scenario = 'movePosition';
				$item->save();
			}

			$transaction->commit();
		} catch(Exception $e) {
		    $transaction->rollBack();
		}

		$this->redirect($model->adminUrl);
	}

	public function loadModel($modelName, $pk = null, $scenario = '', $usePublished = false)
	{
		$model = new $modelName($scenario);
		if($pk === null)
			return $model;

		$condition = $model->pkAttr.'='.$pk;

		if ($usePublished && Y::isGuest())
			$condition.=' AND status='.Y::PUBLISHED;

        $model = $model->find($condition);
        if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не существует.');

        return $model;
	}

    public function renderAjax($view, $data=null, $return=false)
    {
        $output = parent::renderPartial($view, $data, $return, true);
    }
}
