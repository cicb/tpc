<?php

class ReportesController extends Controller
{
	public function actionCortesDiarios()
	{
		$this->render('cortesDiarios');
	}

	public function actionDesgloseVentas()
	{
		$this->render('desgloseVentas');
	}

	public function actionIndex()
	{
		$this->layout="reportes";	
		$this->render('index');
	}

	public function actionLugares()
	{
			$this->layout="reportes";
			$this->render('lugares');
	}

	public function actionLugaresVendidos()
	{

			$this->layout="reportes";
			$this->render('lugaresVendidos');
	}

	public function actionReservacionesFarmatodo()
	{
			$this->layout="reportes";
 
		$this->render('reservacionesFarmatodo');
	}

	public function actionVentasConCargo()
	{
			$this->layout="reportes";
 
		$this->render('ventasConCargo');
	}

	public function actionVentasDiarias()
	{
			$this->layout="reportes";
		$this->render('ventasDiarias');
	}

	public function actionVentasFarmatodo()
	{
			$this->layout="reportes";
		$this->render('ventasFarmatodo');
	}

	public function actionVentasSinCargo()
	{
			$this->layout="reportes";
		$this->render('ventasSinCargo');
	}

	public function actionVentasWeb()
	{
			$this->layout="reportes";
 
		$this->render('ventasWeb');
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
