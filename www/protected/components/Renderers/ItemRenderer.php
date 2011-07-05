<?php
class ItemRenderer extends BaseRenderer
{
	public function parse(&$template, &$templateAlias)
	{
		$this->tmplAlias = $templateAlias;
		$regexRules = "{([^}:]*):?([^}]*)}";
		
		$n=preg_match_all('/'.$regexRules.'/msS',$template,$matches,PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
		
		for($i=0;$i<$n;++$i) {
				
			list($this->command, $params) = $this->getInformation(&$matches[$i], &$template);	
			
			$command = explode('.',$this->command);
				
			if ($command[0] == 'jsFile' || $command[0] == 'cssFile') {
				$this->setSctipt($params);
				continue;
			}
			
			if ($command[0] == 'portlet') {
				$this->_output .= $this->getPortlet($params);
				continue;
			}
			
			$curModel = $this->model;
				
			for ($j = 0; $j < count($command); $j++) {
				if ($curModel === null) break;
				if (!$curModel->has($command[$j])) {
					$this->error("Поле ".$command[$j]." не найдено в ".get_class($curModel));
					return $this->command;
				}
					
				$curModel = $curModel->{$command[$j]};
				
			}
			
			$content = $curModel;

			//filters for data
			foreach ($params as $key=>$param) {
				switch ($key) {
					case 'date':
						$content = date($param, strtotime($content));
						break;
					case 'switch':
						$content = $param[$content];
						break;
					case 'strip':
						$content = $this->stripPatterns($content);
						break;
				}
			}
			
			//render
			if (!is_array($content)) {
				$renderer = new ContentRenderer($this->category, $this->model);
				$this->_output .= $renderer->parse($content);
				$this->addErrors($renderer);
			} else {   //render each winth $params['item'] template
				if (($alias = $params->remove('item')) == null) {
					$this->error("Пропущен обязательный параметр item для $this->command. item - это алиас шаблона для каждого элемента массива. Шаблон: $templateAlias");
					return $this->command;
				}
				
				$tmpl = $this->category->getTemplate($alias)->template;
				
				$res = '';
				foreach ($content as $item) {
					$renderer = new ItemRenderer($this->category, $item);
					$res .= $renderer->parse($tmpl, $alias);
					$this->addErrors($renderer);
				}
				
				if (($tag = $params->remove('tag')) != null)
					$res = CHtml::tag($tag, $params, $res);
				
				$this->_output .= $res;
			}
		}
		
		$this->_output .= $this->afterParse(&$template);
		return $this->_output;
	}
	
	public function stripPatterns($content)
	{
		return preg_replace('/\{[^\}]*\}|\([^\)]*\)/msS', '', $content); 
	}
}