<?php
class RenderController extends Controller
{
    public function render($view, $data = array(), $return = array())
    {
        $category = Y::category();
        
        $params = array(
            'block' => new BlockViewer($category),
            'meta' => new MetaViewer($category),
            'category' => $category
        );
        $data = CMap::mergeArray($data, $params);

        //хранить только алиасы. в базовых классах вычислять саму категорию
        //ввести в контроллер параметр, по которому будет определяться делать render или renderPartial
        //например для popup

//        Y::dump($data['block']->left);
        parent::render($view, $data, $return);
    }

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
