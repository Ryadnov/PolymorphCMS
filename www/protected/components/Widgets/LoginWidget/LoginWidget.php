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
            $this->runController('profile');
        }
	}

    private function runController($id)
    {
        list($c, $a) = Yii::app()->createController($id, $this->module);
        $c->run($a);
    }

    public function update()
    {

    }
    
    public function remove()
    {
        
    }

}