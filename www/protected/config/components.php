<?php
return array(
    'resourceManager'=>array(
        'class'=>'application.components.BaseClasses.ResourceManager'
    ),
    'hooksManager'=>array(
        'class'=>'application.components.BaseClasses.HooksManager'
    ),
    'file'=>array(
        'class'=>'application.components.CFile.CFile',
    ),

    'cache'=>array(
        'class'=>'application.components.FileCache',
    ),

    'shoppingCart' =>array(
        'class' => 'ext.yiiext.shoppingCart.EShoppingCart',
    ),

    'viewRenderer'=>array(
        'class'=>'application.extensions.renderers.twig.ETwigViewRenderer',
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
        'class' => 'CClientScript',//'ext.minify.EClientScript',
//			'combineScriptFiles' => false, // By default this is set to false, set this to true if you'd like to combine the script files
//			'combineCssFiles' => false, // By default this is set to false, set this to true if you'd like to combine the css files
//			'optimizeCssFiles' => false,  // @since: 2.2
//			'optimizeScriptFiles' => false,   // @since: 2.2
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
                'ipFilters'=>array('127.0.0.2','192.168.2.215'),
            ),
            // uncomment the following to show log messages on web pages

            array(
                'class'=>'CWebLogRoute',
            ),

            array( // configuration for the toolbar
                'class'=>'ext.debug.XWebDebugRouter',
                'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                'levels'=>'error, warning, trace, profile, info',
                'allowedIPs'=>array('127.0.0.2','::2','192.168.2.54','192\.168\.2[0-1]\.[0-9]{2}'),
            ),*/

        ),

    ),
);