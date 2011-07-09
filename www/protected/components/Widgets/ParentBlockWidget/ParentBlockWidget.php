<?php
class ParentBlockWidget extends Widget
{
	public $blockAlias;
	public $category;
	
	public static function getDefaultSettings()
	{
		return array();	
	}
	
	public static function getDefaultTitle()
	{
		return 'Родительский блок';
	}
	
	protected function renderContent()
	{
		echo new BlockViewer($this->blockAlias, $this->category->parent);
	}

	public static function removeWidget()
	{
	    CJuiTabs::
	}
}