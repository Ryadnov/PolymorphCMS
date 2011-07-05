<?php
class Admin
{	
	public static function t($str='',$dic='interface', $params=array()) {
		return Yii::t("AdminModule.".$dic, $str, $params);
	}
		
	public static function url($url, $params = array()) 
    {
    	return Y::url('admin/'.$url, $params);
    }

    public static function absUrl($url, $params = array()) 
    {
    	return Y::absUrl('admin/'.$url, $params);
    }
	
    public static function link($text, $url, $urlParams = array(), $linkParams = array())
    {
        return CHtml::link($text, self::url($url, $urlParams), $linkParams);
    }
    
    public static function absLink($url, $text, $urlParams = array(), $linkParams = array())
    {
    	return CHtml::link($text, self::absUrl($url, $urlParams), $linkParams);
    }

	public static function insertUploadedImgJs($model, $attr)
	{
		return "js:function(id, fileName, response) {
				$('#".get_class($model)."_$attr').val(response.filename);
				var img = $('<img>').attr('src','$model->imgPath'+response.filename);
				$('#".$attr."_upload_form img').remove();
				$('#".$attr."_upload_form .right').prepend(img);
			}";
	}
	
	public static function addTabJs($tabsId, $id)
	{
		return "$('#$tabsId').tabs('add','#new-$id', 'Изображения');
				$('#new-$id').append($('#$id'));";
	}
	
	public static function getImgUploaders($model, $attributes)
	{
		foreach ((array)$attributes as $attr) {
			echo '<div class="row" id="'.$attr.'_upload_form">
				<div class="left">'.$model->getAttributeLabel($attr).'</div>
				<div class="right">'.$model->{'cur'.ucfirst($attr)};
			self::getUploader($model, $attr, array('onComplete'=>Admin::insertUploadedImgJs($model, $attr)));
			echo '</div></div>';
		}	
	}

	public static function getUploader($model, $attr, $extOptions = array(), $actionOptions = array())
	{
		$opts = array(
			"folder" => $model->imgFolder,
			'model' => get_class($model),
			'attr' => $attr,
			'model_id' => $model->pk
		);
		$opts = CMap::mergeArray($opts, $actionOptions);
		
		$config = array(
	    	'action'=>Admin::url("manage/upload", $opts),
	        'allowedExtensions'=>array("jpg","jpeg","gif","png"),//array("jpg","exe","mov" and etc...
	        'sizeLimit'=>2*1024*1024,// maximum file size in bytes
	        'minSizeLimit'=>10,// minimum file size in bytes
	        'messages'=>array(
	        	'typeError'=>"{file} имеет неверное расширение. Разрешены следующие расширения {extensions}.",
	            'sizeError'=>"{file} слишком большой, максимальный размер {sizeLimit}.",
	            'minSizeError'=>"{file} слишком мал, минимальный размер {minSizeLimit}.",
				'emptyError'=>"{file} пуст, пожалуйста выбирете другой файл.",
				'onLeave'=>"Идет Загрузка, не покидайте страницу..."
			),
			'showMessage'=>"js:function(message){ alert(message); }"			
		);
	
		$config = CMap::mergeArray($config, $extOptions);
		
		Y::controller()->widget('ext.EAjaxUpload.EAjaxUpload', array(
			'id' => $attr.'_uploader',
		    'config' => $config
		)); 
	}

	public static function makeTextFields($form, $model, $attributes)
	{
		foreach ((array)$attributes as $attr) {
			echo '<div class="row">
				<div class="left">'.$form->labelEx($model,$attr).'</div>
				<div class="right">'
					.$form->textField($model,$attr,array('size'=>60))
					.$form->error($model,$attr).
				'</div>
			</div>';		
		}
	}
	
	public static function makeHiddenFields($form, $model, $attributes)
	{
		foreach ((array)$attributes as $attr) 
			echo $form->hiddenField($model,$attr,array('size'=>60));
	}
	
	public static function submit($model)
	{
		echo '<div class="row buttons">';
		echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить');
		echo '</div>';
	}
	
	public static function beginForm($model, $opts)
	{
		$opts = CMap::mergeArray(array(
			'enableAjaxValidation'=>true,
			'htmlOptions' => array(
				'enctype'=>'multipart/form-data'
			)
		), $opts);
		$form = Y::controller()->beginWidget('CActiveForm', $opts);
		echo $form->errorSummary($model);
		
		return $form;
	}
	
	public static function makeTinyTabs($form, $model, $attributes)
	{
		foreach ((array)$attributes as $attr) {
			Y::controller()->beginTab($model->getAttributeLabel($attr));
			Y::controller()->widget('ext.tiny_mce.TinyMCE', array(
				'model' => $model,
				'attribute' => $attr
			));
			echo $form->error($model,$attr);
			Y::controller()->endTab();
		}
	}
	
	public static function makeDateFields($form, $model, $attributes, $dateFormat = 'yy.mm.dd', $phpDateFormat = 'd.m.Y')
	{
		foreach ((array)$attributes as $attr) {
			echo '<div class="row">
				<div class="left">'.$form->labelEx($model,$attr).'</div>
				<div class="right">';

			$name = get_class($model).'['.$attr.']';
        	$time = date($phpDateFormat,strtotime($model->{$attr}));
        	
			Y::controller()->widget('zii.widgets.jui.CJuiDatePicker', array(
				'attribute'=>$attr,
				'model'=>$model,
				'language'=>Yii::app()->language,
				'options'=>array(
					'changeYear'=>true,
					'yearRange'=>'-50:-15',
					'dateFormat'=>'dd.mm.yy',
				),
				'htmlOptions'=>array('size'=>30,'class'=>'date')
			));
			
			echo '</div>
			</div>';	
		}	
	}
	
	public static function ascWindow($options)
	{
        extract($options);
		
		Y::clientScript()
            ->registerScriptFile('/js/plugins/cms/ascWindow.js')
            ->registerScript($id, "$('#$wrapper').ascWindow({windowId : '$id'});");

		Y::controller()->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id'=>$id,
			'htmlOptions'=>array(
				'title'=>$windowTitle,
			),
			'options'=>array(
				'autoOpen'=>false,
				'modal'=>true,
				'width'=>isset($w) ? $w : 'auto',
				'height'=>isset($h) ? $h : 'auto',
			),	
		));
    
        echo CHtml::beginForm();
        foreach ($fields as $type=>$name) {
            echo CHtml::$type($name);
        }
        echo CHtml::submitButton('Готово');
        echo CHtml::endForm();

		Y::controller()->endWidget();
	}
	
	public static function jsDeleteLi($id, $linkClass)
	{
        Y::clientScript()
            ->registerScriptFile('/js/plugins/cms/deleteLi.js')
            ->registerScript("delete-$id", "$('#$id').deleteLi({'linkClass':'$linkClass'})");
	}
	
	public static function jsSortableLi($id, $url, $hiddenFields)
	{
		Y::controller()->widget('zii.widgets.jui.CJuiDialog', array(
            'id'=>$id,
            // additional javascript options for the accordion plugin
            'options'=>array(
                'opacity'=> 0.6,
                'stop'=> "function (e, ui) {
                    var hiddenFields = new Array(".implode(',',$hiddenFields)."),
                        obj = new Object;
                    for(var name in hiddenFields) {
                        obj.name = $(this).find('input[name=\"name\"]').val();
                    }
                    $.get('{$url}?'+$(this).sortable('serialize'), obj);
                }"
            )
        ));
	}
	
	public static function jsOpenLi($id, $linkClass, $targetId)
	{
        Y::clientScript()
            ->registerScriptFile('/js/plugins/cms/openLi.js')
            ->registerScript("delete-$id", "
			$('#$id').openLi({'linkClass':'$linkClass','targetId':'$targetId'})"
		);	
	}
}