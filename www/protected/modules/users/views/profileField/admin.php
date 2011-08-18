<?php
$this->breadcrumbs=array(
	Users::t('Profile Fields')=>Users::url('profileField/admin'),
	Users::t('Manage Profile Field'),
);
?>
<h1><?php echo Users::t('Manage Profile Fields'); ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(Users::t('Create Profile Field'),Users::url('profileField/create')),
		),
	));
?>

<?php $this->widget('zii.components.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'cssFile'=>'/css/grid/styles.css',
	'columns'=>array(
		'id',
		'varname',
		array(
			'name'=>'title',
			'value'=>'Users::t($data->title)',
		),
		'field_type',
		'field_size',
		//'field_size_min',
		array(
			'name'=>'required',
			'value'=>'ProfileField::itemAlias("required",$data->required)',
		),
		//'match',
		//'range',
		//'error_message',
		//'other_validator',
		//'default',
		'position',
		array(
			'name'=>'visible',
			'value'=>'ProfileField::itemAlias("visible",$data->visible)',
		),
		//*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
