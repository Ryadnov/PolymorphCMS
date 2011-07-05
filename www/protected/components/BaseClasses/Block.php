<?php
class Block extends CClipWidget
{
	public $_cat;
	public $alias;

	public function __construct($category)
    {
        parent::__construct();
        $this->_cat = $category;
    }

    public function __get($alias)
    {
        $this->alias = $alias;

		$this->beginClip($alias);
			$this->renderAllWidgets();
		$this->endClip();

		return $this->clips[$alias];
	}

	private function renderAllWidgets()
	{
		//?????
		//нужно сначала написать портлеты и интерфейсы,
		//а после этого уже написать эту ф-ю
		//идея по кэшированию: т.к. у нас настройки в строке json,
		//то в купе с id категории они дают нам уникальный идентефикатор

		$this->_cat->blocks[$this->alias];
	}

}