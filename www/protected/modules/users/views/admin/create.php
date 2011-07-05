<?php
$this->breadcrumbs=array(
	Users::t('Users')=>Users::url('admin'),
	Users::t('Create User'),
);
?>
<h1><?php echo Users::t("Create User"); ?></h1>

<?php 
	echo $this->renderPartial('_menu',array(
		'list'=> array(),
	));
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>