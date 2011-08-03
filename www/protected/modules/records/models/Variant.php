<?php
class Variant extends VariantListBase
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lookup the static model class
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
		return 'record_variants_lists';
	}
	
	public static function getPkAttr()
	{
		return 'variant_id';
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
			'records' => array(self::MANY_MANY, 'Record', 'variant_relations(model_id, variant_id)'),
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
