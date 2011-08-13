<?php
/**
 * registration events
 * all events in CMS must be incapsulated there
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