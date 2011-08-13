<?php
class PluginModel extends ActiveRecord
{	
	const PUBLISHED = 1;
	const NOT_PUBLISHED = 0;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'plugins';
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
		return 'plugin_id';
	}
	
    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'published='.self::PUBLISHED
            )
        );
    }
}