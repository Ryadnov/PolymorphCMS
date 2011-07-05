<ul class="actions">
<?php 
	if (count($list)) {
		foreach ($list as $item)
			echo "<li>".$item."</li>";
	}
?>
	<li><?php echo CHtml::link(Users::t('Manage User'),Users::url('admin')); ?></li>
	<li><?php echo CHtml::link(Users::t('Manage Profile Field'),Users::url('profileField/admin')); ?></li>
</ul><!-- actions -->