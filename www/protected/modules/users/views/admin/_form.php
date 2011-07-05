<div class="form">

<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'create-user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data'
	)
	
)); ?>
	
	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<div class="row">
		<div class="left">	
		<?php echo $form->labelEx($model,'username'); ?>
		</div>
		<div class="right">	
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username'); ?>
		</div>	
	</div>
	
	<div class="row">
		<div class="left">
		<?php echo $form->labelEx($model,'password'); ?>
		</div>
		<div class="right">	
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>32, 'value'=>'')); ?>
		<?php echo $form->error($model,'password'); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="left">
		<?php echo $form->labelEx($model,'email'); ?>
		</div>
		<div class="right">	
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="row">
		<div class="left">
		<?php echo $form->labelEx($model,'role'); ?>
		</div>
		<div class="right">	
		<?php echo $form->dropDownList($model,'role',Lookup::items('role')); ?>
		<?php echo $form->error($model,'role'); ?>
		</div>
	</div>

	<div class="row">
		<div class="left">
		<?php echo $form->labelEx($model,'status'); ?>
		</div>
		<div class="right">	
		<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
		</div>
	</div>
	
	<?php echo $this->renderPartial('/profile/_form', array('profile'=>$profile, 'form'=>$form))?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Users::t('Create') : Users::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->