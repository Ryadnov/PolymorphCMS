<?php
class PortfolioWorkTypesController extends AdminBaseController
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

	public function loadModel($id = null, $scenario = '')
	{
		return parent::loadModel('PortfolioWorkType', $id, $scenario, false);
	}
	
}
