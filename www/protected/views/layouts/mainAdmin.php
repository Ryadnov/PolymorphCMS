<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/css/admin.css" media="screen, projection" />

        <title>Панель Администратора</title>
    </head>

    <body>
        <div id="wrap">
            <div class="container">
                <?php echo $content?>
            </div>

            <div class="footer">
                <div class="footer-block1">
                </div>
                <div class="footer-block2">
                </div>
                <p class="me"><?php echo date('Y');?> PolymorphCMS - Alexey Sharov</p>
            </div>

        </div>
    </body>
</html>