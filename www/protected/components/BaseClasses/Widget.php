<?php
Yii::import('zii.widgets.CPortlet');

abstract class Widget extends CPortlet
{
	public $category;
    public $widgetModel;    //external param
    public $block;          //external param
    public $model;
    
	public $name;
    
	public $decorationCssClass='portlet-header';
	public $htmlOptions=array('class'=>'portlet');
	public $titleCssClass='portlet-title';
	public $contentCssClass='portlet-content';
	
	public function init()
	{
        $this->model = Y::controller()->model;
        foreach ($this->widgetModel->settings as $key=>$val)
            $this->$key = $val;

		parent::init();
	} 
	
	public function adminForm($widgetModel)
	{
        $res = '';
        $res .= CHtml::form();
            Admin::tab('Настройки виджета', parent::render('_adminForm', array('model'=>$widgetModel), true));  //you can override pender method as in MainContentWidget
            Admin::tab('Дополнительно', $this->renderExternalFields());
            $res .= Admin::getTabs(get_class($this).'_setttings_tabs', true);
            $res .= CHtml::submitButton('Сохранить');
        $res .= CHtml::endForm();
        $a = '11111';
        $res .= Y::clientScript()->render($a);
        return $res;
	}
    
    private function renderExternalFields()
    {
        $res = '<div class="row">';
        $res .= 'Название '.CHtml::textField('Extra[title]', $this->widgetModel->title);
        $res .= '</div>';
        $res .= '<div class="row">';
        $res .= 'Опубликован '.CHtml::checkbox('Extra[published]', $this->widgetModel->published);
        $res .= '</div>';
        return $res;
    }

    public function setWidgetModel($widgetModel)
    {
        $this->widgetModel = $widgetModel;
        $this->block = $widgetModel->block;
        $this->category = $widgetModel->block->category;
    }
	public function behaviors()
 	{
        return array(
          	'JsonSettingsBehavior'=> array(
	            'class' => 'application.components.Behaviors.JsonSettingsBehavior'
	      	),
        );
    }
    
	abstract public static function getDefaultSettings();
	abstract public static function getDefaultTitle();
    abstract public static function removeWidget();

}
