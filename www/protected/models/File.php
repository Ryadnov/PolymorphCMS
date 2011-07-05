<?php
class File extends CModel
{
	public static function getCssJsTrees()
	{
		$cssFiles = array(0 => array(
			'text'=>'css',
			'children'=>self::addLinks(FileSystem::directoryMap('./css'), 'css')
		));
		
		$jsFiles = array(0 => array(
			'text'=>'js', 
			'children'=>self::addLinks(FileSystem::directoryMap('./js'), 'js')
		));

		return array($cssFiles, $jsFiles);
	}
	
	protected static function addLinks($arr, $dir)
	{
		$res = array(); 
		foreach ($arr as $item) {
			$tmp = array();
			$file = $item['text'];
			if ($isDir = isset($item['children'])) {
				$text = $file.CHtml::link('', Admin::url('files/create', array('dir'=>$dir.'/'.$item['text'])), array('class'=>'add_file'));
				$tmp['children'] = self::addLinks($item['children'], $dir.'/'.$file);
			} else {
				$text = CHtml::link($file, Admin::url('files/update', array('dir' => $dir, 'fileName' => $file)), array('class'=>'file'));
			}
			$tmp['text'] = $text;
			
			if (!$isDir) {
				$info = FileSystem::getInfo('./'.$dir.'/'.$file, array('name', 'ext'));
				if (!in_array($info['ext'], array('js', 'css')))
					continue;
			}
			$res[] = $tmp;	
		}
		return $res;
	}

	public function attributeNames()
	{
		return array();
	}
	
}