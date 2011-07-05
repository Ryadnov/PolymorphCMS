<?php
class PortfolioGalleriesController extends AdminBaseController
{	
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
	
	public function loadModel($id = null, $scenario = '')
	{
		return parent::loadModel('PortfolioGallery', $id, $scenario, true);
	}
	
	public function actionAdmin($portfolioPk)
	{
		$portfolio = Portfolio::model()->findByPk((int)$portfolioPk);
		parent::actionAdmin(null, array('portfolio'=>$portfolio));
	}
	
	public function actionDelete($pk)
	{
		$model = $this->loadModel($pk);
		$model->delete();
	}
	
	public function actionUpdate($pk) 
	{
		$img = PortfolioGallery::model()->findByPk($pk);
		FileSystem::deleteFiles('./'.$img->imgPath.$img->image_name);
		FileSystem::deleteFiles('./'.$img->thumbPath.$img->image_name);
		
		if (isset($_POST['PortfolioGallery'])) {
			$info = $_POST['PortfolioGallery'];
			$img->image_name = $info['image_name'];
			$img->makeThumb();
		}
		
		parent::actionUpdate($pk);
	}
}
