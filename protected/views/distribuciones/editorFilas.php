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
		array('label' => ' Agregar fila','class'=>'fa fa-plus btn btn-success',
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
		$('#btn-agregar-fila').live('click',function(){
				var obj=$(this);
				$.ajax({
						url:obj.attr('href'),	
						success:function(resp){
								$('#tabla-filas tr:last').after(resp)
								return false;
						},
				});
		return false;
		});

		function calcularTotal(fid){
				var sum=0;
				var total=0;
				$('.FilasCanLug[data-fid='+fid+']').each(function(){sum+=parseInt($(this).val())||0;});
				$('.Subtotal').each(function(){total+=parseInt($(this).val())||0;});
				$('#Subtotal-'+fid).val(sum);
				sumatoria();
		}
		$('.limite').live('change',function(){
				var fid=$(this).data('fid');
				var sid=$(this).data('sid');
				$('#FilasCanLug-'+sid+'-'+fid).val(
						Math.abs(
								$('#LugaresIni-'+sid+'-'+fid).val()-$(this).val())+1);

				calcularTotal(fid);		
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

"); ?>
