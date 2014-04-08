<?php

// change the following paths if necessary

$yii='/opt/yii/framework/yii.php';

//$yii=dirname(__FILE__).'/../yii1114/framework/yii.php';
//>>>>>>> 6234aa5b420a9e1480a386f167095de0b7a49465
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
