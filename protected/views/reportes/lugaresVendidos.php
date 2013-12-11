<div class="controles">
<h2>Lugares vendidos</h2>
<div id="cargador"  style="position:absolute; width:40px; height:40px;left:30%; top:150px; border:0px; margin-left:-40px; margin-top:-40px;" >
</div>
<div class="form">

<?php 
$form=$this->beginWidget('CActiveForm', array(
   'id'=>'usuarios-form',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
   'enableAjaxValidation'=>false,
   'clientOptions' => array('validateOnSubmit' => false)
));

?>
<div class='row' style="margin-left:30px">
		<div class='span4'>
	<div class="row">
<?php
echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
$modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
$list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
echo CHtml::dropDownList('evento_id','',$list,
		array(
				'ajax' => array(
						'type' => 'POST',
						'url' => CController::createUrl('funciones/cargarFunciones'),
						'beforeSend' => 'function() { $("#cargador").addClass("loading");}',
						'complete'   => 'function() { $("#cargador").removeClass("loading");}',
						'update' => '#funcion_id',
				),'prompt' => 'Seleccione un Evento...'
		));
?>
	</div>

	<div class="row">
<?php
echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));

echo CHtml::dropDownList('funcion_id','',array(),
		array(
				'ajax' => array(
						'type' => 'POST',
						'url' => CController::createUrl('zonas/cargarZonas'),
						'beforeSend' => 'function() { $("#cargador").addClass("loading");}',
						'complete'   => 'function() { $("#cargador").removeClass("loading");}',
						'update' => '#zona_id',
				),'prompt' => 'Seleccione una Funcion...'
		));
?>
	</div>
	<div class="row">
<?php
echo CHtml::label('Zona','zona_id', array('style'=>'width:70px; display:inline-table;'));
echo CHtml::dropDownList('zona_id','',array(),array('prompt'=>'Seleccione una Zona...'));
?>
	 </div>
		</div>
		<div class='span4'>
	<div class="row">
		<?php echo $form->labelEx($model,'filas', array('style'=>'width:70px; display:inline-table;')); ?>
		<?php echo $form->textField($model,'filas'); ?>
		<?php echo $form->error($model,'filas'); ?>
	</div>
	  <div class="row">
		<?php echo $form->labelEx($model,'lugares', array('style'=>'width:70px; display:inline-table;')); ?>
		<?php echo $form->textField($model,'lugares'); ?>
		<?php echo $form->error($model,'lugares'); ?>
	</div>
	<div class="row">
	 <input type="radio" name="tipo" value="asiento"  checked="checked" /> Asiento/Fila 
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	 <input type="radio" name="tipo" value="fecha" /> Fecha de venta
	</div>
		</div>
</div>
       <div class=" buttons">
        <?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
    </div>
    


<?php $this->endWidget(); ?>

</div><!-- form -->
</div><!-- End controles -->

<?php if(( isset($dataProvider) and !is_null($dataProvider))): ?>
<div id="Contenido" >
	<?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'evento-grid',
        'dataProvider'=>$dataProvider,
        'columns'=>array(

			array(
				'name'=>'Zona',
				'cssClassExpression'=>'$data->Estatus',
        	),
            array(
				'name'=>'Fila',
				'cssClassExpression'=>'$data->Estatus',
        	),
            array(
				'name'=>'Asiento',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'Barras',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'Estatus',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'FechaVenta',
				'cssClassExpression'=>'$data->Estatus',
        	),
			
			
             array(
				'name'=>'VentasId',
				'value'=>'"<a href=\"./?r=asiento/detalleventa&id=$data->VentasId#data\" 
					       id=\"inline\">$data->VentasId</a>"',
			//	'value'=>'CHtml::link("test", Yii::App()->controller->createUrl("asiento/detalleventa", 
			//			 array("id"=>"$data->VentasId","#"=>"data")), array("id"=>"inline"))',
				'type'=>'raw',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'VentasNumRef',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'TipoVenta',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'TipoBoleto',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'PuntosventaId',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'PuntoVenta',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'Descuento',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'UsuariosId',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'QuienVende',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'NombreTarjeta',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'NumeroTarjeta',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'VecesImpreso',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'QuienCancelo',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'FechaCancelacion',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'EventoId',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'FuncionesId',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'ZonasId',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'SubzonaId',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'FilasId',
				'cssClassExpression'=>'$data->Estatus',
        	),
             array(
				'name'=>'LugaresId',
				'cssClassExpression'=>'$data->Estatus',
        	),
        ),
    )); ?>
</div>
<?php endif;?>
