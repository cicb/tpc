<div class='controles'>
<h2>Buscar Boleto Y Referencias</h2>
<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form-ventaslevel1',
	'enableClientValidation'=>true,
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'method' =>'get',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,

	),
)); ?>
<div class='col-2'>
		<?php echo TbHtml::textFieldControlGroup('buscar',$ref>0?$ref:'',
				array(
						'append' => TbHtml::submitButton('Buscar',array('class'=>'btn btn-primary')), 
						'span' => 4,
						'placeholder'=>'Referencia o número de boleto',
						'label'=>'Ingrese la referencia o el número de boleto:',
						'id'=>'filtro',
						'style'=>'font-weight:800;text-transform:uppercase;letter-spacing:2px',
						'autofocus'=>"autofocus",
				)); ?>	
    <div class="row">
         Rerefencia: <input type="radio" name="tipo" value="referencia" id="RadioGroup1_0" checked="checked" />
         No. de boleto <input type="radio" name="tipo" value="boleto" id="RadioGroup1_1" />
    </div>

<?php $this->endWidget(); ?>
</div>

</div><!-- form -->
</div><!-- Controles -->


<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('evento-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php 				
if (isset($ref) and !is_null($ref)) {
		$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'evento-grid',
		'dataProvider'=>$model->getVentasPorRef($ref,$tipo),
        'summaryText'=>'',
		'type'=>array('condensed'),
        'emptyText'=>'No se encontraron resultados',
		'columns'=>array(
				array(
						'header'=>'Evento',
						'value'=> '$data->evento->EventoNom'
				),
				array(
						'header'=>'Funcion',
						'value'=> '$data->funcion->FuncionesFecHor'
				),
				array(
						'header'=>'Zona',
						'value'=> '$data->zona->ZonasAli'
				),
				array(
						'header'=>'FilasAli',
						'value'=> '$data->fila->FilasAli'
				),
				array(
						'header'=>'Estatus de venta',
						'value'=> '$data->venta->VentasSta'
				),
				
				array(
						'header'=>'Tipo de Bol.',
						'value'=> '$data->VentasBolTip'
				),
				array(
						'header'=>'Numero de Referencia',
						'value'=> '$data->venta->VentasNumRef'
				),
				array(
						'header'=>'Numero de Boleto.',
						'value'=> '$data->LugaresNumBol'
				),
				array(
						'header'=>'Último acceso',
						'value'=> '@$data->acceso->AccesoFecha'
				),
				//array(
						//'header'=>'Reimpresión',
						//'value'=> 'var_export($data->reimpresion)'
				//),
				//'FuncionesFecHor',
				//'ZonasAli',
				//'FilasAli',
				//'Asiento',
				//'VentasSta',
				//'VentasBolTip',
				//'VentasNumRef',
				//'NumBol',
				//'UltimoAcceso',
				//'IdTerminal'
		),
		));
}else
	echo $ref;	
?>

