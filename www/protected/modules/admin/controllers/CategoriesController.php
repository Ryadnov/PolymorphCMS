<?php
class CategoriesController extends AdminBaseController
{
	public $CQtreeGreedView  = array (
        'modelClassName' => 'Category', //название класса
        'adminAction' => 'admin' //action, где выводится QTreeGridView. Сюда будет идти редирект с других действий.
    );
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'roles'=>array('guest'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'imgUpload'),
				'roles'=>array('writer'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('createNode','updateNode','admin', 'ajaxFillTree', 'simpleTree', 'MoveNode', 'getRelevantCategories', 'copyData'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('viewSettings','delete', 'deleteNode', 'moveData'),
				'roles'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('MakeRoot'),
				'roles'=>array('webmaster'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actions()
	{
		return CMap::mergeArray(parent::actions(), array(
			'createNode'=>'ext.QTreeGridView.actions.Create',
            'updateNode'=>'ext.QTreeGridView.actions.Update',
            'deleteNode'=>'ext.QTreeGridView.actions.Delete',
            'moveNode'=>'ext.QTreeGridView.actions.MoveNode',
            'makeRoot'=>'ext.QTreeGridView.actions.MakeRoot',
    	));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($catId)
	{
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionAdmin()
	{
		$model = new Category('search');
		
		$this->ajaxSetNextValue('published', $model, 'published', array(BaseDataType::PUBLISHED, BaseDataType::NOT_PUBLISHED));
		
		$dp = $model->search();
		$dp->pagination = array('pagesize'=>10000);
		
		$this->render('tree', array(
			'model'=>$model,
			'dp'=>$dp
		));
	}
	
	public function loadModel($id = null, $scenario = '')
	{
		$cat = new Category($scenario);
        return $cat::model()->findByPk($id);
	}

	public function actionGetRelevantCategories()
	{
		if (!Y::isAjaxRequest())
            Y::end();
        
		if(!isset($_POST['catId']))
			throw new CException("Не найден параметр catId");

		if(!isset($_POST['action']))
			throw new CException("Не найден параметр catId");
		
		$cat = Category::model()->findByPk($_POST['catId']);
		
		$name = ModelFactory::t($cat->type);
		if (ModelFactory::isAllowCopy($cat->type)) {
			echo "<p>Категория имеет тип '$name', поэтому все '$name' могут быть скопированы в одну из следующих категорий.</p>".
					"<hr/><p>Все шаблоны с одинаковыми алиасами будут утеряны</p>";
		} else {
			echo "Категория имеет тип '$name', данные такого типа не могут быть сохранены в другой категории.";
			Y::end();
		}	
		
		$cats = Category::model()->findAll("type='".$cat->type."' AND id!=".$cat->pk);
		
		$res = '<ul>';
		foreach ($cats as $target) {
			if ($_POST['action'] == 'copy')
				$res .= '<li>'.$cat->getCopyDataLink($target).'</li>';
			elseif ($_POST['action'] == 'cut')
				$res .= '<li>'.$cat->getCutDataLink($target).'</li>';
		}
		echo $res.'</ul>';	 
	}
	
	public function actionMoveData($action, $from, $to)
	{
		$fromCat = Category::model()->findByPk($from);
		$toCat = Category::model()->findByPk($to);
		
		if ($fromCat == null || $toCat == null)
			throw new CException("Не передан параметр fromCat или toCat в ".__CLASS__."::".__FUNCTION__);
	
		if ($fromCat->type != $toCat->type)
			throw new CException("Типы категорий не совпадают, копирование не может быть произведено.");
	
		if ($fromCat->moveAndDelete($action, $toCat))
			$msg = "Категория удалена успешно";
		else
			$msg = "Произошел сбой при удалении категории, попробуйте еще раз";
			
		Y::flash('deleteCategory', $msg);
		$this->redirect(Admin::url('categories/admin')); 		
	} 	
	
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		$this->loadModel($id)->moveAndDelete('delete');

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_POST['ajax']))
        	isset($_POST['returnUrl']) ? $this->redirect($_POST['returnUrl']) : '';
        	
        $this->redirect(Admin::url('categories/admin'));
	}

	public function actionViewSettings($pk)
	{
            $cat = $this->loadModel($pk);

        $this->render('ViewSettings', array('cat'=>$cat));
	} 
	
}
