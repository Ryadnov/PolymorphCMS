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
        $this->raiseEvent('onRecordRelations', $this->simpleEvent($relations));
    }

    private function simpleEvent(&$content)
    {
        return new SimpleEvent($this, array('content'=>&$content));
    }

}