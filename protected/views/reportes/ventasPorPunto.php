
<div class='controles'>
    <h2>Ventas Por Punto De Venta</h2>
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'controles',
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
			$eventos = Yii::app()->user->modelo->getEventosAsignados();
			$list = CHtml::listData($eventos,'EventoId','EventoNom');
			echo CHtml::dropDownList('evento_id',@$_POST['evento_id'],$list,
			  array(
				'ajax' => array(
				  'type' => 'POST',
				  'url' => CController::createUrl('funciones/cargarFuncionesFiltradas'),
				  'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
				  'complete'   => 'function() { 
					$("#fspin").removeClass("fa fa-spinner fa-spin");
					$("#funcion_id option:nth-child(2)").attr("selected", "selected");}',
				  'update' => '#funcion_id',
				  ),'prompt' => 'Seleccione un Evento...'
				));
                ?>
            </div>
            <div class="row" id="funciones">
                <?php
                echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));
                echo CHtml::dropDownList('funcion_id',@$_POST['funcion_id'],array());
                echo CHtml::hiddenField('grid_mode','view');
                echo CHtml::hiddenField('funcion',@$funcionesId);
                ?>
                <span id="fspin" class="fa"></span>
            </div>
        </div>
        <div class='span4'>
            <div class="controls"> 
              <?php echo "Desde: " ?>
              <?php
              $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(          
                  'name'=>'desde',
                  'attribute'=>'fecha_revision',  
                  'language' => 'es',             
                  'htmlOptions' => array(         
//                         'readonly'=> $this->usuario->esMesaDeControl,
                    ),
                  'options'=>array(               
                    'autoSize'=>false,              
                    'defaultDate'=>'date("Y-m-d")', 
                    'dateFormat'=>'yy-mm-dd',       
                    'selectOtherMonths'=>true,      
                    'showAnim'=>'fade',            
                    'showButtonPanel'=>false,       
                    'showOn'=>'focus',             
                    'showOtherMonths'=>true,        
                    'changeMonth' => true,          
                    'changeYear' => true,
                        'minDate'=>'2010-01-01', //fec\ha minima
                        'maxDate'=>"+1D", //fecha maxima
                        ),
                  )
);
?>
<span class='fa fa-2x fa-calendar'></span>
</div>

<div class="controls"> 
  <?php echo "Hasta: " ?>
  <?php
  $this->widget('zii.widgets.jui.CJuiDatePicker',
    array(          
       'name'=>'hasta',
       'attribute'=>'fecha_revision',  
       'language' => 'es',             
       'htmlOptions' => array(         
//                         'readonly'=> $this->usuario->esMesaDeControl,
        ),
       'options'=>array(               
        'autoSize'=>false,              
        'defaultDate'=>'date("Y-m-d")', 
        'dateFormat'=>'yy-mm-dd',       
        'selectOtherMonths'=>true,      
        'showAnim'=>'fade',            
        'showButtonPanel'=>false,       
        'showOn'=>'focus',             
        'showOtherMonths'=>true,        
        'changeMonth' => true,          
        'changeYear' => true,
                        'minDate'=>'2010-01-01', //fec\ha minima
                        'maxDate'=>"+1D", //fecha maxima
                        ),
       )
    );
    ?>
    <span class='fa fa-2x fa-calendar'></span>
</div>
</div>
</div>
<div class="row">
<?php if($eventoId>0){
	if ($esMovil) 
			echo CHtml::submitButton('Cambiar a vista completa',array('class'=>'btn',
					'onclick'=>"$('#controles').attr('action','".$this->createUrl('reportes/ventasSinCargo',
			array('dispositivo'=>'pc'))."');"));
	else	
			echo CHtml::submitButton('Cambiar a vista movil',array('class'=>'btn',
					'onclick'=>"$('#controles').attr('action','".$this->createUrl('reportes/ventasSinCargo',
			array('dispositivo'=>'movil'))."');"));
}
?>

<?php echo CHtml::link('Exportar',$this->createUrl('reportes/exportarReporte',array(
		'evento_id'=>$eventoId,
		'funcion_id'=>$funcionesId,
		'desde'=>$desde,
		'hasta'=>$hasta,
		'movil'=>$esMovil,
		
)),array('class'=>'btn')) ; ?>
    <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary btn-medium','onclick'=>'$("#grid_mode").val("view");')); ?> 
    </div>   

    <?php $this->endWidget(); ?>

</div>
<div id='reporte'>
<?php
if(isset($eventoId,$funcionesId,$puntoVenta) and $eventoId>0 and $puntoVenta>0){
$this->widget('application.extensions.EExcelView', array(
 'dataProvider'=> $model->getVendidosPor($eventoId,$funcionesId,$puntoVenta),
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

     )
));
}
?>

</div>
