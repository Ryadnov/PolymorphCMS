<?php
class DummyWidget extends Widget
{
	public $template;
	
	public static function getDefaultSettings() 
	{
		return array();
	}
	
	public static function getDefaultTitle()
	{
		return 'Простой текст';
	}
	
	public function renderContent()
	{
		$this->render('template');
	}

    public static function removeWidget()
    {
        
    }
}