<div class="form">
<?php
$form = Admin::beginForm($model, array('id'=>'page-form'));
	Admin::submit($model);
	Admin::makeTinyTabs($form, $model, array('text', 'sidebar'));
	echo $this->getTabs();
$this->endWidget() ?>
</div><!-- form -->