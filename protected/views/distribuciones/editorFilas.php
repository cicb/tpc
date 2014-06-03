<?php 
$EventoId=$model->EventoId;
$FuncionesId=$model->FuncionesId;
?>

<div class='controles'>
<legend>Configuración de la distribución de asientos</legend>
		<div class=''>
<?php echo TbHtml::textField('Requeridos',$model->ZonasCanLug,array(
		'class'=>'input-small text-center  Requeridos',		
		'prepend'=>'Asientos requeridos:',
		'readonly'=>true,
		'data-id'=>$model->ZonasId,
)); ?>
<br />
<?php echo TbHtml::numberField('FilasZonasCanLug',$model->ZonasCanLug,array(
		'class'=>'input-small text-center  FilasZonasCanLug',		
		'prepend'=>'Asientos listos para generar:',
		'readonly'=>true,
		'data-id'=>$model->ZonasId,
		'id'=>'FilasZonasCanLug',
)); ?>
		</div>
<?php echo TbHtml::link(' Regresar', array('editor',
						'EventoId'=>$model->EventoId,
						'FuncionesId'=>$model->FuncionesId,
						'scenario'=>'editar',
						'#'=>'zona-'.$model->ZonasId,
				),
				array('class'=>'btn fa fa-arrow-left','style'=>'margin:10px')
		) ?>
<?php 
echo TbHtml::buttonGroup(array(
		array(
				'id' => 'btn-agregar-fila',
				'label' => ' Agregar fila',
				'class'=>'fa fa-plus btn btn-success',
				'url'=> array('agregarFila','EventoId'=>$model->EventoId,'FuncionesId'=>$model->FuncionesId,'ZonasId'=>$model->ZonasId),
				'title'=>'Agregar una Fila'),
		array('label' => ' Generar asientos','class'=>'fa fa-delicious btn-primary',	
		'id'=>'btn-generar-numerados',
		'url'=> array('generarNumerados','EventoId'=>$model->EventoId,'FuncionesId'=>$model->FuncionesId,'ZonasId'=>$model->ZonasId),
		'title'=>'Generar todos los Asientos'),
)); 

?>
<br />
<br />
</div>
<div class='row-fluid '>
<table border="0" class="table items table-bordered table-hover" id="tabla-filas">
	<tr>
		<th>#</th>
		<th></th>
		<th>No. Fila</th>
		<?php for ($i=0;$i<($model->ZonasCantSubZon);$i++) {
				echo TbHtml::tag('th',array('colspan'=>2),"Subzona ".($i+1));
				echo TbHtml::tag('th',array(),"Ctd.");
		} ?>
		<th>Total</th>
	</tr>
<?php 

				for ($i=1;$i<=($model->nfilas);$i++) {
						$this->actionVerFila($model->EventoId,$model->FuncionesId,$model->ZonasId,$i);
				}
?>

</table>


</div>

<?php Yii::app()->clientScript->registerScript('acciones',"

function sumatoria(){
				var sum=0;
				$('.FilasCanLug').each(function(){
						var fid=$(this).data('fid');
						var sid=$(this).data('sid');
						$(this).val(
								Math.abs( $('#LugaresIni-'+sid+'-'+fid).val()-$('#LugaresFin-'+sid+'-'+fid).val())+1
						);
						sum+=parseInt($(this).val())||0;
				});
				$('.Subtotal').each(function(){
						var sub=0;
						var fid=$(this).data('fid');
						$('.FilasCanLug[data-fid='+fid+']').each(function(){
								sub+=parseInt($(this).val())||0;
						});
						$(this).val(sub);
				});

				$('#FilasZonasCanLug').val(sum);
				if(sum!=$('#Requeridos').val()){
						$('#FilasZonasCanLug').css('color','#C00'); }
				else{ $('#FilasZonasCanLug').css('color','black'); }
		}
function cambiarValoresFilas(control){
		var key=control.attr('name');
		var value=control.val();
		var data={Filas:{ EventoId:$EventoId, FuncionesId:$FuncionesId, 
				ZonasId:control.data('zid'), SubzonaId:control.data('sid'),
				FilasId:control.data('fid'),
		}};
		data['Filas'][key]=value;
		$.ajax({
				url: '".$this->createUrl('AsignarValorFila')."',
				type:'POST',
				data:data,
		});
}
		$('#btn-agregar-fila').on('click',function(){
				var obj=$(this);
				$.ajax({
						url:obj.attr('href'),	
						success:function(resp){
									$('#tabla-filas tr:last').after(resp)
						},
				});
				return false;
		});

		$('.limite').live('change',function(){
				if ($(this).val()<=0 || isNaN($(this).val())) {
					$(this).css('color','red');
				}	
				else{
						$(this).css('color','black');

						cambiarValoresFilas($(this));
						var fid=$(this).data('fid');
						var sid=$(this).data('sid');
						$('#FilasCanLug-'+sid+'-'+fid).val(
								Math.abs(
										$('#LugaresIni-'+sid+'-'+fid).val()-$('#LugaresFin-'+sid+'-'+fid).val())+1);

						sumatoria();		
				}
				});

$('.vivo').live('focusout',function(){
		cambiarValoresFilas($(this));
});


$('#btn-generar-numerados').live('click',function(){
		var obj=$(this);
		$.ajax({
				url:obj.attr('href'),
				success:function(resp){ console.log(resp); },
		});
return false;
});
$('.btn-eliminar-fila').live('click',function(){ 
		var obj=$(this);
		var fid=obj.data('fid');
		$.ajax({
				url:obj.attr('href'),
						type:'post',
						success:function(resp){ 
								if(resp=='true'){ $('#fila-'+fid).remove();return false;}
								else {
										alert('No se puede eliminar esta fila.Verifique que el Evento no tenga ventas');}},
						beforeSend:function(){
													   	return confirm('¿Esta seguro de que desea eliminar esta Fila?\\nEsta operación es irreversible.');						}						

		});
return false;
});

/*///////////////////////////////////////////////////////////*/

sumatoria();

"); ?>
