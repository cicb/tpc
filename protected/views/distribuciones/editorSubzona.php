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
<div id='area-subzona'>
		<?php $this->renderPartial('_subzona',compact('subzona')); ?>
</div>
<br />
<style type="text/css" media="screen">
	table{background:#eeD}	
	th,td{margin:5px;padding:5px !important;}
	.input-mini{width:25px;text-align:center}	
	.input-warning{color:#FFF !important;background:#E74C3C !important;}	
.off{color:#C00 !important}
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
$('.asiento').live('change',function(){
		var fila=$(this).data('fid');
		var id=$(this).data('id');
		var valor=$(this).val();
		var obj =$(this);
		if (isNaN(valor)) {
				// En caso de escribir un caracter no valido...
				$(this).addClass('text-danger');
				}else{
						$(this).removeClass('text-danger');
						var lugar=JSON.parse('$lugarJson');		
						lugar['FilasId']=fila;
						lugar['LugaresId']=id;
						lugar['LugaresNum']=valor;
						$.ajax({
								url:'".$this->createUrl('cambiarLugar')."',
										data:{Lugares:lugar},		
										type:'post',
										success:function(){
												var nlugares=$('#FilasCanLug-'+fila).val();
												var nlorigen=$('#FilasCanLug-'+fila).data('lugares');
												if (valor=='') {
														// Si se ha eliminado su contenido
														obj.addClass('off');
														$('.off[data-fid='+fila+']').removeClass('hidden');
														nlugares=nlugares-1;
												}else{
														obj.removeClass('off');
														$('.off[data-fid='+fila+']').addClass('hidden');
														nlugares=parseInt(nlugares)+1;

												}	
												$('#FilasCanLug-'+fila).val(nlugares);
												if(nlugares!=nlorigen){
														$('#FilasCanLug-'+fila).addClass('input-warning');
												}
												else {
														$('#FilasCanLug-'+fila).removeClass('input-warning');
												}
								}
						});	
				}	
});
$('.btn-alinear').live('click',function(){
		var href=$(this).attr('href');
		$.ajax({
				url:href,
				success:function(resp){ $('#area-subzona').load(window.location.href+'&modo=simple'); } ,	
		}).fail(function(){alert('Error, no se ha podido completar la alineación general')});
return false;
});
$('#SubzonaId').live('change',function(){
		var url=document.location.href;
		window.location=url.replace(/SubzonaId=\d+/g,'SubzonaId='+$(this).val());
});


"); ?>
