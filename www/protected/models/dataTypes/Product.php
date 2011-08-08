<?php
class Product extends BaseDataType implements IECartPosition
{
    public $portfolioWorksIds;
    /**
    * Returns the static model of the specified AR class.
    * @return Lookup the static model class
    */
    public static function model($className=__CLASS__)
    {
       return parent::model($className);
    }

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
       return 'portfolio';
    }

    public static function getPkAttr()
    {
       return 'portfolio_id';
    }

    public function getId()
    {
        return 'product_'.$this->pk;
    }

    public function getPrice()
    {
        return $this->price;
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
           'portfolioWorks' => array(self::MANY_MANY, 'PortfolioWork', 'portfolio_works_relations(portfolio_id, portfolio_work_id)'),
           'gallery' => array(self::HAS_MANY, 'PortfolioGallery', Portfolio::getIdAttr(),
               'order'=>'gallery.sort ASC'
           ),
           'city' => array(self::BELONGS_TO, 'City', City::getIdAttr()),
           'workType' => array(self::BELONGS_TO, 'PortfolioWorkType', PortfolioWorkType::getIdAttr()),
       ));
    }

    public function behaviors(){
       return CMap::mergeArray(parent::behaviors(), array(
             'EAdvancedArBehavior' => array(
               'class' => 'application.components.Behaviors.EAdvancedArBehavior'
             )
         ));
    }

    public function scopes()
    {
       return CMap::mergeArray(parent::scopes(), array(

       ));
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
           'city' => 'Город',
           'activity' => 'о чем это я????',
           'result_url' => 'Ссылка на сайт',
           'result_title' => 'Надпись на ссылке',
           'service' => 'о чем это я???',
           'icon' => 'Иконка',
           'icon_big' => 'Большая Иконка',
           'img' => 'Изображение',
           'sort' => 'Порядок',
           'published' => 'Опубликован',
           'second_title' => 'Второй заголовок',
           'updaetd' => 'Последнее обновление',
           'portfolioWorks' => 'Проделанные работы',
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
        if ($this->result_url) {
            if (substr($this->result_url, 0, 7) != 'http://')
                $this->result_url = 'http://'.$this->result_url;
            return CHtml::link($this->result_title, $this->result_url);
        }
    }

    public function getGalleryFolder()
    {
        return 'gallery';
    }

}
