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
//            ->registerScriptFile('/js/plugins/cms/deleteLi.js')
//            ->registerScriptFile('/js/plugins/cms/openLi.js')
//            ->registerScriptFile('/js/plugins/chosen/chosen.js')
//            ->registerCssFile('/js/plugins/chosen/chosen.css')
            ->registerScriptFile('/js/plugins/cms/asc.js');

        Y::clientScript()->ajaxExclude(array(
            'jquery.js',
            'jquery-ui.min.js',
            'jquery-ui.css',

            //treeview
            'jquery.treeview.js',
            'jquery.cookie.js',
            'jquery.treeview.edit.js',
            'jquery.treeview.async.js',

            'asc.js'
        ));
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
        $menu = array(
		    'categories' => array('text'=>Admin::link('Категории', 'categories/admin')),
            'components' => array('text'=>Admin::link('Компоненты', 'widgets/gallery')),
		    'settings' => array('text'=>Admin::link('Настройки Сайта', 'settings/admin')),
		    /*array('text'=>Admin::link('Пользователи', 'users/admin')),
			array(
				'text'=>'Списки', 
				'children'=>array(
					array('text'=>Admin::link('Проделанные работы', 'portfolioWorks/admin')),
					array('text'=>Admin::link('Виды деятельности', 'portfolioWorkTypes/admin')),
					array('text'=>Admin::link('Города', 'cities/admin')),
				)
			),*/
			//'logout' => array('text'=> Users::link('Выход', 'logout'))
		);
        $res = Y::hooks()->cmsAdminGetSystemMenu($this, array('menu'=>$menu));
        return $res['menu'];
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
			$tmp = array(
                'text'=>ModelFactory::adminViewCategoryLink($child),
                $tmp['active'] = true
            );
            
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
	
	public function actionUpdate($catPk, $pk =  null, $otherParams = array())
	{
		$model=$this->loadModel($catPk, $pk, 'update');
		
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

	public function actionCreate($catPk = null)
	{
		$isCategoryModel = true;
		if ($catPk === null)
			$isCategoryModel = false;
		
		if ($isCategoryModel)	
			$cat = Category::model()->findByPk($catPk);
		$model=$this->loadModel($catPk, null, 'create');
		
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

	public function actionDelete($catPk, $pk)
	{
		// we only allow deletion via POST request
		$model = $this->loadModel($catPk, $pk);

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
	
	public function actionAdmin($catPk = null, $opts = array())
	{
		$isCategoryModel = !($catPk === null);
		
		if ($isCategoryModel)
			$cat = Category::model()->findByPk($catPk);
		
		$model = $this->loadModel($catPk, null, 'search');
		
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
		} else {
    		$this->render('admin',$opts);
        }
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

	public function loadModel($catPk, $pk = null, $scenario = '')
	{
        $cat = Category::model()->findByPk($catPk);
        $modelName = $cat->type;

        if ($cat->type == "Page")
            return $cat->page;

		$model = new $modelName($scenario);
		if($pk === null)
			return $model;

		$condition = $model->pkAttr.'='.$pk;

        $model = $model->find($condition);
        if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не существует.');

        return $model;
	}

}
