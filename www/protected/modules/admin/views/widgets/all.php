<div class="dark-blue-head">
    <?php echo Admin::ascLink('Добавить виджет +', 'widgets/add', array(), array('id'=>'add-widget-btn')) ?>
</div>
<?php $this->widget('CTreeView', array('collapsed'=>true,'data'=>$widgets, 'id'=>'widgets')) ?>

