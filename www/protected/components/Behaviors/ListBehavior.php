<?php
class ListBehavior extends CActiveRecordBehavior
{
	public function all($category) 
	{
		return $this->getOwner();
	}
	
	public function current($category) 
	{
		$owner = $this->getOwner();
		$owner->getDbCriteria()->addCondition(
			$owner->getTableAlias().".category_id=$category->pk"
		);
		return $owner;
	}
	
	public function tree($category)
	{
		$allow = "($category->pk,";
		$cats = $category->descendants()->findAll();
		foreach ($cats as $cat) {
			$allow .= "$cat->pk,";
		}
		
		$allow = substr($allow, 0, strlen($allow) - 1).")";
		
		$owner = $this->getOwner();
		$owner->getDbCriteria()->addCondition(
			"category_id in $allow"
		);
		return $owner;
	}
	
}