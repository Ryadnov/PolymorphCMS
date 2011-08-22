<?php Y::beginTab('Дополнительно') ?>
    <div class="row">
        <?php echo CHtml::label('Название', 'Extra[title]') ?>
        <?php echo CHtml::textField('Extra[title]', $model->title) ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Опубликован', 'Extra[published]')  ?>
        <?php echo CHtml::checkBox('Extra[published]', $model->published)  ?>
    </div>
<?php Y::endTab() ?>

<?php echo Y::getTabs($id) ?>