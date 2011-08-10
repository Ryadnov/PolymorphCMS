<?php
class LoginWidget extends Widget
{
	public $template;
    public $module;

    public function init()
    {
        $this->module = Y::module('users');
        parent::init();
    }
	
	public function renderContent()
	{
        if (Y::isGuest()) {
            $model = new UserLogin;
//            $this->performAjaxValidation($model);
            // collect user input data
            if (isset($_POST['UserLogin'])){
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()){
                    Yii::app()->runController('users/login/lastVisit');
                }
            }
        }

        if (!Y::isGuest()) {
            $model = $this->module->user();
            $this->render('user-info', array(
                'model'=>$model,
                'profile'=>$model->profile,
            ));
        } else {
            $this->render('login-form', array('model' => $model));
        }

        $route = isset($_GET['login']) ? urldecode($_GET['login']) : '';

        if (Y::isGuest()) {
            $this->render('login-form');


        } else {
            //cabinet
            
        }
	}

    public function update()
    {

    }
    
    public function remove()
    {
        
    }

}