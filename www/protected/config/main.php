<?php
define('BASE_URL', 'http://216.231.135.91/polymorph/');

// uncomment the following to define a path alias
Yii::setPathOfAlias('modules',		'protected/modules');
Yii::setPathOfAlias('components',	'protected/components');
Yii::setPathOfAlias('models',		'protected/models');
Yii::setPathOfAlias('widgets',		'protected/components/Plugins');
Yii::setPathOfAlias('behaviors',	'protected/components/Behaviors');
Yii::setPathOfAlias('events',	'protected/components/Events');
Yii::setPathOfAlias('plugins',	'protected/components/Plugins');
Yii::setPathOfAlias('packages',	'protected/modules');

Yii::import('components.BaseClasses.*');
Yii::import('components.*');

Yii::app()->onBeginRequest = function($event) {

    //Yii::createComponent need. If don't make it, then setComponent() not call init()
    $configs = array(
        'resourceManager'=>Yii::createComponent(array(
            'class'=>'ResourceManager',
            'mainRoutes'=> array(
                //site urls
    //            'rss/<blog_id:\d+>'=>'site/rss',
    //            'atom/<blog_id:\d+>'=>'site/atom',
    //            'sitemap.xml'=>'site/sitemapxml',

            //	'admin/<m>/<c>/<a>' => '<m>/<c>/<a>',
            //	'admin/<m>/<c>' => '<m>/<c>/index',
                'admin' => 'admin/manage/index',
                'admin/<m>/<c>/<a>' => 'admin/<m>/<c>/<a>',
                'admin/<c>/<a>' => 'admin/<c>/<a>',
                'admin/login' => 'users/login',

                '<cat1>/<cat2>/<pk:\d+>' => 'site',
                '<cat1>/<pk:\d+>' => 'site',

                '<cat1>/<cat2>/<alias:\w+>' => 'site',
                '<cat1>/<cat2>' => 'site',
                '<cat1>' => 'site',
                ''=>'site',
            )
        )),
    );

    Yii::app()->setComponents($configs);

    return TRUE;
};



// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

    'name'=>'polymorphCMS',	// access it using Yii::app()->name
    'defaultController'=>'site',   // default controller that will be executed when running the application
    'language'=>'ru',   	// user language (for Locale)
	'sourceLanguage'=>'en',	//language for messages and views
    'charset'=>'utf-8',     // charset to use
	'preload'=>array('log', 'maintenanceMode', 'hooksManager'),	// preloading 'log' component

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
		'modules.cms.components.*',
        'modules.cms.models.*',

        //ext
        'ext.yiiext.shoppingCart.*'
    ),
    'preload'=>array('hooksManager'),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		//'gii'=>require("gii.php"),
        'rbam'=>array(
		    'class'=>'modules.rbam.RbamModule',
			'initialise'=>TRUE,
		),
        'admin',
		'cms'
    ),

	// application components
	'components'=>require("components.php"),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require("db.php"),
);