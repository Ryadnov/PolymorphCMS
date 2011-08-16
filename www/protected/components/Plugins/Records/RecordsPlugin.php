<?php
class RecordsPlugin extends Plugin
{
    public function register()
    {
        Yii::import('plugins.Records.models.*');

        $this->addHandler('cmsRegisterDataTypes', 'registerModels');
    }

    public function registerModels($event)
    {
        ModelFactory::registerDataType(Record::model());
    }
    
}