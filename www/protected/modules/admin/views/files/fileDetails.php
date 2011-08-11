<?php $this->widget('CodeMirror', array(
    'type'=>$type,
    'content'=>$content,
    'id'=>'cssFile'
)) ?>
<?php echo CHtml::hiddenField('filePath', $filePath) ?>