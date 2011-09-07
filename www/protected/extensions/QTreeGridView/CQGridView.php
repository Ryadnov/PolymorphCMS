<?php
/**
 * CTreeGridView class file.
 *
 * Used:
 * YiiExt - http://code.google.com/p/yiiext/
 * treeTable - http://plugins.jquery.com/project/treeTable
 * jQuery ui - http://jqueryui.com/
 *
 * @author quantum13
 * @link http://quantum13.ru/
 */


Yii::import('zii.widgets.grid.CGridView');


class CQGridView extends CGridView
{

    public $baseTreeTableUrl;

    public $baseJuiUrl;
	
    
    public function init()
    {
		parent::init();
        $this->baseJuiUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.QTreeGridView.jui'));    
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerClientScript()
    {
        parent::registerClientScript();

        $cs=Yii::app()->getClientScript();
        $cs->registerScriptFile($this->baseJuiUrl.'/jquery.ui.core.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($this->baseJuiUrl.'/jquery.ui.widget.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($this->baseJuiUrl.'/jquery.ui.mouse.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($this->baseJuiUrl.'/jquery.ui.droppable.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($this->baseJuiUrl.'/jquery.ui.draggable.min.js',CClientScript::POS_END);
        
        $baseUrl = Y::curBaseUrl();
        
        $cs->registerScript('draganddrop', '
            $(document).ready(function()  {
               $("#'.$this->getId().' tbody tr").live("mouseenter", function() {
	              var $this = $(this);
	              if($this.is(":data(draggable)")) return;
				  $this.draggable({
	                  helper: "clone",
	                  opacity: .75,
	                  refreshPositions: true, // Performance?
	                  revert: "invalid",
	                  revertDuration: 300,
	                  scroll: true
	              });
	           });
               $("#'.$this->getId().' tbody tr").live("mouseenter", function() {
               		var $this = $(this);
               		if ($this.is(":data(droppable)")) return;
				    $(this).droppable({
	                    drop: function(e, ui) {
							$("#'.$this->getId().'").addClass("grid-views-loading");
	                    	$.get(
		                    	"'.$baseUrl.'/movePosition",
								{
		                    		pk : $(ui.draggable).attr("id"),
		                    		to : $(this).attr("id")
		                    	},
		                    	function() {
		                    		$.fn.yiiGridView.update("'.$this->getId().'");
		    					}
		                    );
	                    },
	  					hoverClass: "accept",
	               });
               });
            });
		');
    }
    
    public function renderTableRow($row)
    {
		$data=$this->dataProvider->data[$row];
		$pk = $this->getId().'_'.$data->pk;
		if ($this->rowCssClassExpression!==null) {
    		echo '<tr class="'.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'" id="'.$pk.'">';
		} else if (is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
			echo '<tr class="'.$this->rowCssClass[$row%$n].'"  id="'.$pk.'">';
		else
			echo '<tr id="'.$pk.'">';
		foreach ($this->columns as $column)
			$column->renderDataCell($row);
		echo "</tr>\n";	
    }
    
    public function renderTableFooter()
	{
		Y::clientScript()->registerScript("pageSize","
			$('#".$this->getId()."').delegate('.pageSizer','change',function() {
				$.fn.yiiGridView.update('".$this->getId()."',{data:{pageSize: $(this).val()}});
			});
    	");
		$options['pageSize'] = CHtml::dropDownList('pageSize', $this->dataProvider->pagination->pageSize, array(10=>10, 25=>25, 50=>50, 100=>100, 500=>500, 1000=>1000), array('class'=>'pageSizer'));
		
		echo "<tfoot>\n";
		echo "<tr>\n";
		echo "<td>\n";
		foreach ($options as $item) 
			echo $item;
		echo "</td>\n";
		echo "</tr>\n";
		echo "</tfoot>\n";
	}
	
}
