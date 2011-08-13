<?php
/**
 * registration events
 * all events in CMS must be incapsulated there
 * Use:
 * 1. setUp - Y::events()->event = function($event) {};
 * 2. call - Y::events()->event($params);
 */
class GlobalEventManager extends CComponent
{
    
    public function init()
    {
        
    }

    public function onRecordRelations(&$relations)
    {
        $event = new SimpleEvent($this, array('content'=>&$relations));
        $this->raiseEvent('onRecordRelations', $event);
    }

}