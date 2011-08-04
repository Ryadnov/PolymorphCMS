<?php
class UserWidget extends Widget
{
	public $template;
    
	public static function getDefaultTitle()
	{
		return 'Пользователи';
	}
	
	public function renderContent()
	{
        
		$this->render('template');
	}

    public function update()
    {

    }
    
    public function remove()
    {
        
    }

}