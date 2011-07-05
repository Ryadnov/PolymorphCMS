<?php
$this->breadcrumbs=array(
	Users::t('Profile Fields')=>Users::url('profileField/admin'),
	$model->title=>array('view','id'=>$model->id),
	Users::t('Update Profile Field'),
);
?>

<h1><?php echo Users::t('Update ProfileField ').$model->id; ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(Users::t('Create Profile Field'),Users::url('profileField/create')),
			CHtml::link(Users::t('View Profile Field'),Users::url('profileField/view',array('id'=>$model->id))),
		),
	));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>