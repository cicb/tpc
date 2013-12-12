<div class="controles">
<h1>Ventas Call Center</h1>
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
       <div class=" buttons">
        <?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
    </div>
    
 </div>   
</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
table.items{
    min-width: 900px !important;
}
</style>
 
  <style>
.CANCELADO{
        background-color:#FFCECE;}
</style>
</div>

<?php
//print_r($data->getData());
if(!empty($data)){
   $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$data,
    'columns'=>array(    
                    array(            // display 'create_time' using an expression
                        'name'=>'Fecha',
                        'value'=>'$data["VentasFecHor"]',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Funcion',
                        'value'=>'$data["funcionesTexto"]',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Zona',
                        'value'=>'$data["ZonasAli"]',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Fila',
                        'value'=>'$data["FilasAli"]',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Asiento',
                        'value'=>'$data["LugaresLug"]',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Referencia',
                        'value'=>'$data["VentasNumRef"]',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Impresiones',
                        'value'=>'$data["vecesImpreso"]',
                    ),
    
    ),
)); 
}

?>
                   