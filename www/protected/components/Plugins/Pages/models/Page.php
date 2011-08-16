<?php
class Page extends BaseDataType
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function tableName()
	{
        return 'pages';
	}
    
	public static function getPkAttr()
	{
		return 'page_id';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('text', 'required'),
			array('created, sidebar_text', 'safe', 'on'=>array('search','create','update')),
		);
	}

    public function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'title' => 'Название',
			'alias' => 'Алиас',
			'descr' => 'Описание',
			'sidebar_text' => 'Текст боковой колонки',
			'text' => 'Основной текст'
		);
	}

	public function search()
	{
		$criteria = $this->getDbCriteria();

		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getAdminControllerName()
	{
		return 'pages';	
	}

	public static function getImgFolder()
	{
		return 'pages';	
	}
	
	public function getAdminUrl()
	{
		return Admin::url($this->adminControllerName.'/update', array('pk'=>$this->pk));
	}

    public function handleCategoryType($category)
    {
        return $category->type == 'Page' ? $category->page : null;
    }
}
