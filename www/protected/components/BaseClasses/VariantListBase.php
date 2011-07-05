<?php

/**
 * Base class for all models implements tables with list data
 * at this table must be 2 column {some id} and {name}
 * Incapsulate functions for dropDown, checkbox and other List; admin urls
 *
 * @author Alexey Sharov
 *
 */
abstract class VariantListBase extends ActiveRecord
{
	
	public static function getNameAttr()
	{
		return 'name';
	}
	
	abstract public static function getListHeader();
	abstract public static function getAdminControllerName();
	
	public function behaviors()
	{
		return array( 
	    	'EAdvancedArBehavior' => array(
	            'class' => 'application.components.Behaviors.EAdvancedArBehavior'
	      	)
	    );
	}
	
	public function rules()
	{
		return array(
			array($this->nameAttr, 'required'),
		);
	}
	
	public function search()
	{
		$criteria = $this->getDbCriteria();

		$criteria->compare($this->nameAttr,$this->{$this->nameAttr},true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function attributeLabels()
	{
		return array(
			$this->nameAttr => 'Название',
		);
	}
	
	public function getAll()
	{
		
		return CHtml::listData($this->findAll(),$this->idAttr,$this->nameAttr);
	}
	
	public function getAllWithHeader()
	{
		$res = array(0 => $this->getListHeader());
		$items = $this->all;
		foreach ($items as $key=>$val) {
			$res[$key] = $val;
		}
		return $res;	
	}
	
	public function dropDownList($model = null, $attr = '')
	{
		$items = $this->allWithHeader;
		return CHtml::activeDropDownList($model, $attr, $items);
	}
	
	public function checkBoxList($model, $attribute)
	{
		if ($model !== null) {
			return CHtml::activeCheckBoxList($model, $attribute, $this->all);
		} else 	
			return CHtml::checkBoxList($attribute, '', $this->all);
			
	}
	
	public function radioButtonList($model, $attribute)
	{
		return CHtml::activeRadioButtonList($model, $attribute, $this->all);	
	}
	
	public function getUrl() 
	{
		return Admin::url($this->adminControllerName.'/view');	
	}
	
	public function getUpdateUrl()
	{
		return Admin::url($this->adminControllerName.'/update', array('pk' => $this->pk));
	}
	
	public function getDeleteUrl()
	{
		return Admin::url($this->adminControllerName.'/delete', array('pk' => $this->pk));
	}
	
	public function getAdminUrl()
	{
		return Admin::url($this->adminControllerName.'/admin');
	}
	
	public function getUpdateLink()
	{
		return CHtml::link($this->title, $this->updateUrl);
	}
	
	public function getAdminLink()
	{
		return CHtml::link($this->title, $this->adminUrl);
	}

	public function getImgPath()
	{
		return "/images/".$this->getImgFolder()."/";	
	}
	
}