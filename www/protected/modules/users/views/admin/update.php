<?php
$this->breadcrumbs=array(
	(Users::t('Users'))=>array('admin'),
	$model->username=>array('view','id'=>$model->id),
	(Users::t('Update User')),
);
?>

<h1><?php echo  Users::t('Update User')." ".$model->id; ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(Users::t('Create User'),Users::url('admin/create')),
			CHtml::link(Users::t('View User'),Users::url('admin/view',array('id'=>$model->id))),
		),
	)); 

	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile)); ?>