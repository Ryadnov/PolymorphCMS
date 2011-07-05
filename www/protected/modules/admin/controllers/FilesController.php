<?php
class FilesController extends AdminBaseController
{
	public function actionManage() 
	{	
		list ($cssFiles, $jsFiles) = File::getCssJsTrees();
		
		$this->render('directories', array(
			'cssFiles' => $cssFiles,
			'jsFiles' => $jsFiles
		));
	}
	
	public function actionUpdate($dir, $fileName)
	{
		if (isset($_POST['file_content']))
			FileSystem::write('./'.$dir.'/'.$fileName, $_POST['file_content'], 'w');
			
		$content = '';
		$info = FileSystem::getInfo('./'.$dir.'/'.$fileName, array('name', 'ext'));
		if (in_array($info['ext'], array('js', 'css'))) {
			if (substr($dir, 0, 2) == 'js' || substr($dir, 0, 3) == 'css') {
				$content = FileSystem::read('./'.$dir.'/'.$fileName);
			}	
		}
		
		echo CJSON::encode(array(
			'fileName' => $fileName,
			'content' => $content,
			'type' => $info['ext'] == 'css' ? 'css' : 'javascript',
			'filePath' => './'.$dir.'/'.$fileName
		));	
	}

	public function actionCreate($dir, $fileName)
	{
		if (FileSystem::write('./'.$dir.'/'.$fileName, '', 'x'))
			$msg = 'Файл Создан';
		else
			$msg = 'Файл Не Создан';
			
		echo CJSON::encode(array('msg' => $msg));
	}
	
	public function actionDelete($dir, $fileName)
	{
		if (FileSystem::deleteFiles('./'.$dir.'/'.$fileName))
			$msg = 'Файл Удален';
		else
			$msg = 'Файл Не Удален';
		
		
		echo CJSON::encode(array('msg' => $msg));
	}
}