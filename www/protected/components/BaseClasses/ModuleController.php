<?php
class ModuleController extends Controller
{
    public function render($view, $data = array(), $return = false)
    {
        $content = $this->renderPartial($view, $data, true);

        
    }
}