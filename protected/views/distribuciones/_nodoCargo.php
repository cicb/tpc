<?php 

$status=$model->ZonasBanVen;
$zid=$model->ZonasId;
$fid=$model->FuncionesId;
$eid=$model->EventoId;
$pid=$model->PuntosventaId;
$padre=$model->puntoventa->tipoid==0;
$nombre=$model->puntoventa->PuntosventaNom;

	echo CHtml::openTag('li',array(
		'id'=>"$fid-$pid", 
		'class'=>'nodo ', 'style'=>'border-top:1px dashed #888;',
		));
	//LI NODO
	if (isset($padre) and $padre) {
	# Si tiene hijos muestra el boton de +
		echo TbHtml::link(' ',array('distribucion/verRamaCargo','EventoId'=>$eid,
			'FuncionesId'=>$fid,'ZonasId'=>$zid,'PuntosventaId'=> $pid),
			array(
				'class'=>'nodo-toggle fa fa-plus-square',
				'id'=>"link-$zid-".$pid, 
				'data-estado'=>'inicial',
				'style'=>'margin:5px',
				)
			);
	}
		//echo TbHtml::checkBox("chk-$fid-$pid",$status,array('class' =>'CPVFSta', 'data-fid'=>$fid,'data-pid'=>$pid));
		echo TbHtml::label($nombre,"chk-$zid-$pid",
			array('style'=>'display:inline;width:100%'));

		echo CHtml::openTag('div',
			array('
				class'=>'fechas-cpf text-right',
				'style'=>'width:100%;'
				)); 

		echo TbHtml::numberField('ZonasFacCarSer',$model->ZonasFacCarSer,array(
				'class'=>'input-small text-center ZonasCosBol','data-zid'=>$zid,'data-pid'=>$pid, 'prepend'=>'$'));

		echo CHtml::closeTag('div');
	echo CHtml::closeTag('li');

 ?>
