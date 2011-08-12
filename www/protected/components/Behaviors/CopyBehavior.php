<?php
class CopyBehavior extends CBehavior
{
    public function copy()
    {
        $className = get_class($this->getOwner());
        $data = new $className;
        $data->setAttributes($this->getOwner()->getAttributes());
        return $data;
    }
}