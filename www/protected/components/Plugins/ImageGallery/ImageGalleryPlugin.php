<?php
class ImageGalleryPlugin extends Plugin
{

    public function register()
    {
        Yii::import('plugins.ImageGallery.models.*');
        Yii::import('plugins.ImageGallery.widgets.*');
        Yii::import('plugins.ImageGallery.behaviors.*');
                
        $this->addHandler('cmsDataTypeRelations', 'addRecordRelations');
        $this->addHandler('cmsAddDataTypeBehaviors', 'addRecordBehaviors');
        $this->addHandler('cmsAdminGetTabs', 'addGalleryTab');
    }

    public function addRecordRelations($event)
    {
        $event->relations = CMap::mergeArray(
            $event->relations,
            array('gallery' => array(Record::HAS_MANY, 'ImageGallery', ImageGallery::getPkAttr()))
        );
    }

    public function addRecordBehaviors($event)
    {
        $event->sander->attachBehavior('someBehavior', new SomeBehavior);
    }

    public function addGalleryTab($event)
    {
        Y::beginTab('Галлерея');
        $this->widget('AdminImageGalleryWidget', $event);
        Y::endTab();
    }
}