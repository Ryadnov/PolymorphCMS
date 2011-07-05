<?php $this->widget('ext.QTreeGridView.CQGridView', array(
	'id'=>'portfolio-grid',
	'dataProvider'=>$model->search($portfolio->pk),
	//'filter'=>	$model,
	'ajaxVar'=> 'ajax',	
    'ajaxUpdate'=> 'ajax',
	'cssFile'=>'/css/grid/styles.css',
    'columns'=>array(
		array(
            'header'=>'Иконка',
            'type'=>'raw',
            'value'=>'$data->getImage("icon", "", array("height"=>48, "width"=>48))'
        ),
        array(
            'header'=>'Название и Адрес',
            'type'=>'raw',
            'value'=>'$data->second_title."<br/>".$data->result_url'
        ),
        array(
			'header'=>'Год и Месяц',
			'type'=>'raw',
            'value'=>'$data->year." ".Y::month($data->month)',
		),
        array(
        	'header'=>'Город и Вид деятельности',
            'type'=>'raw',
            'value'=>'$data->city?$data->city->name:"";echo "<br/>";$data->workType?$data->workType->title:"";'
        ),
        array(
        	'class'=>'AjaxDataColumn',
            'headerText'=>'Опубл.',
			'type'=>'raw',
			'htmlOptions' => array(
				'class'=>'publish-column'
			),
			'value'=>'"<div class=\"".($data->published ? "yes" : "")."\" id=\"published-button-".$data->id."\" ></div>"."<br/>".$data->created'
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

