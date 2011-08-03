<?php
class Records
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

    public static $tabs = array();
    public static $curTabName;

    public static function beginTab($tabName)
    {
        ob_start();
        ob_implicit_flush(false);
        self::$curTabName = $tabName;
    }

    public static function endTab()
    {
        self::$tabs[self::$curTabName] = array('content' => ob_get_contents());
        ob_end_clean();
    }

    public static function tab($tabName, $content)
    {
        self::$tabs[$tabName] = array('content' => $content);
    }

    public function getTabs($id = null, $return = false)
    {
        return Y::controller()->widget('JuiTabs', array(
            'tabs'=>self::$tabs,
            'cssFile'=>'jquery-ui.css',
            'themeUrl'=>'/css/jui',
            'theme'=>'base',
            'options'=>array(
                'collapsible'=>false,
            ),
            'htmlOptions'=>array('id'=>$id)
        ), $return);
    }

    public static $panels = array();
    public static $curPanelName;

    public static function beginPanel($panelName)
    {
        ob_start();
        ob_implicit_flush(false);
        self::$curTabName = $panelName;
    }

    public static function endPanel()
    {
        self::$panels[self::$curPanelName] = ob_get_contents();
        ob_end_clean();
    }

    public static function panel($panelName, $content)
    {
        self::$tabs[$panelName] = $content;
    }

    public function getPanels($id = null, $return = false)
    {
        return Y::controller()->widget('zii.widgets.jui.CJuiAccordion', array(
            'panels'=>self::$panels,
            'cssFile'=>'jquery-ui.css',
            'themeUrl'=>'/css/jui',
            'theme'=>'base',
            'options'=>array(
                'collapsible'=>false,
            ),
            'htmlOptions'=>array('id'=>$id)
        ), $return);
    }

}