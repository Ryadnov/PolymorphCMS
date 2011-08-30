<?php
class MainContentModule extends Package
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
            'mainContent.components.*',
            'mainContent.components.widgets.*',
        ));
    }

    public function cmsRegisterWidgets($event)
    {
        $event->widgets = CMap::mergeArray($event->widgets, array(
            'MainContentWidget' => array(
                'title'=>'Главный контент',
                'class'=>'MainContentWidget'
            ),
            'DummyWidget' => array(
                'title'=>'Простой текст',
                'class'=>'DummyWidget'
            )
        ));
    }

}