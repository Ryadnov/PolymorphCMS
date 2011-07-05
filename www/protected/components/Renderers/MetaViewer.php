<?php
class MetaViewer extends CComponent
{
	private $cat;
	
	public function __construct($category)
	{
		$this->cat = $category;
	}
	
	public function getTitle()
	{
		return $this->cat->meta_title;
	}
	
	public function getKeywords()
	{
		return $this->cat->meta_keywords;
	}
	
	public function getDescription()
	{
		return $this->cat->meta_description;
	}
	
}