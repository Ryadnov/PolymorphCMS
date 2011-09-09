<div class="dark-blue-head">
    <?php echo Admin::ascLink('Добавить виджет +', 'widgets/add', array(), array('id'=>'add-widget-btn')) ?>
</div>
<?php $this->widget('CTreeView', array('collapsed'=>true,'data'=>$widgets, 'id'=>'widgets')) ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#all-widgets li.widget-link a').click(function() {
        $('#widget-details').load($(this).attr('href'));
        return false;
    });
});
</script>
