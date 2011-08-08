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

    public function renderBlock($alias)
    {
        if (($block = $this->cat->getBlock($alias)) === null)
            return '{{ '.$alias.' }}';

        return $block->renderBlock();
    }
}
