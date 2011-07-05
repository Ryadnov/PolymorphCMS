<?php
abstract class BaseRenderer
{
	protected $tmplAlias;
	protected $start=-1;
	protected $end=-1;
	
	protected $isObBlock;
	protected $command;
	
	protected $_output;
	
	protected $model;
	protected $category;
	protected $errors;
	
	public function __construct(&$category, &$model=null) 
	{
		$this->category = $category;
		$this->model = $model;
		$this->errors = new RenderErrors();
	}
	
	protected function error($msg) 
	{
		$this->errors[] = $msg;	
	}
	
	public function getErrors() 
	{
		return $this->errors;
	}
	
	protected function addErrors(&$renderer)
	{
		$this->errors = CMap::mergeArray($this->getErrors(), $renderer->getErrors());
	}
	
	protected function obStart()  
	{
		ob_start();
		ob_implicit_flush(false);
		$this->isObBlock = true;
	}
	
	protected function obEnd() 
	{
		$res = ob_get_contents();
		ob_end_clean();
		$this->isObBlock = false;
		return $res;
	}
	
	protected function getInformation(&$match, &$template) 
	{
		$this->start=$match[0][1];
		//cut simple html code
		$cut = substr($template, $this->end+1, $this->start - $this->end -1);
		
		if($this->isObBlock) 
			echo $cut;
		else
			$this->_output .= $cut;

		$this->end=$this->start+strlen($match[0][0])-1;

		$command=$match[1][0];
		$params = new CMap;
		$level1 = explode(';',$match[2][0]);
		
		foreach ($level1 as $level1Item) {
			if ($level1Item == '') break;
			$level1Item = str_replace("\n","",$level1Item);
			$level1Item = str_replace("\t","",$level1Item);
			$level1Item = str_replace("\r","",$level1Item);
			$level1Item = str_replace(" ","",$level1Item);
			
			$tmp = explode('=', $level1Item, 2);
			if (count($tmp) < 2) {
				$this->error("Ошибка в определении параметра ".$tmp[0]);
				return $template;
			}
			
			$n=preg_match_all('/\[([^\}]*)\]/msS',$tmp[1],$matches,PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
			
			if($n == 0) {
				$value = $tmp[1];
			} else {
				$value = new CMap;
				$level2 = explode(',',$matches[0][1][0]);

				foreach ($level2 as $level2Item) {
					if($level2Item == '') break;
					$tmp1 = explode('=', $level2Item);
					if(count($tmp1)<2) {
						$this->error("Ошибка в определении параметра ".$tmp1[0]);
						return $template;
					}
					
					$value->add($tmp1[0], $tmp1[1]);	
				}
			} 
			$params->add($tmp[0], $value);
		}
		
		return array($command, $params);
	}
	
	protected function afterParse(&$template)
	{
		return substr($template, $this->end + 1, strlen($template) - $this->end-1);
	}
	
	public function mapToArray($map) 
	{
		$map = $map->toArray();
		$res = array();
		
		foreach($map as $i=>$val) {
			if(is_object($val) && get_class($val) == 'CMap')
				$res[$i] = $val->toArray();
			else 
				$res[$i] = $val;
		}
		return $res;
	}
	
	public function getPortlet(&$params)
	{
		if (($alias = $params->remove('id')) == null) {
			$this->error("Параметр id для portlet не найден. Шаблон: $this->tmplAlias");
			return $this->command;
		}
		
		if ($this->model->pk && $this->category->type == 'page' && isset($params['ifPage'])) {
			$alias = $params->remove('ifPage');
			$renderer = new ItemRenderer($this->category, $this->model);	
		} elseif ($this->model->pk && isset($params['ifSingle'])) {
			$alias = $params->remove('ifSingle');
			$renderer = new ItemRenderer($this->category, $this->model);
		} else 
			$renderer = new CategoryRenderer($this->category, $this->model);	
		
		if (($tmpl = $this->category->getTemplate($alias)) === null) {
			$this->error("У категории $this->category->title нет шаблона ".$params['id']);
			return $this->command;
		}
		
		if (Template::ON_FILES)
			$res = $renderer->parse($tmpl->template, $alias);
		else 
			$res = $renderer->parse($tmpl->__get('template'), $alias);
		
		$this->addErrors($renderer);
		return $res;
	}
	
	public function setSctipt(&$params)
	{
		if(!isset($params['src'])) {
			$this->errror("Параметр id для portlet не найден. Шаблон: $this->tmplAlias");
			return $this->command;
		} 

		if(isset($params['position'])) {
			if($params['position'] == 'head')
				$position = CClientScript::POS_HEAD;
			elseif($params['position'] == 'body')
				$position = CClientScript::POS_BEGIN;
			elseif($params['position'] == 'foot')
				$position = CClientScript::POS_END;
			elseif($params['position'] == 'onload')
				$position = CClientScript::POS_LOAD;
			elseif($params['position'] == 'jquery')
				$position = CClientScript::POS_READY;			
		} else 
			$position = CClientScript::POS_HEAD;
		
		if($this->command == 'cssFile')
			Y::regCss($params['src']);
		if($this->command == 'jsFile')
			Y::regJs($params['src'], $position);
	}
	
}