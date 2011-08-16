<?php
class HooksEvent extends CModelEvent
{
    
    public function __get($name)
    {
        return $this->params[$name];
    }

    public function __set($name, $val)
    {
        $this->params[$name] = $val;
    }

}