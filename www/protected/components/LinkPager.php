<?php
class LinkPager extends CLinkPager
{
	public $nextPageLabel = "&rarr";
	public $prevPageLabel = "&larr";
	public $header = '';
	
	protected function createPages()
	{
		return new Pagination;
	}
}