<?php
Yii::import('zii.widgets.CPortlet');

abstract class Widget extends CPortlet
{
	public $category;
    public $widgetModel;    //external param
    public $block;          //external param
    public $model;          //see Widget.init()
    
	public $name;
    
	public $decorationCssClass='portlet-header';
	public $htmlOptions=array('class'=>'portlet');
	public $titleCssClass='portlet-title';
	public $contentCssClass='portlet-content';
	
	public function init()
	{
        $this->model = Y::controller()->model;
		parent::init();
	} 
	
	public function adminForm($widgetModel)
	{
        parent::render('_adminForm', array('model'=>$widgetModel), true).  //you can override render method as in MainContentWidget
            
        $res = '';
        $res .= CHtml::form();
        $id  = get_class($this).'_setttings_tabs';
        $res .= $this->getTabs($id);
        $res .= CHtml::endForm();
        return $res;
	}

    public function getTabs($id = null, $return = true)
    {
        self::beginTab('Дополнительно');
        echo $this->renderExternalFields();
        self::endTab();
        
        return Y::controller()->widget(
            'FormTabs', array(
                'tabs'=>self::$tabs,
                'options'=>array(
                    'collapsible'=>false,
                ),
                'id' => $id,
                'htmlOptions' => array('class'=>'widget_settings_tabs', 'style'=>'height:495px'),
                'buttons' => array (
                    $this->widget('JuiButton', array  (
                        'id' =>'widget-form-save-button',
                        'htmlOptions' => array ('class'=>'save-button'),
                        'name'=>'submit',
                        'caption'=>'Сохранить'
                    ), true)
                ),
                'extHeaderHtml' => '<div class="submit-form-result"></div>'
            ),
            $return
        );
    }

    private function renderExternalFields()
    {
        $res = '<div class="row">';
            $res .= CHtml::label('Название', 'Extra[title]');
            $res .= CHtml::textField('Extra[title]', $this->widgetModel->title);
        $res .= '</div>';
        $res .= '<div class="row">';
        $res .= CHtml::label('Опубликован', 'Extra[published]');
            $res .= CHtml::checkBox('Extra[published]', $this->widgetModel->published);
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

    public static $tabs = array();
    public static $curTabName;

    public static function beginTab($tabName)
    {
        ob_start();
        ob_implicit_flush(false);
        self::$curTabName = $tabName;
    }

    public static function endTab()
    {
        self::$tabs[self::$curTabName] = ob_get_contents();
        ob_end_clean();
    }
    
    abstract public function remove();
    abstract public function update();
}
