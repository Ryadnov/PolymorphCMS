<?php $this->pageTitle=Yii::app()->name . ' - '.Users::t("Change Password");
$this->breadcrumbs=array(
	Users::t("Login") => Users::url('login'),
	Users::t("Change Password"),
);
?>

<h1><?php echo Users::t("Change Password"); ?></h1>


<div class="form">
<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo Users::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'password'); ?>
	<?php echo CHtml::activePasswordField($form,'password'); ?>
	<p class="hint">
	<?php echo Users::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo CHtml::submitButton(Users::t("Save")); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->