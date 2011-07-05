<?php
class RenderController extends Controller
{
	public $model;
	public $category;
	
	public $options;
		
	public function render($tmplAlias, $data = array(), $return = false, $noCache = false)
	{
		$this->options = $data;
		$output = $this->renderPartial($tmplAlias, $this->options, true);
		
		$output = $this->processOutput($output);

		/*
		//error reporting
		if (!Y::isGuest()) {
			$errrors = '';
			foreach ($renderer->getErrors() as $error) {
				$errrors .= $error.'<br/>';	
			}
			
			$output .= CHtml::tag('div',array('class'=>'render-errors'), $errrors);
		}
		*/
        
		if($return)
			return $output;
		else
			echo $output;
	}
	
	public function renderPartial($tmplAlias, $data = array(), $return = false)
	{
		$options = CMap::mergeArray($this->options, $data);
		$tmplPath = $options['category']->getTemplate($tmplAlias, true);
		
		return $output = parent::renderPartial($tmplPath, $options, $return);
	}
	
	public function renderItem(&$item, &$cat, &$templateAlias, $return = false, $noCache = false)
	{
		$renderer = new ItemRenderer($cat, $item);
		$tmpl = $cat->getTemplate($templateAlias);
		
		if($tmpl == null)
			throw new CException("Не найден шаблон $templateAlias для категории $cat->alias");
	 	
		$output=$renderer->parse($tmpl->__get('template'), $tmpl->__get('alias'));
		
		if($return)
			return $output;
		else
			echo $output;
	}
	
}
