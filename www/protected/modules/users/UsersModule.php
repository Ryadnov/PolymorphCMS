<?php
/**
 * Yii-User module
 * 
 * @author Mikhail Mangushev <mishamx@gmail.com> 
 * @link http://yii-user.googlecode.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UserModule.php 105 2011-02-16 13:05:56Z mishamx $
 */

class UsersModule extends Package
{
    public $categoryAlias = 'users';
    public $category = null;

    public function getRouteRules()
    {
        return array(
            //user module links
            'login' => 'users/login',
            'registration' => 'users/registration',
            'recovery/<email>/<activkey>' => 'users/recovery',
            'recovery' => 'users/recovery',
            'logout' => 'users/logout',
            'activation/<email>/<activkey>' => 'users/activation',
            'profile/<id:\d+>' => 'users/profile',
            'cabinet/' => 'users/profile/cabinet',
            'user/edit' => 'users/profile/edit',
            'changepassword' => 'users/profile/changepassword',
            'close' => 'users/registration/close',
            'admin/users/admin' => 'users/admin',
            'admin/users/create' => 'users/admin/create',
            '<controller:(user|profileField)>/<action:(admin|view|create|update|delete)>' => 'users/<controller>/<action>',
        );
    }

    public function widgets()
    {
        return array(
            'UserMenu' => array(
                'title'=>'Меню пользователя',
                'class'=>'UserMenuWidget'
            )
        );
    }

    public function cmsAdminGetSystemMenu($event)
    {
        $event->menu = CMap::mergeArray($event->menu, array(
            'users'=>array('text'=>Admin::link('Пользователи', 'users/admin')),
        ));
    }

	/**
	 * @var int
	 * @desc items on page
	 */
	public $user_page_size = 10;
	
	/**
	 * @var int
	 * @desc items on page
	 */
	public $fields_page_size = 10;
	
	/**
	 * @var string
	 * @desc hash method (md5,sha1 or algo hash function http://www.php.net/manual/en/function.hash.php)
	 */
	public $hash='md5';
	
	/**
	 * @var boolean
	 * @desc use email for activation user account
	 */
	public $sendActivationMail=true;
	
	/**
	 * @var boolean
	 * @desc allow auth for is not active user
	 */
	public $loginNotActiv=false;
	
	/**
	 * @var boolean
	 * @desc activate user on registration (only $sendActivationMail = false)
	 */
	public $activeAfterRegister=false;
	
	/**
	 * @var boolean
	 * @desc login after registration (need loginNotActiv or activeAfterRegister = true)
	 */
	public $autoLogin=true;

	public $registrationUrl = "registration";
	public $recoveryUrl = "recovery";
	public $loginUrl = "login";
	public $logoutUrl = "logout";
	public $cabinetUrl = "cabinet";
	public $profileUrl = "profile";
	public $adminReturnUrl = "/admin";
    public $returnUrl = "/profile";
	public $returnLogoutUrl = "login";
	public $editProfileUrl = "profile/edit";
	public $changePassUrl = "profile/changepassword";
	
	public $fieldsMessage = '';
	
	/**
	 * @var array
	 * @desc User model relation from other models
	 * @see http://www.yiiframework.com/doc/guide/database.arr
	 */
	public $relations = array();
	
	/**
	 * @var array
	 * @desc Profile model relation from other models
	 */
	public $profileRelations = array();
	
	/**
	 * @var boolean
	 */
	public $captcha = array('registration'=>true);
	
	/**
	 * @var boolean
	 */
	//public $cacheEnable = false;
	
	public $tableUsers = '{{users}}';
	public $tableProfiles = '{{profiles}}';
	public $tableProfileFields = '{{profiles_fields}}';
	
	static private $_user;
	static private $_admin;
	static private $_admins;
	
	/**
	 * @var array
	 * @desc Behaviors for models
	 */
	public $componentBehaviors=array();
	
	public $isRegistrationClose = false;
	
	public function init()
	{
        parent::init();
        
        $baseUrl = Yii::app()->baseUrl;
	    $this->registrationUrl = $baseUrl."/registration";
        $this->recoveryUrl = $baseUrl."/recovery";
        $this->loginUrl = $baseUrl."/login";
        $this->logoutUrl = $baseUrl."/logout";
        $this->cabinetUrl = $baseUrl."/cabinet";
        $this->profileUrl = $baseUrl."/profile";
        $this->adminReturnUrl = $baseUrl."/admin";
        $this->returnUrl = $baseUrl."/profile";
        $this->returnLogoutUrl = $baseUrl."/login";
        $this->editProfileUrl = $baseUrl."/profile/edit";
        $this->changePassUrl = $baseUrl."/profile/changepassword";

        $this->category = Y::category('index');

        $this->setImport(array(
            'users.models.*',
            'users.components.*',
            'users.components.widgets.*'
        ));
	}
	
	//simple add lang in url
	private function createUrls($base_urls)
    {
		foreach ($base_urls as $var=>$url) {
			$this->{$var} = Users::url($url);
		}
	}
	
	public function getBehaviorsFor($componentName){
        if (isset($this->componentBehaviors[$componentName])) {
            return $this->componentBehaviors[$componentName];
        } else {
            return array();
        }
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	/**
	 * @param $str
	 * @param $params
	 * @param $dic
	 * @return string
	 */
	public static function t($str='',$params=array(),$dic='user') {
		return Yii::t("UserModule.".$dic, $str, $params);
	}
	
	/**
	 * @return hash string.
	 */
	public static function encrypting($string="") {
		$hash = Y::module('users')->hash;
		if ($hash=="md5")
			return md5($string);
		if ($hash=="sha1")
			return sha1($string);
		else
			return hash($hash,$string);
	}
	
	/**
	 * @param $place
	 * @return boolean 
	 */
	public static function doCaptcha($place = '') {
		if(!extension_loaded('gd'))
			return false;
		if (in_array($place, Y::module('users')->captcha))
			return Y::module('users')->captcha[$place];
		return false;
	}
	
	/**
	 * Return admin status.
	 * @return boolean
	 */
	public static function isAdmin() {
		if(Y::isGuest())
			return false;
		else {
			if (!isset(self::$_admin)) {
				if(Y::checkAccess('administrator'))
					self::$_admin = true;
				else
					self::$_admin = false;	
			}
			return self::$_admin;
		}
	}

	/**
	 * Return admins.
	 * @return array syperusers names
	 */	
	public static function getAdmins() {
		if (!self::$_admins) {
			$admins = User::model()->active()->administrator()->findAll();
			$return_name = array();
			foreach ($admins as $admin)
				array_push($return_name,$admin->username);
			self::$_admins = $return_name;
		}
		return self::$_admins;
	}
	
	/**
	 * Send mail method
	 */
	public static function sendMail($email,$subject,$message) {
		
		$model = new Email;
		
		$model->email_name = self::t("Your registration");
		$model->subject = $subject;
		$model->message = $message;
		$model->to = $email;
		$model->from = Y::config('email_to_registraiton');
    	return $model->send();
	}
	
	/**
	 * Return safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public static function user($id=0)
    {
		if ($id) 
			return User::model()->active()->findbyPk($id);
		else {
			if(Y::isGuest()) {
				return false;
			} else {
				if (!self::$_user)
					self::$_user = User::model()->active()->findbyPk(Yii::app()->user->id);
				return self::$_user;
			}
		}
	}
	
	/**
	 * Return safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public function users() {
		return User;
	}
}
