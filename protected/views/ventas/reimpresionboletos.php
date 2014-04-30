<div class="controles">
<h2>Reimpresi&oacute;n de Boletos</h2>
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
		<div class=''>
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
        <?php echo CHtml::submitButton('Ver boletos',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
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
   $this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$data,
    'columns'=>array(    
                    array(            
                        'name'=>'Fecha',
                        'value'=>'$data["VentasFecHor"]',
                    ),
                    array(            
                        'name'=>'Email',
                        'value'=>'$data["email"]',
                    ),
                    array(            
                        'name'=>'Funci&oacute;n',
                        'value'=>'$data["funcionesTexto"]',
                    ),
                    array(            
                        'name'=>'Zona',
                        'value'=>'$data["ZonasAli"]',
                    ),
                    array(            
                        'name'=>'Fila',
                        'value'=>'$data["FilasAli"]',
                    ),
                    array(            
                        'name'=>'Asiento',
                        'value'=>'$data["LugaresLug"]',
                    ),
                    array(            
                        'name'=>'Referencia',
                        'value'=>'$data["VentasNumRef"]',
                    ),
                    array(            
                        'name'=>'Impresiones',
                        'value'=>'noReimpresiones($data["VentasCon"])',
                    ),
                    /*array(            
                        'name'=>'Impresiones',
                        'value'=>'$data["VentasCon"]',
                    ),*/
                    
    ),
)); 
}
function noReimpresiones($string = ""){
            if(!empty($string)):
                    $len = strlen($string);
                    $num = substr($string ,$len -2);
                    if(is_numeric($num)):
                        return $num + 1;
                    else:
                        $num = substr($string ,$len -1);
                        return $num + 1;
                    endif;
                else:
                    return "0";
                endif;
}
?>
<?php 
$form=$this->beginWidget('CActiveForm', array(
   'id'=>'usuarios-form',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
   'enableAjaxValidation'=>false,
   'clientOptions' => array('validateOnSubmit' => false)
));
if(!empty($data)){
?>
<?php echo CHtml::radioButton('impresion',true,array('value'=>'no_impresos','id'=>'no_impresos','style'=>'margin:0 5px;'));?>
<label style="display: inline-block;" for="no_impresos"><strong>IMPRIMIR BOLETOS NO IMPRESOS</strong></label>
<br />
<?php echo CHtml::radioButton('impresion',false,array('value'=>'todos','id'=>'todos','style'=>'margin:0 5px;'));?>
<label style="display: inline-block;" for="todos"><strong>IMPRIMIR TODOS LOS BOLETOS</strong></label>

<?php

    $img_formato = Formatosimpresion::model()->findAll("FormatoSta='ALTA'");
    foreach($img_formato as $key => $formato):
        echo CHtml::radioButton('impresion',true,array('value'=>"formato$key",'id'=>"$key",'style'=>'margin:0 5px;'));
        echo $formato->FormatoIma;
    endforeach;
}
?>
<?php echo CHtml::submitButton('Imprimir',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
<?php $this->endWidget(); ?>
