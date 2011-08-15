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
	
<?php Y::beginTab('Настройки')?>
	<?php Admin::makeTextFields($form, $model, array('title', 'second_title', 'alias'))?>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model,'published')?></div>
		<div class="right">
			<?php if ($model->isNewRecord) $model->published = Record::PUBLISHED?>
			<?php echo $form->radioButtonList($model,'published',Lookup::items('FPublished'));?>
		</div>
	</div>
	<?php if ($model->isNewRecord) $model->date = date('d.m.Y')?>
	<?php Admin::makeDateFields($form, $model, 'date', 'dd.mm.yy'); ?>
<?php Y::endTab()?>

<?php Admin::makeTinyTabs($form, $model, array('text', 'descr'))?>
<?php Y::events()->onAdminGetTabs($this) ?>
<?php echo Y::getTabs()?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->