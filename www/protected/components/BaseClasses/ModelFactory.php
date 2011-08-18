<?php
class ModelFactory
{
    private static $_m = array();

    public static function registerDataType($model)
    {
        self::$_m[get_class($model)] = $model;
    }

    /**
     * Chain of Responsability pattern
     * it call handleCategoryType method on all registered models by chain
     * while some model return not null
     * @static
     * @param $category
     * @return bool
     */
    public static function getModel($category)
    {
        $res = null;
        foreach (self::$_m as $model) {
            if ($res = $model->handleCategoryType($category))
                return $res;
        }
        return $res;
    }



    
    //some deprecated functions

	public static $allTypes = array(
		'Page',
		'Record'
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

	public static function getType($typeOrObj)
	{
		$name = self::getName($typeOrObj);
		switch ($name) {
			case 'Page': 		return 'Page';
			case 'Record': 		return 'Record';
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
			case 'Page': 		return false;
            case 'Record':     return true;

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
			case 'Page':
				$page = $cat->page;
 				if($page == null) {
					$page = new Page;
					$page->text = 'Пока здесь ничего не написано';
					$page->category_id = $cat->pk;
					if(!$page->save())
						Y::flash('createPageError', 'Не получилось создать страницу. Повторите действие еще раз.');
				}

				return Admin::url('Pages/update', array('pk'=>$page->pk));
			case 'Record':
				return Admin::url('Record/admin', array('catPk'=>$cat->pk));
			default:
				self::exception($cat);
		}
	}

	public static function getTemplatePatterns()
	{
		return 'Page|Record';
	}

	public static function cutRelations($fromCat, $toCat)
	{
		switch ($toCat->type) {
			case 'Page':
				throw new CException("Нельзя копировать данные типа 'Страница'");
			case 'Record':
				$toCat->record = $fromCat->record;
				$toCat->save();
				break;
			default:
				self::exception($cat);
		}
	}

	public static function copyRelations($fromCat, $toCat)
	{
		switch ($toCat->type) {
			case 'Page':
				throw new CException("Нельзя копировать данные типа 'Страница'");
			case 'Record':
				 $toCat->record = self::destroyAllId($fromCat->record);
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
			case 'Page':
				if ($cat->page != null)
					$cat->page->delete();
				break;
			case 'Record':
				 $cat->record = array();
				 break;
			default:
				self::exception($cat);
		}
	}

	public static function getCriteriaWith($type)
	{
		switch ($type) {
			case 'Page': 		return array();
			case 'Record':     return array();
			default: 			self::exception($cat);
		}
	}

	public static function getAfterAjaxUpdateFunction($type)
	{
        switch ($type) {
			case 'Page': 		return "function() {}";
			case 'Record': 	return "function() {}";
			default: 			self::exception($cat);
		}
	}

	public static function getBeforeAjaxUpdateFunction($type)
	{
		switch ($type) {
			case 'Page': 		return "function() {}";
			case 'Record':     return "function() {}";
			default: 			self::exception($cat);
		}
	}

	public static function labels()
	{
		return array(
			'Page'=>'страница',
			'Record'=>'записи'
		);
	}

    public static function getTypes()
    {
        return array(
            'Page'=>'страница',
            'Record'=>'записи',
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