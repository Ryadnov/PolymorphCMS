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
            $viewName = $this->category->type == 'Page' ? 'fullPage' : 'full';
            $this->render($viewName, array('model'=>$this->model, 'category'=>$this->category));
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
            'afterAjaxUpdate' => 'js:funciton() {}',
            'beforeAjaxUpdate' => 'js:funciton() {}',
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
        $dir = 'mainContent.components.widgets.views.'.$this->widgetModel->pk.'.';
                
        if (isset($_POST['list-template'])) {
            FileSystem::write(Yii::getPathOfAlias($dir.'listTemplate').'.twig', $_POST['list-template']);
        }
        if (isset($_POST['item'])) {
            FileSystem::write(Yii::getPathOfAlias($dir.'item').'.twig', $_POST['item']);
        }
        if (isset($_POST['full'])) {
            FileSystem::write(Yii::getPathOfAlias($dir.'full').'.twig', $_POST['full']);
        }
    }

    public function adminForm()
    {
        $dir = 'mainContent.components.widgets.views.MainContent.'.$this->widgetModel->pk.'.';
        Y::beginTab('Шаблон списка');
        $this->widget('CodeMirror', array(
            'type'=>'text/html',
            'id'=>'main_content_list_template',
            'content'=>FileSystem::read(Yii::getPathOfAlias($dir.'listTemplate').'.twig'),
            'name'=>'list-template'
        ));
        Y::endTab();
        Y::beginTab('Шаблон элемента');
        $this->widget('CodeMirror', array(
            'type'=>'text/html',
            'id'=>'main_content_item',
            'content'=>FileSystem::read(Yii::getPathOfAlias($dir.'item').'.twig'),
            'name'=>'item'
        ));
        Y::endTab();
        Y::beginTab('Шаблон полный');
        $this->widget('CodeMirror', array(
            'type'=>'text/html',
            'id'=>'main_content_full',
            'content'=>FileSystem::read(Yii::getPathOfAlias($dir.'full').'.twig'),
            'name'=>'full'
        ));
        Y::endTab();

    }
}