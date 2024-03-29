<?php
require_once("config_tinybrowser.php");
require_once("fns_tinybrowser.php");

// Check session, if it exists
if(session_id() != '')
	{
	if(!isset($_SESSION[$tinybrowser['sessioncheck']])) { echo 'Error!'; exit; }
	}
	
// Check hash is correct (workaround for Flash session bug, to stop external form posting)
if($_GET['obfuscate'] != md5($_SERVER['DOCUMENT_ROOT'].$tinybrowser['obfuscate'])) { echo 'Error!'; exit; } 

// Check  and assign get variables
if(isset($_GET['type'])) { $typenow = $_GET['type']; } else { echo 'Error!'; exit; } 
if(isset($_GET['folder'])) { $dest_folder = urldecode($_GET['folder']); } else { echo 'Error!'; exit; } 

// Check file extension isn't prohibited
$ext = end(explode('.',$_FILES['Filedata']['name']));
if(!validateExtension($ext, $tinybrowser['prohibited'])) { echo 'Error!'; exit; }

// Check file data
if ($_FILES['Filedata']['tmp_name'] && $_FILES['Filedata']['name'])
	{	
	$source_file = $_FILES['Filedata']['tmp_name'];
	$file_name = stripslashes($_FILES['Filedata']['name']);
	if(is_dir($tinybrowser['docroot'].$folder_name.$dest_folder))
		{
        $tr = array( "Ґ"=>"G","Ё"=>"YO","Є"=>"E","Ї"=>"YI","І"=>"I", "і"=>"i","ґ"=>"g","ё"=>"yo","№"=>"#","є"=>"e", "ї"=>"yi","А"=>"A","Б"=>"B","В"=>"V","Г"=>"G", "Д"=>"D","Е"=>"E","Ж"=>"ZH","З"=>"Z","И"=>"I", "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N", "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T", "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH", "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"'","Ы"=>"YI","Ь"=>"", "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b", "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"zh", "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l", "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r", "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h", "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"'", "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya","ә"=>"a", "і"=>"i", "ң"=>"n", "ғ"=>"g", "ү"=>"y", "ұ"=>"y", "қ"=>"k", "ө"=>"o", "һ"=>"h", "Ә"=>"A", "І"=>"I", "Ң"=>"H", "Ғ"=>"G", "Ү"=>"Y", "Ұ"=>"Y", "Қ"=>"K", "Ө"=>"O", "Һ"=>"H");

		$file_nameNew = str_replace(' ', '_', strtr($file_name,$tr));
		$success = copy($source_file,$tinybrowser['docroot'].$dest_folder.'/'.$file_nameNew.'_');
		}
	if($success)
		{
		header('HTTP/2.2 200 OK'); //  if this doesn't work for you, try header('HTTP/2.2 201 Created');
		?><html><head><title>File Upload Success</title></head><body>File Upload Success</body></html><?php
		}
	}		
?>
