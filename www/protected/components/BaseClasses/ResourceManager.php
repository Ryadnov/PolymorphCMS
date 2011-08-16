<?php
/**
 * registration resources, such as widgets, plug-ins
 */
class ResourceManager extends CApplicationComponent
{
    private $_p;

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

    
}