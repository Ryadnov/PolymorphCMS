<?php
class Package extends CWebModule
{

    public function install()
    {

    }

    public function uninstall()
    {

    }

    public function addHandler($eventName, $methodName)
    {
        Y::hooks()->$eventName = array($this, $methodName);
    }

    public function widget($widgetName, $event, $additionParams = array())
    {
        $params = CMap::mergeArray($event->params, $additionParams);
        Y::controller()->widget($widgetName, $params);
    }


}