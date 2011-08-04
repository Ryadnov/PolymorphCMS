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
			'block' => array(self::BELONGS_TO, 'TemplateBlock', 'block_id'),
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
		return 'template_widget_id';
	}
	
    public static function getExistsWidgets()
    {
    	$path = Yii::getPathOfAlias('widgets');
    	$map = FileSystem::directoryMap($path, 1);
    	
    	$res = array();

    	foreach ($map as $folder) {
            if ($config = FileSystem::read($path.'/'.$folder['text'].'/config.json')) {
    			$config = json_decode($config);

    			$class = $config->class;
    			Yii::import("widgets.{$folder['text']}.*");

                $widget = new TemplateWidget;
                $widget->class = $class;
                $widget->title = $class::getDefaultTitle();
    
    			array_push($res, $widget);

    		}
        }

    	return $res;
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