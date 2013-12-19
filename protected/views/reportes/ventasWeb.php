<div class='controles'>
<h2>Reportes de ventas web</h2>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form-ventaslevel1',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<?php 
$models = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order' => 'EventoNom'));
$list = CHtml::listData($models, 'EventoId', 'EventoNom');
// print_r($dataProvider->getData());
?>
	<div class="row">
<?php
echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
$modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
$list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
echo CHtml::dropDownList('evento_id','<?php @echo $_POST["evento_id"]; ?>',$list,
		array(
				'ajax' => array(
						'type' => 'POST',
						'url' => CController::createUrl('funciones/cargarFunciones'),
						'beforeSend' => 'function() { $("#cargador").addClass("loading");}',
						'complete'   => 'function() { $("#cargador").removeClass("loading");}',
						'update' => '#Ventaslevel1_funcion',
				)
		));
?>
	</div>

	<div class="row">
<?php
echo CHtml::label('Funcion','Ventaslevel1_funcion', array('style'=>'width:70px; display:inline-table;'));
echo CHtml::dropDownList('Ventaslevel1[funcion]','',array());
?>
	</div>
	<div class='row'>
    <?php echo CHtml::hiddenField('grid_mode', 'view'); ?>                                                                      
    <?php echo CHtml::hiddenField('funcion_id', '<?php @echo $_POST["Ventaslevel1"]["funcion"]; ?>'); ?>                                                                      
    <?php echo $form->error($model,'evento_id'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary','onclick'=>'$("#grid_mode").val("show");')); ?>
		<?php echo CHtml::submitButton('Exportar',array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ;
		 ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

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


<?php /*
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evento-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
        'fnc',
		'PuntosventaNom',
		'VentasFecHor',
		'ZonasAli',
		'FilasAli',
		'LugaresLug',
		'VentasCon',
		'VentasNumRef',
		'ClientesEma',
        array(
            'name'=>'id',
            'value'=>'
                !empty($data["VentasCon"])?is_numeric(substr($data["VentasCon"] ,strlen($data["VentasCon"])-2))+1?:substr($data["VentasCon"] ,strlen($data["VentasCon"])-1)+1:"" 
                
            '
        )
	),
)); */?>



</div>

<?php
if(isset($eventoId,$funcionesId) and $eventoId>0):
$this->widget('application.extensions.EExcelView', array(
 'dataProvider'=> $model->getInternet($eventoId,$funcionesId,101),
 'grid_mode'=>$grid_mode,
 'htmlOptions'=>array('class'=>'principal'),
 'type'=>'condensed',

 'columns'=>array(    
     array(            
         'header'=>'Fecha',
         'value'=>'$data["VentasFecHor"]',
         ),
     array(            
         'header'=>'Email',
         'value'=>'$data["email"]',
         ),
     array(            
         'header'=>'Funcion',
         'value'=>'$data["funcionesTexto"]',
         ),
     array(            
         'header'=>'Zona',
         'value'=>'$data["ZonasAli"]',
         ),
     array(            
         'header'=>'Fila',
         'value'=>'$data["FilasAli"]',
         ),
     array(            
         'header'=>'Asiento',
         'value'=>'$data["LugaresLug"]',
         ),
     array(            
       'header'=>'Referencia',
       'value'=>'$data["VentasNumRef"]',
       ),
     array(            
       'header'=>'Impresiones',
       'value'=>'$data["vecesImpreso"]',
       )

     )
));
?>
<?php endif; ?>
</div> 



