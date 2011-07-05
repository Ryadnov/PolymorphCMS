<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lookup_id), array('view', 'id'=>$data->lookup_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>