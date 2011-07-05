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
        if (!isset($this->inherit_settings))    //fix it bug
            return array();
        
        if ($this->_arr_settings === null) {
			if ($this->inherit_settings)
				$this->_arr_settings = $this->parent->settings;
			else
				$this->_arr_settings = (array)json_decode($this->json_settings);
		}	
		
		return $this->_arr_settings;
	}
	
	public function setSettings($settings)
	{
		$this->json_settings = json_encode(self::castArray($settings));
	}
	
}
