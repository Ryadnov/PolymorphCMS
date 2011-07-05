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
		return 'Пустой';	
	}
	
	public function renderContent()
	{
		$this->render('template', $this->settings);
	}
	
}