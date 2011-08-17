<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'posts-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' => array(
            'enctype'=>'multipart/form-data'
        )
    ));
        echo $form->errorSummary($model);

        Y::hooks()->cmsAdminGetTabs($this, array('model'=>$model, 'form'=>$form));

        echo Y::getTabs();

    $this->endWidget();
    ?>
</div><!-- form -->