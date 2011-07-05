<?php
class MainContentWidget extends Widget
{
    public $scopes = array();
    
    public static function getDefaultSettings()
	{
		return array();
	}

	public static function getDefaultTitle()
	{
		return 'Родительский блок';
	}

	protected function renderContent()
	{
        if (isset($this->model->pk)) {    //full record
            $this->render('full', array('item'=>$this->model, 'category'=>$this->category));
        } else {                          //record-list
            if (!empty($this->scopes)) {
                foreach ($this->scopes as $scope=>$params)
                    $this->model->$scope($params);
            }

            $criteria = $this->model->getDbCriteria();
            $this->getListView($criteria);
        }
    }

    public function render($view, $data = array(), $return = false)
    {
        return parent::render($this->block->pk.'/'.$view, $data, $return);
    }

    public function getListView(&$criteria, $return = false)
    {
        $dp = new EActiveDataProvider(get_class($this->model), array(
            'criteria' => $criteria,
            //'pagination' => $this->settings['pagination'],
        ));
        
        //default params
        $params = array(
            'dataProvider'=>$dp,
            'pager'=>array(
                'id'=>$this->widgetModel->pk.'Pager', 'class'=>'LinkPager', 'htmlOptions'=>array('class'=>'pager'),
                'cssFile'=>'/css/pager.css'
            ),
            'ajaxUpdate'=>true,
            'template'=>$this->render('listTemplate', array(), true),
            'afterAjaxUpdate' => ModelFactory::getAfterAjaxUpdateFunction($this->category->type),
            'beforeAjaxUpdate' => ModelFactory::getBeforeAjaxUpdateFunction($this->category->type),
            'category' => $this->category,
            'contextWidget' => $this
        );

        try {
            $res = Y::controller()->widget('ListView', $params, true);
        } catch (CException $e) {
            Y::dump($e->__toString());
        }

        if ($return)
            return $res;
        else
            echo $res;
    }

    public static function removeWidget()
    {
        //remove all resources
    }
}