<?php
$this->breadcrumbs=array(
	'Lookups'=>array('index'),
	$model->name=>array('view','id'=>$model->lookup_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lookup', 'url'=>array('index')),
	array('label'=>'Create Lookup', 'url'=>array('create')),
	array('label'=>'View Lookup', 'url'=>array('view', 'id'=>$model->lookup_id)),
	array('label'=>'Manage Lookup', 'url'=>array('admin')),
);
?>

<h1>Update Lookup <?php echo $model->lookup_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>