<?php
class AdminImageGalleryWidget extends Widget
{
    public $model;
    public $form;
    public $galleryFolder = './images/gallery';
    
    public function update()
    {

    }

    public function remove()
    {

    }

    public function renderContent()
    {
        $this->render('_adminTab', array('model'=>$this->model, 'form'=>$this->form));
    }
}
