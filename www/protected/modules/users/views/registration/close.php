<div>
<?php echo Yii::t('errors', 'registration close', array('{email}'=>Y::config('email_to_registraiton') ));?>
</div>

<div class="form">
<?php 
if(Y::hasFlash('success')) {
	echo CHtml::tag('div', array('class'=>'success'), Y::flash('success'));
}?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
	    'id'=>'send-mail',
	    'enableAjaxValidation'=>true
	)); ?>
	<?php echo CHtml::errorSummary($model); ?>
	
    <div class="row">
        <?php echo $form->labelEx($model,'subject'); ?>
        <?php echo $form->textField($model,'subject') ?>
        <?php echo $form->error($model,'subject'); ?>
    </div>
 
    <div class="row">
        <?php echo $form->labelEx($model,'message'); ?>
        <?php echo $form->textArea($model,'message') ?>
        <?php echo $form->error($model,'message'); ?>
    </div>	
 	
	<div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('interface', "send mail")); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->