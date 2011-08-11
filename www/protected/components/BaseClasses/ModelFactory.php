<?php
class ModelFactory
{

	public static $allTypes = array(
		'page',
		'records'
	);

	private static function getName($strOrObj)
	{
		if (is_string($strOrObj))
			return $strOrObj;
		elseif (is_integer($strOrObj))
			return self::$allTypes[$strOrObj];
		else
			return get_class($strOrObj);
	}

	public static function getModel($catOrType)
	{
        $type = is_string($catOrType) ? $catOrType : $catOrType->type;
		switch ($type) {
			case 'page': 		return is_string($catOrType) ? Page::model() : $catOrType->page;
			case 'records': 	return Record::model();
			default: 			self::exception($typeOrObj);
		}
	}

	public static function getType($typeOrObj)
	{
		$name = self::getName($typeOrObj);
		switch ($name) {
			case 'Page': 		return 'page';
			case 'Record': 		return 'records';
			default: 			self::exception($typeOrObj);
		}
	}

	public static function getTypeId($typeOrObj)
	{
		$type = self::getName($typeOrObj);
		$typesIds = array_flip(self::allTypes());
		return $typesIds[$type];
	}

	public static function isAllowCopy($type)
	{
		switch ($type) {
			case 'page': 		return false;
            case 'records':     return true;

			default: 			self::exception($cat);
		}
	}

	public static function adminViewCategoryLink($cat)
	{
		return CHtml::link($cat->title, self::adminViewCategory($cat));
	}

	public static function adminViewCategory($cat)
	{
		switch ($cat->type) {
			case 'page':
				$page = $cat->page;
 				if($page == null) {
					$page = new Page;
					$page->text = 'Пока здесь ничего не написано';
					$page->category_id = $cat->pk;
					if(!$page->save())
						Y::flash('createPageError', 'Не получилось создать страницу. Повторите действие еще раз.');
				}

				return Admin::url('pages/update', array('pk'=>$page->pk));
			case 'records':
				return Admin::url('records/admin', array('catId'=>$cat->pk));
			default:
				self::exception($cat);
		}
	}

	public static function getTemplatePatterns()
	{
		return 'page|records';
	}

	public static function cutRelations($fromCat, $toCat)
	{
		switch ($toCat->type) {
			case 'page':
				throw new CException("Нельзя копировать данные типа 'Страница'");
			case 'records':
				$toCat->records = $fromCat->records;
				$toCat->save();
				break;
			default:
				self::exception($cat);
		}
	}

	public static function copyRelations($fromCat, $toCat)
	{
		switch ($toCat->type) {
			case 'page':
				throw new CException("Нельзя копировать данные типа 'Страница'");
			case 'records':
				 $toCat->records = self::destroyAllId($fromCat->records);
				 $toCat->save();
				break;
			default:
				self::exception($cat);
		}
	}

	private static function destroyAllId($models)
	{
		$res = array();
		foreach ($models as $i=>$model) {
			$new = $model;
		 	$new->pk = null;
		 	$res[$i] = $new;
		}
		return $res;
	}

	public static function deleteRelations($cat)
	{
		switch ($cat->type) {
			case 'page':
				if ($cat->page != null)
					$cat->page->delete();
				break;
			case 'records':
				 $cat->records = array();
				 break;
			default:
				self::exception($cat);
		}
	}

	public static function getCategoryRelations()
	{
		return array(
			'records' => array(CActiveRecord::HAS_MANY, 'Record', 'category_id',
	        	'order'=>'records.sort DESC'
			),
			'page' => array(CActiveRecord::HAS_ONE, 'Page', 'category_id')
		);
	}

	public static function getCriteriaWith($type)
	{
		switch ($type) {
			case 'page': 		return array();
			case 'records':     return array();
			default: 			self::exception($cat);
		}
	}

	public static function getAfterAjaxUpdateFunction($type)
	{
		switch ($type) {
			case 'page': 		return "function() {}";
			case 'records': 	return "function() {}";
			default: 			self::exception($cat);
		}
	}

	public static function getBeforeAjaxUpdateFunction($type)
	{
		switch ($type) {
			case 'page': 		return "function() {}";
			case 'records':     return "function() {}";
			default: 			self::exception($cat);
		}
	}

	public static function labels()
	{
		return array(
			'page'=>'страница',
			'records'=>'записи'
		);
	}

    public static function getTypes()
    {
        return array(
            'page'=>'страница',
            'records'=>'записи',
            'products'=>'товары'
        );
    }

	public static function t($type, $toEng = false)
	{
		$arr = self::labels();
		if ($toEng)
			$arr = array_flip($arr);
		return $arr[$type];
	}

	public static function exception(&$cat)
	{
		$msg = is_object($cat) ? $cat->type : $cat;
		throw new CException("Неизвестный тип категории: $msg");
	}

	public static function modelsWithoutPublished()
	{
		return array('Page');
	}

	public static function contentTags()
	{
		$arr = CMap::mergeArray(self::labels(), array(
			'more'=>'линк'
		));

		$open = "[\{\(]";
		$close = "[\)\}]";
		$params = ":?([^\}^\)]*)";
		$res = array();
		foreach ($arr as $en=>$ru) {	//tag may be closed
			$res[] = "\/?".$en;
			$res[] = "\/?".$ru;
		}

		return $open."(".implode('|', $res).")".$params.$close;
	}
}