<?php
class PagesPlugin extends Plugin
{
    public function register()
    {
        Yii::import('plugins.Pages.models.*');

        $this->addHandler('cmsRegisterDataTypes', 'registerModels');
    }

    public function registerModels($event)
    {
        ModelFactory::registerDataType(Page::model());
    }
    
}