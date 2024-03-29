<div class='controles'>
<h2>Ventas Web y Call Center</h2>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form-ventaslevel1',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<?php 
$models = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order' => 'EventoNom'));
$list = CHtml::listData($models, 'EventoId', 'EventoNom');
// print_r($dataProvider->getData());
?>
<div class="row">
<?php
echo CHtml::label('Punto de Venta','pv', array('style'=>'width:70px; display:inline-table;'));
echo CHtml::dropDownList('pv',@$_POST["pv"],array('101'=>'Web','102'=>'Call Center'));
?>
</div>
<div class="row">
<?php
echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
$modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
$list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
echo CHtml::dropDownList('evento_id',@$_POST["evento_id"],$list,

		array(
				'ajax' => array(
						'type' => 'POST',
						'url' => CController::createUrl('funciones/cargarFunciones'),
						'beforeSend' => 'function() { $("#cargador").addClass("loading");}',
						'complete'   => 'function() { $("#cargador").removeClass("loading");}',
						'update' => '#Ventaslevel1_funcion',
				)
		));
?>
	</div>

	<div class="row">
<?php
echo CHtml::label('Funcion','Ventaslevel1_funcion', array('style'=>'width:70px; display:inline-table;'));
echo CHtml::dropDownList('Ventaslevel1[funcion]','',array());
?>
	</div>
	<div class='row'>
    <?php echo CHtml::hiddenField('grid_mode', 'view'); ?>                                                                      
    <?php echo CHtml::hiddenField('funcion_id', '<?php @echo $_POST["Ventaslevel1"]["funcion"]; ?>'); ?>                                                                      
    <?php echo $form->error($model,'evento_id'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary','onclick'=>'$("#grid_mode").val("show");')); ?>
		<?php echo CHtml::submitButton('Exportar',array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ;
		 ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('evento-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<?php /*
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evento-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
        'fnc',
		'PuntosventaNom',
		'VentasFecHor',
		'ZonasAli',
		'FilasAli',
		'LugaresLug',
		'VentasCon',
		'VentasNumRef',
		'ClientesEma',
        array(
            'name'=>'id',
            'value'=>'
                !empty($data["VentasCon"])?is_numeric(substr($data["VentasCon"] ,strlen($data["VentasCon"])-2))+1?:substr($data["VentasCon"] ,strlen($data["VentasCon"])-1)+1:"" 
                
            '
        )
	),
)); */?>



</div>

<?php
if(isset($eventoId,$funcionesId) and $eventoId>0):
$this->widget('application.extensions.EExcelView', array(
 'dataProvider'=> $model->getInternet($eventoId,$funcionesId,$_POST["pv"]),
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
     array(            
       'header'=>'Impresiones',
       'value'=>'reimpresiones($data["VentasCon"])',
       )

     )
));
?>
<table style="width: 100%;">
    <tr>
        <td style="text-align: left;">
        <button class="btn btn-success" id="imprimir-boletos-no-impresos">
            <i class="icon-print icon-white"></i>&nbsp;Imprimir Boletos NO Impresos
        </button>
        </td>
        <td style="text-align: right;">
        <button class="btn btn-success" id="imprimir-todos-boletos" >
            <i class="icon-print icon-white"></i>&nbsp;Imprimir TODOS los Boletos
        </button>
        </td>
    </tr>
</table>
<br />
<style>
.formato_seleccionado{
    border: 2px blue solid;
}
#formatos input[type=radio]{
    display: none;
}
.modal{
    width:420px ;
}
</style>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Formato de impresi&oacute;n</h3>
  </div>
  <div class="modal-body">
    <input type="hidden" id="select_tipo_impresion" value="0" />
    <div id="formatos">
        <?php
        
            $img_formato = Formatosimpresion::model()->findAll("FormatoSta='ALTA'");
            $selected_formato = !empty($region)?$region:"1";
            foreach($img_formato as $key => $formato):
                echo CHtml::radioButton('impresion',($formato->FormatoId==$selected_formato?true:false),array('value'=>$formato->FormatoId,'id'=>"formato_".$formato->FormatoId,'style'=>'margin:0 5px;'));
                ?>
                    <label style="display: inline-block;" for="formato_<?php echo $formato->FormatoId;?>"><img id="imagen_formato<?php echo $formato->FormatoId; ?>" class="<?php echo $formato->FormatoId==$selected_formato?"formato_seleccionado":""; ?>" src="https://taquillacero.com/imagesbd/<?php echo $formato->FormatoIma;?>" style="width: 180px;height: 350px;"  /></label>
                <?php
                
            endforeach;
        ?> 
    </div> 
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" id="imprimir_boletos">OK</button>
  </div>
