<?
$dp = $model->search();
$dp->pagination->pageSize = 20;

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'posts-grid',
	'dataProvider'=>$dp,
	'filter' =>	$model,
	'cssFile' => '/css/grid/styles.css',
    'columns'=>array(
    	array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'$data->title'
        ),
        array(
            'name'=>'alias',
            'type'=>'raw',
            'value'=>'$data->alias'
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

