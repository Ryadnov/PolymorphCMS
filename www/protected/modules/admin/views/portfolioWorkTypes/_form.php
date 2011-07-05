<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'posts-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data'
	)
));
	echo $form->errorSummary($model) ?>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model,'name')?></div>
		<div class="right">
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->