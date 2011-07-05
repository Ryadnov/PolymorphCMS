<?php

/**
 * This is the model class for table "ru_lookup".
 *
 * The followings are the available columns in table 'ru_lookup':
 * @property integer $lookup_id
 * @property string $type
 * @property integer $code
 * @property string $name
 */
class Lookup extends ActiveRecord
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
		return 'lookup';
	}

	public static function getPkAttr()
	{
		return 'lookup_id';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, code, name', 'required'),
			array('code', 'numerical', 'integerOnly'=>true),
			array('type, name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lookup_id, type, code, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lookup_id' => 'Lookup',
			'type' => 'Type',
			'code' => 'Code',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->getDbCriteria();

		$criteria->compare('lookup_id',$this->lookup_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('code',$this->code);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	private static $_items=array();
	/**
	 * Returns the items for the specified type.
	 * @param string item type (e.g. 'PostStatus').
	 * @return array item names indexed by item code. The items are order by their position values.
	 * An empty array is returned if the item type does not exist.
	 */
	public static function items($type)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return self::$_items[$type];
	}

	/**
	 * Returns the item name for the specified type and code.
	 * @param string the item type (e.g. 'PostStatus').
	 * @param integer the item code (corresponding to the 'code' column value)
	 * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
	 */
	public static function item($type,$code)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
	}

	/**
	 * Loads the lookup items for the specified type from the database.
	 * @param string the item type
	 */
	private static function loadItems($type)
	{
		self::$_items[$type]=array();
		$models=self::model()->findAll(array(
			'condition'=>'type=:type',
			'params'=>array(':type'=>$type),
			'order'=>'position',
		));
		foreach($models as $model)
			self::$_items[$type][$model->code]=$model->name;
	}
	
	public function keys($type) {
		return array_keys(self::items($type));
	}

	public static function getAll()
	{
		$criteria = new CDbCriteria;
        $criteria->select = 'type, name';
		$items = self::model()->findAll($criteria);
 
		$res = array();
		foreach ($items as $item) {
			$res[$item->type][] = $item->name;
		}
		
		return $res;
	}
}