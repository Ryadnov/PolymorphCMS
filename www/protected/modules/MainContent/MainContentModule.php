<?php
class MainContentModule extends Package
{
    //_records is noconflict rule
    public function getRouteRules()
    {
        return array(
            '_mainContent/<c>/<a>' => 'mainContent/<c>/<a>',
            '_mainContent/<c>' => 'mainContent/<c>',
            '_mainContent' => 'mainContent',
        );
    }

    public function imports()
    {
        return array(
            'mainContent.components.*',
            'mainContent.models.*',
            'mainContent.components.widgets.*'
        );
    }

    public function widgets()
    {
        return array(
            'MainContentWidget' => array(
                'title'=>'Главный контент',
                'class'=>'MainContentWidget'
            ),
            'DummyWidget' => array(
                'title'=>'Простой текст',
                'class'=>'DummyWidget'
            )
        );
    }

    public function dataTypes()
    {
        return array(
            'Page'
        );
    }

}