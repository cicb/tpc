<div class='row-fluid'>
<table border="0" class="table table-hover" id="tabla-filas">
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

<?php 
echo TbHtml::link(' Agregar fila',
		array('agregarFila','EventoId'=>$model->EventoId,'FuncionesId'=>$model->FuncionesId,'ZonasId'=>$model->ZonasId),
		array(
				'id'=>'btn-agregar-fila',
				'class'=>'btn btn-success fa fa-plus pull-left'));
?>
<?php 
echo TbHtml::link(' Generar asientos',
		array('generarNumerados','EventoId'=>$model->EventoId,'FuncionesId'=>$model->FuncionesId,'ZonasId'=>$model->ZonasId),
		array(
				'id'=>'btn-generar-numerados',
				'class'=>'btn btn-primary fa fa-circle-o-notch'));
?>

		<div class='pull-right'>
<?php echo TbHtml::textField('ZonasCanLug',$model->ZonasCanLug,array(
		'class'=>'input-small text-center  ZonasCanLug',		
		'prepend'=>'Asientos requeridos:',
		'readonly'=>true,
		'data-id'=>$model->ZonasId,
)); ?>
<br />
<?php echo TbHtml::numberField('FilasZonasCanLug',$model->ZonasCanLug,array(
		'class'=>'input-small text-center  ZonasCanLug',		
		'prepend'=>'Asientos para generar:',
		'readonly'=>true,
		'data-id'=>$model->ZonasId,
)); ?>
		</div>
</div>
