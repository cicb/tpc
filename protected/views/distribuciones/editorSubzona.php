<?php 
/*
 *EDITOR DE SUBZONA
 */
?>

<div class='controles'>
<h2>Editor de subzona.</h2>
<?php echo TbHtml::dropDownList('SubzonaId',$subzona->SubzonaId,TbHtml::listData($subzona->hermanas,'SubzonaId','nombre'),
array('class'=>'input-medium panel-head')); ?>
<br />
    <?php echo TbHtml::buttonGroup(array(
			array('title'=>'Alinear todo a la izquierda',  'class'=>'fa fa-align-left fa-3x btn btn-large btn-alinear', 
			'url'=>array('alinearSubzona',
			'EventoId'=>$subzona->EventoId,
			'FuncionesId'=>$subzona->FuncionesId,
			'ZonasId'=>$subzona->ZonasId,
			'SubzonaId'=>$subzona->SubzonaId,
			'direccion'=>'izquierda'
	)
),
			array('title'=>'Alinear todo al centro',  'class'=>'fa fa-align-center fa-3x btn btn-large btn-alinear', 
			'url'=>array('alinearSubzona',
			'EventoId'=>$subzona->EventoId,
			'FuncionesId'=>$subzona->FuncionesId,
			'ZonasId'=>$subzona->ZonasId,
			'SubzonaId'=>$subzona->SubzonaId,
			'direccion'=>'centro'
	)
),

	array('title'=>'Alinear todo a la derecha','class'=>'fa fa-align-right fa-3x btn btn-large btn-alinear',
			'url'=>array('alinearSubzona',
			'EventoId'=>$subzona->EventoId,
			'FuncionesId'=>$subzona->FuncionesId,
			'ZonasId'=>$subzona->ZonasId,
			'SubzonaId'=>$subzona->SubzonaId,
			'direccion'=>'derecha'
	)
),
    ), array('vertical' => false)); ?>
<br />
<?php echo TbHtml::link(' Regresar', array('editor',
						'EventoId'=>$subzona->EventoId,
						'FuncionesId'=>$subzona->FuncionesId,
						'scenario'=>'editar',
						'#'=>'zona-'.$subzona->ZonasId,
				),
				array('class'=>'btn fa fa-arrow-left','style'=>'margin:10px')
		) ?>

</div>

