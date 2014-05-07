<?php

class DistribucionesController extends Controller
{
	public function actionAsignar()
	{
		$ForoId=$_POST['foroid'];
		$ForoMapIntId=$_POST['distid'];	
		$distribucion=Forolevel1::model()->with('funcion')->findByPk(compact('ForoId','ForoMapIntId'));
		echo $distribucion->asignar($_POST['EventoId'],$_POST['FuncionesId'])?"true":"false";
		// $this->render('asignar');

	}

	public function actionGuardar()
	{
		$this->render('guardar');
	}


	public function actionNueva()
	{
		$this->render('nueva');
	}

	public function actionIndex($eid,$fid,$foroid)
	{
		#Despliega una lista de distribuciones actuales
		$model=new Forolevel1('search');
		if (isset($_POST['Forolevel1'])) {
			# code...
			$model->attributes=$_POST['Forolevel1'];
			// $model->EventoId=$_POST['Forolevel1'];
		}
		else{
			$model->ForoId=$foroid;
		}
		$this->render('listaDistribuciones',compact('model','eid','fid'));
	}


	// Uncomment the following methods and override them if needed
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'postOnly + asignar',
			'accessControl'
			// array(
			// 	'class'=>'path.to.FilterClass',
			// 	'propertyName'=>'propertyValue',
			// ),
		);
	}
	public function accessRules()
	{
		return array(

			);
	}

	// public function actions()
	// {
	// 	// return external action classes, e.g.:
	// 	return array(
	// 		'action1'=>'path.to.ActionClass',
	// 		'action2'=>array(
	// 			'class'=>'path.to.AnotherActionClass',
	// 			'propertyName'=>'propertyValue',
	// 		),
	// 	);
	// }
	
}
