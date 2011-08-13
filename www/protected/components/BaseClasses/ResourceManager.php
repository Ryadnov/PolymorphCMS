<?php
class ResourceManager extends CComponent
{
    private $_w;
    private $_p;

    public function init()
    {
        
    }

    /**
     * register all widgets belonging to blocks of this and parrents categories
     * @param Category $category
     * @return void
     */
    public function registerWidgets($category)
    {
        foreach ($category->allBlocks as $block) {
            foreach ($block['block']->widgets as $widget) {
                Yii::import('widgets.'.$widget->class.'.*');
                $w = Yii::app()->getWidgetFactory()->createWidget(Y::controller(),$widget->class, $widget->settings);
                $w->register($category);
                $this->_w[] = $widget->pk;
            }
        }
    }

    public function registerPlugins($category)
    {
                
    }

}