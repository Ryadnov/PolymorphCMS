<?php
class MainContentPlugin extends Plugin
{

    public function register()
    {
        Y::events()->onDataTypeRelations = function($event) {
            $event->content = CMap::mergeArray(
                $event->content,
                array('gallery' => array(Record::HAS_MANY, 'ImageGallery', ImageGallery::getPkAttr()))
            );
        };
    }

}