<?php
class TmpController extends Controller
{
    public function handlerUpdate($event)
    {
//        $model = $event->model;

    }

    public function handlerGetAdminTabs($event)
    {
        $this->render('_adminTabs', array('model'=>$event->model, 'form'=>$event->form), true);
    }
}