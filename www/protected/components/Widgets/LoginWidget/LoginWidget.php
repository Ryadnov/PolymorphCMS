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
            $this->runController('login');
        } else {
            //cabinet
            $model = $this->module->user();
//            $this->render('cabinet',array(
//                'model'=>$model,
//                'profile'=>$model->profile,
//            ));
        }
	}

    private function runController($id)
    {
        ob_start();
        list($c, $a) = Yii::app()->createController($id, $this->module);
        $c->run($a);
        ob_end_flush();
    }

    public function update()
    {

    }
    
    public function remove()
    {
        
    }

}