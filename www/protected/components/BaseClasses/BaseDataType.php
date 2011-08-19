<?php
abstract class BaseDataType extends ActiveRecord implements IDataType
{
	const PUBLISHED = 1;
	const NOT_PUBLISHED = 0;
	
	
	public function rules() 
	{
		return array(
			array('published, created, sort, second_title', 'safe', 'on'=>array('search', 'create', 'update', 'published')),
			array('alias', 'unique', 'on'=>array('create', 'update')),
		);	
	}
	
	public function getId()
	{
		return get_class($this).$this->pk;	
	}
	
	public function behaviors()
	{
		return array(
            'list' => array(
                'class' => 'application.components.Behaviors.ListBehavior'
            ),
			'EAdvancedArBehavior' => array(
	            'class' => 'application.components.Behaviors.EAdvancedArBehavior'
	      	)
        );
	}

    public function relations()
    {
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
        );
    }


	public function getUrl()
	{
		$params = array();
		if ($this->alias) {
			$params['alias'] = $this->alias;
			$params['type'] = get_class($this);
		} else {
			$params['id'] = $this->pk;
		}
		
		$params = CMap::mergeArray($params, $this->category->urlParams);
		
		return Y::url('site', $params);	
	}
		
	public function getUpdateUrl()
	{
		return Y::url(Y::module()->getId().'/records/update', array('pk' => $this->pk, 'catPk'=>$this->category->pk));
	}
	
	public function getDeleteUrl()
	{
		return Admin::url($this->adminControllerName.'/delete', array('pk' => $this->pk));
	}
	
	public function getAdminUrl()
	{
		return Admin::url($this->adminControllerName.'/admin', array('catId'=>$this->category_id));
	}
	
	public function getUpdateLink()
	{
		return CHtml::link($this->title, $this->updateUrl);
	}
	
	public function getAdminLink()
	{
		return CHtml::link($this->title, $this->adminUrl);
	}

	public function getImgPath()
	{
		$dir = "/images/".$this->getImgFolder()."/";
		if (!is_dir('.'.$dir)) 
			@mkdir('.'.$dir);
		return $dir;
	}
	
	public function getThumbPath()
	{
		$dir = "/images/".$this->getImgFolder()."/thumbs/";
		if (!is_dir('.'.$dir)) 
			@mkdir('.'.$dir);
		return $dir;	
	}

	public function getImage($attr, $alt = '', $htmlOptions = array())
	{
		if ($this->{$attr}) 
			return CHtml::image($this->imgPath.$this->{$attr}, $alt, $htmlOptions);
		else 
			return '';
	}
	
	public function beforeSave()
	{
		if (parent::beforeSave()) {
			if ($this->isNewRecord && get_class($this) != 'Page') {
				$this->sort = 1 + $this->dbConnection->createCommand("SELECT MAX(`sort`) FROM ".$this->tableName())->queryScalar();
				$this->created = date('Y-m-d H:i:s');
			}
			return true;
		}
		return false;
	}

	public function search($catPk, $attributes = array(), $extCriteria = null) 
	{
		$criteria = $this->getDbCriteria();
		foreach ((array)$attributes as $attr) {
			$criteria->compare('t.'.$attr, $this->$attr, true);	
		}
		
		$criteria->order = 't.sort DESC';
		
		$cat = Category::model()->findByPk($catPk);
		
		$tree = $cat->descendants()->findAll();
		$tree[] = $cat;
		
		$data = CHtml::listData($tree, $cat->pkAttr, $cat->pkAttr);
		$data = "(".implode(',', $data).")";
		
		$criteria->condition = 't.category_id IN '.$data;

		if ($extCriteria)
			$criteria->mergeWith($extCriteria);
		
		$opts = array('criteria'=>$criteria);
		if (isset($_GET['pageSize'])) {
			$opts['pagination'] = array('pageSize'=>$_GET['pageSize']);
		}
		
		return new CActiveDataProvider(get_class($this), $opts);
	}

    public function handleCategoryType($category)
    {
        if ($category->type == get_class($this)) {
            $model = $this;
        } else {
            return null;
        }
        
        //if has alias or id of model, then find it
        if (isset($_GET['alias']) || isset($_GET['pk'])) {
            $value = isset($_GET['alias']) ? $_GET['alias'] : $_GET['pk'];
            $attr = isset($_GET['alias']) ? 'alias' : $model->pkAttr;

            $model = $model->published()->findByAttributes(array($attr => $value));
        }

        return $model;
    }
}