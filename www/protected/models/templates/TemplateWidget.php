<?php
class TemplateWidget extends ActiveRecord
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

	public function tableName()
	{
		return 'template_widgets';
	}

	public function rules()
	{
		return array(
			array('template, block_id', 'safe', 'on'=>'create'),
			array('template', 'safe', 'on'=>array('search', 'update')),
		);
	}
	
	public function relations()
	{
        return array(
			'block' => array(self::MANY_MANY, 'TemplateBlock', 'templates_blocks_widgets_relations('.self::getPkAttr().', '.TemplateBlock::getPkAttr().')'),
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
		return 'widget_id';
	}
	
    public static function getExistsWidgets()
    {
        return Y::resources()->existsWidgets;
	}
    
	public function getUpdateUrl()
	{
		return Admin::url('templateWidgets/update', array('pk' => $this->pk));
	}
	
	public function getDeleteUrl()
	{
		return Admin::url('templateWidgets/delete', array('pk' => $this->pk));
	}
	
	public function getAdminUrl()
	{
		return Admin::url('templateWidgets/admin', array('catId'=>$this->category_id));
	}
	
	public function getUpdateLink()
	{
		return CHtml::link($this->alias, $this->updateUrl);
	}
	
	public function getAdminLink()
	{
		return CHtml::link($this->alias, $this->adminUrl);
	}

    public function getDetailsLink($htmlOptions = array())
    {
        return Admin::link($this->title, 'widgets/details', array('pk'=>$this->pk), $htmlOptions);
    }
}