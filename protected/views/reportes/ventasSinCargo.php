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

<?php $this->endWidget(); ?>

</div>
<div class="row-fluid">
<?php  if (isset($eventoId) and $eventoId>0): 
    $evento=Evento::model()->findByPk($eventoId);
    $funcion="TODAS";
    if (isset($funcionesId) and $funcionesId>0){
        $funcion=Funciones::findByPk(array('EventoId'=>$eventoId,'FuncionesId'=>$funcionesId));
        if(is_object($funcion))
            $funcion=$funcion->funcionesTexto;
    }

?>
<?php  if (is_object($evento)): ?>

    <div class="span7">
    <br/>
        <div class="well">
            <small>Evento:</small>
            <h3><?php echo $evento->EventoNom ?></h3>
            <small>Funcion (es):</small>
            <h4><?php echo $funcion ?></h4>
            <small>A la venta desde:</small>
            <strong><?php echo "$desde";?> </strong>
        </div>
        <?php
        foreach ($evento->funciones as $funcion) {
            foreach ($funcion->zonas as $zona) {
                echo "<div class='panel-head'>".$zona->ZonasAli."</div>";
                $this->widget('bootstrap.widgets.TbGridView', array(
                    'id'=>'taquilla-grid',
                    'emptyText'=>'No se encontraron coincidencias',
                    'dataProvider'=>$model->getDetallesZonasCargo($eventoId,$funcionesId,$zona->ZonasId,$desde,$hasta,$cargo='NO'),
                    'summaryText'=>'',
                    'htmlOptions'=>array('class'=>'normal'),
                    'columns'=>array(
                        array(
                            'header'=>'Tipo de boleto',
                            'type'  =>'row',
                            'value' => 'data[\'VentasBolTip\']'
                            ),
                        array(
                            'header'=>'Boletos vendidos.',
                            'name'=>'cantidad',
                            'htmlOptions'=>array(
                                'style'=>'text-align:right;'
                                )
                            ), 
                        array(
                            'header'=>'Precio Boleto.',
                            'name'=>'VentasCosBol',
                            'htmlOptions'=>array(
                                'style'=>'text-align:right;'
                                )
                            ),
                        array(
                            'header'=>'Sub-Totales de venta',
                            'value'=>'"$".number_format($data[\'total\'],2)',
                            'type'=>'raw',
                            'htmlOptions'=>array(
                                'style'=>'text-align:right;'
                                )
                            ),

                        ),
                    )); 
            }
            break;
        }
?>
    </div>
<?php endif; ?>
<div class="span5 remark" style="float:right">
    <div class="panel-head">
        Resumen del evento
    </div>
<?php
    $taquillas=$this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'taquilla-grid',
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
?>
    <?php 
    $puntos=$this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'canales-venta-grid',
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

    $especiales=$this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'boletos-especiales-grid',
        'emptyText'=>'No se encontraron boletos duros o cortesias',
        'dataProvider'=>$model->getReporte($eventoId,$funcionesId,$desde,$hasta,$cargo='NO',
            'CORTESIA,BOLETO DURO','','VentasBolTip'),
        'summaryText'=>'',
        // 'htmlOptions'=>array('class'=>'span4'),
        'columns'=>array(
            array(
                'header'=>'Tipo de boleto.',
                'name'=>'VentasBolTip',
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
    echo "<div class='panel-head'>Descuentos</div>";
        $descuentos=$this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'descuentos-grid',
        'emptyText'=>'No se encontraron ventas con descuentos',
        'dataProvider'=>$model->getReporte($eventoId,$funcionesId,$desde,$hasta,$cargo='NO',
            'NORMAL','AND t2.DescuentosId>0','DescuentosId'),
        'summaryText'=>'',
        'htmlOptions'=>array('class'=>'normal'),
        'columns'=>array(
            array(
                'header'=>'Descuento.',
                'name'=>'DescuentosId',
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
    // SUMATORIAS-------------------------------------------------------------------------------------
    $vendidos=array('taquilla'=>0,'puntos'=>0,'especiales'=>0);
    $subtotal=array('taquilla'=>0,'puntos'=>0,'especiales'=>0);
    foreach ($puntos->dataProvider->getData() as $punto) {
        # Sumariza los totales
        $vendidos['puntos']+=$punto['cantidad'];
        $subtotal['puntos']+=$punto['total'];
    }
    foreach ($taquillas->dataProvider->getData() as $taquilla) {
        # Sumariza los totales de taquilla y taquilla con descuento
        $vendidos['taquilla']+=$taquilla['cantidad'];
        $subtotal['taquilla']+=$taquilla['total'];
    }
    foreach ($especiales->dataProvider->getData() as $especial) {
        # Sumariza los totales de taquilla y taquilla con descuento
        $vendidos['especiales']+=$especial['cantidad'];
        $subtotal['especiales']+=$especial['total'];
    }
    Yii::app()->clientScript->registerScript('sumatorias',"
        $('#canales-venta-grid table').append('<tr> <td >Sub-Total T.C. </td> <td style=\"text-align:right\">".$vendidos['puntos']."</td><td style=\"text-align:right\">$".number_format($subtotal['puntos'],2)."</td> ');
        $('#canales-venta-grid table').append('<tr class=\'panel-head\'><td colspan=\'3\' ></td></tr><tr> <td ><b>Subtotales. </b></td> <td style=\"text-align:right\">".($vendidos['taquilla']+$vendidos['puntos'])."</td><td style=\"text-align:right\">$".number_format($subtotal['taquilla']+$subtotal['puntos'],2)."</td> ')

        $('#boletos-especiales-grid table').append('<tr class=\'panel-head\'><td colspan=\'3\' style=\'text-align:center\'>TOTAL</td></tr><tr class=\' \'> <td ><b>Total: </b></td> <td style=\"text-align:right\">".(array_sum($vendidos))."</td><td style=\"text-align:right\">$".number_format(array_sum($subtotal),2)."</td> ')
        "
        ,CClientScript::POS_LOAD);
?>
<?php endif; ?>
</div>
</div>

