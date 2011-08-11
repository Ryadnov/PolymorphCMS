<?php 

$this->widget('ext.QTreeGridView.CQGridView', array(
	'id'=>'posts-grid',
	'dataProvider'=>$model->search($cat->pk),
	'filter'=>	$model,
	'ajaxVar'=> 'ajax',	
    'ajaxUpdate'=> 'ajax',
	'cssFile'=>'/css/grid/styles.css',
    'columns'=>array(
		array(
            'name'=>'second_title',
            'type'=>'raw',
            'value'=>'preg_replace("/(".ModelFactory::contentTags().")/msS", "", $data->second_title)'
        ),
        array(
			'class'=>"DateColumn",
			'name'=>'date',
        	'uiDateFormat' => 'd.m.yy',
			'value'=>'date("d.m.Y", strtotime($data->date))',
			'model'=>$model
		),
		array(
        	'class'=>'AjaxDataColumn',
            'headerText'=>'Опубл.',
			'type'=>'raw',
			'htmlOptions' => array(
				'class'=>'publish-column'
			),
			'value'=>'"<div class=\"".($data->published ? "yes" : "")."\" id=\"published-button-".$data->pk."\" ></div>"'
        ),
		array(
            'class'=>'CButtonColumn',
        	'buttons' => array(
				'view' => array(
					'url'   => '$data->url',
				),
				'update' => array(
					'url' => '$data->updateUrl',
				),
				'delete' => array(
					'url' => '$data->deleteUrl',
				),
			)
        ),
	),
)); ?>

