<?php
$this->breadcrumbs=array(
	'Emails'=>array('index'),
	$model->email_name,
);

$this->menu=array(
	array('label'=>'List Email', 'url'=>array('index')),
	array('label'=>'Create Email', 'url'=>array('create')),
	array('label'=>'Update Email', 'url'=>array('update', 'id'=>$model->email_name)),
	array('label'=>'Delete Email', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->email_name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Email', 'url'=>array('admin')),
);
?>

<h1>View Email #<?php echo $model->email_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email_name',
		'subject',
		'message',
		'from',
		'to',
	),
)); ?>
