<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'posts-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data'
	)
));
	echo $form->errorSummary($model); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
	
<?php $this->beginTab('Настройки')?>
	<?php Admin::makeTextFields($form, $model, array('title', 'second_title', 'alias', 'result_url','result_title'))?>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model,'portfolioWorks'); ?></div>
		<div class="right">
<?php 

echo CHtml::activeCheckBoxList(
    $model,
    'portfolioWorksIds',
    Chtml::listData(PortfolioWork::model()->findAll(),PortfolioWork::getIdAttr(),PortfolioWork::getNameAttr())
    );?>
		<?php //echo PortfolioWork::model()->checkBoxList($model,'portfolioWorksIds');?>
		<?php echo $form->error($model,'portfolioWorks'); ?>
		</div>
	</div>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model, 'city')?></div>
		<div class="right">
			<?php echo City::model()->dropDownList($model, 'city')?>
		</div>
	</div>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model,'workType')?></div>
		<div class="right">
			<?php echo PortfolioWorkType::model()->dropDownList($model, 'workType')?>
		</div>
	</div>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model,'year')?></div>
		<div class="right">
			<?php echo $form->dropDownList($model,'year',Y::years())?>
		</div>
	</div>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model,'month')?></div>
		<div class="right">
			<?php echo $form->dropDownList($model,'month',Y::month())?>
		</div>
	</div>
	<div class="row">
		<div class="left"><?php echo $form->labelEx($model,'published')?></div>
		<div class="right">
			<?php echo $form->radioButtonList($model,'published',Lookup::items('NPublished'));?>
		</div>
	</div>
<?php $this->endTab()?>
	
	<?php Admin::makeTinyTabs($form, $model, array('text', 'index_text', 'sidebar_text'))?>
	
	<?php 
$this->beginTab('Изображения');
		Admin::makeHiddenFields($form, $model, array('icon', 'icon_big', 'img'));
		Admin::getImgUploaders($model, array('icon', 'icon_big', 'img'));
$this->endTab();
	?>
	
<?php $this->beginTab('Фотогалерея');?>
	<div id='gallery'>
		<?php 
		$gal = new PortfolioGallery;
		foreach ($model->gallery as $item) {?>
			<div class='gallery-img' id="gellery-item-<?php echo $item->pk?>">
				<img src='<?php echo $gal->thumbPath.$item->image_name?>' height='72' />
				<a href="<?php echo Admin::url('portfolioGalleries/delete', array('pk'=>$item->pk))?>" class='gallery-delete'></a>
				<a href="<?php echo Admin::url('portfolioGalleries/update', array('pk'=>$item->pk))?>" class='gallery-update'></a>
			</div>
		<?php }?>
	</div>
<?php 
$js_delete =<<< EOD
$(document).ready(
	function() {
		$('#gallery').delegate('.gallery-delete', 'click', function() {
			var link = $(this);
			$.get(link.attr('href'), {}, function(data) {
				link.parent().remove();
			});
			return false;
		});
	});
EOD;
Y::clientScript()->registerScript('delete-gallery-img', $js_delete);

$createUrl = Admin::url($model->adminControllerName.'/addToGallery');
$js =<<< EOR
js:function(id, fileName, response) {
	$.get(
		'$createUrl',
		{
			imageName : response.filename,
			modelPk : '$model->pk'
		},
		function(data) {
		
			var html = $("<div class='gallery-img' id='gellery-item-"+data.pk+"'>");
			
			html.append("<img src='$gal->thumbPath"+response.filename+"' height='72' />")
			html.append("<a href='/admin/portfolioGalleries/delete?pk="+data.pk+"' class='gallery-delete'>");			
			html.append("<a href='/admin/portfolioGalleries/update?pk="+data.pk+"' class='gallery-update'></a>");
			$("#gallery").prepend(html);
		}, 
		'json'
	);
}
EOR;
		echo CHtml::tag('div', array('class'=>'clear'));
		Admin::getUploader($model, 'gallery', array('multiple' => true, 'onComplete'=>$js), array('folder'=>$model->galleryFolder));
$this->endTab();?>

<?php $this->getTabs('portfolio-tabs')?>
<?php $this->endWidget(); ?>


</div><!-- form -->