<?php
class Record extends BaseDataType
{
	public $portfolioWorksIds;
	
	public static function model()//$type)
	{
		return parent::model(__CLASS__);
	}

	public static function getPkAttr()
	{
		return 'record_id';
	}
	
	public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
			array('sort, title, second_title, index_text, sidebar_text', 'safe', 'on'=>'movePosition'),
			array('title', 'length', 'max'=>255),
			array('title, index_text, sidebar_text, text, portfolioWorksIds, portfolioWorks, img, icon, icon_big, alias, month, year, result_url, result_title, second_title', 'safe', 'on'=>array('search','create','update')),
		));
		return array(
			
		);
	}
	
	public function relations()
	{
		return CMap::mergeArray(parent::relations(), array(
			//!!!don't use this relations!!!
			//use relations with functions
			//need set type condition
			'variant_list' => array(self::MANY_MANY, 'VariantLias', 'variant_list_relations(model_id, variant_id)'),
			'union_list' => array(self::BELONGS_TO, 'UnionList', UnionList::getPkAttr()),
			'subdata_list' => array(self::HAS_MANY, 'SubdataList', SubList::getPkAttr()),
			'image_gallery' => array(self::HAS_MANY, 'ImageGallery', ImageGallery::getPkAttr()),
			
			//написать BELONGS_TO и HAS_MANY
			'workType' => array(self::BELONGS_TO, 'PortfolioWorkType', PortfolioWorkType::getPkAttr()),
		));
	}
	
	function getGallery()
	{
		return $this->type(ModelFactory::getType($this->type_id))->image_gallery;
	}
	
	public function type($type)
	{
		$this->getDbCriteria()->mergeWith(array('condition'=>'type='.$type));
		return $this;
	}
	
	public function behaviors(){
	    return CMap::mergeArray(parent::behaviors(), array());
	}

	public function scopes()
    {
    	return CMap::mergeArray(parent::scopes(), array());
    }
    
    public function inYear($year)
    {
    	$this->getDbCriteria()->compare('t.year',$year,true);
    	return $this;
    }
    
    public function inWorkType($workTypeId) 
    {
    	$this->getDbCriteria()->compare('t.portfolio_work_type_id',$workTypeId);
    	return $this;
    }
    
    public function inCity($cityId)
    {
    	$this->getDbCriteria()->compare('t.city_id',$cityId);
    	return $this;
    }
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'title' => 'Название',
			'alias' => 'Алиас',
			'text' => 'Текст',
			'month' => 'Месяц',
			'year' => 'Год',
			'index_text' => 'Текст для главной',
			'sidebar_text' => 'Текст боковой колонки',
			'icon' => 'Иконка',
			'icon_big' => 'Большая Иконка',
			'img' => 'Изображение',
			'sort' => 'Порядок',
			'published' => 'Опубликован',
			'second_title' => 'Второй заголовок',
			'updaetd' => 'Последнее обновление',
			'workType' => 'Виды деятельности'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($catPk)
	{
		return parent::search($catPk, array('title', 'index_text', 'sidebar_text'));
	}

	public static function getAdminControllerName()
	{
		return 'portfolios';	
	}
	
	public function getPortfolioWorksArray()
	{
		$res = array();
		foreach ($this->portfolioWorks as $item) {
			$res[$item->pk] = $item->title;
		}
		return $res;
	}
	
	public function afterFind()
	{
		$this->portfolioWorksIds = array();
		foreach ($this->portfolioWorks as $item) {
			$this->portfolioWorksIds[] = $item->{PortfolioWork::getIdAttr()};
		}
		
		parent::afterFind();
	}
	
	public function beforeSave()
	{
		if (parent::beforeSave()) {
			return true;
		}	
		return false;
	}

	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			$this->portfolioWorks = array();
			$this->gallery = array();
			$this->workType = array();
			return true;
		}
		return false;
	}
	
	public function getImgFolder()
	{
		return 	'portfolio';
	}

	public function getCurIcon()
	{
		return $this->getImage("icon");
	}

	public function getCurIcon_big()
	{
		return $this->getImage('icon_big');	
	}
	
	public function getCurImg()
	{
		return $this->getImage('img');
	}	

	public function getResultLink()
	{
		if (substr($this->result_url, 0, 7) != 'http://') 
			$this->result_url = 'http://'.$this->result_url;
		
		if ($this->result_url)
			return CHtml::link($this->result_title, $this->result_url);
		else 
			return	$this->result_title;
	}

	public function getGalleryFolder()
	{
		return 'gallery';
	}
	
}
