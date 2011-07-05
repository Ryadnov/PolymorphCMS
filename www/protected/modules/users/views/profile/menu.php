<ul class="actions">
<?php 
if(UserModule::isAdmin()) {
?>
<li><?php echo CHtml::link(Users::t('Manage User'),array('/user/admin')); ?></li>
<?php 
}
?>
<li><?php echo CHtml::link(Users::t('Profile'),Y::module()->profileUrl); ?></li>
<li><?php echo CHtml::link(Users::t('Edit'),Y::module()->editProfileUrl); ?></li>
<li><?php echo CHtml::link(Users::t('Change password'),Y::module()->changePassUrl); ?></li>
<li><?php echo CHtml::link(Users::t('Logout'),Y::module()->logoutUrl); ?></li>
<li><?php echo CHtml::link(Yii::t('interface', 'CreatePost'), Users::url("posts/create",array('lang' => Yii::app()->language, 'add_type'=>'post'))); ?></li>
<li><?php echo CHtml::link(Yii::t('interface', 'CreateQuestion'),Users::url("posts/create",array('lang' => Yii::app()->language, 'add_type'=>'question'))); ?></li>
</ul>