<?php 
echo TbHtml::openTag('table',array('width'=>'auto','class'=>'table-bordered centrado box'));
foreach ($subzona->filas as $fila) {
		// Por filas
		//$this->renderPartial('_filaAsiento',array('asientos'=>$fila->asientos));
		echo TbHtml::openTag('tr');
		echo TbHtml::tag('th',array(),$fila->FilasAli);	
		foreach ($fila->lugares as $asiento) {
				//Por cada Asiento
				$clase="";
				if ($asiento->LugaresStatus=='OFF') {
						$clase.=" off hidden";
				}
				$control=TbHtml::textField('asiento',$asiento->LugaresNum, array(
						'class'=>'input-mini asiento'.$clase,
						'data-fid'=>$asiento->FilasId,
						'data-id'=>$asiento->LugaresId,
				));
				echo TbHtml::tag('td',array('class'=>' '),$control);	

		}

		echo TbHtml::tag('td',array(),
				TbHtml::buttonGroup(
						array( 
								array(
										'data-id'=>$fila->FilasId,
										'title'=>'Alinear todo a la izquierda',  
										'class'=>'fa fa-angle-double-left btn btn-info btn-alinear', 
										'url'=>array('alinearFila',
										'EventoId'=>$subzona->EventoId,
										'FuncionesId'=>$subzona->FuncionesId,
										'ZonasId'=>$subzona->ZonasId,
										'SubzonaId'=>$subzona->SubzonaId,
										'FilasId'=>$fila->FilasId,   
										'direccion'=>'izquierda')
								),
								array(
										'data-id'=>$fila->FilasId,
										'title'=>'Recorrer a la izquierda',  
										'class'=>'fa fa-angle-left btn btn-info btn-alinear', 
										'url'=>array('moverFila',
										'EventoId'=>$subzona->EventoId,
										'FuncionesId'=>$subzona->FuncionesId,
										'ZonasId'=>$subzona->ZonasId,
										'SubzonaId'=>$subzona->SubzonaId,
										'FilasId'=>$fila->FilasId,   
										'direccion'=>'izquierda')
								),
								array(
										'data-id'=>$fila->FilasId,
										'title'=>'Alinear todo al centro',  
										'class'=>'fa fa-angle-double-up btn-alinear btn btn-info', 
										'url'=>array('alinearFila',
										'EventoId'=>$subzona->EventoId,
										'FuncionesId'=>$subzona->FuncionesId,
										'ZonasId'=>$subzona->ZonasId,
										'SubzonaId'=>$subzona->SubzonaId,
										'FilasId'=>$fila->FilasId,
										'direccion'=>'centro')
								),
								array(
										'data-id'=>$fila->FilasId,
										'title'=>'Recorrer a la derecha', 
									   	'class'=>'fa fa-angle-right  btn-alinear btn btn-info', 
										'url'=>array('moverFila',
										'EventoId'=>$subzona->EventoId,
										'FuncionesId'=>$subzona->FuncionesId,
										'ZonasId'=>$subzona->ZonasId,
										'SubzonaId'=>$subzona->SubzonaId,
										'FilasId'=>$fila->FilasId,
										'direccion'=>'derecha')
								),
								array(
										'data-id'=>$fila->FilasId,
										'title'=>'Alinear todo a la derecha', 
									   	'class'=>'fa fa-angle-double-right  btn-alinear btn btn-info', 
										'url'=>array('alinearFila',
										'EventoId'=>$subzona->EventoId,
										'FuncionesId'=>$subzona->FuncionesId,
										'ZonasId'=>$subzona->ZonasId,
										'SubzonaId'=>$subzona->SubzonaId,
										'FilasId'=>$fila->FilasId,
										'direccion'=>'derecha')
								),
						))
		);	

		echo TbHtml::tag('td',array(),TbHtml::button('',array(
				'onclick'=>'activarOff('.$fila->FilasId.')',
				'class'=>'btn fa fa-adjust',
	   	)));	
		echo TbHtml::closeTag('tr');

}
echo TbHtml::closeTag('table');
?>

<br />
<style type="text/css" media="screen">
	table{background:#eeD}	
	th,td{margin:5px;padding:5px !important;}
	.input-mini{width:25px;text-align:center}	
.off{color:#C00}
</style>
<script type="text/javascript" charset="utf-8">
function activarOff(fila){
		//Esta funcion activa lo asientos off para su registro como  asientos true
				$('.off[data-fid='+fila+']').toggleClass('hidden','');
}
</script>
<?php 
$lugarJson=CJSON::encode($subzona->getPrimaryKey());
Yii::app()->clientScript->registerScript('efecto',"
$('.asiento').on('change',function(){
		var fila=$(this).data('fid');
		var id=$(this).data('id');
		var valor=$(this).val();
		var obj =$(this);
		if (isNaN(valor)) {
				// En caso de escribir un caracter no valido...
				$(this).addClass('text-danger');
				}else{

						$(this).removeClass('text-danger');
						//var lugar=JSON.parse('$lugarJson');
						var lugar=JSON.parse('$lugarJson');		
						lugar['FilasId']=fila;
						lugar['LugaresId']=id;
						lugar['LugaresNum']=valor;
						console.log(JSON.stringify(lugar));
						$.ajax({
								url:'".$this->createUrl('cambiarLugar')."',
										data:{Lugares:lugar},		
										type:'post',
										success:function(){
												if (valor=='') {
														// Si se ha eliminado su contenido
														$(this).addClass('off');
														$('.off[data-fid='+fila+']').removeClass('hidden');
												}else{
														obj.removeClass('off');
														$('.off[data-fid='+fila+']').addClass('hidden');
												}	
								}
						});	
				}	
});
$('.btn-alinear').on('click',function(){
		var href=$(this).attr('href');
		$.ajax({
				url:href,
				success:function(resp){location.reload(); } ,	
		}).fail(function(){alert('Error, no se ha podido completar la alineación general')});
return false;
});
$('#SubzonaId').on('change',function(){
		var url=document.location.href;
		window.location=url.replace(/SubzonaId=\d+/g,'SubzonaId='+$(this).val());
});


"); ?>
