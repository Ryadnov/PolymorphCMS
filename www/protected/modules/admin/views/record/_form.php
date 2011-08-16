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
	<?php Admin::makeDateFields($form, $model, 'created', 'dd.mm.yy'); ?>
<?php Y::endTab()?>

<?php
Admin::makeTinyTabs($form, $model, array('text', 'descr'));
Y::hooks()->cmsAdminGetTabs($this, array('model'=>$model, 'form'=>$form));
echo Y::getTabs();
$this->endWidget();
?>
</div><!-- form -->