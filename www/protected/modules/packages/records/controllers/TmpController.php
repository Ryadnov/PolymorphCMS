<?php
class TmpController extends Controller
{
    public function handlerUpdate($event)
    {
        Y::dump($event->model);
    }
}