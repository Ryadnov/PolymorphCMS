<?php $this->pageTitle=Yii::app()->name . ' - '.Users::t("Profile");
$this->breadcrumbs=array(
	Users::t("Profile")=>Users::url('cabinet'),
	Users::t("Edit"),
);
?>
<h2><?php echo Users::t('Edit profile'); ?></h2>
<?php if(Y::isGuest()) {$this->widget('GuestMenu');}
	  else {$this->widget('UserMenu');}
?>

<?php if(Y::hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Y::flash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'profile-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<?php echo $this->renderPartial('_form', array('profile'=>$profile, 'form'=>$form))?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Users::t('Create') : Users::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
