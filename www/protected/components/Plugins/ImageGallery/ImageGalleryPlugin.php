<?php
class ImageGalleryPlugin extends Plugin
{

    public function register()
    {
        Yii::import('plugins.ImageGallery.models.*');
        Yii::import('plugins.ImageGallery.widgets.*');
                
        $this->addHandler('onDataTypeRelations', 'addRecordRelations');
    }

    public function addRecordRelations($event)
    {
        $event->relations = CMap::mergeArray(
            $event->relations,
            array('gallery' => array(Record::HAS_MANY, 'ImageGallery', ImageGallery::getPkAttr()))
        );
    }

}