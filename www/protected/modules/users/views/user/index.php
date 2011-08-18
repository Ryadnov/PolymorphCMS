<?php
$this->breadcrumbs=array(
	Users::t("Users"),
);
?>
<h1><?php echo Users::t("List User"); ?></h1>
<?php if(UsersModule::isAdmin()) {
	?><ul class="actions">
	<li><?php echo CHtml::link(Users::t('Manage User'),Users::url('admin')); ?></li>
	<li><?php echo CHtml::link(Users::t('Manage Profile Field'),Users::url('profileField/admin')); ?></li>
</ul><!-- actions --><?php 
} ?>
<?php $this->widget('zii.components.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),Users::url("admin/view",array("id"=>$data->id)))',
		),
		array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):Users::t("Not visited"))',
		),
	),
)); ?>
