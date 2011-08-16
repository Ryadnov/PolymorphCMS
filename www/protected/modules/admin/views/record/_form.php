<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'posts-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data'
	)
));
	echo $form->errorSummary($model);?>
    
<?php Y::hooks()->cmsAdminGetTabs($this, array('model'=>$model, 'form'=>$form)) ?>
<?php echo Y::getTabs()?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->