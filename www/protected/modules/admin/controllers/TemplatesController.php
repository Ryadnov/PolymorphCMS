<?php
class TemplatesController extends AdminBaseController
{	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
	        array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','admin'),
				'roles'=>array('writer'),
			),
			array('deny',  // deny all users
		        'actions'=>array('*'),    
		        'users'=>array('*'),
	        ),
	    );
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($catId)
	{
		$cat = Category::model()->findByPk($catId);
		if ($cat ==null) 
			throw new CException("Неизвестный id категории: $catId");
		
		$trees = $this->getTemplatesTree($cat);
		
		$this->render('admin',array(
			'trees'=>$trees,
		));
	}
	
	public function actionUpdate($pk) 
	{
		if (Y::isAjaxRequest() && isset($_POST['type']) && isset($_POST['filePath']) && isset($_POST['css_file_content'])  && isset($_POST['js_file_content'])) {
			if (!in_array($_POST['type'], array('css','javascript')))
				throw new CException('Type должно принимать значение "css", "javascript"');
			
			$content = ($_POST['type'] == 'css') ? $_POST['css_file_content'] : $_POST['js_file_content'];
			if (FileSystem::write($_POST['filePath'], $content, 'w')) 
				echo CJSON::encode(array('status'=>'ok','msg'=>'Файл сохранен'));	
			else 
				echo CJSON::encode(array('status'=>'error','errors'=>array('Файл не сохранен')));
			
			Y::end();
		}
		
		list ($cssFiles, $jsFiles) = File::getCssJsTrees();
		parent::actionUpdate($pk, array('cssFiles'=>$cssFiles, 'jsFiles'=>$jsFiles));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($pk = null, $scenario = '')
	{
		return parent::loadModel('Template', $pk, $scenario, false);
	}

	public function getTemplatesTree($cat)
	{
		$level = $cat->level;
		$res = $base = array();
		for ($i=0;$i<$level;$i++) {			//display all trees
			$templates = $cat->templates;
			$children = array();
			
			foreach ($templates as $tmpl) {	//display all templates in tree
				$options = array('text'=>$tmpl->updateLink); 
				if(in_array($tmpl->alias, $base))
					$options['htmlOptions'] = array('class' => 'red');
				else 	
					array_push($base, $tmpl->alias);
				$children[] = $options;
			}
			$children[] = array(
				'text' => Admin::link('Добавить новый шаблон', 'templates/create', array('catId'=>$cat->pk)),
				'htmlOptions' => array('class'=>'green')
			);
			$tmp = array(
				'text' => $cat->updateLink,
				'children' => $children
			);
			$res[$i] = $tmp;
			$cat = $cat->parent;
		}	
		return $res;
	}

}