</div>


<?php endif; ?>
</div> 
</div>
<?php
//print_r($dataProvider->getData());
if(isset($dataProvider) and !is_null($dataProvider) ):
		$datos = $dataProvider->getData();
echo "Se muestran ".count($dataProvider->getData())." resultados(s)" ;
?>

    <table class="items table table-condensed table-striped table-hover">
        <thead>
        <th>Función</th>
        <th>Punto venta</th>
        <th>Ventas Fecha y Hora</th>
        <th>Zonas</th>
        <th>Filas</th>
        <th>Lug</th>
        <th>Referencia</th>
        <th>Clientes Email</th>
        <th>Reimp</th>
        </thead>
        <tbody>
        <?php
        foreach($dataProvider->getData() as $key => $data):
        ?>
        <tr class="<?php echo ($key%2)==0?'odd':"even"; ?>">
            <td><?php echo $data['fnc']; ?></td>
            <td><?php echo $data['PuntosventaNom']; ?></td>
            <td><?php echo $data['VentasFecHor']; ?></td>
            <td><?php echo $data['ZonasAli']; ?></td>
            <td><?php echo $data['FilasAli']; ?></td>
            <td><?php echo $data['LugaresLug']; ?></td>
            <td><?php echo $data['VentasNumRef']; ?></td>
            <td><?php echo $data['email'];//.$data['VentasCon']; ?></td>
            <td>
            <?php 
                $string = $data['VentasCon'];

                if($string!=""):
                    $len = strlen($string);
                    $num = substr($string ,$len -2);
                    if(is_numeric($num)):
                        echo $num + 1;
                    else:
                        $num = substr($string ,$len -1);
                        echo $num + 1;
                    endif;
                else:
                    echo "0";
                endif;
            ?>
            </td>
        </tr>
        <?php
        endforeach;
        ?>
       
        </tbody>    
    </table>
<?php

?>  
<table style="width: 100%;">
    <tr>
        <td style="text-align: left;">
        <button class="btn btn-success" id="imprimir-boletos-no-impresos">
            <i class="icon-print icon-white"></i>&nbsp;Imprimir Boletos NO Impresos
        </button>
        </td>
        <td style="text-align: right;">
        <button class="btn btn-success" id="imprimir-todos-boletos" >
            <i class="icon-print icon-white"></i>&nbsp;Imprimir TODOS los Boletos
        </button>
        </td>
    </tr>
</table>
<br />
<div id="formatos">
<?php

    $img_formato = Formatosimpresion::model()->findAll("FormatoSta='ALTA'");
    $selected_formato = !empty($region)?$region:"1";
    foreach($img_formato as $key => $formato):
        echo CHtml::radioButton('impresion',($formato->FormatoId==$selected_formato?true:false),array('value'=>$formato->FormatoId,'id'=>"formato_".$formato->FormatoId,'style'=>'margin:0 5px;'));
        ?>
            <label style="display: inline-block;"  for="formato_<?php echo $formato->FormatoId;?>"><img id="imagen_formato<?php echo $formato->FormatoId; ?>" class="<?php echo $formato->FormatoId==$selected_formato?"formato_seleccionado":""; ?>" id="dfgggg" src="https://taquillacero.com/imagesbd/<?php echo $formato->FormatoIma;?>" style="width: 75px;height: 160px;"  /></label>
        <?php
        
    endforeach;
