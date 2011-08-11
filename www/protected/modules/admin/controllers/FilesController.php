<?php
class FilesController extends AdminBaseController
{
	public function actionCssManage()
	{	
		$this->renderAjax('css', array(
			'cssFiles' => File::getCssTree(),
		));
	}

    public function actionJsManage()
    {
		$this->renderAjax('js', array(
			'jsFiles' => File::getJsTree()
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
		
		$output = $this->renderPartial('fileDetails', array(
			'fileName' => $fileName,
			'content' => $content,
			'type' => $info['ext'] == 'css' ? 'css' : 'javascript',
			'filePath' => './'.$dir.'/'.$fileName
		), true);
        Y::clientScript()->render($output);
        $this->beginTab('Содержимое файла');
        echo $output;
        $this->endTab();
        $this->getTabs('cssFileForm');
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