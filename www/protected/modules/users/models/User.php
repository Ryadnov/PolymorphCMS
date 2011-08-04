<?php
class User extends ActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Y::module('users')->tableUsers;
	}

	public static function getPkAttr() 
	{
		return 'id';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return (Y::checkAccess('moderator')?array(
			array('username, password, email', 'required', 'on' => 'create'),
			array('username, email', 'required', 'on' => 'update'),
			array('id, role, username, password, email, activkey, createtime, lastvisit, status', 'safe'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => Users::t("Incorrect username (length between 2 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => Users::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => Users::t("This user's name already exists.")),
			array('email', 'unique', 'message' => Users::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => Users::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
			array('role', 'in', 'range'=>Lookup::keys('role')),
			array('username, email, createtime, lastvisit, status', 'required'),
			array('createtime, lastvisit, status', 'numerical', 'integerOnly'=>true),
		):((Y::userId()==$this->id)?array(
			array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => Users::t("Incorrect username (length between 2 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => Users::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => Users::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => Users::t("This user's email address already exists.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{	
		$relations = array(
			'profile'=>array(self::HAS_ONE, 'Profile', 'user_id'),
		);
		if (isset(Y::module('users')->relations)) $relations = array_merge($relations,Y::module('users')->relations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'role'=>Users::t("role"),
			'username'=>Users::t("username"),
			'password'=>Users::t("password"),
			'verifyPassword'=>Users::t("Retype Password"),
			'email'=>Users::t("E-mail"),
			'verifyCode'=>Users::t("Verification Code"),
			'id' => Users::t("Id"),
			'activkey' => Users::t("activation key"),
			'createtime' => Users::t("Registration date"),
			'lastvisit' => Users::t("Last visit"),
			'status' => Users::t("Status"),
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactvie'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANED,
            ),
            'administrator'=>array(
                'condition'=>'role="admin" OR role="webmaster"',
            ),
            'notsafe'=>array(
            	'select' => 'id, role, username, password, email, activkey, createtime, lastvisit, status',
            ),
        );
    }
	
	public function defaultScope()
    {
        return array(
            'select' => 'id, role, username, email, createtime, lastvisit, status',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('role',$this->role);
		$criteria->compare('createtime',$this->createtime);
		$criteria->compare('lastvisit',$this->lastvisit);
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
    
	public static function itemAlias($type,$code=NULL) {
		
		$_items = self::aliases();
		
		if (isset($code)) {
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		} else {
			return isset($_items[$type]) ? $_items[$type] : false;
		}
	}
	
	public function aliases($type=NULL) {
		$arr = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => Users::t('Not active'),
				self::STATUS_ACTIVE => Users::t('Active'),
				self::STATUS_BANED => Users::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => Users::t('No'),
				'2' => Users::t('Yes'),
			)
		);
		 return $type ? $arr[$type] : $arr;
	} 	

	public function getUrl() 
	{
		return Users::url('profile', array('id'=>$this->id));
	}
	
	protected function afterSave() 
	{
		if(parent::afterSave()) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function beforeSave() 
	{
		if(parent::beforeSave()) {
			if($this->isNewRecord)
				$this->createtime = time();
			return true;
		} 
		
		return false;
	}
	
	protected function afterDelete() 
	{
		if(parent::afterDelete()) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function beforeDelete() 
	{
		if(parent::beforeDelete()) {
			$this->blog->delete();
			return true;
		} else {
			return false;
		}
	}
	
}