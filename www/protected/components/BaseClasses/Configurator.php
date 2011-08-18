<?php
/**
 * this class is initialized onBeforeRequest
 * it registers packages and plugins
 * add routing rules
 */
class Configurator extends CComponent
{

    public function init()
    {
        $modules = array();

        // if it module add moduleId to array, this array exist for adding routing rules
        $route = Yii::app()->getRequest()->getPathInfo();
        $module = substr($route,0,strpos($route,'/'));
        if(Yii::app()->hasModule($module))
            $modules[] = $module;

        $modules = $this->addPackages($modules);

        $this->addRoutesFromModules($modules);
    }
    
    public function addRoutesFromModules($modules)
    {
        foreach ($modules as $moduleId) {
            //add routes from module
            $module = Y::module($moduleId);
            if(isset($module->urlRules))
            Yii::app()->urlManager->addRules($module->urlRules);
        }

        $site = array(
            //site urls
            'rss/<blog_id:\d+>'=>'site/rss',
            'atom/<blog_id:\d+>'=>'site/atom',
            'sitemap.xml'=>'site/sitemapxml',

            '<cat1>/<cat2>/<id:\d+>' => 'site',
            '<cat1>/<id:\d+>' => 'site',

            '<cat1>/<cat2>/<type:(w+)>-<alias:\w+>' => 'site',
            '<cat1>/<type:(w+)>-<alias:\w+>' => 'site',

            '<cat1>/<cat2>' => 'site',
            '<cat1>' => 'site',
            ''=>'site',
        );
        
        Yii::app()->urlManager->addRules($site);
    }


    public function addPackages($modules)
    {
        //load plugins
        Yii::import('components.*');
        Yii::import('components.helpers.*');

        $config = require(Yii::getPathOfAlias('modules.records.config').'.php');
        Yii::app()->setModules(array('records'=>$config));

//        $class = $config['class'];
//        unset($config['class'], $config['enabled']);
//
//
//        $m = Yii::createComponent($class, 'records', null, $config);
        $modules[] = 'records';

        return $modules;
    }
}