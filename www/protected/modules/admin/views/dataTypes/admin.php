<h1>Записи категории "<?php echo $cat->title?>"</h1>
<?php echo CHtml::link('Создать новую запись', Admin::url('dataTypes/create', array('catPk'=>$cat->pk)))?>

<?php $this->renderPartial('admingrid',array(
	'model'=>$model,
	'cat'=>$cat,
    'columns'=>$columns
));?>