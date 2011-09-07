<?php

class ImageGalleryModule extends Package
{
    //_records is noconflict rule
    public function getRouteRules()
    {
        return array(
            '_imageGallery/<c>/<a>' => 'imageGallery/<c>/<a>',
            '_imageGallery/<c>' => 'imageGallery/<c>',
            '_imageGallery' => 'imageGallery',
        );
    }

    public function handlers()
    {
        return array(
            'cmsAdminGetTabs' => array('imageGallery', 'addGalleryTab')
        );
    }

    public function imports()
    {
        return array(
            'imageGallery.models.*',
            'imageGallery.components.behaviors.*',
        );
    }

    public function widgets()
    {
        return array(
            'ImageGalleryWidget' => array(
                'title'=>'Галерея изображений',
                'class'=>'ImageGalleryWidget'
            )
        );
    }

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
