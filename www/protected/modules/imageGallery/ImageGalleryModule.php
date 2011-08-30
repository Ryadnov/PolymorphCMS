<?php

class ImageGalleryModule extends Package
{
    //_records is noconflict rule
    public $urlRules = array(
        '_imageGallery/<c>/<a>'=>'imageGallery/<c>/<a>',
        '_imageGallery/<c>'=>'imageGallery/<c>',
        '_imageGallery'=>'imageGallery',
    );

    public $eventMap = array(
        'cmsAdminGetTabs' => array('imageGallery', 'addGalleryTab')
    );

	public function init()
	{
        $this->setImport(array(
			'imageGallery.models.*',
			'imageGallery.components.behaviors.*',
		));
        parent::init();
	}

    public function cmsDataTypeRelations($event)
    {
        $event->relations = CMap::mergeArray(
            $event->relations,
            array('gallery' => array(ImageGallery::HAS_MANY, 'ImageGallery', ImageGallery::getPkAttr()))
        );
    }

    public function cmsAddDataTypeBehaviors($event)
    {
        $event->sander->attachBehavior('someBehavior', new SomeBehavior);
    }

    public function cmsRegisterWidgets($event)
    {
        $event->widgets = CMap::mergeArray($event->widgets, array('ImageGalleryWidget' => array(
            'title'=>'Галлерея изображений',
            'class'=>'ImageGalleryWidget'
        )));
    }
}
