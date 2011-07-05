<?php
class AjaxDataColumn extends CDataColumn
{
	public $cssClass = null;
	public $headerText = null;
	
	protected function renderHeaderCellContent()
	{
		$this->registerScripts();
		if ($this->headerText != null)
			echo $this->headerText;
		else 
			parent::init();
	}
	
	public function registerScripts() 
	{
		$id = $this->grid->id;
		$class = $this->htmlOptions["class"];
		$url = Y::curUrl();
		$js =<<< EOM
			$('#$id').delegate('.$class div', 'click', function() {
				$(this).toggleClass('yes');
				$.get(
					'$url',
					{
						model_id : parseInt($(this).attr('id').replace(/published-button-/ig, "")),
						published : true,
						val : $(this).attr('class') == "yes" ? true : false
					}
				);
				return false;
			});
EOM;
			
		Y::clientScript()->registerScript(__CLASS__.'#'.$this->id, $js);
	}
	
	public function renderFilterCell()
	{
		echo "<td class='$this->cssClass'>";
		$this->renderFilterCellContent();
		echo "</td>";
	}
}