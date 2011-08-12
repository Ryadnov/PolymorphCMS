<?php
$this->widget('CodeMirror', array(
    'type'=>$type,
    'content'=>$content,
    'name'=>'fileContent',
    'id'=>'cssFile'
)) ?>
<?php echo CHtml::hiddenField('filePath', $filePath) ?>