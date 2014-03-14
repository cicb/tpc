<?php

class ZonasController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCargarZonas()
	{
        $data = Zonas::model()->findAll('EventoId=:parent_id AND FuncionesId=:parent_funcion_id',
        array(':parent_id'=>(int) $_POST['evento_id'],':parent_funcion_id'=>(int) $_POST['funcion_id']));

         $data = CHtml::listData($data,'ZonasId','ZonasAli');
         echo CHtml::tag('option',array('value' => ''),'Seleccione ...',true);
         foreach($data as $id => $value)
         {
             echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
         }   
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
