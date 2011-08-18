<?php
$this->breadcrumbs=array(
	'Lookups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Lookup', 'url'=>array('index')),
	array('label'=>'Create Lookup', 'url'=>array('create')),
	array('label'=>'Update Lookup', 'url'=>array('update', 'id'=>$model->lookup_id)),
	array('label'=>'Delete Lookup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lookup_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lookup', 'url'=>array('admin')),
);
?>

<h1>View Lookup #<?php echo $model->lookup_id; ?></h1>

<?php $this->widget('zii.components.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lookup_id',
		'type',
		'code',
		'name',
	),
)); ?>
