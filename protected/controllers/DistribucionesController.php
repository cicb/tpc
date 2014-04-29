<?php

class DistribucionesController extends Controller
{
	public function actionAsignar()
	{
		$this->render('asignar');
	}

	public function actionGuardar()
	{
		$this->render('guardar');
	}


	public function actionNueva()
	{
		$this->render('nueva');
	}

	public function actionIndex()
	{
		#Despliega una lista de distribuciones actuales
		$model=new Forolevel1('search');
		if (isset($_GET['Forolevel1'])) {
			# code...
			$model->attributes=$_GET['Forolevel1'];
		}
		$this->render('listaDistribuciones',compact('model'));
	}


	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
