<?php
$admin = array(
//	'admin/<m>/<c>/<a>' => '<m>/<c>/<a>',
//	'admin/<m>/<c>' => '<m>/<c>/index',
	'admin' => 'admin/manage/index',
    'admin/<m>/<c>/<a>' => 'admin/<m>/<c>/<a>',
    'admin/<c>/<a>' => 'admin/<c>/<a>',
    'admin/login' => 'users/login',
);

$rbam = array(
	'admin/rbam/<c>/<a>' => 'rbam/<c>/<a>',	
	'admin/rbam/<c>' => 'rbam/<c>', 
	'admin/rbam' => 'rbam/rbam',
);

$users = addModule('users', array(
	//user module links
	'login'=>'login',
	'registration'=>'registration',
	'recovery/<email>/<activkey>'=>'recovery',
	'recovery'=>'recovery',
	'logout'=>'logout',
	'activation/<email>/<activkey>'=>'activation',
	'profile/<id:\d+>'=>'profile',
	'cabinet/'=>'profile/cabinet',
	'user/edit'=>'profile/edit',
	'changepassword'=>'profile/changepassword',
	'close' => 'registration/close',
	'users/admin'=>'admin',
	'users/create'=>'admin/create',
	'<controller:(user|profileField)>/<action:(admin|view|create|update|delete)>'=>'<controller>/<action>',
));

//echo '<pre>';
//print_r(array_merge($admin, $users));

return array(
	'urlFormat'=>'path',
	'rules'=>array_merge($admin, $users),
	'showScriptName' => false, 
);

function addModule($moduleId, $array) 
{
	$res = array();
	foreach ($array as $key=>$val) {
		$res[$key] = $moduleId.'/'.$val; 
	}
	
	return $res;
}

function addWay($moduleId, $array) 
{
	$res = array();
	foreach ($array as $key=>$val) {
		$res[$moduleId.'/'.$key] = $val; 
	}
	
	return $res;
}
