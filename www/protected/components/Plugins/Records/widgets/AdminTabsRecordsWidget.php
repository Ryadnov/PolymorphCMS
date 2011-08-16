<?php
class AdminTabsWidget extends Widget
{
    public $model;
    public $form;

    public function update()
    {

    }

    public function renderContent()
    {
        $this->render('_adminTabs', array('model'=>$this->model, 'form'=>$this->form));
    }
    
}