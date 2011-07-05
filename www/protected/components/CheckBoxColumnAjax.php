<?php
class CheckBoxColumnAjax extends CCheckBoxColumn
{
	
	public $headerText = null;
	public $selectableRows = 2;
	
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
		$url = Y::curUrl();
		$js =<<< EOM
			$('#$id').delegate('.checkbox-column input', 'change', function() {
				$.get(
					'$url',
					{
						model_id:$(this).val(),
						published:true,
						val:$(this).is(':checked')
					}
				);	
			
			});
EOM;
			
		Y::clientScript()->registerScript(__CLASS__.'#'.$this->id, $js);
	}
	
}