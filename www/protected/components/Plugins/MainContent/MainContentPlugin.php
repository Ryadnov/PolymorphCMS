<?php
class MainContentPlugin extends Plugin
{
    public function register()
    {
        Yii::import('plugins.MainContent.widgets.*');
    }


}