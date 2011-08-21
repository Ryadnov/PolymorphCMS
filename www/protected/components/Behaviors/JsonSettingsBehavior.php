<?php
/**
 * EAdvancedRelations class file.
 *
 * @author Jeanluca
 * @link http://www.yiiframework.com/extension/eadvancedarbehavior/
 * @version 0.2
 */

class JsonSettingsBehavior extends CBehavior
{
	private $_arr_settings = array();

    private function _constructId()
    {
        return get_class($this->owner).$this->owner->pk;
    }

	public function getSettings()
	{
        $id = $this->_constructId();
        if (!isset($this->_arr_settings[$id])) {
            $this->_arr_settings[$id] = (array)CJSON::decode($this->owner->json_settings);
		}

		return $this->_arr_settings[$id];
	}
	
	public function setSettings($settings)
	{
        $id = $this->_constructId();
		$this->_arr_settings[$id] = $this->owner->json_settings = json_encode(self::castArray($settings));
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
