<?php
$this->breadcrumbs=array(
	Users::t('Users')=>Users::url('admin'),
	Users::t('Manage User'),
);
?>
<h1><?php echo Users::t("Manage Users"); ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(Users::t('Create User'),Users::url('admin/create')),
		),
	));
?>

<?php $this->renderPartial('admingrid', 
	array('model'=>$model)
)?>
