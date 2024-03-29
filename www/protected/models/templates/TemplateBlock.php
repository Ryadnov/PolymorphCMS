<?php
class TemplateBlock extends ActiveRecord
{
	const PUBLISHED = 1;
	const NOT_PUBLISHED = 0;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Blogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'template_blocks';
	}

	public function rules()
	{
		return array(
			array('alias, template, category_id', 'safe', 'on'=>'create'),
			array('alias, template', 'safe', 'on'=>array('search', 'update')),
			array('alias', 'required'),
			array('alias', 'length', 'max'=>255)
		);
	}
	
	public function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'widgets'=>array(self::MANY_MANY, 'TemplateWidget', 'templates_blocks_widgets_relations('.self::getPkAttr().', '.TemplateWidget::getPkAttr().')'),
		);
	}

	public function behaviors()
 	{
        return array(
          	'JsonSettingsBehavior'=> array(
	            'class' => 'behaviors.JsonSettingsBehavior'
	      	),
            'CopyBehavior'=> array(
	            'class' => 'behaviors.CopyBehavior'
	      	)
        );
    }
    
    public static function getPkAttr()
    {
    	return 'block_id';	
    }

    public function renderBlock($category)
    {
        $content = '';

		foreach ($this->widgets as $widget) {

            $content .= $widgetContent = $this->renderWidget($widget, $category);
		}

        return $content;
    }

	private function renderWidget($widget, $category)
	{
        $settings = CMap::mergeArray($widget->settings, array(
			'category' => $category,
            'blockModel' => $this,
            'widgetModel' => $widget,
            'block' => $this,
            'model' => isset(Y::controller()->model) ? Y::controller()->model : null
		));

		return Y::controller()->widget($widget->class.'Widget', $settings, true);
	}



    public function getUpdateUrl()
    {
        return Admin::url('blocks/admin');
    }
	    
	public function getAdminUrl()
	{
		return Admin::url('blocks/update', array('pk' => $this->pk));
	}
	
	public function getDeleteUrl()
	{
		return Admin::url('templateBlocks/delete', array('pk' => $this->pk));
	}
	
	public function getAdminLink()
	{
		return CHtml::link($this->alias, $this->adminUrl);
	}

    public function getSettingsLink($htmlOptions = array())
    {
        return Admin::link('', 'blocks/settings', array('pk'=>$this->pk), $htmlOptions);
    }

}