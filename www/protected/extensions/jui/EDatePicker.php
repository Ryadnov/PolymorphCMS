<?php
/**
 * EDatePicker class file.
 *
 * @author Michiel Betel <mbetel@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Michiel Betel
 * @license http://www.yiiframework.com/license/
 * @version 2.2 - added changes from users:
 *	@change PickerOnly - isset -> check on boolean
 * @change internationalisation changes
 */

Yii::import('zii.widgets.jui.CJuiInputWidget');

/**
 * EJuiDateTinePicker displays a datePicker.
 *
 * CDatePicker encapsulates the {@link http://jqueryui.com/demos/datepicker/ JUI
 * datepicker} plugin extended with the Picker plugin from Trent Richardson
 * {@link http://trentrichardson.com/examples/Picker/ }
 *
 * To use this widget, you may insert the following code in a views:
 * <pre>
 * $this->widget('zii.components.jui.EDatePicker', array(
 *     'name'=>'publishDate',
 *     // additional javascript options for the date picker plugin
 *     'options'=>array(
 *         'showAnim'=>'fold',
 *     ),
 *     'htmlOptions'=>array(
 *         'style'=>'height:20px;'
 *     ),
 * ));
 * </pre>
 *
 * By configuring the {@link options} property, you may specify the options
 * that need to be passed to the JUI datepicker plugin. Please refer to
 * the {@link http://jqueryui.com/demos/datepicker/ JUI datepicker} documentation
 * for possible options (name-value pairs).
 *
 * @author Michiel Betel <mbetel@gmail.com>
 */
class EDatePicker extends CJuiInputWidget
{
	/**
	 * @var string the locale ID (e.g. 'fr', 'de') for the language to be used by the date picker.
	 * If this property is not set, I18N will not be involved. That is, the date picker will show in English.
	 */
	public $language;

	/**
	 * @var string The i18n Jquery UI script file. It uses scriptUrl property as base url.
	 */
	public $i18nScriptFile = 'jquery-ui-i18n.min.js';
	
	/**
	* Define the needed extra files for the Picker
	* 
	*/
	public $extraScriptFile = "jquery-ui-Picker-addon.min.js";
	public $extraCssFile = "jquery-ui-Picker-addon.css";
	public $PickerOnly = false; // thanks Mukke
	
	public function init()
	{
		parent::init();
		// Register the extension script and needed Css - different $baseUrl from the zii stuff
		$path = pathinfo(__FILE__); // changed to enable various extension Paths - GOsha
		$basePath = $path['dirname']. '/assets';		
		$baseUrl=Yii::app()->getAssetManager()->publish($basePath);
		$cs=Yii::app()->getClientScript();
		$cs->registerCssFile($baseUrl.'/'.$this->extraCssFile);
		// NOTE CJuiWidget registers the ui js at POS_END so we should too, otherwise the inclusion order is wrong
		$cs->registerScriptFile($baseUrl.'/'.$this->extraScriptFile, CClientScript::POS_END);    
	}
	
	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];
		else
			$this->htmlOptions['name']=$name;
		
		if($this->hasModel())
			echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textField($name,$this->value,$this->htmlOptions);
		
		$options=CJavaScript::encode($this->options);
		
		if($this->PickerOnly)
			$js = "jQuery('#{$id}').Picker($options);";
		else
			$js = "jQuery('#{$id}').datePicker($options);";		
		
		if (isset($this->language)){
			$this->registerScriptFile($this->i18nScriptFile);
			if($this->PickerOnly)
				$js = "jQuery('#{$id}').Picker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['{$this->language}'], {$options}));";
			else
				$js = "jQuery('#{$id}').datePicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['{$this->language}'], {$options}));";	
		}
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id, $js);
	}
}