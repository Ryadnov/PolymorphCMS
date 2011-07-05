<?php
class MainContentWidget extends Widget
{
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
            $this->render($this->block->pk.'/full', array());
        } else {                          //record-list
            if (isset($this->settings['scopes'])) {
                foreach ($this->settings['scopes'] as $scope=>$params)
                    $this->model->$scope($params);
            }

            $criteria = $this->model->getDbCriteria();
            //return $this->getListView($criteria, $params, $model);
        
//            $this->category->getTemplate('single');
//            $this->category->getTemplate('listTemplate');
        }
    }


    public function getListView(&$criteria, &$params, &$model)
    {
        $dpParams = $this->settings->dataProvider;
        $dataProvider = new EActiveDataProvider(get_class($model), $dpParams);
        $pager = $this->settings->pager;

        //default params
        $params = array(
            'pager'=>array(
                'id'=>$this->command.'Pager', 'class'=>'LinkPager', 'htmlOptions'=>array('class'=>'pager'),
                'cssFile'=>'/css/pager.css'
            ),
            'ajaxUpdate'=>true,
            'template'=>file_get_contents(Yii::getPathOfAlias($cat->pk.'listTemplate')),
            'afterAjaxUpdate' => ModelFactory::getAfterAjaxUpdateFunction($this->command),
            'beforeAjaxUpdate' => ModelFactory::getBeforeAjaxUpdateFunction($this->command),
            'category' => $this->category
        );
        
        try {
            $res = Y::controller()->widget('ListView',$params, true);

        } catch (CException $e) {
            Y::dump($e->getMessage());
        }

        return $res;
    }

    public static function removeWidget() {
        
    }
}