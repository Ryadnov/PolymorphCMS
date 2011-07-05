<?php $this->beginContent('//layouts/main'); ?>

<div class="index-left">
	<a href="#"><img src="/images/ir.gif" alt="ir.kz" /></a>
	<div class="system-menu">Системные</div>
	<div class="category-menu">Категории</div>
</div>
		
<div class="icons">
	<a href="#"><img src="/images/icon_home.gif" alt="" /></a><a href="#"><img src="/images/icon_map.gif" alt="" /></a><a href="#"><img src="/images/icon_pen.gif" alt="" /></a>
</div>
<div class="top-contacts">
	<p class="tel"><span class="tel-code">+7 (7172)</span> 36-78-77 <a href="#">Все номера</a></p>
    <p class="address">РК, 010008, Астана, <img src="/images/pointer.gif" alt="" /> <a href="#">м-н. 6, д. 6, вп. 4</a></p>
</div>
<div class="container-show">
	<div id="content-wide" class="content">
		<?php echo $content?>
	</div>
</div>

<?php $this->endContent(); ?>