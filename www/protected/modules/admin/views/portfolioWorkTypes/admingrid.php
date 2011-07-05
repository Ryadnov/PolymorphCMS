<?php $this->widget('ext.QTreeGridView.CQGridView', array(
	'id'=>'posts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>	$model,
	'ajaxVar'=> 'ajax',	
    'ajaxUpdate'=> 'ajax',
	'cssFile'=>'/css/grid/styles.css',
    'columns'=>array(
    	array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'$data->name'
        ),
        array(
            'class'=>'CButtonColumn',
        	'template'=>"{update}\n{delete}",
            'buttons' => array(
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

