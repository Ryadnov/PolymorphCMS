<?php 
$this->pageTitle=Yii::app()->name . ' - '.Users::t("Login");
$this->breadcrumbs=array(
	Users::t("Login"),
);
?>

<h1><?php echo Users::t("Login"); ?></h1>

<?php if(Y::hasFlash('loginMessage')) { ?>
    <div class="success">
        <?php echo Y::flash('loginMessage'); ?>
    </div>
<?php } ?>
<!--
<p><?php echo Users::t("Please fill out the following form with your login credentials:"); ?></p>
-->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	    'id'=>'login-form',
	    'enableAjaxValidation'=>true,
	    'enableClientValidation'=>false,
	    'focus'=>array($model,'username'),
		'action'=>$this->module->loginUrl)
	); ?>
	<?php echo CHtml::errorSummary($model); ?>
	
    <div class="row">
        <?php echo $form->label($model,'username'); ?>
        <?php echo $form->textField($model,'username') ?>
    </div>
 
    <div class="row">
        <?php echo $form->label($model,'password'); ?>
        <?php echo $form->passwordField($model,'password') ?>
    </div>
 <!-- 
	<div class="row">
		<p class="hint">
		<?php echo CHtml::link(Users::t("Register"),$this->module->registrationUrl); ?> | <?php echo CHtml::link(Users::t("Lost Password?"),Y::module('users')->recoveryUrl); ?>
		</p>
	</div>
	
    <div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
    </div>
 -->
    <div class="row submit">
        <?php echo CHtml::submitButton('Войти'); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->

<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);

?>