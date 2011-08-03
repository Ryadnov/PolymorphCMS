<?php
class ImageGallery extends BaseDataType
{
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
		return 'portfolio_gallery';
	}
	
	public static function getPkAttr()
	{
		return 'image_id';
	}
	
	public function rules()
	{
		return array(
			array('image_name, descr', 'safe', 'on'=>array('create','update')),
			array('image_name', 'length', 'max'=>255),
		);
	}
	
	public function relations()
	{
		return array(
			'portfolio' => array(self::BELONGS_TO, 'Portfolio', Portfolio::getIdAttr()),
		);
	}
	
	public function behaviors(){
	    return CMap::mergeArray(parent::behaviors(), array(
	      	'EAdvancedArBehavior' => array(
	            'class' => 'application.components.Behaviors.EAdvancedArBehavior'
	      	)
      	));
	}
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Название',
			'portfolio' => 'Портфолио',
			'descr' => 'Описание'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($portfolioPk)
	{
		return parent::search(array('name', 'descr'), 'portfolio_id='.$portfolioPk);
	}

	public static function getAdminControllerName()
	{
		return 'portfolioGalleries';	
	}

	public function makeThumb() 
	{
		Yii::import('ext.image.class_upload.upload');
		
		$handle = new upload('.'.$this->imgPath.$this->image_name);
		$handle->image_resize            = true;
        $handle->image_ratio_crop        = 'T';
        $handle->image_x                 = 72;
        $handle->image_y                 = 72;
		$handle->process('.'.$this->thumbPath);
	}
	
	public function getAdminUrl()
	{
		return Admin::url('/records/update', array('pk'=>$this->record->pk));
	}
	
	public static function getImgFolder()
	{
		return 	'gallery';
	}

	public function getCurImage_name()
	{
		return $this->getImage('image_name');
	}

	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			$file ='./'.$this->imgPath.$this->image_name;
			if (is_file($file))
				@unlink($file);
			return true;
		}
		return false;
	}
}
