<?
session_start();
include_once($_SERVER["DOCUMENT_ROOT"]."/admin/init.php");


if($auth_check == 1) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$_SERVER['SERVER_NAME']?> [ Панель управления ] Язык - <?=$lang{$l}?></title>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<link href="/admin/admin.css" type="text/css" rel="stylesheet">
    <link href="/admin/tree/jquery.treeview.css" rel="stylesheet" type="text/css" />
    <link href="/data/messages.css" rel="stylesheet" type="text/css">
    <link href="/js/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-1.5.min.js"></script>
	<script type="text/javascript" src="/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="/admin/tree/jquery.treeview.js"></script>
	<script type="text/javascript" src="/js/tiny_mce/jquery.tinymce.js"></script>
    <script src="/js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php" type="text/javascript"></script>
    <script type="text/javascript" src="/js/jquery.keyfilter-1.1.js"></script>
	<script type="text/javascript" src="/js/translate.js"></script>
	<script type="text/javascript" src="/js/jquery.crawlLine.js"></script>
	<script type="text/javascript" src="/admin/js/admin.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="/js/ui.datetimepicker.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.admin-gallery-title').crawlLine({
            speed:2,
            crawElement:'div', // для примера div.move
            textElement:'p',
            hoverClass:'viewText'
        });
    });
