<?php
Yii::import('zii.widgets.CPortlet');

abstract class Widget extends CPortlet
{
	public $category;
    public $widgetModel;
    public $block;
    public $viewPath;
    public $model;
    public $settings;
    
	public $name;
    
	public $decorationCssClass='portlet-header';
	public $htmlOptions=array('class'=>'portlet');
	public $titleCssClass='portlet-title';
	public $contentCssClass='portlet-content';
	
	public function init()
	{
        $this->viewPath = Yii::getPathOfAlias('widgets.'.get_class($this).'.views');
        $this->model = Y::controller()->model;
        $this->settings = $this->widgetModel->settings;
		parent::init();
	} 
	
	public function renderForm()
	{
		return $this->render('_adminForm', array(), true);
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