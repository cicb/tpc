<?php 

$status=$model->ZonasBanVen;
$zid=$model->ZonasId;
$fid=$model->FuncionesId;
$eid=$model->EventoId;
$pid=$model->PuntosventaId;
$padre=$model->puntoventa->tipoid==0;
$nombre=$model->puntoventa->PuntosventaNom;

	echo CHtml::openTag('li',array(
		'id'=>"nodo-$zid-$pid", 
		'class'=>'nodo ', 'style'=>'border-top:1px dashed #888;',
		));
	//LI NODO
	$mas="";	
	if (isset($padre) and $padre) {
	# Si tiene hijos muestra el boton de +
		$mas= TbHtml::link(' ',array('distribuciones/verRamaCargo','EventoId'=>$eid,
			'FuncionesId'=>$fid,'ZonasId'=>$zid,'PuntosventaId'=> $pid),
			//array(
				//'update'=>"#hijos-$zid-$pid"
			//),	
			array(
				'class'=>'nodo-toggle fa fa-plus-square',
				'id'=>"link-$zid-".$pid, 
				'data-uid'=>"$zid-$pid",
				'data-estado'=>'inicial',
				'style'=>'margin:5px',
				)
			);
	}


		echo CHtml::openTag('div',
			array('
				class'=>'text-left',
				'style'=>'width:100%;'
				)); 
		echo TbHtml::numberField('ZonasFacCarSer',$model->ZonasFacCarSer,array(
				'class'=>'input-small text-center ZonasCosBol','data-zid'=>$zid,'data-pid'=>$pid, 'prepend'=>$mas,'append'=>$nombre.' '));
		echo CHtml::closeTag('div');
		echo TbHtml::tag('div',array('id'=>"hijos-$zid-$pid",''));	
	echo CHtml::closeTag('li');

 ?>
