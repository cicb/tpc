<?php

class PuntosVentaController extends Controller
{

	public function actionCargarPuntosventa()
	{
		if (isset($_POST['usuario_id'])) {
			$usuario=$_POST['usuario_id'];
			$data = Puntosventa::model()->with(array(
				'ventas'=>array(
				'condition'=>"PuntosventaSta like '%ALTA%' and ventas.UsuariosId=:usuario",
				'order'=>'PuntosventaNom',
					'params'=>array(
						'usuario'=>$usuario))))->findAll();
		}
		else{
			$data = Puntosventa::model()->findAll(array(
				'condition'=>"PuntosventaSta like '%ALTA%'",
				'order'=>'PuntosventaNom',
				));			
		}
			$list = CHtml::listData($data,'PuntosventaId','PuntosventaNom');
			echo CHtml::tag('option',array('value' => ''),'Seleccione un punto de venta...',true);
			foreach($list as $id => $value)
			{
					echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
			}
	}

	public function actionVerRama($pid=0,$fid='')
	{
		#Visualiza el arbol de puntos de venta de acuerdo a su jerarquia
		$rama=Puntosventa::getHijos($pid);
		if (sizeof($rama)>0) {
			# Si tiene hijos
			echo CHtml::openTag('ul',array('class'=>'rama-pvs', 'id'=>"rama-$fid-$pid"));	
			foreach ($rama as $model) {
				// echo $model->getAsNode('li',$fid);
				$pid=$model->PuntosventaId;
				$nombre=$model->PuntosventaNom;
				$padre=$model->tieneHijos;
				$this->renderPartial('/funciones/_nodoCPVF',compact('fid','pid','nombre','padre'));
			}
			echo CHtml::closeTag('ul');	
		}
		else
			echo "";
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