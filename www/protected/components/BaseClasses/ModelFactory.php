<?php
class ModelFactory
{
    private static $_m;

    public static function registerDataTypes($modelName)
    {
        foreach ((array)$modelName as $name)
            self::$_m[] = $name;
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
        
        foreach (self::$_m as $modelName) {
            if ($category->type == $modelName)
                $model = $modelName::model();
            else
                return null;

            //if has alias or id of model, then find it
            if (isset($_GET['alias']) || isset($_GET['pk'])) {
                $value = isset($_GET['alias']) ? $_GET['alias'] : $_GET['pk'];
                $attr = isset($_GET['alias']) ? 'alias' : $model->pkAttr;

                $model = $model->published()->findByAttributes(array($attr => $value));
                break;
            }
        }
        return $model;
    }



    
    //some deprecated functions
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
        if ($cat->type == "Page")
            return Admin::link($cat->title, 'pages/update', array('catPk'=>$cat->pk));
        else
            return Admin::link($cat->title, 'dataTypes/admin', array('catPk'=>$cat->pk));
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