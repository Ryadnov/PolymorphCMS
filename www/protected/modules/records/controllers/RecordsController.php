<?php
class RecordsController extends Controller
{
    public function handlerUpdate($event)
    {
//        $model = $event->model;

    }

    public function handlerGetAdminTabs($event)
    {
        $this->renderPartial('_adminTabs', array('model'=>$event->model, 'form'=>$event->form));
    }
}