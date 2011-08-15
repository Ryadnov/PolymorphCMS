<?php
/**
 * registration events
 * all events in CMS must be incapsulated there
 * Use:
 * 1. setUp - Y::events()->event = function($event) {};
 * 2. call - Y::events()->event($params);
 */
class GlobalEventManager extends CApplicationComponent
{
    private $_e;

    public function __set($name,$value)
	{
        if(strncasecmp($name,'on',2)===0)
		{
			// duplicating getEventHandlers() here for performance
			$name=strtolower($name);
			if(!isset($this->_e[$name]))
				$this->_e[$name]=new CList;
			return $this->_e[$name]->add($value);
		}
    }

    public function __call($name, $parameters)
	{
        $sender = $parameters[0];
        $params = isset($parameters[1]) ? $parameters[1] : array();
        return $this->raiseEvent($name, $this->event($sender, $params));
	}

    public function hasEvent($name)
    {
        return true;
    }
    
    public function raiseEvent($name,$event)
	{
		$name=strtolower($name);
		if(isset($this->_e[$name]))
		{
			foreach($this->_e[$name] as $handler)
			{
				if(is_string($handler))
					call_user_func($handler,$event);
				else if(is_callable($handler,true))
				{
					if(is_array($handler))
					{
						// an array: 0 - object, 1 - method name
						list($object,$method)=$handler;
						if(is_string($object))	// static method call
							call_user_func($handler,$event);
						else if(method_exists($object,$method))
							$object->$method($event);
						else
							throw new CException(Yii::t('yii','Event "{class}.{event}" is attached with an invalid handler "{handler}".',
								array('{class}'=>get_class($this), '{event}'=>$name, '{handler}'=>$handler[1])));
					}
					else // PHP 5.3: anonymous function
						call_user_func($handler,$event);
				}
				else
					throw new CException(Yii::t('yii','Event "{class}.{event}" is attached with an invalid handler "{handler}".',
						array('{class}'=>get_class($this), '{event}'=>$name, '{handler}'=>gettype($handler))));
				// stop further handling if param.handled is set true
				if(($event instanceof CEvent) && $event->handled)
					return;
			}
		}
		else if(YII_DEBUG && !$this->hasEvent($name))
			throw new CException(Yii::t('yii','Event "{class}.{event}" is not defined.',
				array('{class}'=>get_class($this), '{event}'=>$name)));
	}

    private function event($sender, &$parameters)
    {
        return new SimpleEvent($sender, &$parameters);
    }


}