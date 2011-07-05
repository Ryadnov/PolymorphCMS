<?php

class RecoveryController extends AdminBaseController
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionRecovery () {
		$form = new UserRecoveryForm;
		if (Y::userId()) {
    		$this->redirect(Y::module()->returnUrl);
			Y::end();
		}

		$email = isset($_GET['email']) ? $_GET['email'] : '';
		$activkey = isset($_GET['activkey']) ? $_GET['activkey'] : '';
		if ($email&&$activkey) {	//get new pass
			
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
    		if(isset($find)&&$find->activkey==$activkey) {
				$form2 = new UserChangePassword;
    			if(isset($_POST['UserChangePassword'])) {
					$form2->attributes=$_POST['UserChangePassword'];
					if($form2->validate()) {
						$find->password = UserModule::encrypting($form2->password);
						if ($find->status==0) {
							$find->status = 1;
						}
						$find->save();
						Y::flash('recoveryMessage',Users::t("New password is saved."));
						$this->redirect(Y::module()->recoveryUrl);
					}
				} 
				$this->render('changepassword',array('form'=>$form2));
    		} else {
    			Y::flash('recoveryMessage',Users::t("Incorrect recovery link."));
				$this->redirect(Y::module()->recoveryUrl);
    		}
    	} else {	//send email
	    	if(isset($_POST['UserRecoveryForm'])) {
	    		$form->attributes=$_POST['UserRecoveryForm'];
	    		
	    		if($form->validate()) {
	    			$user = User::model()->notsafe()->findbyPk($form->user_id);
	    			$user->activkey = Y::module()->encrypting(microtime().$user->password);	
	    			$user->save();
	    			$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->siteUrl('user/recovery',array("activkey" => $user->activkey, "email" => urldecode($user->email)));
					
					$subject = Users::t("You have requested the password recovery site {site_name}",
	    					array(
	    						'{site_name}'=>Yii::app()->name,
	    					));
	    			$message = Users::t("You have requested the password recovery site {site_name}. To receive a new password, go to {activation_url}.",
	    					array(
	    						'{site_name}'=>Yii::app()->name,
	    						'{activation_url}'=>$activation_url,
	    					));
					
	    			UserModule::sendMail($user->email,$subject,$message);
	    			
					Y::flash('recoveryMessage',Users::t("Please check your email. An instructions was sent to your email address."));
	    			$this->refresh();
	    		}
	    	}
    		$this->render('recovery',array('form'=>$form));
    	}
	}

}