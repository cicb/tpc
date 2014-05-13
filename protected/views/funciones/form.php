<div class="controles">
	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	)); ?>

	<h1>Agregar Funciones</h1>

</div>

<div class="row white-box">
	<div class="input-append white-box">
		<label>Selecciona Fecha Final del Evento</label>
		<?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
							'name' => 'Funciones[FuncionesFecHor]',
							'value'=>$model->FuncionesFecHor,
							'pluginOptions' => array(
							'lenguage'=>'es-MX',
							'format' => 'yyyy-MM-dd hh:mm:ss'
							),
							));
		?>
	
	</div>
	<div class="input-append white-box">
		<input >
	</div>
</div>
	<input type="hidden" name="Funciones[eid]" value="<?php echo $_GET['eid']; ?>">

	<?php /* echo $form->textFieldControlGroup($model, 'FuncionesTip',
    array('help' => 'In addition to freeform text, any HTML5 text-based input appears like so.')); */?>

<div class="btn-group">
	<?php echo  TbHtml::submitButton('Guardar') ?>
</div>


<?php $this->endWidget(); //Fin de formulacio ?>
<script type="text/javascript">
	$("#yw1").change(function(){
		console.log($(this).val());
	});
</script>
