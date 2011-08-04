<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
	//public $layout='//layouts/admin';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        if (!Y::isGuest()) {
            if (Y::checkAccess('moderator'))
                $this->redirect($this->module->adminReturnUrl);
            else
                $this->redirect($this->module->returnUrl);
        }
			
		$model = new UserLogin;
		$this->performAjaxValidation($model);
    	// collect user input data
		if (isset($_POST['UserLogin']))
		{
			$model->attributes = $_POST['UserLogin'];
			// validate user input and redirect to previous page if valid
			if ($model->validate()) {
				$this->lastViset();
				$this->redirect($this->module->returnUrl);
			}
		}
	
		// display the login form
		$this->renderPartial('/user/login', array('model'=>$model));
	}
	
	private function lastViset() 
	{
		$lastVisit = User::model()->notsafe()->findByPk(Y::userId());
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}