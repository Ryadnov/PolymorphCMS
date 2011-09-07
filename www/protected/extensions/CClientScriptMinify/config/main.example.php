<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Orite Yii Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.forms.*',
	),

	// application components
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
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
		// uncomment the following to set up database
		'db'=>array(
            'class'=>'CDbConnection',
            'connectionString'=>'mysql:host=localhost;dbname=test',
            'username'=>'root',
            'password'=>'',
        ),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'test@orite.com',
	),
);