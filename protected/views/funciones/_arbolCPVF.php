<?php echo CHtml::tag('div',array('id'=>'arbol-'.$model->FuncionesId)); ?>
	<?php 
		#Impresion de arbol en primer nivel
	// $root=1000;//Id del nodo raiz
	$root=Confipvfuncion::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId, 
		'PuntosventaId'=> Yii::app()->params['pvRaiz'],//Id del punto de venta  raiz
		));
	$taquilla=Confipvfuncion::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId, 
		'PuntosventaId'=> $model->evento->PuntosventaId, //Id de la taquilla del evento
		));
		echo CHtml::openTag('ul',array('id'=>"rama-".$model->FuncionesId, 'class'=>"arbol text-left"));
				/****
				***Caso especial Taquilla propia
				*/
				if (is_object($taquilla)) {
					# Si es valido el id de taquilla del evento
					$this->renderPartial('/funciones/_nodoCPVF',array('model'=>$taquilla));
				}
/*			
		Caso Modulos
*/
			if (is_object($root)) {
				# Si el id de la raiz es correcto
				$this->renderPartial('/funciones/_nodoCPVF',array('model'=>$root));
			}
			else
					echo CHtml::link(' Generar árbol',array('Funciones/generarArbolCPVF'),array(
							'data-fid'=>$model->FuncionesId,
							'class'=>'btn btn-generar-arbol fa fa-sitemap '));	
		echo CHtml::closeTag('ul');
echo CHtml::closeTag('div');

	 ?>
