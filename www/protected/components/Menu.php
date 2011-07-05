<?php
Yii::import('zii.widgets.CMenu');
class Menu extends CMenu
{
	public function init() 
	{
		$route=$this->getController()->getRoute();
		$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
	}
	
	public function get($alias)
	{
		if (($menuRoot = Category::model()->menuRoot($alias)) == null) {
			$this->error("Параметр tag для menu не верен. Шаблон $this->tmplAlias");
			$res = $this->command;
		}
		
		$params = new CMap();
		
		if ($params->remove('expand')) {
			$res = $menuRoot->makeTreeHtml(Y::controller()->category, true);	
		} else {
			$params['items'] = $menuRoot->makeMenu(Y::controller()->category);
			$res = Y::controller()->widget('Menu', $params, true);
		}
	
		return $res;
	}
		
}