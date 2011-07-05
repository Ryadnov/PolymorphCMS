<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('modules',		'protected/modules');
Yii::setPathOfAlias('components',	'protected/components');
Yii::setPathOfAlias('models',		'protected/models');
Yii::setPathOfAlias('widgets',		'protected/components/Widgets');


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
 
    'name'=>'p.ru',	// access it using Yii::app()->name
    'defaultController'=>'site',   // default controller that will be executed when running the application
    'language'=>'ru',   	// user language (for Locale)
	'sourceLanguage'=>'en',	//language for messages and views
    'charset'=>'utf-8',     // charset to use
	'preload'=>array('log', 'maintenanceMode'),	// preloading 'log' component

	// autoloading model and component classes
	'import'=>array(
		'models.*',
		'models.dataTypes.*',
		'models.templates.*',
		'components.*',
		'components.Renderers.*',
		'components.Helpers.*',
		'components.Behaviors.*',
		'components.BaseClasses.*',
		'components.Interfaces.*',
		'components.Twig.*',
		'modules.users.components.*',
		'modules.users.UsersModule',
		'modules.users.models.*',
		'modules.admin.AdminModule',
		'modules.admin.components.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>require("gii.php"),
        'users'=>array(
			'class'=>'application.modules.users.UsersModule',
			'tableUsers' => 'users',
			'tableProfiles' => 'profiles',
			'tableProfileFields' => 'profiles_fields',
			'sendActivationMail' => false,
			'loginNotActiv' => true,
			'activeAfterRegister' => true,
			'isRegistrationClose' => true
		),
		'admin' => array(
			'class'=>'application.modules.admin.AdminModule'
		),
		'rbam'=>array(
		    'class'=>'application.modules.rbam.RbamModule',
			'initialise'=>TRUE,
		),
    ),

	// application components
	'components'=>array(
		'file'=>array(
	        'class'=>'application.components.CFile.CFile',
	    ),
    
    	'cache'=>array(
        	'class'=>'application.components.FileCache',
		),
		'viewRenderer'=>array(
            'class'=>'application.extensions.renderers.twig.CTwigViewRenderer',
     		'fileExtension' => '.twig',
        ),
    	'request'=>array(
			'class'=>'HttpRequest',
    		'noCsrfValidationRoutes'=>array(
				'blogs/imgUpload'
	        ),
//          'enableCsrfValidation'=>true,
    		'enableCookieValidation'=>true
        ),
        
		'maintenanceMode' => array(
        	'class' => 'application.extensions.MaintenanceMode.MaintenanceMode',
    		'enabledMode' => false,
	        //'message' => 'Hello!',
	        // or
	        'capUrl' => 'maintenance/index',
	        // allowed users
	        //'users' => array('admin', ),
	        // allowed roles
	        'roles' => array('moderator'),
	        // allowed urls
	        'urls' => array('/ru/login', '/ru/registration', ),  
    	),
    
    	'user'=>array(
			// enable cookie-based authentication
			'class'=>'WebUser',
    	),
    	
		'clientScript' => array(
			'class' => 'ext.minify.EClientScript',
			'combineScriptFiles' => false, // By default this is set to false, set this to true if you'd like to combine the script files
			'combineCssFiles' => false, // By default this is set to false, set this to true if you'd like to combine the css files
			'optimizeCssFiles' => false,  // @since: 1.1
			'optimizeScriptFiles' => false,   // @since: 1.1
		),
		
		'urlManager'=> require("route.php"),
        'assetManager'=>array(			// assets, see http://www.yiiframework.com/doc/api/CAssetManager
            'basePath'=>dirname(__FILE__).'/../../assets/',   // change the path on disk
            'baseUrl'=>'/assets/'   // change the url
        ),
		// uncomment the following to use a MySQL database
		
		'db'=>require("db.php"),
		'authManager'=>array(
            'class'=>'PhpAuthManager',
            'defaultRoles'=>array('guest'), 
        ),
        
		'config' => array(
			'class' => 'application.extensions.config.EConfig',
		),
		
        'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),

		'log'=>array(
            'class'=>'CLogRouter',   	// class of logger
            'routes'=>array(            // where to store logs?
        		array(
                    'class'=>'CFileLogRoute',	        // store on file, other options are available
                    'levels'=>'error, warning',	        // what to store on file? error and warning, info and trace can be added here
                	//'showInFireBug'=>true,
                ),
                /*
		        array(
	                'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
	                'ipFilters'=>array('127.0.0.1','192.168.1.215'),
	            ),     
                // uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
                array( // configuration for the toolbar
					'class'=>'ext.debug.XWebDebugRouter',
					'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
					'levels'=>'error, warning, trace, profile, info',
					'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
		        ),*/
             	
		    ),
			
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require("db.php"),
);