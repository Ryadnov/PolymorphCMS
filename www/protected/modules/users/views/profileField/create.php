<?php
$this->breadcrumbs=array(
	Users::t('Profile Fields')=>Users::url('profileField/admin'),
	Users::t('Create Profile Field'),
);
?>
<h1><?php echo Users::t('Create Profile Field'); ?></h1>

<?php echo $this->renderPartial('_menu',array(
		'list'=> array(),
	)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>