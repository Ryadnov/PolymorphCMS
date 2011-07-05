<?php
$admin = array(
	'admin/<c>/<a>' => 'admin/<c>/<a>',	
	'admin/<c>' => 'admin/<c>/index', 
	'admin' => 'admin/manage/index',
);

$rbam = array(
	'admin/rbam/<c>/<a>' => 'rbam/<c>/<a>',	
	'admin/rbam/<c>' => 'rbam/<c>', 
	'admin/rbam' => 'rbam/rbam',
);

$site = array(
	//site urls
	'rss/<blog_id:\d+>'=>'site/rss',
	'atom/<blog_id:\d+>'=>'site/atom',
	'sitemap.xml'=>'site/sitemapxml',
	
	'ajax/<a>'=>'ajax/<a>',
	
	'<cat1>/<cat2>/<id:\d+>' => 'site',
	'<cat1>/<id:\d+>' => 'site',

	'<cat1>/<cat2>/<type:(portfolio|partner|client|publication|news)>-<alias:\w+>' => 'site',
	'<cat1>/<type:(portfolio|partner|client|publication|news)>-<alias:\w+>' => 'site',

	'<cat1>/<cat2>' => 'site',
	'<cat1>' => 'site',
	''=>'site',
);

$user = addWay('admin', addModule('users', array( 	
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
)));

//echo '<pre>';
//print_r(array_merge($admin, $user, $site));

return array(
	'urlFormat'=>'path',
	'rules'=>array_merge($rbam, $user, $admin, $site),
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
