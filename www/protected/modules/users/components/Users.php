<?php
class Users
{
	public static function t($str='',$dic='user', $params=array()) {
		return Yii::t("UsersModule.".$dic, $str, $params);
	}
		
	public function url($url, $params = array()) 
    {
    	return Y::url('users/'.$url, $params);
    }

    public function absUrl($url, $params = array()) 
    {
    	return Y::absUrl('users/'.$url, $params);
    }

    public static function link($text, $url, $urlParams = array(), $linkParams = array())
    {
    	return CHtml::link($text, self::url($url, $urlParams), $linkParams);
    }
}