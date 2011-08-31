<?php

class ImageGalleryModule extends Package
{
    //_records is noconflict rule
    public $urlRules = array(
        '_imageGallery/<c>/<a>' => 'imageGallery/<c>/<a>',
        '_imageGallery/<c>' => 'imageGallery/<c>',
        '_imageGallery' => 'imageGallery',
    );

    public $eventMap = array(
        'cmsAdminGetTabs' => array('imageGallery', 'addGalleryTab')
    );

    public $imports = array(
        'imageGallery.models.*',
        'imageGallery.components.behaviors.*',
    );

    public $widgetsMap = array(
        'ImageGalleryWidget' => array(
            'title'=>'Галерея изображений',
            'class'=>'ImageGalleryWidget'
        )
    );

    public function cmsDataTypeRelations($event)
    {
        $event->relations = CMap::mergeArray(
            $event->relations,
            array('gallery' => array(ImageGallery::HAS_MANY, 'ImageGallery', ImageGallery::getPkAttr()))
        );
    }

    //demo for refact
    public function cmsAddDataTypeBehaviors($event)
    {
        $event->sander->attachBehavior('someBehavior', new SomeBehavior);
    }

}
