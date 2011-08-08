<?php
class RenderEvent extends CModelEvent
{
    public function getContent()
    {
        return $this->params['content'];
    }

    public function setContent($val)
    {
        $this->params['content'] = $val;
    }


}