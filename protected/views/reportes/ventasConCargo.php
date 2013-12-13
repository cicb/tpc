<div class='controles'>
        <h2>Reportes de ventas con cargo</h2>
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
        						'beforeSend' => 'function() { $("#funciones").addClass("loading");}',
        						'complete'   => 'function() { $("#funciones").removeClass("loading");}',
        						'update' => '#funcion_id',
        				),'prompt' => 'Seleccione un Evento...'
        		));
        ?>
		</div>
		<div class="row" id="funciones">
        <?php
        echo CHtml::label('Funcion','funcio_id', array('style'=>'width:70px; display:inline-table;'));
		echo CHtml::dropDownList('funcion_id','',array());
		echo CHtml::hiddenField('grid_mode','view');
		echo CHtml::hiddenField('funcion','');
        ?>
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
                        'minDate'=>'-5Y', //fecha minima
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
                        'minDate'=>'-5Y', //fecha minima
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

<?php $this->endWidget(); ?>
