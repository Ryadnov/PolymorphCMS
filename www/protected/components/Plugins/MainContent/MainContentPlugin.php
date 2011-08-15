<?php
class MainContentPlugin extends Plugin
{
    public function register()
    {
        Yii::import('plugins.MainContent.widgets.*');

        $this->addHandler('onAdminGetTabs', 'getTabs');

    }

    public function getTabs()
    {
        Y::beginTab('Шаблон списка');
        Y::controller()->widget('CodeMirror', array(
            'id'=>'main-content-list-template',
            'content'=>'slfj',
            'name'=>'list-template'
        ));
        Y::endTab();
        Y::beginTab('Шаблон элемента');
        Y::endTab();
        Y::beginTab('Шаблон полный');
        Y::endTab();
    }

}