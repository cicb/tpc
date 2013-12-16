<div class='controles'>
        <h2>Reportes de ventas sin cargo</h2>
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
        						'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
        						'complete'   => 'function() { $("#fspin").removeClass("fa fa-spinner fa-spin");}',
        						'update' => '#funcion_id',
        				),'prompt' => 'Seleccione un Evento...'
        		));
        ?>
		</div>
		<div class="row" id="funciones">
        <?php
        echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));
		echo CHtml::dropDownList('funcion_id','',array());
		echo CHtml::hiddenField('grid_mode','view');
		echo CHtml::hiddenField('funcion','');
        ?>
        <li id="fspin" class="fa"></li>
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
        <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary btn-medium','onclick'=>'$("#grid_mode").val("view");')); ?> 
<?php echo CHtml::submitButton('Exportar'
				,array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ;
		 ?>
	 </div>   


</div>
<div class="span4 remark" style="float:right">
    <div class="panel-head">
        Resumen del evento
    </div>
<?php $this->endWidget(); ?>
<?php
    if (isset($eventoId) and $eventoId>0) {
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'evento-grid',
        'emptyText'=>'No se encontraron coincidencias',
        'dataProvider'=>$model->getReporteTaquilla($eventoId,$funcionesId,$desde,$hasta,$cargo='NO'),
        'summaryText'=>'',
        'columns'=>array(
            array(
                'header'=>'Canales de venta.',
                'name'=>'descuento',
                ),
            array(
                'header'=>'Boletos vendidos.',
                'name'=>'cantidad',
                'htmlOptions'=>array(
                    'style'=>'text-align:right;'
                    )
                ),
            array(
                'header'=>'Total',
                'value'=>'"$".number_format($data[\'total\'],2)',
                'type'=>'raw',
                'htmlOptions'=>array(
                    'style'=>'text-align:right;'
                    )
                ),

        ),
    )); 
    }
?>
    <?php 
    if (isset($eventoId) and $eventoId>0) {
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'evento-grid',
        'emptyText'=>'No se encontraron coincidencias',
        'dataProvider'=>$model->getReporte($eventoId,$funcionesId,$desde,$hasta,$cargo='NO'),
        'summaryText'=>'',
        // 'htmlOptions'=>array('class'=>'span4'),
        'columns'=>array(
            array(
                'header'=>'Canales de venta.',
                'name'=>'puntos',
                ),
            array(
                'header'=>'Boletos vendidos.',
                'name'=>'cantidad',
                'htmlOptions'=>array(
                    'style'=>'text-align:right;'
                    )
                ),
            array(
                'header'=>'Total',
                'value'=>'"$".number_format($data[\'total\'],2)',
                'type'=>'raw',
                'htmlOptions'=>array(
                    'style'=>'text-align:right;'
                    )
                ),

        ),
    )); 
    }
?>
</div>