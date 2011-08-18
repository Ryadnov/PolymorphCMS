<?php
class Package extends CWebModule
{

    public function install()
    {

    }

    public function uninstall()
    {

    }

    public function addHandler($eventName, $handler)
    {
        if (is_array($handler)) {
            $handler[0] = Y::module('records')->createController(ucfirst($handler[0]).'Controller');
            $handler[1] = 'handler'.ucfirst($handler[1]);
        } else {
            $handler = array($this, $handler);
        }
        Y::hooks()->$eventName = $handler;
    }

    public function widget($widgetName, $event, $additionParams = array())
    {
        $params = CMap::mergeArray($event->params, $additionParams);
        Y::controller()->widget($widgetName, $params);
    }


}