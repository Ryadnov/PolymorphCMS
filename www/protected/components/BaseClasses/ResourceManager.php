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
        foreach ($modules as $moduleId) {

            //add routes from module
            $module = Yii::app()->getModule($moduleId);

            if(isset($module->urlRules))
                Yii::app()->urlManager->addRules($module->urlRules);
        }

        //in the end, add main rules
        Yii::app()->urlManager->addRules($this->mainRoutes);
    }

    public function addPackages($modules)
    {
        //load plugins
        Yii::import('components.*');
        Yii::import('components.helpers.*');

        $ids = array(
            'records',
            'imageGallery'
        );
        
        foreach ($ids as $id) {
            if (is_file(Yii::getPathOfAlias("packages.$id.config").'.php')) {
                $config = require(Yii::getPathOfAlias("packages.$id.config").'.php');
                Yii::app()->setModules($config);
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
        $this->_w = Y::hooks()->cmsRegisterWidgets($this, array('widgets'=>array()));
    }

    public function getExistsWidgets()
    {
        return $this->_w;
    }

}