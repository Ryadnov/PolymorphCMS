<?php
Yii::import('zii.widgets.CMenu');
class MenuWidget extends Widget
{
    public $alias;
    public $expand;
        
	protected function renderContent()
    {
        $alias = $this->alias;
        if (($menuRoot = Category::model()->menuRoot($alias)) == null) {
            $this->error("Параметр tag для menu не верен. Шаблон $this->tmplAlias");
            $res = $this->command;
        }

        if ($this->expand) {
            echo $menuRoot->makeTreeHtml($this->category, true);
        } else {
            $params = array(
                'items' => $menuRoot->makeMenu($this->category)
            );
            Y::controller()->widget('CMenu', $params);
        }
    }
	
    public static function removeWidget()
    {
        
    }

    public static function getDefaultSettings()
    {
        return array();
    }

    public static function getDefaultTitle()
    {
        return 'Меню';
    }
}