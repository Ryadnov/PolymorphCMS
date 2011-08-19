<?php
Yii::import('zii.widgets.CPortlet');

abstract class Widget extends CPortlet
{
	public $category;
    public $widgetModel;    //external param
    public $blockModel;          //external param
    public $block;          //external param
    public $model;          //see Plugins.init()
    
	public $name;
    
	public $decorationCssClass='portlet-header';
	public $htmlOptions=array('class'=>'portlet');
	public $titleCssClass='portlet-title';
	public $contentCssClass='portlet-content';

    public $ajaxGet;
    public $ajaxPost;
    
	public function init()
	{
        parent::init();
	}

	public function adminForm($widgetModel)
	{
        parent::render('_adminForm', array('model'=>$widgetModel), true).  //you can override render method as in MainContent

        $id  = get_class($this).'_setttings_tabs';
        return $this->getTabs($id);
	}

    public function getTabs($id = null, $return = true)
    {
        Y::tab('Дополнительно', $this->renderExternalFields());
        return Y::getTabs($id, $return);
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
	            'class' => 'behaviors.JsonSettingsBehavior'
	      	),
        );
    }

    abstract public function update();

    public static function register($category)
    {
        
    }
}
