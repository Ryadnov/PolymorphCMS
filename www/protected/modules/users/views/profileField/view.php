<?php
$this->breadcrumbs=array(
	Users::t('Profile Fields')=>Users::url('profileField/admin'),
	Users::t($model->title),
);
?>
<h1><?php echo Users::t('View Profile Field #').$model->varname; ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(Users::t('Create Profile Field'),Users::url('profileField/create')),
			CHtml::link(Users::t('Update Profile Field'),Users::url('profileField/update',array('id'=>$model->id))),
			CHtml::linkButton(Users::t('Delete Profile Field'),array('submit'=>Users::url('profileField/delete',array('id'=>$model->id)),'confirm'=>'Are you sure to delete this item?')),
		),
	));
?>

<?php $this->widget('zii.components.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'varname',
		'title',
		'field_type',
		'field_size',
		'field_size_min',
		'required',
		'match',
		'range',
		'error_message',
		'other_validator',
		'widget',
		'widgetparams',
		'default',
		'position',
		'visible',
	),
)); ?>
