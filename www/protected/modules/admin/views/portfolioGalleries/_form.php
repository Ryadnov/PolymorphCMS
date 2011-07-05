<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'galary-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data'
	)
));
	echo $form->errorSummary($model);?>

	<?php Admin::makeTextFields($form, $model, 'descr')?>
	
<?php Admin::makeHiddenFields($form, $model, 'image_name');
	Admin::getImgUploaders($model, 'image_name');?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->