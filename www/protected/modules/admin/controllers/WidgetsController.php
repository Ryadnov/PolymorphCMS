<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 03.07.11
 * Time: 16:19
 * To change this template use File | Settings | File Templates.
 */
 
class WidgetsController extends AdminBaseController
{
    public function loadModel($pk = null, $scenario = '')
    {
        return parent::loadModel('TemplateWidget', $pk, $scenario, false);
    }

    public function actionCreate($blockPk, $alias)
    {
        $widget = TemplateWidget::model();
        $widget->block_id = $blockPk;
        $widget->alias = $alias;
        $this->performAjaxValidation($widget);

        if ($widget->save()) {
            $content = Admin::link('', 'components/see', array('pk'=>$widget->pk), array('class'=>'widget-preview'));
            $content.= Admin::link('', 'components/settings', array('pk'=>$widget->pk), array('class'=>'widget-settings'));
            $content.= CHtml::tag('div', array(), $widget->alias);
            $content.= Admin::link('x', 'components/delete', array('pk'=>$widget->pk), array('class'=>'widget-delete'));
            echo CHtml::tag('li', array('class'=>'widget btn-blue'), $content);
        }
    }

    public function actionDetails($pk)
    {
        if (count($_POST) > 0) {
            $model = $this->loadModel($pk);
            $model->attributes = $_POST['Extra'];
            unset($_POST['Extra']);
            $model->settings = $_POST;
        } else {
            $model = $this->loadModel($pk);
            Yii::import('components.'.$model->class.'.*');
            $widget = new $model->class;
            $widget->setWidgetModel($model);

            $output = $widget->adminForm($model);
            Y::clientScript()->render($output);
            echo $output;
        }
    }

    public function actionDelete($pk)
    {

    }
}