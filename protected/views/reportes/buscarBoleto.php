<div class='controles'>
<h2>Buscar Boleto Y Referencias</h2>
<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form-ventaslevel1',
	'enableClientValidation'=>true,
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,

	),
)); ?>
<div class='col-4'>
		<?php echo TbHtml::textFieldControlGroup('buscar',$ref>0?$ref:'',
				array(
						'append' => TbHtml::submitButton('Buscar',array('class'=>'btn btn-primary')), 
						'span' => 3,
						'placeholder'=>'Referencia o número de boleto',
						'label'=>'Ingrese la referencia o el número de boleto:',
						'id'=>'filtro',
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
				'EventoNom',
				'FuncionesFecHor',
				'ZonasAli',
				'FilasAli',
				'Asiento',
				'VentasSta',
				'VentasBolTip',
				'VentasNumRef',
				'NumBol',
				'UltimoAcceso',
				'IdTerminal'
		),
		));
}else
	echo $ref;	
?>

