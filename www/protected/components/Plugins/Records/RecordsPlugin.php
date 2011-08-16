<?php
class RecordsPlugin extends Plugin
{
    public function register()
    {
        Yii::import('plugins.Records.models.*');
        Yii::import('plugins.Records.widgets.*');

        $this->addHandler('cmsRegisterDataTypes', 'registerModels');
        $this->addHandler('cmsAdminGetTabs', 'addAdminTabs');
    }

    public function registerModels($event)
    {
        ModelFactory::registerDataType(Record::model());
    }

    public function addAdminTabs($event)
    {
        Y::controller()->widget('AdminTabsRecordsWidget', array('model'=>$event->model, 'form'=>$event->form));
    }
    
}