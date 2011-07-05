<?php
class PortfoliosController extends AdminBaseController
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id = null, $scenario = '')
	{
		return parent::loadModel('Portfolio', $id, $scenario, true);
	}

	public function actionAddToGallery($modelPk, $imageName)
	{
		$img = new PortfolioGallery('create');
		$img->image_name = $imageName;
		$img->{Portfolio::getIdAttr()} = $modelPk;
		$img->makeThumb();
		$img->save();
		
		echo CJSON::encode(array('pk'=>$img->pk));
	}
	
	protected function saveRelations(&$model)
	{
		$model->portfolioWorks = array();
		$arr = $_POST['Portfolio']['portfolioWorksIds'];
		if(!empty($arr)) {
			$arr = implode(',',$arr);
			$models = PortfolioWork::model()->findAll(array(
				'condition' => PortfolioWork::getIdAttr().' in ('.$arr.')'
			));
			$model->portfolioWorks = $models;
		}

		$pk = (int)$_POST['Portfolio']['workType'];
		 
		if ($pk)
			$model->workType = PortfolioWorkType::model()->findByPk($pk);
			
		$pk = (int)$_POST['Portfolio']['city'];
		
		if ($pk) 
			$model->city = City::model()->findByPk($pk);
	}		
}