<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="/css/ie.css" media="screen, projection" />
    <![endif]-->
    <?php echo $meta->title ?>
  </head>
  
  <body>
    <div id="wrap">
      <div class="container">
        <div class="index-left">
			<a href="#"><img src="/images/ir.gif" alt="ir.kz" /></a>
		    <?php echo $block->left ?>
		</div>
        
        <?php echo $block->header ?>
        
        <div class="container-show">
          <div id="content-wide" class="content">
            <?php echo $content ?>
          </div>
        </div>

        <div class="footer">
          <div class="footer-block1">
            <?php echo $block->footer ?>
          </div>
          <p class="ir">© 1999-2011 Группа компаний «Интернет Решения»</p>
        </div>
        
      </div>
    </div>
  </body>
</html>