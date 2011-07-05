<?php
/**
 * EAdvancedRelations class file.
 *
 * @author Jeanluca
 * @link http://www.yiiframework.com/extension/eadvancedarbehavior/
 * @version 0.1
 */

class JsonSettingsBehavior extends CActiveRecordBehavior
{
	private $_arr_settings   = null;
	
	public function getSettings()
	{
        if ($this->_arr_settings === null) {
			$this->_arr_settings = (array)json_decode($this->owner->json_settings);
		}
		
		return $this->_arr_settings;
	}
	
	public function setSettings($settings)
	{
		$this->owner->json_settings = json_encode(self::castArray($settings));
	}
	
}
