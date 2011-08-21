<?php
echo CHtml::beginForm($action);
    echo CHtml::checkBoxList('newWidgets', '', $widgets);
    echo '</br>'.CHtml::ajaxSubmitButton('Добавить','',array('success'=>'js:function(){}'), array('id'=>'widget_change_button'));
echo CHtml::endForm();