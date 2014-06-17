<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/jquery.tablesorter.js",CClientScript::POS_HEAD); ?>
<style>
th.headerSortUp { 
    background:#3399FF url(images/asc.gif) no-repeat right; 
} 
th.headerSortDown { 
    background:#3399FF url(images/desc.gif) no-repeat right;  
}
th.header { 
    cursor: pointer; 
}  
tr.sub-total td{
    text-align: right;
} 
</style>
<div class='controles'>
    <h2>Ventas En Farmatodo</h2>
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'usuarios-form',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
     'enableAjaxValidation'=>false,
     'clientOptions' => array('validateOnSubmit' => false)
     ));
     ?>


     <div class='row' >
        <div class='span4' style="margin:auto;float:none">
            <div class="controls"> 
                <?php echo "Desde: " ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(          
                      'name'=>'desde',
                      'value'=>@$_POST['desde'],
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
<span class='fa fa-2x fa-calendar text-info'></span>
</div>

<div class="controls"> 
    <?php echo "Hasta: " ?>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker',
        array(          
            'name'=>'hasta',
            'value'=>@$_POST['hasta'],
            'attribute'=>'fecha_revision',  
            'language' => 'es',             
            'htmlOptions' => array(         
//                         'readonly'=> $this->usuario->esMesaDeControl,
                ),
            'options'=>array(               
                'autoSize'=>false,              
                'defaultDate'=>$hasta, 
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
    echo CHtml::hiddenField('por');
        ?>
        <span class='fa fa-2x fa-calendar text-info'></span>
    </div>
</div>
</div>
<div class="row">
        
        <?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary btn-medium')); ?> 
    </div>   

    <?php $this->endWidget(); ?>
</div>

<?php                    
    if (isset($desde,$hasta) and preg_match("(\d{4}-\d{2}-\d{2})", $desde)==1  ) :
			$ventas=$model->getVentasFarmatodo($desde,$hasta);
	$this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'farmatodo-grid',
            'emptyText'=>'No se encontraron coincidencias',
            'dataProvider'=>$ventas,
			'summaryText'=>'Ventas en farmatodo agrupadas por punto de venta',
			'htmlOptions'=>array('class'=>'primario'),
			'type'=>array('condensed'),
            'columns'=>array(
					array(
							'header'=>'Sucursal',
							'name'=>'PuntosventaNom'
					),
					array(
							'header'=>'Total de la venta',
							'name'=>'importe',
							'value'=>'number_format($data[\'importe\'])',
							'htmlOptions'=>array('style'=>'text-align:right')
					),
					array(
							'header'=>'Total de transacciones',
							'value'=>'number_format($data[\'ventas\'])',
							'htmlOptions'=>array('style'=>'text-align:right')
					),
					array(
							'header'=>'Total de boletos',
							'value'=>'number_format($data[\'boletos\'])',
							'htmlOptions'=>array('style'=>'text-align:center')
					),
					array(
							'header'=>'Última transacción',
							'name'=>'ultimo'
					),
		
                ),
    )); 


 ?>

<?php 
	$data=$ventas->getData();
	$i=0;
    $importeTotal       = 0;
    $transaccionesTotal = 0;
    $boletosTotal       = 0;
foreach ($data as $key => $fila) {
		$importeTotal       += $fila['importe'];
        $transaccionesTotal += $fila['ventas'];
        $boletosTotal       += $fila['boletos'];
        $data[$key]['i']=$i;
		$i++;
}
echo $importeTotal;
		$this->widget('application.extensions.morris.MorrisChartWidget', array(
				'id'      => 'grafica-ventas',
				'options' => array(
						'chartType' => 'Bar',
						'data'      => $data,
						'xkey'      => 'PuntosventaNom',
						'ykeys'     => array('ventas','boletos'),
						'labels'    => array('Transacciones','Boletos'),
						'barColors'    => array('#e67e22','#3498db')
				),
		));
        ?>
<script>
    $('#farmatodo-grid table :last').append("<tfoot><tr class='sub-total'><td><strong>Sub Total</strong></td><td><strong><?php echo number_format($importeTotal);?></strong></td><td><strong><?php echo $transaccionesTotal;?></strong></td><td style='text-align:center;'><strong><?php echo $boletosTotal;?></strong></td><td>&nbsp;</td></tr></tfoot>"); 
    $("#farmatodo-grid table").tablesorter(); 
</script>
<?php endif;?>

