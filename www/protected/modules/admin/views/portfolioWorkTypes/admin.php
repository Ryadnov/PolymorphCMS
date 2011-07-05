<h1>Виды деятельности</h1>
<?php echo CHtml::link('Создать новый вид деятельности', Admin::url($model->adminControllerName.'/create'))?>
<?php $this->renderPartial('admingrid',array(
	'model'=>$model,
));?>