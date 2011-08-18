<?php
class ImageGalleryController extends Controller
{

    public function handlerAddGalleryTab($event)
    {
        Y::beginTab('Галлерея');
        $this->renderPartial('_adminTab', array('model'=>$event->model, 'form'=>$event->form));
        Y::endTab();
    }
}