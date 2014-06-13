<div class="controles">
<h2>Ventas Call Center</h2>
<div id="cargador"  style="position:absolute; width:40px; height:40px;left:30%; top:150px; border:0px; margin-left:-40px; margin-top:-40px;" >
</div>
<div class="form">
<?php if(isset($_POST['evento_id'],$_POST['funcion_id'])){
		$eventoId=$_POST['evento_id'];
		$funcionesId=$_POST['funcion_id'];
		//print_r ($_POST);
		}
else{
		$eventoId='';
		$funcionesId='';
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

?>
<div class='row' style="margin-left:30px">
		<div class=''>
	<div class="row">
        <?php
        echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
        $modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
        $list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
        echo CHtml::dropDownList('evento_id',$eventoId,$list,
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
        
		echo CHtml::dropDownList('funcion_id',$funcionesId,array());
		echo CHtml::hiddenField('grid_mode','view');
		echo CHtml::hiddenField('funcion',$funcionesId);
        ?>
	</div>
	<div class="row">
       <div class=" ">

        <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary btn-medium','onclick'=>'$("#grid_mode").val("view");')); ?> 
<?php echo CHtml::submitButton('Exportar'
		//,$this->createUrl('reportes/ventasCallCenter',
				//array('evento'=>$eventoId,'funcion'=>$funcionesId,'grid_mode'=>'export'))
				,array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ;
		 ?>
    </div>
    
 </div>   
</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
 
  <style>
.CANCELADO{
        background-color:#FFCECE;}
</style>
</div>

<?php
//print_r($data->getData());
	if(isset($eventoId,$funcionesId) and $eventoId+$funcionesId>0){
			$this->widget('bootstrap.widgets.TbGridView', array(
					'dataProvider'=>$model->getCallCenter($eventoId, $funcionesId),
					'columns'=>array(    
							array(            // display 'create_time' using an expression
									'name'=>'Fecha',
									'value'=>'$data["VentasFecHor"]',
							),
							array(            // display 'create_time' using an expression
									'name'=>'Funcion',
									'value'=>'$data["funcionesTexto"]',
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
									'name'=>'Referencia',
									'value'=>'$data["VentasNumRef"]',
							),
							array(            // display 'create_time' using an expression
									'name'=>'Impresiones',
									'value'=>'$data["vecesImpreso"]',
							),

					),
			)); 
	}
 
 
 
?>
  <?php
//if (isset($eventoId, $funcionesId))
//$this->widget('EExcelView', array(
    //'dataProvider'=> $model->getCallCenter($eventoId,$funcionesId),
    //'htmlOptions'=>array('class'=>'table table-hover table-condensed','style'=>'width:100%'),
    //'ajaxUpdate'=>false,
    //'title'=>'Visualización de Archivos',
    //'creator'=>Yii::app()->name,
    //'subject'=>'Reporte de Visualización de Archivos',
    //'exportText'=>'Exportar a:  ',
    //'grid_mode'=>'export',
    //'autoWidth'=>true,
    //'exportType'=>'Excel5, Excel2007',
    //'exportButtons'=>array('Excel5', 'Excel2007'),
    //'filter'=>$model,
    //'columns'=>array(    
                    //array(            // display 'create_time' using an expression
						//'header'=>'Fecha',
                        //'value'=>'$data["VentasFecHor"]',
                    //),
                    //array(            // display 'create_time' using an expression
						//'header'=>'Funcion',
                        //'value'=>'$data["funcionesTexto"]',
                    //),
                    //array(            // display 'create_time' using an expression
						//'header'=>'Zona',
                        //'value'=>'$data["ZonasAli"]',
                    //),
                    //array(            // display 'create_time' using an expression
						//'header'=>'Fila',
                        //'value'=>'$data["FilasAli"]',
                    //),
                    //array(            // display 'create_time' using an expression
						//'header'=>'Asiento',
                        //'value'=>'$data["LugaresLug"]',
                    //),
                    //array(            // display 'create_time' using an expression
						//'header'=>'Referencia',
                        //'value'=>'$data["VentasNumRef"]',
                    //),
                    //array(            // display 'create_time' using an expression
						//'header'=>'Impresiones',
                        //'value'=>'$data["vecesImpreso"]',
                    //),
    
    //),
//));

?>                 
