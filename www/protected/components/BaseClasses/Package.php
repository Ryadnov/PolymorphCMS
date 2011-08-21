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
            $ca = Yii::app()->createController(ucfirst($handler[0]), $this);
            $handler[0] = $ca[0];
            $handler[1] = 'handler'.ucfirst($handler[1]);
        } else {
            $handler = array($this, 'handler'.ucfirst($handler));
        }

        Y::hooks()->$eventName = $handler;
    }

    public function widget($widgetName, $event, $additionParams = array())
    {
        $params = CMap::mergeArray($event->params, $additionParams);
        Y::controller()->widget($widgetName, $params);
    }

    


}