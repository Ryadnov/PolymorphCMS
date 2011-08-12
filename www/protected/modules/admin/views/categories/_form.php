<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'category-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
));

    $form->errorSummary($model);

    Y::beginTab('Настройки');
        Admin::makeTextFields($form, $model, array('title', 'alias')) ?>
        <div class="row">
            <div class="left"><?php echo $form->labelEx($model,'published') ?></div>
            <div class="right">
                <?php echo $form->radioButtonList($model,'published',Lookup::items('MPublished')) ?>
            </div>
        </div>
        <div class="row">
            <div class="left"<?php echo $form->labelEx($model,'is_empty') ?></div>
            <div class="right">
                <?php echo $form->radioButtonList($model,'is_empty',Lookup::items('YesNo')) ?>
            </div>
        </div>
        <?php if ($model->isNewRecord) { ?>
            <div class="row">
                <div class="left"><?php echo $form->labelEx($model,'type') ?></div>
                <div class="right">
                    <?php echo $form->dropDownList($model,'type',ModelFactory::getTypes()) ?>
                </div>
            </div>
        <?php } ?>
    <?php
    Y::endTab();
    Y::beginTab('Метаданные');
            Admin::makeTextFields($form, $model, array('meta_title', 'meta_descr', 'meta_keywords'));
    Y::endTab();
    Y::getTabs();

$this->endWidget() ?>
</div><!-- form -->
