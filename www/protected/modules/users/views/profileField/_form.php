<div class="form">

<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo Users::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row varname">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'varname'); ?>
		</div>
		<div class="right">
		<?php echo (($model->id)?CHtml::activeTextField($model,'varname',array('size'=>60,'maxlength'=>50,'readonly'=>true)):CHtml::activeTextField($model,'varname',array('size'=>60,'maxlength'=>50))); ?>
		<?php echo CHtml::error($model,'varname'); ?>
		<p class="hint"><?php echo Users::t("Allowed lowercase letters and digits."); ?></p>
		</div>
	</div>

	<div class="row title">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'title'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'title'); ?>
		<p class="hint"><?php echo Users::t('Field name on the language of "sourceLanguage".'); ?></p>
		</div>
	</div>

	<div class="row field_type">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'field_type'); ?>
		</div>
		<div class="right">
		<?php echo (($model->id)?CHtml::activeTextField($model,'field_type',array('size'=>60,'maxlength'=>50,'readonly'=>true,'id'=>'field_type')):CHtml::activeDropDownList($model,'field_type',ProfileField::itemAlias('field_type'),array('id'=>'field_type'))); ?>
		<?php echo CHtml::error($model,'field_type'); ?>
		<p class="hint"><?php echo Users::t('Field type column in the database.'); ?></p>
		</div>
	</div>

	<div class="row field_size">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'field_size'); ?>
		</div>
		<div class="right">
		<?php echo (($model->id)?CHtml::activeTextField($model,'field_size',array('readonly'=>true)):CHtml::activeTextField($model,'field_size')); ?>
		<?php echo CHtml::error($model,'field_size'); ?>
		<p class="hint"><?php echo Users::t('Field size column in the database.'); ?></p>
		</div>
	</div>

	<div class="row field_size_min">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'field_size_min'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'field_size_min'); ?>
		<?php echo CHtml::error($model,'field_size_min'); ?>
		<p class="hint"><?php echo Users::t('The minimum value of the field (form validator).'); ?></p>
		</div>
	</div>

	<div class="row required">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'required'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeDropDownList($model,'required',ProfileField::itemAlias('required')); ?>
		<?php echo CHtml::error($model,'required'); ?>
		<p class="hint"><?php echo Users::t('Required field (form validator).'); ?></p>
		</div>
	</div>

	<div class="row match">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'match'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'match',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'match'); ?>
		<p class="hint"><?php echo Users::t("Regular expression (example: '/^[A-Za-z0-9\s,]+$/u')."); ?></p>
		</div>
	</div>

	<div class="row range">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'range'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'range',array('size'=>60,'maxlength'=>5000)); ?>
		<?php echo CHtml::error($model,'range'); ?>
		<p class="hint"><?php echo Users::t('Predefined values (example: 1;2;3;4;5 or 1==One;2==Two;3==Three;4==Four;5==Five).'); ?></p>
		</div>
	</div>

	<div class="row error_message">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'error_message'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'error_message',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'error_message'); ?>
		<p class="hint"><?php echo Users::t('Error message when you validate the form.'); ?></p>
		</div>
	</div>

	<div class="row other_validator">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'other_validator'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'other_validator',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'other_validator'); ?>
		<p class="hint"><?php echo Users::t('JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('file'=>array('types'=>'jpg, gif, png'))))); ?></p>
		</div>
	</div>

	<div class="row default">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'default'); ?>
		</div>
		<div class="right">
		<?php echo (($model->id)?CHtml::activeTextField($model,'default',array('size'=>60,'maxlength'=>255,'readonly'=>true)):CHtml::activeTextField($model,'default',array('size'=>60,'maxlength'=>255))); ?>
		<?php echo CHtml::error($model,'default'); ?>
		<p class="hint"><?php echo Users::t('The value of the default field (database).'); ?></p>
		</div>
	</div>

	<div class="row widget">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'widget'); ?>
		</div>
		<div class="right">
		<?php 
		list($widgetsList) = ProfileFieldController::getWidgets($model->field_type);
		echo CHtml::activeDropDownList($model,'widget',$widgetsList,array('id'=>'widgetlist'));
		//echo CHtml::activeTextField($model,'widget',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'widget'); ?>
		<p class="hint"><?php echo Users::t('Widget name.'); ?></p>
		</div>
	</div>

	<div class="row widgetparams">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'widgetparams'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'widgetparams',array('size'=>60,'maxlength'=>5000,'id'=>'widgetparams')); ?>
		<?php echo CHtml::error($model,'widgetparams'); ?>
		<p class="hint"><?php echo Users::t('JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('param1'=>array('val1','val2'),'param2'=>array('k1'=>'v1','k2'=>'v2'))))); ?></p>
		</div>
	</div>

	<div class="row position">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'position'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeTextField($model,'position'); ?>
		<?php echo CHtml::error($model,'position'); ?>
		<p class="hint"><?php echo Users::t('Display order of fields.'); ?></p>
		</div>
	</div>

	<div class="row visible">
		<div class="left">
		<?php echo CHtml::activeLabelEx($model,'visible'); ?>
		</div>
		<div class="right">
		<?php echo CHtml::activeDropDownList($model,'visible',ProfileField::itemAlias('visible')); ?>
		<?php echo CHtml::error($model,'visible'); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Users::t('Create') : Users::t('Save')); ?>
	</div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->
<div id="dialog-form" title="<?php echo Users::t('Widget parametrs'); ?>">
	<form>
	<fieldset>
		<label for="name">Name</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
		<label for="value">Value</label>
		<input type="text" name="value" id="value" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>
