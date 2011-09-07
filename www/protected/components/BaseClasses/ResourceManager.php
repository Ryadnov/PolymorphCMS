<?php
/**
 * registration resources, such as components
 */
class ResourceManager extends CApplicationComponent
{
    private $_p;
    private $_w;

    public $mainRoutes;

    public function init()
    {
        $modules = array();

/*
        // if it module add moduleId to array
        $route = Yii::app()->getRequest()->getPathInfo();
        $module = substr($route,0,strpos($route,'/'));
        if(Yii::app()->hasModule($module))
            $modules[] = $module;
//*/
        
        //register packages
        $modules = $this->addPackages($modules);

        $this->addRoutesFromModules($modules);
    }

    public function addRoutesFromModules($modules)
    {
        $routes = array();
        foreach ($modules as $moduleId) {

            //add routes from module
            $module = Yii::app()->getModule($moduleId);

            if(isset($module->routeMap))
                $routes = CMap::mergeArray($routes, $module->routeMap);
        }

       //in the end, add main rules
        $routes = CMap::mergeArray($routes, $this->mainRoutes);
        Yii::app()->urlManager->addRules($routes);
    }

    public function addPackages($modules)
    {
        Yii::import('components.*');
        Yii::import('components.helpers.*');

        $packagesFolder = FileSystem::directoryMap(Yii::getPathOfAlias('packages'),1);
        $ids = array();
        foreach ($packagesFolder as $item)
            $ids[] = $item['text'];

        foreach ($ids as $id) {
            $path = Yii::getPathOfAlias("packages.$id.config").'.php';
            if (is_file($path)) {
                Yii::app()->setModules(require($path));
                $modules[] = $id;
            }
        }

        return $modules;
    }

    public function getRegisteredWidgets()
    {
        return $this->_w;
    }

    public function registerWidgets($widgets)
    {
        foreach ((array)$widgets as $widget)
            $this->_w[] = $widget;
    }


}