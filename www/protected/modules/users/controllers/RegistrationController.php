<?php

class RegistrationController extends AdminBaseController
{
	public $defaultAction = 'registration';

	public function accessRules()
	{
		if(Y::module('users')->isRegistrationClose) {
			$register = array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('registration'),
				'users'=>array('moderator'),
			);
			$close = array('allow',  // deny all users
		        'actions'=>array('close'),    
		        'users'=>array('*'),
	        );
		} else {
			$register = array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('registration'),
				'users'=>array('*'),
			);
			$close = array('deny',  // deny all users
		        'actions'=>array('close'),    
		        'users'=>array('*'),
	        );
		}
		
		return array(
			$register,
			$close,
			array('allow', // allow authenticated users to perform any action
				'actions'=>array('captcha'),
	        	'users'=>array('*'),
	        ),
	        array('deny',  // deny all users
		        'actions'=>array('*'),    
		        'users'=>array('*'),
	        ),
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')?array():array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	
	/**
	 * Registration user
	 */
	public function actionRegistration() 
	{
		if(Y::module()->isRegistrationClose) $this->redirect('close');
		$model = new RegistrationForm;
        $profile=new Profile;
        $profile->regMode = true;
            
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			Y::end(UActiveForm::validate(array($model,$profile)));
		
		if (Y::userId()) {
			$this->redirect(Y::module()->profileUrl);
		} else {
			if(isset($_POST['RegistrationForm'])) {
				$model->attributes=$_POST['RegistrationForm'];
				$profile->attributes= isset($_POST['Profile'])?$_POST['Profile']:array();
				if($model->validate()&&$profile->validate())
				{
					$soucePassword = $model->password;
					$model->activkey=UserModule::encrypting(microtime().$soucePassword);
					$model->password=UserModule::encrypting($soucePassword);
					$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
					$model->createtime=time();
					$model->lastvisit=((Y::module()->loginNotActiv||(Y::module()->activeAfterRegister&&Y::module()->sendActivationMail==false))&&Y::module()->autoLogin)?time():0;
					$model->superuser=0;
					$model->status=((Y::module()->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						
					if ($model->save()) {
						$profile->user_id=$model->id;
						$profile->save();
						if (Y::module()->sendActivationMail) {
							$activation_url = $this->createAbsoluteUrl('/user/activation',array("activkey" => $model->activkey, "email" => $model->email));
							UserModule::sendMail($model->email,Users::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),Users::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
						}
							
						if ((Y::module()->loginNotActiv||(Y::module()->activeAfterRegister&&Y::module()->sendActivationMail==false))&&Y::module()->autoLogin) {
							$identity=new UserIdentity($model->username,$soucePassword);
								$identity->authenticate();
								Y::user()->login($identity,0);
								$this->redirect(Y::module()->returnUrl);
						} else {
							if (!Y::module()->activeAfterRegister&&!Y::module()->sendActivationMail) {
								Y::flash('/user/registration',Users::t("Thank you for your registration. Contact Admin to activate your account."));
							} elseif(Y::module()->activeAfterRegister&&Y::module()->sendActivationMail==false) {
								Y::flash('/user/registration',Users::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(Users::t('Login'),Y::module()->loginUrl))));
							} elseif(Y::module()->loginNotActiv) {
								Y::flash('/user/registration',Users::t("Thank you for your registration. Please check your email or login."));
							} else {
								Y::flash('/user/registration',Users::t("Thank you for your registration. Please check your email."));
							}
							$this->refresh();
						}
					}
				} else $profile->validate();
			}
		    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile,'lang'=>Yii::app()->language));
	    }
	}
	
	public function actionClose() {
		
		$email = new Email;

		$this->performAjaxValidation($email);
		
		if(isset($_POST['Email'])) {
			$email->attributes = $_POST['Email'];
			$email->to = Y::config('email_to_registraiton');
			$email->send();
			Y::flash('success',Yii::t('interface', "email was sended"));
		}
		
		$this->render('/registration/close', 
			array('model' => $email)
		);
	}
}