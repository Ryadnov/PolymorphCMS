<?php
class ListViewer extends CComponent
{
	private $cat;
	private $model;

	public function __construct($category)
	{
		$this->cat = $category;
		$this->model = ModelFactory::getModel($category);
	}
}