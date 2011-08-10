<?php 
	echo CHtml::tag('div', array('class'=>'admin-flash-msg'), Y::flash('deleteCategory'));
	echo CHtml::link('Создать категорию', Admin::url('categories/createNode'));
	$this->widget('ext.QTreeGridView.CQTreeGridView',array(
		'dataProvider'=>$dp,
		'cssFile'=>'/css/grid/styles.css',
		'template'=>'{items}',
		'hideHeader'=>false,
		//'pager'=>array('cssFile'=>'/css/pager/pager-styles.css'),
		'ajaxUpdate' => true,
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
	            'name'=>'type',
	            'type'=>'raw',
	            'value'=>'$data->type'
	        ),
	        array(
	        	'class'=>'CheckBoxColumnAjax',
	            'headerText'=>'published',
	            'checked'=>'$data->published',
	        ),
	        array(
	            'class'=>'CButtonColumn',
	        	'template'=>'{templates-admin}{view}{update}{remove}',
	        	'htmlOptions' => array('style'=>'width:90px'),
	            'buttons' => array(
	        		/*'published' => array(
	        			'label' => '$data->published ? "Скрыть" : "Опубликовать"',
						'url'   => 'Admin::url("templates/admin", array("catId"=>$data->pk))',
	        			'imageUrl'   => '/images/eyes.png'
					),*/
	            	'templates-admin' => array(
	        			'label' => 'Редактирование Шаблонов',
						'url'   => 'Admin::url("templates/admin", array("catId"=>$data->pk))',
	        			'imageUrl'   => '/images/template-edit.png'
					),
	            	'view' => array(
						'url'   => '$data->adminViewUrl',
					),
					'update' => array(
						'url' => '$data->updateUrl',
					),
					
					'remove' => array(
						'url' => '$data->deleteUrl',
						'imageUrl'=>'/images/delete.png',
						'options'=>array('onClick'=>'$("#delete-category").dialog("open"); $("#delete-category").find("input[name=\'category_id\']").val($(this).closest("tr").attr("id")); return false;')
					),
				)
	        ),
		)
	));
	
	
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'delete-category',
	'htmlOptions'=>array(
		'title'=>'Удаление категории',
	),
	'options'=>array(
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>350,
		'height'=>270,
	),	
));
	echo CHtml::tag('b',array(), "Что сделать со связанными с категорией данными?");

	echo CHtml::dropDownList('deleteCategoryVariant','1',Lookup::items('deleteCategoryVariant'));
	echo CHtml::hiddenField('category_id');

$js_delete =<<< EOD
    var variant = $(this).parent().children('#deleteCategoryVariant').val();
    var catId = $(this).parent().find('input[name="category_id"]').val();
    $("#delete-category").dialog("close");
    if(variant == 1) { 
    	$("#choise-category").dialog("open");
    	$("#relevant-cats").load('/admin/categories/getRelevantCategories',{catId:catId, action:'cut'});
    } else 
    	window.location = '/admin/categories/delete?id='+catId;
    return false;
EOD;
	
	echo CHtml::link('Удалить', '#', array( 'onclick'=>$js_delete));	
	echo CHtml::link('Отмена', '#', array( 'onclick'=>'$("#delete-category").dialog("close"); return false;'));
  
$this->endWidget('zii.widgets.jui.CJuiDialog'); 

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'choise-category',
	'htmlOptions'=>array(
		'title'=>'Выбирете категорию для перемещения',
	),
	'options'=>array(
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>350,
		'height'=>470,
	),
));?>
<div id='relevant-cats'></div>
<?php 
	echo CHtml::submitButton('Отмена', array('onclick'=>'$("#choise-category").dialog("close"); return false;'));
$this->endWidget('zii.widgets.jui.CJuiDialog'); 
?>

