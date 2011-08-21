<?php

class ProfileController extends AdminBaseController
{
	public $defaultAction = 'profile';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = $this->loadUser();
	    $this->renderPartial('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function actionCabinet()
	{
        $model = $this->loadUser();
	    $this->render('cabinet',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		
		// ajax validator
		if (isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
			Y::end(UActiveForm::validate(array($model,$profile)));
		
		if (isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if(!empty($model->password)  && (strlen($model->password)<32)||$model->isNewRecord) {
				$model->password = UserModule::encrypting($model->password);
			} else { 
				$profile->__unset('password');
			}
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				
				$profile->save();
				Y::flashRedir('profileMessage',Users::t("Changes is saved."), $this->module()->cabinetUrl);
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Y::userId()) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
				Y::end(UActiveForm::validate($model));
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Y::userId());
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Y::flashRedir('profileMessage',Users::t("New password is saved."),$this->module->profileUrl);
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
        $this->_model = $this->module->user();
        if (!$this->_model)
            $this->redirect($this->module->loginUrl);
		return $this->_model;
	}
}