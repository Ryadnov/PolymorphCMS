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

        $this->addHandler('cmsAdminWidgetDetailsGetTabs', 'getTabs');
        $this->addHandler('cmsRegisterWidgets', 'registerWidgets');
    }

    public function getTabs($event)
    {
        $dir = 'mainContent.components.widgets.views.'.$event->widget->pk.'.';
        Y::beginTab('Шаблон списка');
        $this->widget('CodeMirror', $event, array(
            'id'=>'main-content-list-template',
            'content'=>file_get_contents(Yii::getPathOfAlias($dir.'listTemplate')),
            'name'=>'list-template'
        ));
        Y::endTab();
        Y::beginTab('Шаблон элемента');
        $this->widget('CodeMirror', $event, array(
            'id'=>'main-content-item',
            'content'=>file_get_contents(Yii::getPathOfAlias($dir.'item')),
            'name'=>'item'
        ));
        Y::endTab();
        Y::beginTab('Шаблон полный');
        $this->widget('CodeMirror', $event, array(
            'id'=>'main-content-full',
            'content'=>file_get_contents(Yii::getPathOfAlias($dir.'full')),
            'name'=>'full'
        ));
        Y::endTab();
    }

    public function registerWidgets($event)
    {
        $event->widgets = CMap::mergeArray($event->widgets, array('MainContentWidget' => array(
            'title'=>'Главный контент',
            'class'=>'MainContentWidget'
        )));
    }

}