<?php
class PagesController extends AdminBaseController
{	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($pk = null, $scenario = '')
	{
		return parent::loadModel('Page', $pk, $scenario, false);
	}
	
}
