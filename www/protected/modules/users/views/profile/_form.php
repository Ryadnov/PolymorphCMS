<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="row">
		<div class="left">
			<?php echo $form->labelEx($profile,$field->varname);?>
		</div>
		<div class="right">
		<?if ($field->widgetEdit($profile)) {
			echo $field->widgetEdit($profile);
		} elseif ($field->field_type=="DATE") {
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			    'attribute'=>$field->varname,
			    'model'=>$profile,
				'language'=>Yii::app()->language,
                'options'=>array(
					'changeYear'=>true,
					'yearRange'=>'-50:-15',
					'dateFormat'=>'yy-mm-dd',
				),
				'htmlOptions'=>array('size'=>30,'class'=>'date')
			));		
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		echo $form->error($profile,$field->varname); ?>
		</div>
	</div>	
			<?php
			}
		}
?>
