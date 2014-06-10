<?php 
/*
 *GENERA EL PRIMER NIVEL DE UN ARBOL DE CARGOS POR SERVICIO (ZONASLEVEL1)
 */
//Obtiene el nodo Raíz
$raiz=Zonaslevel1::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId,
		'ZonasId'=>$model->ZonasId,
		'PuntosventaId'=>Yii::app()->params['pvRaiz']
));
//Obtiene ta taquilla del evento
$pve=Zonaslevel1::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId,
		'ZonasId'=>$model->ZonasId,
		'PuntosventaId'=>$model->evento->PuntosventaId
));

if (is_object($pve)) {
		// Si el nodo raiz esta asignado
		$this->renderPartial('_nodoCargo', array('model'=>$pve));
}	
if (is_object($raiz)) {
	// Si el nodo raiz esta asignado
		$this->renderPartial('_nodoCargo', array('model'=>$raiz));
}	
 ?>
<?php 		echo TbHtml::link(' Reparar árbol de cargo por servicio',
				array('generarArbolCargos'),
				array(
						'class'=>'btn btn-small  fa fa-sitemap btn-generar-arbol',
						'id'=>"btn-generarArbol-".$model->ZonasId,
						'data-zid'=>$model->ZonasId,
				)
		) ;  ?>
