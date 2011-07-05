<?php
class ContentRenderer extends BaseRenderer
{	
	public function parse(&$content)
	{
					
		$regexRules = ModelFactory::contentTags(); // component tags
		
		$n=preg_match_all('/'.$regexRules.'/msS',$content,$matches,PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
		
		for($i=0;$i<$n;++$i)
		{
			list($this->command, $params) = $this->getInformation($matches[$i], $content);	
			
			switch ($this->command) {
				case 'portlet':
					$this->_output .= $this->getPortlet($params);
					break;
				case 'more' : case 'линк' :
					$this->_output .= $this->getBeginMore();
					break;
				case '/more' : case '/линк' :
					$this->_output .= $this->getEndMore($params);
					break;
				
				case 'portfolio'	: case ModelFactory::t('portfolio') : 
				case 'partners'		: case ModelFactory::t('portfolio') : 
				case 'clients'		: case ModelFactory::t('portfolio') :
				case 'publications'	: case ModelFactory::t('portfolio') :
				case 'news'			: case ModelFactory::t('portfolio') :
					$this->_output .= $this->getBeginLink();
					break;
					
				case '/portfolio'	: case '/partners'	: case '/clients'	: case '/publications'	:
					$type = substr($this->command, 0, strlen($this->command));
					$model = ModelFactory::getModel($type);
					$this->_output.=$this->genEndLink($model, $params);
					break;
				
				case '/'.ModelFactory::t('portfolio') 	: 
				case '/'.ModelFactory::t('partners') 	:	
				case '/'.ModelFactory::t('clients') 	:
				case '/'.ModelFactory::t('publications'):	
					$type = substr($this->command, 0, strlen($this->command));
					$type = ModelFactory::t($type, true);
					$model = ModelFactory::getModel($type);
					$this->_output.=$this->genEndLink($model, $params);
					break;
			}
		}
		
		$this->_output .= $this->afterParse(&$content);
		
		return $this->_output;
	}
	
	public function getBeginMore() 
	{
		if (ModelFactory::getType($this->model) == 'portfolio') {// only for this site
			return CHtml::openTag('span');
		} else {
			$this->isObBlock = true;
			$this->obStart();
			return '';	
		}
	}
	
	public function getEndMore(&$params) 
	{
		if (ModelFactory::getType(get_class($this->model)) == 'portfolio') {// only for this site
			return CHtml::closeTag('span');
		} else {
			$text = $this->obEnd();
			$this->isObBlock = false;
			return CHtml::link($text, $this->model->url, $params);
		}
		
	}
	
	public function getBeginLink() 
	{
		$this->isObBlock = true;
		$this->obStart();
	}
	
	public function getEndLink(&$model, &$params) 
	{
		$text = $this->obEnd();
		
		
		return CHtml::link($text, $this->model->url, $params);
	}
	
}
