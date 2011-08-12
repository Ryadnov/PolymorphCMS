<div class="form">
<?php
$form = Admin::beginForm($model, array('id'=>'page-form'));
	Admin::makeTinyTabs($form, $model, array('text', 'sidebar'));
	Y::getTabs('page-tabs', false);
$this->endWidget() ?>

</div><!-- form -->