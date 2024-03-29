<?php
class BlockViewer
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
            return $this->renderBlock($this->templateAlias);
        } catch (CException $e) {
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

    public function renderBlock($alias)
    {
        if (!isset($this->cat)) {
            if (($module = Y::module()) != null) {
                $this->cat = $module->category;
            }
        }
        if (($block = $this->cat->getBlock($alias)) === null)
            return '{{ ' . $alias . ' }}';

        return $block->renderBlock($this->cat);
    }


}
