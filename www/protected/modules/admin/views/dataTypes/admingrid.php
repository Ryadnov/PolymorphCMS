<?php
$buttons = array(
    'class'=>'CButtonColumn',
    'buttons' => array(
    'view' => array(
        'url'   => '$data->url',
    ),
    'update' => array(
        'url' => 'Admin::url("dataTypes/update", array("catPk"=>$data->category->pk, "pk"=>$data->pk))',
    ),
    'delete' => array(
        'url' => 'Admin::url("dataTypes/delete", array("catPk"=>$data->category->pk, "pk"=>$data->pk))',
    )
));

array_push($columns, $buttons);

$this->widget('ext.QTreeGridView.CQGridView', array(
	'id'=>'posts-grid',
	'dataProvider'=>$model->search($cat->pk),
	'filter'=>	$model,
	'ajaxVar'=> 'ajax',	
    'ajaxUpdate'=> 'ajax',
	'cssFile'=>'/css/grid/styles.css',
    'columns'=>$columns,
    /*
*/)); ?>

