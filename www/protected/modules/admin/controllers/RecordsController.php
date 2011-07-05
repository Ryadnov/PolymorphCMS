<?php
class RecordsController extends AdminBaseController
{	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'dateConvert + create, update'
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id = null, $scenario = '')
	{
		return parent::loadModel('Record', $id, $scenario, true);
	}
	
	public function filterDateConvert() 
	{
		//Y::dump(4);
	} 
}
