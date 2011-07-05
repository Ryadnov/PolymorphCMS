<ul class="actions">
	<li><?php echo CHtml::link(Users::t('Manage User'),Users::url('admin')); ?></li>
	<li><?php echo CHtml::link(Users::t('Manage Profile Field'),Users::url('profileField/admin')); ?></li>
<?php 
	if (isset($list)) {
		foreach ($list as $item)
			echo "<li>".$item."</li>";
	}
?>
</ul><!-- actions -->