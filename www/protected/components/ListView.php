<?php
Yii::import('zii.widgets.CListView');
/*
 * $this->widget('zii.widgets.CListView', array(
 *     'dataProvider'=>$dataProvider,
 *     'itemView'=>'_post',   // refers to the partial view named '_post'
 *     'category'=>$category
 * ));
 */
class ListView extends CListView
{
	public $itemView = 'nothing';
	public $itemsId = 'nothing';
	
	public $itemsTagName = 'ul';
	public $category;
	public $enableSorting = true;
	public $_attributes = array();
	public $pager=array('class'=>'LinkPager');
	public $itemsHtmlOptions;
    public $isEvenOdd = false;
    public $contextWidget;
    
	public $sortableAttributes = array('title', 'date'); 
	
	public function init() 
	{
		if (isset($_GET['filter']) && isset($_GET['filterDetails']) && $_GET['filterDetails'] != 0)
			$this->dataProvider->setScopes(array($_GET['filter']=>$_GET['filterDetails']));
		
		parent::init();
	}

	//don't remove it, beacause it is redefine parent function
	public function renderItems()
	{
		$this->_baseRender('item');
	}
	
	public function renderFilter() 
	{
		$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
		$details = isset($_GET['filterDetails']) ? $_GET['filterDetails'] : ''; 
		
		if(isset($_GET['filterButton'])) 
			unset($_GET['filterButton']);
			
		$tmpGet = $_GET;
		if (isset($tmpGet['filter'])) {
			if (isset($tmpGet['filterDetails']))
				unset($tmpGet['filterDetails']);
			unset($tmpGet['filter']);
		}
		
		echo CHtml::form( Y::url('site', $tmpGet), 'get');
		echo CHtml::dropDownList('filter',$filter,array(
			'inYear'=>'по годам', 'inWorkType'=>'по видам деятельности','inCity'=>'по городам'
		));
		
		if ($filter) { 
			
			if ($filter == 'inYear')
				$items = Y::years();
			if ($filter == 'inCity') 
				$items = City::model()->allWithHeader;
			if ($filter == 'inWorkType') 
				$items = PortfolioWorkType::model()->allWithHeader;
				
			if (isset($items))
				echo CHtml::dropDownList('filterDetails', $details, $items);
		}
		
		echo CHtml::submitButton('Отфильтровать', array('name'=>'filterButton'));
		echo CHtml::endForm();
	}
	
	protected function renderSection($matches)
	{
        $method='render'.$matches[1];
        if (method_exists($this,$method))
			$this->$method();
		else
			$this->_baseRender(substr($matches[1], 0, strlen($matches[1])-1));
		
		$html=ob_get_contents();
		ob_clean();
        return $html;
	}

	private function _baseRender($part)
	{
        if (empty($this->category))
			throw new CException("category - обязательный параметр для ListView");

		$opts = array();
		$data=$this->dataProvider->getData();
		if (($n=count($data))>0) {
			$j=0;
			foreach ($data as $i=>$item) {
				$template = null;
				//may be isset odd or even templates
                if ($this->isEvenOdd)
                    $tmplName = $j%2 == 0 ? $part.'Even' : $part.'Odd';
                else
                	$tmplName = $part;
            
				$this->contextWidget->render($tmplName, array('item' => $item));
				if ($j++ < $n-1)
					echo $this->separator;
			}
		}
		
		if (isset($this->itemsHtmlOptions[$part.'sTagName']))
			echo CHtml::closeTag($this->itemsHtmlOptions[$part.'sTagName']);
	}

}
