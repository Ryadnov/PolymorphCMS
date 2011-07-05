<h1>Управление видами проделанных работ</h1>
<?php 
echo Admin::link('Создать новый вид работ','portfolioWorks/create');
$this->renderPartial('admingrid', array('model'=>$model))
?>