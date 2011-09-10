<?php

class AdminModule extends Package
{
    public function init()
	{
        parent::init();
	    $this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
        Y::clientScript()->registerScriptFile($this->scriptPath.'/js/cms/asc.js');
	}




}
