<?php
class Package extends CWebModule
{
    public $eventMap = null;
    public $routeMap = null;
    
    public function init()
    {
        parent::init();

        //set handlers, must have 'cms' prefix
        foreach(get_class_methods($this) as $method) {
            if (strncasecmp($method, 'cms', 3) === 0)
            $this->addHandler($method, $method);
        }

        //attach events from $this->eventMap
        foreach ($this->eventMap as $event=>$handler) {
            $this->addHandler($event, $handler);
        }
    }

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
            $handler[1] = 'cms'.ucfirst($handler[1]);
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