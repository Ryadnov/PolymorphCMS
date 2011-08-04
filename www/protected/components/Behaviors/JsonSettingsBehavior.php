<?php
/**
 * EAdvancedRelations class file.
 *
 * @author Jeanluca
 * @link http://www.yiiframework.com/extension/eadvancedarbehavior/
 * @version 0.2
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

    /**
	 * make recursive cast all values in array to string
	 * @param array $arr
	 * @return array
	 */
	private static function castArray($arr)
	{
		$res = array();
		foreach ($arr as $key=>$val) {
			if (is_array($val))
				$res[$key] = self::castArray($arr);
			else
				$res[$key] = (string)$val;
		}
		return $res;
	}
}
