<?php

require_once( dirname(__FILE__) . '/../components/helpers.php');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Panel de control',

	// preloading 'log' component
	'preload'=>array('log'),

	'aliases'=>array(
	        'bootstrap' => realpath('/home/taquilla/public_html/panel/protected/extensions/bootstrap'), // change this if necessary
	        'yiiwheels' => realpath('/home/taquilla/public_html/panel/protected/extensions/yiiwheels'), // change this if necessary

	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.helpers.TbHtml',
        'application.extensions.EExcelView',
        //'application.extensions.yiireport.*',
        'application.extensions.EChosen.*',
        'application.extensions.CJuiDateTimePicker.*',
		'ext.giix-components.*',
        'application.extensions.yii-mail.*',

		'ext.quickdlgs.*',
        // 'application.vendors.PHPExcel',
        // 'application.vendors.PHPExcel.*',

	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'globaloxs',
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array('bootstrap.gii'),
		),
		
	),

	// application components
	'components'=>array(
		// 'chartjs' => array('class' => 'chartjs.components.ChartJs'),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'mustache'=>array(
			'class'=>'ext.mustache.components.MustacheApplicationComponent',
            // Default settings (not needed)
			'templatePathAlias'=>'application.templates',
			'templateExtension'=>'mustache',
			'extension'=>true,
			),
    'mobileDetect' => array(
        'class' => 'ext.MobileDetect.MobileDetect'
    ),
        'mail' => array(
                'class' => 'application.extensions.yii-mail.YiiMail',
                    'transportType'=>'php', /// case sensitive!
                    //'transportType'=>'smtp', /// case sensitive!
                    //'transportOptions'=>array(
                    //'host'=>'ssl://smtp.gmail.com',
                    //'username'=>'globaloxs@gmail.com',
                    //'password'=>'10203',
                    //'port'=>'465',
                    //),
                'viewPath' => 'application.views.mail',
                'logging' => true,
                'dryRun' => false,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/ 
		/*
		 *'db'=>array(
		 *    'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		 *),
		 */
		// uncomment the following to use a MySQL database
		 //'db'=>array(
				 //'connectionString' => 'mysql:host=taquillacero.com;dbname=taquilla_ver3',
				 //'emulatePrepare' => true,
				 //'username' => 'taquilla_report',
				 //'password' => 't4quill4-05',
				 //'charset' => 'utf8',
				 //),		
		 'db'=>array(
				 'connectionString' => 'mysql:host=taquillacero.com;dbname=taquilla_ver3',
				 'emulatePrepare' => true,
				 'username' => 'taquilla_usr3',
				 'password' => 'F5rL0gU8x',
				 'charset' => 'utf8',
				 ),		
		  // 'db'=>array(
				//   'connectionString' => 'mysql:host=taquillacero.com;dbname=taquilla_ver3demo01',
    //                'emulatePrepare' => true,
				//  'username' => 'taquilla_victor',
				//  'password' => 'dfer45g-a',
				//  'charset' => 'utf8',
				//  ),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',   
        ),
		'yiiwheels' => array(
				'class' => 'yiiwheels.YiiWheels',   
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
        'pvRaiz'=>1000,
		'adminEmail'=>'webmaster@example.com',
	),
);
