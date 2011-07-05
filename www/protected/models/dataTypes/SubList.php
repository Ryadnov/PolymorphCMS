<?php
class SubListType extends VariantListBase
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'record_subdatas';
	}
	
	public static function getPkAttr()
	{
		return 'subdata_id';
	}
		
	public function relations()
	{
		return array(
			'records' => array(self::HAS_MANY, 'Records', self::getIdAttr()),
		);
	}
	
	public static function getAdminControllerName()
	{
		return 'portfolioWorkTypes';	
	}

	public static function getListHeader()
	{
		return 'Все';
	}

	public static function getImgFolder()
	{
		return 'portfolioWorkType';	
	}
	
}
