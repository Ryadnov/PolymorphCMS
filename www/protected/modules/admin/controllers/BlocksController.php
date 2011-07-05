<?php
class BlocksController extends AdminBaseController
{
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($pk = null, $scenario = '')
	{
		return parent::loadModel('TemplateBlock', $pk, $scenario, false);
	}
	
	public function actionAdd($catPk, $alias)
	{
		$model = $this->loadModel();
		$model->category_id = $catPk;
		$model->alias = $alias;
		$model->save();
	}
	
	public function saveWidgetsPosition()
	{
		
	}

	public function actionSee($pk)
	{
		$block = $this->loadModel($pk);
		
		$res = '';
		foreach($block->widgets as $widget) {
			$content = Admin::link('', 'widgets/see', array('pk'=>$widget->pk), array('class'=>'widget-preview'));
			$content.= Admin::link('', 'widgets/settings', array('pk'=>$widget->pk), array('class'=>'widget-settings'));
			$content.= CHtml::tag('div', array(), $widget->alias);
			$content.= Admin::link('x', 'widgets/delete', array('pk'=>$widget->pk), array('class'=>'widget-delete'));
			$res .= CHtml::tag('li', array('class'=>'widget btn-blue'), $content);
		}

		echo CHtml::tag('ul', array(), $res);
	}
	
}