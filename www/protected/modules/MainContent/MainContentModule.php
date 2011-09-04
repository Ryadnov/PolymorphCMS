<?php
class MainContentModule extends Package
{
    //_records is noconflict rule
    public $routeMap = array(
        '_imageGallery/<c>/<a>' => 'imageGallery/<c>/<a>',
        '_imageGallery/<c>' => 'imageGallery/<c>',
        '_imageGallery' => 'imageGallery',
    );

    public $imports = array(
        'mainContent.components.*',
        'mainContent.models.*',
        'mainContent.components.widgets.*'
    );

    public $widgetsMap =array(
        'MainContentWidget' => array(
            'title'=>'Главный контент',
            'class'=>'MainContentWidget'
        ),
        'DummyWidget' => array(
            'title'=>'Простой текст',
            'class'=>'DummyWidget'
        )
    );


    public $dataTypesMap = array(
         'Page'
     );

}