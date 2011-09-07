Customized CClientScript to utilize Minify

###Installation
1. Copy 'controller' and 'extensions' folder to your project's 'protected' folder
2. Add following to your config/main.php with in 'components'=>array(, please check out the config/main.example.php

	//URL management
	'urlManager'=>array(
		'urlFormat'=>'path',
		'showScriptName'=>false,
		'rules'=>array(
			'minify/<group:[^\/]+>'=>'minify/index',
		),
        ),
	//Customized CClientScript with Minify
	'clientScript'=>array(
		'class'=>'application.extensions.CClientScriptMinify',
		'minifyController'=>'/minify',
	),


3. Change any Minify options in controller/MinifyController.php

###Usage
Use to following methods to register css or js files to be minified.

Yii::app()->clientScript->registerCSSFile($url, $media);
Yii::app()->clientScript->registerScriptFile($url);

Please note, the $url needs to be absolute path from your document root (where the index.php script is), i.e. '/css/main.css', '/js/myscript.js' etc.

For more information about Minify please goto http://code.google.com/p/minify/
