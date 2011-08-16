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

<?php Admin::makeTinyTabs($form, $model, array('text', 'descr'))?>
