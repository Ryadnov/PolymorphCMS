<?php
class BlockViewer extends CComponent
{
	private $templateAlias;
	private $cat;
	
	public function __construct($category = null)
	{
        $this->cat = $category;
	}
	
	public function __toString() //__toString can't throw Exception in PHP
	{
        try {
            return $this->{$this->templateAlias};
		} catch(CException $e) {
            Y::dump($e->__toString());
		}
	}

    public function __call($alias, $args)
    {
        return $this->renderBlock($alias);
    }

    public function __get($alias)
    {
        return $this->renderBlock($alias);
    }

    private function renderBlock($alias)
    {
        if (($block = $this->cat->getBlock($alias)) === null)
			return '{{'.$alias.'}}';

		$res = '';
		foreach ($block->widgets as $widget) {
			Yii::import('widgets.'.$widget->class.'.*');
            $res .= $this->renderWidget($widget, $block);
		}

        return $res;
    }

	private function renderWidget($widget, $block)
	{
        $settings = CMap::mergeArray($widget->settings, array(
			'category' => $this->cat,
            'block' => $block,
            'widgetModel' => $widget
		));
        
		return Y::controller()->widget($widget->class, $settings, true);
	}

}