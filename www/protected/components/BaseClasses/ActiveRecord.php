<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
abstract class ActiveRecord extends CActiveRecord
{
	public $verifyCode;
    //make ajax captcha validation
    public function activeCaptcha()
	{ 
		$code = Y::controller()->createAction('captcha')->getVerifyCode();
        
		if ($code != $this->verifyCode) { 
        	$this->addError('verifyCode', 'Неправильный код проверки.');
        }
        
        if(!isset($_POST['ajax'])) {
        	Y::controller()->createAction('captcha')->getVerifyCode(true);
        }
	}
	
	public function rules() {
		return array(    
			array('verifyCode', 'activeCaptcha', 'allowEmpty'=>!Y::isGuest() || !CCaptcha::checkRequirements()), // Во время AJAX запроса не забудьте установить сценарий для модели
		    //to captcha ajax validation    
			/*array('verifyCode','captcha',
               // авторизованным пользователям код можно не вводить
               ,
			   'captchaAction' => 'site/captcha'
            ),*/
            
		);
	}
	
	public function has($attr)
	{
		return $this->hasAttribute($attr) || is_callable(array($this, 'get'.ucfirst($attr)));
	}
	
	abstract static public function getPkAttr();
	
	public function getPk() 
	{
		return $this->{$this->pkAttr};	
	}
	
	public function setPk($newId) 
	{
		return $this->{$this->pkAttr} = $newId;	
	}

	public function cache($tags, $queryCount = 1) 
	{
		return parent::cache(0, new Tags($tags), $queryCount); 
	}
}
