<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
	
	public function rules() {
		$rules = array(
			array('username, password, verifyPassword, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => Users::t("Incorrect username (length between 2 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => Users::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => Users::t("This user's name already exists.")),
			array('email', 'unique', 'message' => Users::t("This user's email address already exists.")),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => Users::t("Retype Password is incorrect.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => Users::t("Incorrect symbols (A-z0-9).")),
		);
		if (isset($_POST['ajax']) && $_POST['ajax']==='registration-form') 
			return $rules;
		else 
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UsersModule::doCaptcha('registration')));
		return $rules;
	}
	
}