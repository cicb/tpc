<?php 

$status=$model->ConfiPVFuncionSta;
$fid=$model->FuncionesId;
$eid=$model->EventoId;
$pid=$model->PuntosventaId;
$padre=true;
$nombre=$model->puntoventa->PuntosventaNom;

	echo CHtml::openTag('li',array(
		'id'=>"$fid-$pid", 
		'class'=>'nodo ', 'style'=>'border-top:1px dashed #888;',
		));
	//LI NODO
	if (isset($padre) and $padre) {
	# Si tiene hijos muestra el boton de +
		echo TbHtml::link(' ',array('funciones/verRama','EventoId'=>$eid,
			'FuncionesId'=>$fid,'PuntosventaId'=> $pid),
			array(
				'class'=>'nodo-toggle fa fa-plus-square',
				'id'=>"link-$fid-".$pid, 
				'data-estado'=>'inicial',
				'style'=>'margin:5px',
				)
			);
	}
		echo TbHtml::checkBox("chk-$fid-$pid",$status,array('class' =>'CPVFSta', 'data-fid'=>$fid,'data-pid'=>$pid));
		echo TbHtml::label($nombre,"chk-$fid-$pid",
			array('style'=>'display:inline;width:100%'));

		echo CHtml::openTag('div',
			array('
				class'=>'fechas-cpf text-right',
				'style'=>'width:100%;'
				)); 

			echo TbHtml::textField("CPF_FecIni-$fid-$pid",date('d-m-Y H:i:s'),
				array(
					'data-fid'=>$fid,'data-pid'=>$pid,
					'class'=>'picker box1 hidden CPVFFecIni',
					'style'=>'font-size:10px;width:5px'));

			echo TbHtml::link(' ','#',array('class'=>'fa fa-calendar text-info ', 
				'title'=>'Fecha de inicio', 
				'onclick'=>"$('#CPF_FecIni-$fid-$pid').datetimepicker('show');return false;
				"));
			echo " / ";
			echo TbHtml::textField("CPF_FecFin-$fid-$pid",
				date('d-m-Y H:i:s'),
				array(
					'data-fid'=>$fid,'data-pid'=>$pid,
					'class'=>'picker box1 hidden CPVFFecFin',
					'style'=>'font-size:10px;width:5px')) ;

			echo TbHtml::link(' ','#',array('class'=>'fa fa-calendar  text-warning', 
				'title'=>'Fecha Fin', 
				'onclick'=>"$('#CPF_FecFin-$fid-$pid').datetimepicker('show');return false;
				"));

		echo CHtml::closeTag('div');
	echo CHtml::closeTag('li');

 ?>