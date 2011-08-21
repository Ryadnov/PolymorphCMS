<?php
$rbam = array(
	'admin/rbam/<c>/<a>' => 'rbam/<c>/<a>',	
	'admin/rbam/<c>' => 'rbam/<c>', 
	'admin/rbam' => 'rbam/rbam',
);


//echo '<pre>';
//print_r(array_merge($admin));

return array(
	'urlFormat'=>'path',
	'rules'=>'',
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
