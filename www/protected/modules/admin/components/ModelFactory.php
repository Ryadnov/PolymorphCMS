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
			case 'news': 		return true;
			case 'portfolio': 	return true;
			case 'partners': 	return true;
			case 'client': 		return true;
			case 'publication': return true;
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
			case 'news':
				return Admin::url('records/admin', array('catId'=>$cat->pk));
			case 'portfolio':
				return Admin::url('portfolios/admin', array('catId'=>$cat->pk));
			case 'partners':
				return Admin::url('partners/admin', array('catId'=>$cat->pk));
			case 'clients':
				return Admin::url('clients/admin', array('catId'=>$cat->pk));
			case 'publications':
				return Admin::url('publications/admin', array('catId'=>$cat->pk));
			default:
				self::exception($cat);
		}
	}

	public static function getTemplatePatterns()
	{
		return 'page|news|portfolio|partners|clients|publications';	
	}
	
	public static function cutRelations($fromCat, $toCat)
	{
		switch ($toCat->type) {
			case 'page':
				throw new CException("Нельзя копировать данные типа 'Страница'");
			case 'news':
				$toCat->records = $fromCat->records;
				$toCat->save();
				break;
			case 'portfolio':
				$toCat->portfolios = $fromCat->with('portfolioWorks')->portfolios;
				$toCat->save();
				break;
			case 'partners':
				$toCat->partners = $fromCat->partners;
				$toCat->save();
				break;
			case 'clients':
				$toCat->clients = $fromCat->clients;
				$toCat->save();
				break;
			case 'partners':
				$toCat->publications = $fromCat->publications;
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
			case 'news':
				 $toCat->records = self::destroyAllId($fromCat->records);
				 $toCat->save();
				break;
			case 'portfolio':
				$toCat->portfolios = self::destroyAllId($fromCat->with('portfolioWorks')->portfolios);
				$toCat->save();
				break;
			case 'partners':
				$toCat->partners = self::destroyAllId($fromCat->partners);
				$toCat->save();
				break;
			case 'clients':
				$toCat->clients = self::destroyAllId($fromCat->clients);
				$toCat->save();
				break;
			case 'publications':
				$toCat->publications = self::destroyAllId($fromCat->publications);
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
			case 'news':
				 $cat->records = array();
				 break;
			case 'portfolio':
				$cat->portfolios->portfolioWorks = array();
				$cat->portfolios = array();
				break;
			case 'clients':
				$cat->clients = array();
				break;
			case 'publications':
				$cat->publications = array();
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
			case 'news': 		return array();
			case 'portfolio': 	return array('city', 'workType');
			case 'partners': 	return array();
			case 'clients': 	return array();
			case 'publications':return array();
			default: 			self::exception($cat);
		}
	}

	public static function getAfterAjaxUpdateFunction($type)
	{
		switch ($type) {
			case 'page': 		return "function() {}";
			case 'news': 		return "function() {}";
			case 'portfolio': 	return 'function() {$("#filter-wrapper input").hide();}';
			case 'partners': 	return "function() {}";
			case 'clients': 	return "function() {}";
			case 'publications':return "function() {}";
			case 'partners': 	return "function() {}";
			default: 			self::exception($cat);
		}	
	}
	
	public static function getBeforeAjaxUpdateFunction($type)
	{
		switch ($type) {
			case 'page': 		return "function() {}";
			case 'news': 		return "function() {}";
			case 'portfolio': 	return "function() {}";
			case 'partners': 	return "function() {}";
			case 'clients': 	return "function() {}";
			case 'publications':return "function() {}";
			default: 			self::exception($cat);
		}
	}
	
	public static function labels()
	{
		return array(
			'page'=>'страница',
			'news'=>'новости',
			'portfolio'=>'портфолио',
			'partners'=>'партнеры',
			'clients'=>'клиенты',
			'publications'=>'публикации'
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