</script>

 </head>
 <body>
  <div id="container">
   <div id="header">

        <div id="language">
         <?
         foreach ($lang as $key => $value) {
            if ($key==$l){
                echo '<img src="/admin/images/flags/png/'.$key.'.png" alt="'.$value.'" title="'.$value.'" hspace="7" style="border: solid 4px #fff;" width="1">';
                $link = $key;
            }else {
                echo '<a href="/admin/?l='.$key.'"><img src="/admin/images/flags/png/'.$key.'.png" alt="'.$value.'" title="'.$value.'" hspace="7" style="border: solid 4px #89CEDE;"></a>';
    	    }
        }
	?>
          <br /><br />
        &larr; <a href="/" target="blank">Вернутся на сайт</a>
        </div>
        <h2>Панель управления IRSite</h2>

        <div id="support">
        <img src="/admin/images/information.png" align="left" hspace="10" vspace="15"><b>Служба поддержки</b><br />
        <a href="http://support.ir.kz" target="_blank">Оставить заявку</a> <br />
        <a href="mailto:support@ir.kz">Написать письмо</a><br />
        +7 (7172) 36-78-77, 35-91-84

        </div>

   </div>
   <div id="sidebar">
   <div class="menuHead"><b>Управление</b> (db: <?=$db_name;?>)</div>
   <!-- Колонка -->
    <?
    if ($user_tp > 0) {
    ?>

    <ul id="menublock">
        <li><img src="img/group.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=useradmin">Управление пользователями</a></li>
        <li><img src="img/folder_wrench.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=kats">Управление разделами</a></li>
        <li><img src="img/layout_edit.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=maincfg">Общие настройки</a></li>
        <li><img src="img/application_view_tile.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=cfgcategory">Управление категориями</a></li>
        <li><img src="img/application_form.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=atribut_all">Управление атрибутами</a></li>
        <li><img src="img/user_comment.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=voute">Он-лайн опросы</a></li>
        <li><img src="img/compress.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=dumper">Экспорт / Импорт БД</a></li>
    </ul>
    <?
    }else {
    ?>
    <ul id="menublock">
        <li><img src="img/group.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=pass">Смена пароля</a></li>
        <li><img src="img/layout_edit.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=maincfg">Общие настройки</a></li>
        <li><img src="img/application_view_tile.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=cfgcategory">Управление категориями</a></li>
        <li><img src="img/user_comment.gif" align="absmiddle"> <a href="<?=$admindir;?>?l=<?=$l?>&md=voute">Он-лайн опросы</a></li>
    </ul>

    <?
    }
    ?>
    <div class="menuHead">
    <span id="treecontrol">
		<a title="Свернуть все" href="#"><img src="/admin/tree/images/minus.gif" /></a>&nbsp;
		<a title="Развернуть" href="#"><img src="/admin/tree/images/plus.gif" /></a>
	</span> <b>Разделы</b>
    </div>

    <?
    include('./katlist.php');
    ?>

   <!-- Трям Колонка -->

   </div>
   <div id="content">
    <!-- Контент -->
    <?
    $md = (isset($_POST['md'])) ? $_POST['md'] : $_GET['md'];

	if(!isset($md)) {
	    include('./incs/hello.php');
	} else {
		$query="SELECT id_kat, xsl_short, xsl_full, xsl_col, params FROM ".$tables['_kat_cfg']." WHERE id_kat='".$id_kat."'";
		$result = @mysql_query($query);
		if (!@mysql_error()) {
			$row = @mysql_fetch_object($result);
			$xsl_short=$row->xsl_short;
			$xsl_full=$row->xsl_full;
			$xsl_col=$row->xsl_col;
			$params=$row->params;
			};

		$lst=split("\n", $params);
		$par_arr=array();
		for ($i=0; $i<count($lst); $i++) {
			$lst[$i]=str_replace("\n", '', $lst[$i]);
			list($key, $val)=split("=",$lst[$i]);
			$par_arr["$key"]=$val;
			};
        define('IN_ADMIN', '2');
		switch ($md) {
		case 'kats': include('./md_kats.php');break;
		case 'cfgkats': include('./md_cfgkats.php');break;
		case 'cfgcategory': include('./md_cfgcategory.php');break;
		case 'cfgcols': include('./md_cfgcols.php');break;
		case 'pic_col': include('./md_pic_col.php');break;
		case 'file_col': include('./md_file_col.php'); break;
		case 'voute': include('./md_voute.php'); break;
		case 'maincfg': include('./md_maincfg.php');break;//new in 2.2.0.1atribut_all
		case 'atribut_all': include('./md_atribut_all.php');break;
		case 'pass': include('./md_pass.php');break;

		case 'page': include('./md_page.php');break;
		case 'news': include('./md_news.php');break;
		case 'faq': include('./md_faq.php');break;
		case 'gb': include('./md_gb.php');break;
		case 'photo': include('./md_photo.php');break;
		case 'files': include('./md_files.php');break;
		case 'links': include('./md_links.php');break;
		case 'prod': include('./md_prod.php');break;
		case 'htmlcol': include('./md_htmlcol.php');break;
		case 'feedback': include('./md_feedback.php');break;//new in 2.2.0.2

		case 'voutearc': include('./md_voutearc.php');break;//new in 2.2.0.0
		case 'search': include('./md_search.php');break;


		case 'link': include('./md_link.php');break;
		case 'scrpt': include('./md_script.php');break;

		case 'useradmin': include('./md_useradmin.php'); break;
		case 'userruler': include('./md_userruler.php'); break;
		case 'htaccess': include('./md_htaccess.php');break;

		case 'comment': include('./md_comment.php');break;
		case 'atribut': include('./md_atribut.php');break;//new in 2.2.0.0
		case 'sprav': include('./md_sprav.php'); break;//new in 2.2.0.0


        case 'open': include('./md_news_a1.php'); break;//new in 2.2.0.0
        case 'open1': include('./md_news_a2.php'); break;//new in 2.2.0.0
        case 'open2': include('./md_news_a3.php'); break;//new in 2.2.0.0
        case 'open_users': include('./md_news_a_users.php'); break;//new in 2.2.0.0
        case 'open_gb': include('./md_news_a_gb.php'); break;//new in 2.2.0.0
        case 'open_kat': include('./md_news_a_kat.php'); break;//new in 2.2.0.0
        case 'report': include('./md_news_a_reoprt.php'); break;//new in 2.2.0.0


        case 'dumper': include('./dumper.php'); break;//new in 2.2.0.0




	   }
	   }
    $acct = (isset($_POST['act'])) ? $_POST['act'] : $_GET['act'];

    ?>
    <!-- Трям Контент -->
     <!-- Load TinyMCE -->
<script type="text/javascript" src="/lib/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '/js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			convert_urls : false,
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,jaretypograph",
		skin : "cirkuit",
        extended_valid_elements : "iframe[src|width|height|name|align|frameborder|scrolling]",
        height : "450",
        width: "100%" ,
			// Theme options
			theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,sub,sup,|,bullist,numlist,|,charmap,|,justifyleft,justifycenter,justifyright,justifyfull,|,outdent,indent,blockquote,formatselect",
			theme_advanced_buttons2 : "image,media,link,unlink,anchor,|,cut,copy,paste,pastetext,pasteword,|,newdocument,pagebreak,|,jaretypograph,visualaid,cleanup,removeformat,|,fullscreen,|,code",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
            file_browser_callback : "tinyBrowser",
			language : "ru"
            //content_css : "/style.css",
		});
	});
</script>
<!-- /TinyMCE -->
   </div>
   <div id="footer">	<?include('./incs/bottom.php');?>  </div>
  </div>
 </body>
</html>
<?
}else{
    include('./incs/loginform.php');
}
?>