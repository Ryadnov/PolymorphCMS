<?php
class Configurator extends CComponent
{

    public function init()
    {
        $modules = array();

        // if it module add moduleId to array
        $route = Yii::app()->getRequest()->getPathInfo();
        $module = substr($route,0,strpos($route,'/'));
        if(Yii::app()->hasModule($module))
            $modules[] = $module;

        $modules = Configurator::addPackages($modules);

        Configurator::addRoutesFromModules($modules);

    }
    
    public function addRoutesFromModules($modules)
    {
        foreach ($modules as $moduleId) {
            //add routes from module
            $module = Yii::app()->getModule($moduleId);
            if(isset($module->urlRules))
            Yii::app()->getUrlManager()->addRules($module->urlRules);
        }
    }


    public function addPackages($modules)
    {
        //load plugins
        Yii::import('components.*');
        Yii::import('components.helpers.*');

        $config = require(Yii::getPathOfAlias('packages.records.config').'.php');
        $class = $config['class'];
        unset($config['class'], $config['enabled']);

        $m = Yii::createComponent($class, 'records', null, $config);
        $modules[] = 'records';

        return $modules;
    }
}