<?php
$this->breadcrumbs=array(
	Users::t('Users')=>Users::url('user/admin'),
	$model->username,
);
?>
<h1><?php echo Users::t('View User').' "'.$model->username.'"'; ?></h1>

<?php
echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(Users::t('Create User'),Users::url('admin/create')),
			CHtml::link(Users::t('Update User'),Users::url('admin/update',array('id'=>$model->id))),
			CHtml::linkButton(Users::t('Delete User'),array('submit'=>array('delete','id'=>$model->id),'confirm'=>Users::t('Are you sure to delete this item?'))),
		),
	)); 

	$attributes = array(
		'id',
		'username',
		'password',
		'email',
		'activkey',
		array(
			'name' => 'createtime',
			'value' => date("d.m.Y H:i:s",$model->createtime),
		),
		array(
			'name' => 'lastvisit',
			'value' => ($model->lastvisit?date("d.m.Y H:i:s",$model->lastvisit):Users::t("Not visited")),
		),
		array(
			'name' => 'role',
			'value' => Lookup::item("role",$model->role),
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
	$this->widget('zii.components.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes
	
	));
	
	$prof_attrs = array();
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($prof_attrs, array(
				'label' => Users::t($field->title),
				'name' => $field->varname,
				'stype'=>'raw',
				'value' => ($field->widgetView($model->profile)?$field->widgetView($model->profile):
										(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):
													$model->profile->getAttribute($field->varname))),
			));
		}
	}
	
	echo 'Профиль';
	
	$this->widget('zii.components.CDetailView', array(
		'data'=>$model->profile,
		'attributes'=>$prof_attrs,
	));
	
?>
