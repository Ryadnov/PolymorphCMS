<?php
class DateColumn extends CDataColumn 
{
	public $uiDateFormat;
	public $model;
	public $attribute;
	
	public function init() 
	{
		parent::init();
		$this->uiDateFormat = $this->uiDateFormat ? $this->uiDateFormat : "yy-mm-dd";
		$this->attribute = $this->attribute ? $this->attribute : $this->name;

		$this->filter = Y::controller()->widget('ext.jui.FJuiDatePicker',
			array(
				'model'=>$this->model, 
				'attribute'=>$this->attribute,
				'language'=>'ru',
				'options'=>array(
					'dateFormat'=>$this->uiDateFormat
				)
			), 
			true
		);
	}	
}