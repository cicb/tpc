<div class='controles'>
    <h2>Reportes de ventas diarias</h2>
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
</div>
</div>
<div class="row">
    <?php echo CHtml::submitButton("Exportar"
        ,array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ;
        ?>
    <div class="btn-group">
        
        <?php echo CHtml::submitButton('Ver por usuario',array('class'=>'btn btn-inverse ','onclick'=>'$("#grid_mode").val("view");')); ?>
        <?php echo CHtml::submitButton('Ver por evento',array('class'=>'btn btn-primary btn-medium','onclick'=>'$("#grid_mode").val("view");')); ?> 
    </div>
    </div>   

    <?php $this->endWidget(); ?>
</div>

<?php                    
if (isset($desde,$hasta) and preg_match("(\d{4}-\d{2}-\d{2})", $desde)==1  ) {

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'taquilla-grid',
    'emptyText'=>'No se encontraron coincidencias',
    'dataProvider'=>$model->getVentasDiarias($desde,$hasta),
    'summaryText'=>'',
    'htmlOptions'=>array('class'=>'normal'),
    'columns'=>array(
        array(
            'header'=>'Tipo de boleto',
            'type'  =>'raw',
            'value' => '$data[\'PuntosventaNom\']'
            ),
        array(
            'header'=>'Usuario.',
            'name'=>'UsuariosNom',
            'htmlOptions'=>array(
                'style'=>'text-align:right;'
                )
            ),
        array(
            'header'=>'Boletos vendidos.',
            'name'=>'cantidad',
            'htmlOptions'=>array(
                'style'=>'text-align:right;'
                )
            ), 
        array(
            'header'=>'Sub-Totales de venta',
            'value'=>'"$".number_format($data[\'efectivo\'],2)',
            'type'=>'raw',
            'htmlOptions'=>array(
                'style'=>'text-align:right;'
                )
            ),

        ),
));
}
 ?>