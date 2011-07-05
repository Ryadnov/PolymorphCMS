<?php
class FileCache extends CFileCache
{	
	const PREFIX = '__tag__';

	/**
	* Инвалидирует данные, помеченные тегом(ами)
	*
	* @param $tags
	* @return void
	*/
	public function clear($tags) 
	{
		foreach ((array)$tags as $tag) {
 			$this->set(self::PREFIX.$tag, time());
 		}
 	}
		
}