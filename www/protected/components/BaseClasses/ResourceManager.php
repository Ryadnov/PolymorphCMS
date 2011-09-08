<?php
/**
 * registration resources, such as components
 */
class ResourceManager extends CApplicationComponent
{
    private $_w; //widget classes
    private $_m; //module ids
    private $_r; //routes

    public $mainRoutes;

    public function init()
    {
        //register packages
        $this->addPackages();
        $this->addRoutesFromModules();
    }

    public function addRoutesFromModules()
    {
        $routes = array();
        foreach ($this->_m as $moduleId) {
            //add routes from module
            $module = Yii::app()->getModule($moduleId);
            $this->_r = CMap::mergeArray($this->_r, $module->getRouteRules());
        }

       //in the end, add main rules
       $this->_r = CMap::mergeArray($this->_r, $this->mainRoutes);
        
        Yii::app()->urlManager->addRules($this->_r);
    }

    public function addPackages()
    {
        Yii::import('components.*');
        Yii::import('components.helpers.*');

        $packagesFolder = FileSystem::directoryMap(Yii::getPathOfAlias('packages'),1);
        $ids = array();
        foreach ($packagesFolder as $item)
            $ids[] = $item['text'];

        $folder = Yii::getPathOfAlias("packages").'/';
        $modules = array();
        foreach ($ids as $id) {
            $path = $folder.$id.'/config.php';
            if (is_file($path)) {
                $modules = CMap::mergeArray($modules, require($path));
                $this->_m[] = $id;
            }
        }
        Yii::app()->setModules($modules);
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