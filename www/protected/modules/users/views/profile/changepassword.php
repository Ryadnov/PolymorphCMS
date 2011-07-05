<?php $this->pageTitle=Yii::app()->name . ' - '.Users::t("Change Password");
$this->breadcrumbs=array(
	Users::t("Profile") => Users::url('profile/cabinet'),
	Users::t("Change password"),
);
?>

<h2><?php echo Users::t("Change password"); ?></h2>
<?php if(Y::isGuest()) {$this->widget('GuestMenu');}
	  else {$this->widget('UserMenu');}
?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo Users::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
	<?php echo Users::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo CHtml::submitButton(Users::t("Save")); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->