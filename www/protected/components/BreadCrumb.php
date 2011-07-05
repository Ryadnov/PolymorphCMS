
<?php
class BreadCrumb extends CWidget {
 
    public $crumbs = array();
    public $delimiter = ' / ';
 
    public function run() 
    {
    	if (isset($this->crumbs[1])) {
	    	return CHtml::tag('h2', array(),
	        	CHtml::tag('span', array(), $this->crumbs[1]).
	        	CHtml::tag('br').
	        	$this->crumbs[0]
	        );
    	} else {
    		return CHtml::tag('h2', array(), $this->crumbs[0]);
    	}
    }
}
