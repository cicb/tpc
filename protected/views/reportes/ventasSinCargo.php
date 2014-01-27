<?php
$esMovil=Yii::app()->mobileDetect->isMobile();
if (isset($_GET['dispositivo']) and $_GET['dispositivo']=='pc') {
	$esMovil=false;
}
else if (isset($_GET['dispositivo']) and $_GET['dispositivo']=='movil')
		$esMovil=true;
?>
<div class='controles'>
    <h2>Ventas Sin Cargo</h2>
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
<div class="contenido"  id="reporte">
    <?php  if (isset($eventoId) and $eventoId>0): 
    $evento=Evento::model()->findByPk($eventoId);
    $funciones="TODAS";
    if (isset($funcionesId) and $funcionesId>0){
        $funcion=Funciones::model()->findByPk(array('EventoId'=>$eventoId,'FuncionesId'=>$funcionesId));
		if(is_object($funcion)){
				$funciones=$funcion->funcionesTexto;
		}

	}
	else{
			$funcion=$evento->funciones[0];
	}
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
			"Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$months = array( 'January', 'February', 'March', 'April', 'May',
			'June', 'July ', 'August', 'September', 'October', 'November',  'December',);
	$ventasDesde=str_replace($months,$meses,date_create($funcion->FuncionesFecIni)->format("d-F-Y"));                   
	$diaFuncion = new DateTime($funcion->FuncionesFecHor);
	$hoy = new DateTime("now");
	$diaspara=round(($diaFuncion->format('U') - $hoy->format('U')) / (60*60*24));

    ?>
    <?php  if (is_object($evento)): ?>

<div class=span4 style="float:none">
           
           <br/>
            <div >
                <strong><span>Evento:</span>
                <?php echo $evento->EventoNom ?></strong><br/>
                <span>Funcion (es):</span>
                <?php echo $funciones; ?><br/>
                <span>A la venta desde:</span>
				<?php echo $ventasDesde;?> <br/><br/>
                <?php echo $diaspara>-1?" <span>D&iacute;as para el evento:</span>
".$diaspara:"El evento ya ha finalizado.";?> <br/><br/>

            </div>
            </div>
<div class="row-fluid">
        <div class="span4" style="margin:10px; <?php
				echo $esMovil?"float:none;margin:auto;display:block;":"";
        ?>">
				<div class='panel-primario'>Resumen de evento</div>
				<?php 
	$resumenEvento=$model->getResumenEvento($eventoId,$funcionesId,$desde,$hasta);
	$data=array();
	foreach (array_slice($resumenEvento,1,4) as $key=>$fila) {
		$label=strcasecmp($key,'NORMAL')==0?'Ventas':ucwords($key);		
		$data[]=array('label'=>$label,'value'=>(int)str_replace(',','',$fila['boletos']));
	}
		
					$this->widget('application.extensions.morris.MorrisChartWidget', array(
							'id'      => 'grafica-resumen',
							'options' => array(
									'chartType' => 'Donut',
									'data'      => $data,
									'colors'    => array('#f1c40f','#2980b9','#8e44ad','#27ae60','#f1c40f')
							),
					));

					Yii::app()->mustache->render('tablaResumenEvento', $resumenEvento);
             ?>

            <?php 
            $arreglo=$model->getPromedios($eventoId,$funcionesId);
            Yii::app()->mustache->render('tablaPromediosDiarios', $arreglo);
             ?>
            <?php 
			echo "<div id='tabla-ultimas' ".($esMovil?'':'style="display:none !important;visibility:none"').">";
					$ultimas=$model->getUltimasVentas($eventoId,$funcionesId);
					Yii::app()->mustache->render('tablaUltimasVentas', $ultimas);
			echo "</div>";
             ?>
    </div>
<?php endif; ?>
<?php 
if(!$esMovil): ?>
<div class="span7 " id="tablas-detalladas" style="float:right">
<table class="table">
    <tr>
        <td style="text-align:center !important;font-weight:800">Resumen de ventas </td>
        <td style="text-align:center !important;font-weight:800">Ventas de hoy</td>
    </tr>
    <tr>
        <td>
            <?php 
            $arreglo=$model->getReporte($eventoId,$funcionesId,$desde,$hasta);
            Yii::app()->mustache->render('tablaVentasSinCargo', $arreglo);
             ?>  
        </td>
        <td>
            <?php 
            $arreglo=$model->getReporte($eventoId,$funcionesId,'curdate()','curdate()',$cargo=false,'NORMAL','and t3.FuncPuntosventaId<>t.PuntosventaId');
            Yii::app()->mustache->render('tablaVentasHoySin', $arreglo);
             ?>
        </td>
    </tr>

</table>
              <?php 
            $arreglo=$model->getReporteZonas($eventoId,$funcionesId,$desde,$hasta);
            Yii::app()->mustache->render('tablasVentasZonas', $arreglo);
             ?>  

<div class='panel-head'>Boletos vendidos por día</div>
<?php 
$data=$model->getDatosGraficaPorDia($eventoId,$funcionesId,$desde,$hasta);
$this->widget('application.extensions.morris.MorrisChartWidget', array(
    'id'      => 'grafica-ventas',
    'options' => array(
        'chartType' => 'Bar',
        'data'      => $data,
        'xkey'      => 'dia',
        'ykeys'     => 'v',
        'labels'    => array('Boletos'),
        'barColors'    => array('#e67e22')
    ),
));
        ?>




<?php endif; //Fin de validacion movil ?>
<?php endif; ?>
</div>

</div>
</div>
<style type="text/css">
    .table-condensed thead{
        background: white; color:#222;
    }
    .summary{background: white}
    table{font-size: 90%}
	td{text-align: right !important;}
	.table-bordered th,.table-bordered td{border:1px solid #222 !important;}	
	th{text-align:center !important;}	
	.table{width:auto !important;}	
</style>

<?php
if (isset($_POST['evento_id'])) {
		Yii::app()->clientScript->registerScript('carga',"$('#evento_id').change();",CClientScript::POS_LOAD);
		//Yii::app()->clientScript->registerScript('versiones',"var full=".(!$esMovil?'true':'false').";
		//$('#btn-cambio-version').on('click',function (){
			//$('#tablas-detalladas').toggle();
			//$('#tabla-ultimas').toggle();		
			//if(full){ 
					//$('#btn-cambio-version').text('Cambiar a version completa');}
			//else{ 
					//$('#btn-cambio-version').text('Cambiar a version movil');}
					//full=!full;	event.preventDefault();
		//});",CClientScript::POS_LOAD);

}
?>

