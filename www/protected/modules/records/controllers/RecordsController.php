<?php
class RecordsController extends Controller
{
    public function handlerUpdate($event)
    {
        Y::dump($this->getViewPath());
//        $model = $event->model;

    }

    public function cmsGetAdminTabs($event)
    {
        if (get_class($event->model) == 'Record')
            $this->renderPartial('_adminTabs', array('model'=>$event->model, 'form'=>$event->form));
    }

    public function cmsAdminGetGridColumns($event)
    {
        if (get_class($event->model) == 'Record') {
            $event->columns = CMap::mergeArray($event->columns, array(
                array(
                    'name'=>'title',
                    'type'=>'raw',
                    'value'=>'preg_replace("/(".ModelFactory::contentTags().")/msS", "", $data->second_title)'
                ),
                array(
                    'class'=>"DateColumn",
                    'name'=>'created',
                    'uiDateFormat' => 'd.m.yy',
                    'value'=>'date("d.m.Y", strtotime($data->created))',
                    'model'=>$event->model
                ),
                array(
                    'class'=>'AjaxDataColumn',
                    'headerText'=>'Опубл.',
                    'type'=>'raw',
                    'htmlOptions' => array(
                        'class'=>'publish-column'
                    ),
                    'value'=>'"<div class=\"".($data->published ? "yes" : "")."\" id=\"published-button-".$data->pk."\" ></div>"'
                ),

            ));
        }
    }
}