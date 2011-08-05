<?php
class RenderController extends Controller
{
	public $model;
	public $category;
	
	public $options;

	public function renderItem(&$item, &$cat, &$templateAlias, $return = false, $noCache = false)
	{
		$renderer = new ItemRenderer($cat, $item);
		$tmpl = $cat->getTemplate($templateAlias);
		
		if ($tmpl == null)
			throw new CException("Не найден шаблон $templateAlias для категории $cat->alias");
	 	
		$output = $renderer->parse($tmpl->__get('template'), $tmpl->__get('alias'));
		
		if($return)
			return $output;
		else
			echo $output;
	}
	
}
