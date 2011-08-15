<?php
class Plugin extends CComponent
{
    public function register()
    {
        
    }

    public function install()
    {

    }

    public function uninstall()
    {

    }

    public function addHandler($eventName, $methodName)
    {
        Y::events()->$eventName = array($this, $methodName);
    }
    
}