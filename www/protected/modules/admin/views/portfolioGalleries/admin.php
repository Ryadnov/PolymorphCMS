<h1>Галлерея для Портфолио "<?php echo $portfolio->second_title?>"</h1>
<?php echo CHtml::link('Добавить фото', Admin::url($model->adminControllerName.'/create', array('portfolioId'=>$portfolio->pk)))?>
<?php $this->renderPartial('admingrid',array(
	'model'=>$model,
	'portfolio'=>$portfolio
));?>


