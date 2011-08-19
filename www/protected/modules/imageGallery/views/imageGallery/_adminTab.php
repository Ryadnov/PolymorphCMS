<ul id='gallery'>
    <?php
    foreach ($model->gallery as $item) {?>
        <li class='gallery-img' id="gellery-item_<?php echo $item->pk?>">
            <img src='<?php echo $model->thumbPath.$item->image_name?>' height='72' />
            <a href="<?php echo Y::url('imageGallery/delete', array('pk'=>$item->pk))?>" class='gallery-delete'></a>
            <a href="<?php echo Y::url('imageGallery/update', array('pk'=>$item->pk))?>" class='gallery-update'></a>
        </li>
    <?php }?>
</ul>
<?php 
$js_delete =<<< EOD
$('#gallery').delegate('.gallery-delete', 'click', function() {
	var link = $(this);
	$.get(link.attr('href'), {}, function(data) {
		link.parent().remove();
	});
	return false;
});
EOD;
Y::clientScript()->registerScript('delete-gallery-img', $js_delete);
$baseUrl = Y::curBaseUrl();

$movePositionUrl = Y::url('imageGallery/movePosition');

//sortable gallery
$js_move_pos =<<< EOD
$("#gallery").sortable({
    opacity: 0.6,
    stop: function (e, ui) {
    	$.get("$movePositionUrl?"+$(this).sortable('serialize'));
    }
});
EOD;

$baseJuiUrl=Yii::getPathOfAlias('system.web.js.jui.js');
Yii::app()->getClientScript()
		->registerScriptFile($baseJuiUrl.'/jquery-ui.min.js',CClientScript::POS_END)
		->registerScript('delete-gallery-dnd', $js_move_pos);
//end sortable galery
		

$createUrl = Y::url('imageGallery/addToGallery');
$deleteUrl = Y::url('imageGallery/delete');
$updateUrl = Y::url('imageGallery/update');
$js =<<< EOR
js:function(id, fileName, response) {
	$.get(
		'$createUrl',
		{
			imageName : response.filename,
			modelPk : '$model->pk'
		},
		function(data) {
		
			var html = $("<div class='gallery-img' id='gellery-item_"+data.pk+"'>");
			
			html.append("<img src='$model->thumbPath"+response.filename+"' height='72' />")
			html.append("<a href='$deleteUrl?pk="+data.pk+"' class='gallery-delete'>");
			html.append("<a href='$updateUrl?pk="+data.pk+"' class='gallery-update'></a>");
			$("#gallery").append(html);
			bindDD(html);
		}, 
		'json'
	);
}
EOR;
    echo CHtml::tag('div', array('class'=>'clear'));
    Admin::getUploader($model, 'gallery',
        array('multiple' => true, 'onComplete'=>$js),
        array('folder'=>$model->galleryFolder)
    );
?>