<?php
class ETwigStaticClassProxy
{
    private $_staticClassName;

    public function __construct($staticClassName) {
        $this->_staticClassName = $staticClassName;
    }

    public function __get($property)
    {
        return ${$this->_staticClassName}::$property;
    }

    public function __set($property, $value)
    {
        return (${$this->_staticClassName}::$property = $value);
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->_staticClassName, $method), $arguments);
    }
}