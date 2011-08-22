<?php
class ClientScript extends CClientScript
{
    public function ajaxExclude($names)
    {
        if (Y::isAjaxRequest()) {
            $files = array();
            foreach ((array)$names as $name)
                $files[$name] = false;

            Y::clientScript()->scriptMap = CMap::mergeArray(
                Y::clientScript()->scriptMap,
                $files
            );
        }
    }
}