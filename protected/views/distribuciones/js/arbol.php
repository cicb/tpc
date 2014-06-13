<?php 
Yii::app()->clientScript->registerScript('arbol',
 "
$( '.nodo-toggle').live('click',function(){
		var uid= $(this).data('uid');
		var link= $(this);
		if (link.data('estado')=='inicial') {
				var href= link.attr('href');
				$.ajax({
						url:href,
								success:function(data){ 
										$('#hijos-'+uid).append(data);
										link.data('estado','toggle')
												link.toggleClass('fa-minus-square');
								}
				});
		}
		else if (link.data('estado')=='toggle'){
				link.toggleClass('fa-minus-square');
				$('#rama-'+uid).toggle();
		}
		return false;
})
		$('.btn-generar-arbol').live('click',function(){
				var obj=$(this);
				var zid=obj.data('zid');
				var dir=obj.attr('href');
				$.ajax({
						url:dir,
								type:'POST',
								data:{Zonas:{EventoId:$EventoId,FuncionesId:$FuncionesId,ZonasId:zid}},
								success:function(resp){ $('#arbol-'+zid).html(resp); },
								beforeSend:function(){ $('#arbol-'+zid).html('<i class=\'fa fa-spinner fa-spin\'></i> '); }
				});
				return false;
		});
						/*Esta funcion solo actualiza los valores de los nodos inferiores de manera visual*/		
						$('.ZonasFacCarSer').live('keyup',function(){
								var zid=$(this).data('zid');		
								var pid=$(this).data('pid');		
								var valor=$(this).val();
								$('#nodo-'+zid+'-'+pid+' input').val(valor);
						});

						$('.ZonasFacCarSer').live('focusout',function(){
								if (Math.round((new Date()).getTime() / 1000)-start>1) {
										// Si la estampa de tiempo es mayor a 1 segundos
										start=Math.round((new Date()).getTime() / 1000);
										var zid=$(this).data('zid');		
										var pid=$(this).data('pid');		
										var valor=$(this).val();
										$.ajax({
												url:'".CController::createUrl('/Distribuciones/cambiarCargo',compact('EventoId','FuncionesId'))."',
														data: {ZonasId:zid,PuntosventaId:pid,valor:valor},
														type:'GET',
														success: function(){ $('#nodo-'+zid+'-'+pid+' input').val(valor); }
										});		
								}	
						});
");
?>
