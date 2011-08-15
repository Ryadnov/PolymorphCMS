<?php
/**
 * registration resources, such as widgets, plug-ins
 */
class ResourceManager extends CApplicationComponent
{
    private $_w;
    private $_p;

    /**
     * register all widgets belonging to blocks of this and parrents categories
     * @param Category $category
     * @return void
     */
    public function registerWidgets($category)
    {
        foreach ($category->allBlocks as $block) {
            foreach ($block['block']->widgets as $widget) {
                Yii::import('widgets.'.$widget->class.'Widget.*');
                $w = Yii::app()->getWidgetFactory()->createWidget(Y::controller(),$widget->class, $widget->settings);
                $w->register($category);
                $this->_w[] = $widget->pk;
            }
        }
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

    
}