?> 
</div> 
<?php
elseif(!empty($itemselected)):
    echo "No hay informacion para Ventas en Web y Call Center";
endif;
?>

 
<div id="wrapper" style="display: none;"><div class="area_impresion"></div></div>
<style type="text/css" media="print">
@media print {
#parte1 {display:none;}
#parte2 {display:none;}
.controles {display:none;}
#footer {display:none;}
.container-fluid{display:none;}
}
</style>
<script>
$.ajax({
            type: "POST",
            url:'<?php echo $this->createUrl('funciones/cargarFunciones') ?>',
            data:"evento_id="+<?php echo @$_POST["evento_id"]; ?>,
            success:function(data){
                $("#Ventaslevel1_funcion").html(data);
                
            }
            
        });
$("#formatos input[type=radio]").click(function(){
    console.log(this.value);
    $("#formatos img").removeClass("formato_seleccionado");
    $("#formatos img#imagen_formato"+this.value).addClass("formato_seleccionado");
    $.post( '<?php echo $this->createUrl('reportes/ActualizarRegion') ?>', { region_id: this.value});
});        
$("#imprimir_boletos").click(function(){
    $('#myModal').modal('hide');
    var EventoId  = $("#evento_id option:selected").val();
    var formatoId = $("#formatos input[type=radio]:checked").val();
    var FuncionId  = $("#Ventaslevel1_funcion option:selected").val();
    var pv  = $("#pv option:selected").val();
    var tipo = $("#select_tipo_impresion").val();
        if(tipo=="todos"){
            $.ajax({
                type: "POST",
                url:'<?php echo $this->createUrl('reportes/ImpresionBoletosAjax') ?>',
                data:"formatoId="+formatoId+"&tipo_impresion=todos"+"&EventoId="+EventoId+"&FuncionId="+FuncionId+"&pv="+pv,
                success:function(data){
                    $(".area_impresion").html(data);
                    imprSelec('wrapper');
                }
                
            });
        }else{
            $.ajax({
                type: "POST",
                url:'<?php echo $this->createUrl('reportes/ImpresionBoletosAjax') ?>',
                data:"formatoId="+formatoId+"&tipo_impresion=no_impresos"+"&EventoId="+EventoId+"&FuncionId="+FuncionId+"&pv="+pv,
                success:function(data){
                    $(".area_impresion").html(data);
                    imprSelec('wrapper');
                }
                
            });
        }
    
});        
$("#imprimir-boletos-no-impresos").click(function(){
    var EventoId  = $("#evento_id option:selected").val();
    var FuncionId  = $("#Ventaslevel1_funcion option:selected").val();
    if(EventoId==""){
        alert("Necesitas seleccionar un Evento");
    }else if(FuncionId==""){
        alert("Necesitas seleccionar una Funcion");
    }else{
        $("#select_tipo_impresion").val("no_impresos");
        $('#myModal').modal('show'); 
    }
});
$("#imprimir-todos-boletos").click(function(){
    var EventoId  = $("#evento_id option:selected").val();
    var FuncionId  = $("#Ventaslevel1_funcion option:selected").val();
    if(EventoId==""){
        alert("Necesitas seleccionar un Evento");
    }else if(FuncionId==""){
        alert("Necesitas seleccionar una Funcion");
    }else{
        $("#select_tipo_impresion").val("todos");
        $('#myModal').modal('show'); 
    }  
});
function imprSelec(nombre){
      
      var ficha = document.getElementById(nombre);
      var ventimp = window.open('', 'popimpr');
      ventimp.document.write( ficha.innerHTML );
      ventimp.document.close();
      ventimp.print( );
      ventimp.close();
} 
</script>
<?php
function reimpresiones($string = ""){
            if($string!=""):
                    $len = strlen($string);
                    $num = substr($string ,$len -2);
                    if(is_numeric($num)):
                        echo $num + 1;
                    else:
                        $num = substr($string ,$len -1);
                        echo $num + 1;
                    endif;
                else:
                    echo "0";
                endif;
}
?>
