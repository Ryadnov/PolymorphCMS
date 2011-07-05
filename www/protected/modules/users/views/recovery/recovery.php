<?php $this->pageTitle=Yii::app()->name . ' - '.Users::t("Restore");
$this->breadcrumbs=array(
	Users::t("Login") => Users::url('login'),
	Users::t("Restore"),
);
?>

<h1><?php echo Users::t("Restore"); ?></h1>

<?php if(Y::hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Y::flash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><?php echo Users::t("Please enter your login or email addres."); ?></p>
	</div>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(Users::t("Restore")); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>