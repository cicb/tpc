<?php

class FuncionesController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	
	}

	public function actionCargarFunciones()
	{
			$data =Yii::app()->user->modelo->getFuncionesAsignadas($_POST['evento_id']);
			$lista = CHtml::listData($data,'FuncionesId','funcionesTexto');
			echo CHtml::tag('option',array('value' => 'TODAS'),'Todas',true);
			foreach($lista as $id => $value)
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
