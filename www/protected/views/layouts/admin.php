<?php $this->beginContent('//layouts/adminMain'); ?>
<div class="head"></div>

<div class="left-col">
	<div class="system-menu">
		<h2>Системные</h2>
		<?php $this->widget('CTreeView', array('collapsed'=>true, 'data'=>$this->getSystemMenu(), 'cookieId'=>'SystemMenu'))?>		
	</div>
	<hr/>
	<div class="category-menu">
		<h2>Категории</h2>
		<?php $this->widget('CTreeView', array('collapsed'=>true, 'data'=>$this->getCategoryMenu(), 'cookieId'=>'CatMenu'))?>
	</div>
	<div class="category-menu">
		<h2>Другие Категории</h2>
		<?php $this->widget('CTreeView', array('collapsed'=>true, 'data'=>$this->getOtherMenus(), 'cookieId'=>'OtherCats'))?>
	</div>
</div>
        
<div class="content-wrapper">
	<div id="content" class="content">
		<?php echo $content?>
	</div>
</div>

<?php $this->endContent(); ?>