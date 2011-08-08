<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('modules',		'protected/modules');
Yii::setPathOfAlias('components',	'protected/components');
Yii::setPathOfAlias('models',		'protected/models');
Yii::setPathOfAlias('widgets',		'protected/components/Widgets');
Yii::setPathOfAlias('behaviors',	'protected/components/Behaviors');
Yii::setPathOfAlias('events',	'protected/components/Events');

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
        'events.*',


		'models.*',
		'models.dataTypes.*',
		'models.templates.*',

        'components.*',
		'components.Renderers.*',
		'components.Helpers.*',
		'components.Behaviors.*',
		'components.BaseClasses.*',
		'components.Interfaces.*',
		'components.Other.*',

        //models and components
		'modules.users.components.*',
		'modules.users.models.*',
		'modules.admin.components.*',
        'modules.admin.models.*',
        'modules.records.components.*',
        'modules.records.models.*',
        'modules.cms.components.*',
        'modules.cms.models.*',


        //ext
        'ext.yiiext.shoppingCart.*'
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
		'rbam'=>array(
		    'class'=>'application.modules.rbam.RbamModule',
			'initialise'=>TRUE,
		),
        'admin',
		'cms',
        'records'
    ),

	// application components
	'components'=>require("components.php"),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require("db.php"),
);