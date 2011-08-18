<?php
class RecordController extends AdminBaseController
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
    public function actionUpdate($catPk, $pk, $otherParams = array())
	{
		$model = $this->loadModel($catPk, $pk, 'update');

		$this->performAjaxValidation($model);

		if (isset($_POST[get_class($model)])) {
			$model->attributes = $_POST[get_class($model)];

			if (method_exists($this, 'saveRelations'))
				$this->saveRelations($model);

			if ($model->save()) {
                Y::hook()->cmsRecordUpdate($this, array('model'=>$model));
                Y::end();
            }
		}

		$opts = CMap::mergeArray($otherParams, array(
			'model' => $model
		));
		if (!isset($opts['cat']) && isset($model->category))
			$opts['cat'] = $model->category;

		$this->render('update', $opts);
	}
}
