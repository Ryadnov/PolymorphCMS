<?php

class ImageGalleryModule extends Package
{
    //_records is noconflict rule
    public $urlRules = array(
        '_imageGallery/<c>/<a>'=>'imageGallery/<c>/<a>',
        '_imageGallery/<c>'=>'imageGallery/<c>',
        '_imageGallery'=>'imageGallery',
    );

	public function init()
	{
        $this->setImport(array(
			'imageGallery.models.*',
			'imageGallery.components.behaviors.*',
		));

        $this->addHandler('cmsDataTypeRelations', 'addRecordRelations');
        $this->addHandler('cmsAddDataTypeBehaviors', 'addRecordBehaviors');
        $this->addHandler('cmsAdminGetTabs', array('imageGallery', 'addGalleryTab'));
	}

    public function addRecordRelations($event)
    {
        $event->relations = CMap::mergeArray(
            $event->relations,
            array('gallery' => array(ImageGallery::HAS_MANY, 'ImageGallery', ImageGallery::getPkAttr()))
        );
    }

    public function addRecordBehaviors($event)
    {
        $event->sander->attachBehavior('someBehavior', new SomeBehavior);
    }


}
