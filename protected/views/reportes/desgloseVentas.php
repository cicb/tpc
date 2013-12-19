<div class="controles">
    <h2>Desglose de Ventas</h2>
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
                  'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
                  'complete'   => 'function() { 
                    $("#fspin").removeClass("fa fa-spinner fa-spin");
                    $("#funcion_id option:nth-child(2)").attr("selected", "selected");}',
                  'update' => '#funcion_id',
                  ),'prompt' => 'Seleccione un Evento...'
                ));
                ?>
            </div>

            <div class="row">
                <?php
                echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));

                echo CHtml::dropDownList('funcion_id','',array());
                ?>
                <span id="fspin" class="fa"></span>

            </div>
            <div class="row">
             <div class=" buttons">
                <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
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
                    array(            // display 'create_time' using an expression
                        'name'=>'Usuario',
                        'value'=>'$data["UsuariosNom"]',
                        ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Folio',
                        'value'=>'$data["UsuariosId"]',
                        ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Referencia',
                        'value'=>'$data["VentasNumRef"]',
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
                        'name'=>'Boleto',
                        'value'=>'$data["LugaresNumBol"]',
                        ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Precio S/C',
                        'value'=>'$data["VentasCosBol"]',
                        ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Tipo Venta',
                        'value'=>'$data["VentasBolTip"]',
                        ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Status',
                        'value'=>'$data["VentasSta"]',
                        ),
                    array(            // display 'create_time' using an expression
                        'name'=>'Fecha de Venta',
                        'value'=>'$data["VentasFecHor"]',
                        ),
                    ),
)); 
}

?>
