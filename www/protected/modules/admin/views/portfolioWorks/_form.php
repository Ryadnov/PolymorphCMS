<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'portfolio-work-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data'
	)
));
	echo $form->errorSummary($model);
	
	$this->beginTab('Основные данные');
		Admin::makeTextFields($form, $model, array('title', 'alias'));
	$this->endTab();
	
	Admin::makeTinyTabs($form, $model, 'descr');
	
	$this->beginTab('Изображения');
		Admin::makeHiddenFields($form, $model, array('icon'));
		Admin::getImgUploaders($model, array('icon'));
	$this->endTab();
	
	$this->getTabs();
	?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
<?php $this->endWidget(); ?>

	
</div><!-- form -->