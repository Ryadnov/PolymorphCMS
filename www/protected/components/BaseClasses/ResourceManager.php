<?php
/**
 * registration resources, such as components, plug-ins
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

        //deprecated
        $this->registerPlugins();

        $this->registerWidgets();

    }

    public function addRoutesFromModules($modules)
    {
        $urls = array();
        foreach ($modules as $moduleId) {

            //add routes from module
            $module = Yii::app()->getModule($moduleId);

            if(isset($module->urlRules))
                $urls = CMap::mergeArray($urls, $module->urlRules);
        }

       //in the end, add main rules
        $urls = CMap::mergeArray($urls, $this->mainRoutes);
        Yii::app()->urlManager->addRules($urls);
    }

    public function addPackages($modules)
    {
        //load plugins
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

    public function registerPlugins()
    {
        foreach (PluginModel::model()->published()->findAll() as $plugin) {
            Yii::import('plugins.'.$plugin->class.'.*');
            $pluginName = $plugin->class.'Plugin';
            $p = new $pluginName();
            $p->register();
            $this->_p[] = $plugin->pk;
        }
    }

    public function registerWidgets()
    {
        $res = Y::hooks()->cmsRegisterWidgets($this, array('widgets'=>array()));
        $this->_w = $res['widgets'];
    }

    public function getExistsWidgets()
    {
        return $this->_w;
    }

}