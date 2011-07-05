<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'ajaxVar'=> 'ajax',
    'ajaxUpdate'=> 'ajax',
	'cssFile'=>'/css/grid/styles.css',
	'filter'=>$model,
	
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),Users::url("admin/update",array("id"=>$data->id)))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),Users::url("admin/view",array("id"=>$data->id)))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter'=>User::aliases('UserStatus'),
		),
		array(
			'name'=>'role',
			'type'=>'raw',
			'value'=>'Lookup::item("role",$data->role)',
			'filter'=>Lookup::items('role'),
		),
		array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
			'value' => '($data->lastvisit?date("d.m.Y H:i:s",$data->lastvisit):Users::t("Not visited"))',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>