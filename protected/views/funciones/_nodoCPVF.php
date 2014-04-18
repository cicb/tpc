<?php 
	echo CHtml::openTag('li',array(
		'id'=>"$prefix-$id", 
		'class'=>'nodo'));
	//LI NODO
	if ($model->tieneHijos) {
	# Si tiene hijos muestra el boton de +
		echo TbHtml::link(' ',array('puntosVenta/verRama','id'=>$id,'prefix'=>$prefix),
			array(
				'class'=>'nodo-toggle fa fa-plus-square',
				'id'=>"link-$prefix-$id", 
				'data-estado'=>'inicial')
			);
	}

		echo TbHtml::label($model->PuntosventaNom,"chk-$prefix-$id",
			array('style'=>'display:inline;width:120px'));

		echo CHtml::openTag('div',
			array('
				class'=>'fechas-cpf text-right',
				'style'=>'width:100%;'
				)); 

			echo TbHtml::textField("CPF_FecIni-$prefix-$id",date('d-m-Y H:i:s'),
				array(
					'placeholder'=>'Fecha de inicio', 
					'class'=>'picker hidden ',
					'style'=>'width:5px'));

			echo TbHtml::link(' ','#',array('class'=>'fa fa-calendar text-info ', 
				'onclick'=>"$('#CPF_FecIni-$prefix-$id').datetimepicker('show');return false;
				"));

			echo TbHtml::textField("CPF_FecFin-$prefix-$id",
				date('d-m-Y H:i:s'),
				array('placeholder'=>'Fecha de inicio', 
					'class'=>'picker hidden ','style'=>'width:5px')) ;

			echo TbHtml::link(' ','#',array('class'=>'fa fa-calendar  text-warning', 
				'onclick'=>"$('#CPF_FecFin-$prefix-$id').datetimepicker('show');return false;
				"));

		echo CHtml::closeTag('div');
	echo CHtml::closeTag('li');

 ?>