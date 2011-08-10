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
        $route = isset($_GET['users']) ? urldecode($_GET['users']) : '';

        if (Y::isGuest()) {
            Yii::app()->runController('users/'.$route);
        } else {
            //cabinet
            $model = $this->module->user();
            $this->render('user-info',array(
                'model'=>$model,
                'profile'=>$model->profile,
            ));
        }
	}

    public function update()
    {

    }
    
    public function remove()
    {
        
    }

}