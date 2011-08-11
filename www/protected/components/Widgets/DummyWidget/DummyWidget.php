<?php
class DummyWidget extends Widget
{
	public $template;
	
	public static function getDefaultSettings() 
	{
		return array();
	}
	
	public function update()
	{
		return 'Простой текст';
	}

    public function remove()
    {
        
    }
	
	public function renderContent()
	{
		$this->render('template');
	}

    public static function removeWidget()
    {
        
    }
}