<?php
$this->breadcrumbs=array(
	'Emails'=>array('index'),
	$model->email_name=>array('view','id'=>$model->email_name),
	'Update',
);

$this->menu=array(
	array('label'=>'List Email', 'url'=>array('index')),
	array('label'=>'Create Email', 'url'=>array('create')),
	array('label'=>'View Email', 'url'=>array('view', 'id'=>$model->email_name)),
	array('label'=>'Manage Email', 'url'=>array('admin')),
);
?>

<h1>Update Email <?php echo $model->email_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>