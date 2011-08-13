<?php
class GlobalEventManager extends CComponent
{
    
    public function init()
    {
        
    }

    public function onRecordRelations($event)
    {
        $this->raiseEvent('onRecordRelations', $event);
    }


}