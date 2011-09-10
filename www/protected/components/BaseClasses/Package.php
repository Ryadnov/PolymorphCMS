<?php
class Package extends CWebModule
{
    //urlManager rules
    public function getRouteRules() {return array();}

    //eventName => array(class, method)
    public function handlers() {return array();}

    //simple modelNames
    public function dataTypes() {return array();}

    /*
    array(
        'title'=>widgetTitle,
        'class'=>widgetClassName
    )
    */
    public function widgets() {return array();}

    public $scriptPath;
    
    public function init()
    {
        parent::init();

        //attach events from $this->eventMap
        foreach ($this->handlers() as $event=>$handler)
            $this->addHandler($event, $handler);

        //dataTypes register
        ModelFactory::registerDataTypes($this->dataTypes());

        //register widets
        Y::resources()->registerWidgets($this->widgets());

        //set assets path
        if (is_dir($path = Yii::getPathOfAlias($this->getId().'.assets'))) {
            $this->scriptPath = Yii::app()->getAssetManager()->publish($path);
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