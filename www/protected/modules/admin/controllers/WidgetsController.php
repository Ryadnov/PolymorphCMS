<?php
/**
 * WidgetsController class file.
 *
 * @author Alexey Sharov
 * @version 0.2
 */
class WidgetsController extends AdminBaseController
{
    public function loadModel($pk = null, $scenario = '')
    {
        $m = new TemplateWidget($scenario);
        return $m->findByPk($pk);
    }

    public function loadWidget ($model)
    {
        $widgetName = $model->class.'Widget';
        $widget = new $widgetName;
        $widget->setWidgetModel($model);
        return $widget;
    }

    public function actionCreate()
    {
        if (isset($_POST['newWidgets'])) {
            $widgets = array();
            $transaction = Yii::app()->db->beginTransaction();

            foreach ($_POST['newWidgets'] as $class) {
                $model = TemplateWidget::model();
                $model->class = $class;
                $widgetName = $class.'Widget';
                $model->settings = $widgetName::getDefaultSettings();
                $widgets[] = $model;
            }

            //save all widgets in transaction
            try {
                foreach ($widgets as $model)
                    if (!$model->save())
                        throw new CException('Sorry, adding widgets proved unsuccessful. Try again');
                $transaction->commit();
            } catch(Exception $e) { 
                $transaction->rollBack();
                Y::end(Admin::t($e->getMessage()));
            }

            //some output
            $content = Admin::link('', 'widgets/see', array('pk'=>$model->pk), array('class'=>'widget-preview'));
            $content.= Admin::link('', 'widgets/settings', array('pk'=>$model->pk), array('class'=>'widget-settings'));
            $content.= CHtml::tag('div', array(), $model->alias);
            $content.= Admin::link('x', 'widgets/delete', array('pk'=>$model->pk), array('class'=>'widget-delete'));
            echo CHtml::tag('li', array('class'=>'widget'), $content);
        } else {
            //make list of widgets
            $widgets = Y::resources()->registeredWidgets;
            $list = CHtml::listData($widgets, 'pk', 'title');

            $this->renderPartial("/widgets/widgetChangeForm", array('widgets'=>$list, 'action'=>Admin::url('widgets/create')), false, true);
        }
    }

    public function actionDetails($pk)
    {
        if (count($_POST) > 0) {
            $model = $this->loadModel($pk);
            $model->attributes = $_POST['Extra'];
            unset($_POST['Extra']);
            $model->settings = $_POST;

            $widget = $this->loadWidget($model);
            $widget->update();
        } else {
            $model = $this->loadModel($pk);
            $widget = $this->loadWidget($model);
            
            $widget->adminForm();

            $id  = get_class($this).'_setttings_tabs';
            $this->renderPartial('details', array('id'=>$id, 'model'=>$model), false, true);
        }
    }

    public function actionDelete($pk)
    {

    }

    public function actionGallery()
    {
        $createdWidgets = TemplateWidget::model()->findAll();
        $this->render('gallery', array('createdWidgets'=>$createdWidgets));
    }
}