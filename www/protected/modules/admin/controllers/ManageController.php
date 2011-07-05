<?php
class ManageController extends AdminBaseController
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'roles'=>array('guest'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'imgUpload', 'upload'),
				'roles'=>array('writer'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('delete'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
        $this->render('index');
	}
	
	public function actionUpload()
	{
		$model = new $_GET['model'];
		$folder = 'images/'.$_GET['folder'].'/';// folder for uploaded files
		
		if (!is_dir('./'.$folder)) {
			mkdir('./'.$folder);
		}
		
		$allowedExtensions = array("jpg","jpeg","gif","png");//array("jpg","jpeg","gif","exe","mov" and etc...
	    $sizeLimit = 2 * 1024 * 1024;// maximum file size in bytes

	    Yii::import("ext.EAjaxUpload.qqFileUploader");
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	    
	    $result = $uploader->handleUpload($folder);
	    $result['filePath'] = $folder;
	    $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	    echo $result;// it's array
	}
}
