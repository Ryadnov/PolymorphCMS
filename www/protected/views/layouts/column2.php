<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-16">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
 
	<div class="span-8 last">
		<div id="sidebar">
	    <?php 
	    if(Y::isGuest()) {
			echo CHtml::link(Yii::t('interface', 'new question'), BController::siteUrl('posts/createQuestion', array('blog_id'=>$this->cur_blog_id)));
		} else {$this->widget('UserMenu');}
    	?>
		
	    <?php $this->widget('RecentComments', array(
			'maxCount'=>Yii::app()->params['recentCommentCount'],
		)); ?>

	    <?php $this->widget('RecentQuestions', array(
			'maxCount'=>Yii::app()->params['recentQuestionsCount'],
		)); ?>
		
		</div><!-- sidebar -->
	</div>
    
</div>
<?php $this->endContent(); ?>