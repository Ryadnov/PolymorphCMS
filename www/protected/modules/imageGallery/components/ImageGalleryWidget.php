<?php
class MainContentWidget extends Widget
{
    public $scopes = array();

    public function init()
    {
        parent::init();
    }

    protected function renderContent()
	{
        if (isset($this->model->pk)) {    //full records
            $this->render('full', array('model'=>$this->model, 'category'=>$this->category));
        } else {                          //records-list
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
        if (isset($this->blockModel) && isset($this->model)) {
            return parent::render($this->widgetModel->pk.'/'.$view, $data, $return);
        } else {
            return parent::render($view, $data, $return);
        }
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

    public function remove()
    {
        //remove all resources
    }

    public function update()
    {
        
    }
}