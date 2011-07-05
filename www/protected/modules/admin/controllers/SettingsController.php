<?php
class SettingsController extends AdminBaseController
{	
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
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$all = Lookup::model()->getAll();
		Y::dump($all);
		$model = new Portfolio('search');
		$model->unsetAttributes();  // clear any default values
		$model = $model->current($cat);
		
		if (isset($_GET['Portfolio']))
			$model->attributes=$_GET['Portfolio'];
		
		if (isset($_GET['ajax'])) {
			$this->renderPartial('admingrid',array(
	            'model'=>$model,
		    ));
    	} else {
    		$this->render('admin',array(
				'model'=>$model,
    			'cat'=>$cat
    		));
		}
	}
}
