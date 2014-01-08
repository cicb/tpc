<div class='controles'>
    <h2>Ventas Diarias</h2>
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
        
        <?php echo CHtml::submitButton('Ver por usuario',array('class'=>'btn btn-inverse ','onclick'=>'$("#por").val("usuario");')); ?>
        <?php echo CHtml::submitButton('Ver por evento',array('class'=>'btn btn-primary btn-medium','onclick'=>'$("#por").val("evento");')); ?> 
    </div>   

    <?php $this->endWidget(); ?>
</div>

<?php                    
    if (isset($desde,$hasta) and preg_match("(\d{4}-\d{2}-\d{2})", $desde)==1  ) {
    if (isset($por) and $por=="evento") {
             $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'taquilla-grid',
            'emptyText'=>'No se encontraron coincidencias',
            'dataProvider'=>$model->getVentasDiarias($desde,$hasta,'evento'),
            'summaryText'=>'',
			'type'=>'condensed',
            'htmlOptions'=>array('class'=>'primario'),
            'columns'=>array(
                array(
                    'header'=>'Evento',
                    'type'  =>'raw',
                    'value' => '$data[\'EventoNom\']'
                    ),
                array(
                    'header'=>'Fecha.',
                    'name'=>'EventoFecIni',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'No. Boletos.',
                    'name'=>'cantidad',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ), 
                array(
                    'header'=>'Efectivo sin cargo',
                    'value'=>'"$".number_format($data[\'efectivo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Efectivo con cargo',
                    'value'=>'"$".number_format($data[\'efe_cargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Visa/Mastercard sin cargo',
                    'value'=>'"$".number_format($data[\'tarjeta\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Visa/Mastercard con cargo',
                    'value'=>'"$".number_format($data[\'tarjetaccargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Terminal sin cargo',
                    'value'=>'"$".number_format($data[\'terminal\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Terminal con cargo',
                    'value'=>'"$".number_format($data[\'terminalccargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Total venta sin cargo',
                    'value'=>'"$".number_format($data[\'total\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Total con cargo',
                    'value'=>'"$".number_format($data[\'totalccargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Total de cargo por servicio',
                    'value'=>'"$".number_format($data[\'cargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),

                ),
    ));       
    }
    else{
        # si se muestra la lista por usuarios
            echo  "<div class='panel-head panel-primario'> Ventas diarias agrupadas por terminal y usuario</div>";
             $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'taquilla-grid',
            'emptyText'=>'No se encontraron coincidencias',
            'dataProvider'=>$model->getVentasDiarias($desde,$hasta,'usuario'),
            'summaryText'=>'Ventas diarias agrupadas por terminal y usuario',
            'htmlOptions'=>array('class'=>'primario'),
            'columns'=>array(
                array(
                    'header'=>'Terminal',
                    'type'  =>'raw',
                    'value' => '$data[\'PuntosventaNom\']'
                    ),
                array(
                    'header'=>'Usuario',
                    'type'  =>'raw',
                    'value' => '$data[\'UsuariosNom\']'
                    ),

                array(
                    'header'=>'No. Boletos.',
                    'name'=>'cantidad',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ), 
                array(
                    'header'=>'Efectivo sin cargo',
                    'value'=>'"$".number_format($data[\'efectivo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Efectivo con cargo',
                    'value'=>'"$".number_format($data[\'efe_cargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Visa/Mastercard sin cargo',
                    'value'=>'"$".number_format($data[\'tarjeta\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Visa/Mastercard con cargo',
                    'value'=>'"$".number_format($data[\'tarjetaccargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Terminal sin cargo',
                    'value'=>'"$".number_format($data[\'terminal\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Terminal con cargo',
                    'value'=>'"$".number_format($data[\'terminalccargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Total venta sin cargo',
                    'value'=>'"$".number_format($data[\'total\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Total con cargo',
                    'value'=>'"$".number_format($data[\'totalccargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Total de cargo por servicio',
                    'value'=>'"$".number_format($data[\'cargo\'],2)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),

                ),
    )); 
    }

}
 ?>
