<div class='controles'>
<h2>Referencia / Numero De Boleto</h2>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form-ventaslevel1',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="row">
<b>Buscar</b>
		<?php echo CHtml::textField('buscar',$ref>0?$ref:'',array('placeholder'=>'Referencia o número de boleto')); ?>

	</div>
    <div class="row">
         Rerefencia: <input type="radio" name="tipo" value="referencia" id="RadioGroup1_0" checked="checked" />
         No. de boleto <input type="radio" name="tipo" value="boleto" id="RadioGroup1_1" />
    </div>

	<br />
	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

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

