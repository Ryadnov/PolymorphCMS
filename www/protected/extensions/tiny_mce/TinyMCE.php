<?php
class TinyMCE extends CInputWidget
{
	public $editorOptions = array();
    private $defaultOptions = array(
        'language'=>'ru',
		'theme'=> "advanced",
        'plugins' => "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,jaretypograph",
        'convert_urls' => 'false',
		'skin'=> "cirkuit",

		'editorTemplate'=>'full',

        'extended_valid_elements' => "iframe[src|width|height|name|align|frameborder|scrolling]",
        
			// Theme options
			'theme_advanced_buttons1' => "undo,redo,|,bold,italic,underline,strikethrough,sub,sup,|,bullist,numlist,|,charmap,|,justifyleft,justifycenter,justifyright,justifyfull,|,outdent,indent,blockquote,formatselect",
			'theme_advanced_buttons2' => "image,media,link,unlink,anchor,|,cut,copy,paste,pastetext,pasteword,|,newdocument,pagebreak,|,jaretypograph,visualaid,cleanup,removeformat,|,fullscreen,|,code",
			'theme_advanced_buttons3' => "",
			'theme_advanced_toolbar_location' => "top",
			'theme_advanced_toolbar_align' => "left",
			'theme_advanced_statusbar_location' => "bottom",
			'theme_advanced_resizing' => 'true',
            'file_browser_callback' => "tinyBrowser",

		'width'=>'100%',
        'height'=>'350',
    );
    
    public function run()
    {
    	$this->editorOptions = array_merge($this->editorOptions, $this->defaultOptions);
    	
        list($name, $id) = $this->resolveNameID();
        
        // Publishing assets.
        $dir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($dir.DIRECTORY_SEPARATOR.'assets');
        $this->editorOptions['script_url'] = $assets.'/tiny_mce.js';
        
        // Registering javascript.
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets.'/jquery.tinymce.js');
        $cs->registerScriptFile($assets.'/plugins/tinybrowser/tb_tinymce.js.php');
        
        $cs->registerScript(
            'Yii.'.get_class($this).'#'.$id,
            '$(function(){$("#'.$id.'").tinymce('.CJavaScript::encode($this->editorOptions).');});'
        );
        
        $this->htmlOptions['id'] = $id;
        
        if($this->hasModel())
            $html = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        else
            $html = CHtml::textArea($name, $this->value, $this->htmlOptions);
            
        echo $html;
    }
}