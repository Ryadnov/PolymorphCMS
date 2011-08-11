<?php
class Union extends VariantListBase
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'record_union_lists';
	}
	
	public static function getPkAttr()
	{
		return 'union_id';
	}
	
	public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
			array('alias', 'required'),
			array('icon', 'safe', 'on'=>array('search', 'update', 'create')),
		));
	}
		
	public function relations()
	{
		return array(
			'records' => array(self::BELONGS_TO, 'Record', Record::getPkAttr()),
		);
	}
	
	public function attributeLabels()
	{
		return CMap::mergeArray(parent::attributeLabels(), array(
			'icon' => 'Иконка',
		));
	}

	public static function getAdminControllerName()
	{
		return 'portfolioWorks';	
	}
	
	public static function getListHeader()
	{
		return 'Все';
	}

	public static function getNameAttr()
	{
		return 'title';
	}

	public static function getImgFolder()
	{
		return 	'portfolioWork';
	}

	public function getCurIcon()
	{
		if (empty($this->icon))
			return '';
		else
			return CHtml::image($this->imgPath.$this->icon);
	}
	
}
