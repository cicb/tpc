<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();

//$cf=Confipvfuncion::model()->with(
		//array('puntoventa'=>
				//array('with'=>'hijos')))->findByPk(array('EventoId'=>521,
		//'FuncionesId'=>1,'PuntosventaId'=>101));
//print($cf->puntoventa->PuntosventaNombre);
$pv=Puntosventa::model()->with('hijos')->findByPk(1001);
print($pv->PuntosventaNom);
foreach ($pv->hijos as $hijo)
		echo $hijo->PuntosventaNom;


