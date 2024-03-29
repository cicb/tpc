<div class='controles'>

<h2>Ventas Web Y CallCenter</h2>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form-ventaslevel1',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<?php 
        $this->widget( 'ext.EChosen.EChosen', array(
            'target' => '.chosen',
      ));
    ?>
    
<?php 
$models = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order' => 'EventoNom'));
$list = CHtml::listData($models, 'EventoId', 'EventoNom');
// print_r($dataProvider->getData());
?>
<style>
#pvs{
   visibility: hidden; 
}
</style>
<div class="row">
<?php

//echo CHtml::label('Punto de Venta','pv', array('style'=>'width:90px; display:inline-table;'));
//echo CHtml::dropDownList('pv',@$_POST["pv"],array('101'=>'Web','102'=>'Call Center'));
?>
</div>
<div class="row" >
    <input id="pvweb" type="radio" name="pv" <?php echo @$_POST["pv"]=='101'?'checked="checked"':''; ?>   value="101"/><label style="display: inline-block;width: 100px;text-align: left;" for="pvweb">Web</label>
    <input id="pvcallcenter" type="radio" name="pv" <?php echo @$_POST["pv"]=='102'?'checked="checked"':''; ?> value="102"/> <label style="display: inline-block;width: 100px;text-align: left;" for="pvcallcenter">Call Center</label>
</div>
<br />
<div class="row">
<?php
$funcionId = @$_POST["Ventaslevel1"]["funcion"];
echo CHtml::label('Evento','evento_id', array('style'=>'width:200px; display:inline-table;'));
$modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
$list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
            echo CHtml::dropDownList('evento_id',@$_POST['evento_id'],$list,
              array(
                'class'=>'chosen span3',
                'ajax' => array(
                  'type' => 'POST',
                  //'data' => 'FuncionId='.@$_POST['Ventaslevel1']['funcion'],
                  'url' => CController::createUrl('funciones/cargarFunciones'),
                  'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
                  'complete'   => "function() { 
                    $('#fspin').removeClass('fa fa-spinner fa-spin');
                    var data = 0$funcionId ;
                    var child=0;
                    var num_elem = $('#Ventaslevel1_funcion option').length;
                    if(data==0){ child=2;}
                    else{child= data+1;}
                    $('#Ventaslevel1_funcion option:nth-child('+child+')').attr('selected', 'selected');}
                    ",
                  'update' => '#Ventaslevel1_funcion',
                  ),'prompt' => 'Seleccione un Evento...','style'=>''
                ));
?>
	<span id="fspin" class="fa"></span>
	</div>

	<div class="row">
    <?php
    echo CHtml::label('Función','Ventaslevel1_funcion', array('style'=>'width:200px; display:inline-table;'));
    echo CHtml::dropDownList('Ventaslevel1[funcion]','',array(),array('class'=>'span3'));
    ?>
	</div>
    <div class="row">
    <?php
	   $busqueda = @$_POST["busqueda"];
    ?>
    <?php echo CHtml::label('Búsqueda (correo, referencia, TC)','', array('style'=>'width:200px; display:inline-table;'));?>
    <?php echo CHtml::textField('busqueda',$busqueda!=""?$busqueda:'',array('class'=>'span3','placeholder'=>'correo, referencia, TC'))?>
    </div>
	<div class='row'>
    <?php echo CHtml::hiddenField('grid_mode', 'view'); ?>                                                                      
    <?php echo CHtml::hiddenField('funcion_id', '<?php @echo $_POST["Ventaslevel1"]["funcion"]; ?>'); ?>                                                                      
    <?php echo $form->error($model,'evento_id'); ?>
	</div>
    <div class="row">
        <input id="" type="checkbox" name="verNoImpresos" <?php 
        echo isset($_POST["verNoImpresos"])?'checked="checked"':'';
         ?> value="1"/>
         <label style="display: inline-block;width: 200px;text-align: left;" for="pvcallcenter">Ver Boletos No Impresos</label>
    </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Exportar',array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ; ?>
         <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary','onclick'=>'$("#grid_mode").val("show");')); ?>
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
 'dataProvider'=> $model->getVendidosPor($eventoId,$funcionesId,@$_POST["pv"],@$_POST["verNoImpresos"],@$_POST["busqueda"]),
 'grid_mode'=>$grid_mode,
 'htmlOptions'=>array('class'=>'principal'),
 'type'=>'condensed',

 'columns'=>array(  
     array(
          'class'          => 'CCheckBoxColumn',
          'header'         => 'Selección',
          'name'           => 'check_boleto[]',
          'value'          => '$data["VentasNumRef"]',
          'selectableRows' => 2,
          ),
     array(            
       'header'=>'Referencia',
       'value'=>'$data["VentasNumRef"]',
       ),       
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
            <i class="icon-repeat icon-white"></i>&nbsp;Generar Boletos NO Impresos
        </button>
        </td>
        <td style="text-align: center;">
        <button class="btn btn-success" id="imprimir-boletos-referencia">
            <i class="icon-check icon-white"></i>&nbsp;Generar Boletos Seleccionados X Referencia
        </button>
        </td>
        <td style="text-align: right;">
        <button class="btn btn-success" id="imprimir-todos-boletos" >
            <i class="icon-repeat icon-white"></i>&nbsp;Generar TODOS los Boletos
        </button>
        </td>
    </tr>
</table>
<br />
<script>
var ref = "";
$("table tr td input[type=checkbox]").each(function(index){
    
    if(ref == this.value){
        $(this).remove();
    }else{
        ref = this.value;
    }
});
</script>
<style>
.formato_seleccionado{
    border: 2px blue solid;
}
#formatos input[type=radio]{
    display: none;
}
.modal{
    width:600px ;
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
                    <label style="display: inline-block;" for="formato_<?php echo $formato->FormatoId;?>"><img id="imagen_formato<?php echo $formato->FormatoId; ?>" class="<?php echo $formato->FormatoId==$selected_formato?"formato_seleccionado":""; ?>" src="<?php echo Yii::app()->request->baseUrl."/images/".$formato->FormatoIma;?>" style="width: 180px;height: 350px;"  /></label>
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
            <i class="icon-repeat icon-white"></i>&nbsp;Generar Boletos NO Impresos
        </button>
        </td>
        <td style="text-align: right;">
        <button class="btn btn-success" id="imprimir-todos-boletos" >
            <i class="icon-repeat icon-white"></i>&nbsp;Generar TODOS los Boletos
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
<button id="print_pdf" style="display: none;" class="btn btn-warning"><i class="icon-print icon-white"></i>&nbsp;Inprimir pdf</button>
<div id="wrapper" style="width: 90mm;border: black solid 1px;display: none;"><div class="area_impresion"></div></div>
<style>
.loading{
    position: fixed;
    border: none;
    width: 300px;
    height: 320px;
    top: 45%;
    left: 35%;
    background: url('<?php echo  Yii::app ()->baseUrl . '/images/loading.gif'; ?>') no-repeat center ;
    text-align: center;
    color: blue;
    font-size: 20pt;
    font-weight: bold;
}
</style>
<script>
$("#print_pdf").click(function(){
    imprSelec('wrapper');
});
$("#formatos input[type=radio]").click(function(){
    $("#formatos img").removeClass("formato_seleccionado");
    $("#formatos img#imagen_formato"+this.value).addClass("formato_seleccionado");
    $.ajax({
        type:'POST',
        data:{ region_id: this.value},
        url:'<?php echo $this->createUrl('reportes/ActualizarRegion') ?>',
        beforeSend:function(){
            $("#imprimir_boletos").hide();
        },
        success:function(){
            $("#imprimir_boletos").show();
        }
    });
    
});        
$("#imprimir_boletos").click(function(){
    $('#myModal').modal('hide');
    var refs = "";
    var EventoId  = $("#evento_id option:selected").val();
    var formatoId = $("#formatos input[type=radio]:checked").val();
    var FuncionId  = $("#Ventaslevel1_funcion option:selected").val();
    var pvs  = $("#pvs option:checked").val();
    console.log(pvs);
    var tipo = $("#select_tipo_impresion").val();
        if(tipo=="todos"){
            $.ajax({
                type: "POST",
                //dataType:'json',
                beforeSend:function(){
                    $("body").append("<div class='loading'>Generando Boletos</div>");
                    $("#print_pdf").hide();
                },
                error: function(objeto, quepaso, otroobj){
                    $(".loading").remove();
                    alert("Ha ocurrido un error por favor trate de nuevo: "+objeto+"-"+quepaso);
                },
                url:'<?php echo $this->createUrl('reportes/ImpresionBoletosAjax2') ?>',
                data:{'formatoId':formatoId,'tipo_impresion':'todos','EventoId':EventoId,'FuncionId':FuncionId,'pv':pvs},
                success:function(data){
                    //$(".area_impresion").html(data);
                    $("#wrapper").html(data);
                    $(".loading").remove();
                    $("#print_pdf").show();
                    /*try{
                        boletos.close();
                    }catch(err){}
                    if(data.ok=="si"){
                        window.open('<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Yii::app ()->baseUrl . '/doctos/boletos.pdf'?>', 'boletos', 'width=960,height=600');
                        
                    }else{
                        alert("No hay boletos para imprimir");
                     }
                    //imprSelec('wrapper');*/
                }
                
            });
        }else if(tipo=="referencia"){
            
            $("table tr td input[type=checkbox]:checked").each(function(index){
                refs = refs + "'" + this.value + "'" + ",";
                
            });
            
            if(refs == ""){
                alert("Necesitas seleccionar al menos una Referencia");
                return false;
            }
            
            refs = refs.slice(0,-1);
            $.ajax({
                type: "POST",
                //dataType:'json',
                beforeSend:function(){
                    $("body").append("<div class='loading'>Generando Boletos</div>");
                    $("#print_pdf").hide();
                },
                error: function(objeto, quepaso, otroobj){
                    $(".loading").remove();
                    alert("Ha ocurrido un error por favor trate de nuevo: "+objeto+"-"+quepaso);
                },
                url:'<?php echo $this->createUrl('reportes/ImpresionBoletosAjax2') ?>',
                data:{'formatoId':formatoId,'tipo_impresion':'referencia','EventoId':EventoId,'FuncionId':FuncionId,'pv':pvs,'refs':refs},
                success:function(data){
                    //$(".area_impresion").html(data);
                    $("#wrapper").html(data);
                    $(".loading").remove();
                    $("#print_pdf").show();
                    /*try{
                        boletos.close();
                    }catch(err){}
                    if(data.ok=="si"){
                        window.open('<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Yii::app ()->baseUrl . '/doctos/boletos.pdf'?>', 'boletos', 'width=960,height=600');
                        
                    }else{
                        alert("No hay boletos para imprimir");
                     }
                    //imprSelec('wrapper');*/
                }
                
            });
        }else{
            $.ajax({
                type: "POST",
                //dataType:'json',
                beforeSend:function(){
                    $("body").append("<div class='loading'>Generando pdf</div>");
                    $("#print_pdf").hide();
                },
                error: function(objeto, quepaso, otroobj){
                    $(".loading").remove();
                    alert("Ha ocurrido un error por favor trate de nuevo: "+objeto+"-"+quepaso);
                },
                url:'<?php echo $this->createUrl('reportes/ImpresionBoletosAjax2') ?>',
                data:{'formatoId':formatoId,'tipo_impresion':'no_impresos','EventoId':EventoId,'FuncionId':FuncionId,'pv':pvs},
                success:function(data){
                    //$(".area_impresion").html(data);
                    if(data==""){
                        $(".loading").remove();
                        $("#print_pdf").hide();
                        alert('No hay boletos para generar');
                    }else{
                        $("#wrapper").html(data);
                        $(".loading").remove();
                        $("#print_pdf").show();
                    }
                    
                    /*try{
                        boletos.close();
                    }catch(err){}
                     console.log(data);
                     if(data.ok=="si"){
                        window.open('<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].Yii::app ()->baseUrl . '/doctos/boletos.pdf'?>', 'boletos', 'width=960,height=600');
                        
                     }else{
                        alert("No hay boletos NO impresos para imprimir");
                     }
                                          //imprSelec('wrapper');
                    //imprSelec('wrapper');*/
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
$("#imprimir-boletos-referencia").click(function(){
    var EventoId  = $("#evento_id option:selected").val();
    var FuncionId  = $("#Ventaslevel1_funcion option:selected").val();
    if(EventoId==""){
        alert("Necesitas seleccionar un Evento");
    }else if(FuncionId==""){
        alert("Necesitas seleccionar una Funcion");
    }else{
        $("#select_tipo_impresion").val("referencia");
        $('#myModal').modal('show'); 
    }  
});
function imprSelec(nombre){
      
      var ficha = document.getElementById(nombre);
      var ventimp = window.open('', 'popimpr');
      ventimp.document.write( ficha.innerHTML );
      ventimp.document.close();
      ventimp.print();
      ventimp.close();
} 
try{
   var resultados = $(".summary").html();
    $(".summary").html(resultados.replace("results","resultados")); 
}catch(err){
    
}
try{
    var empty = $("span.empty").html();
    $(".empty").html(empty.replace("No results found.","No hay resultados."));
}catch(err){
    
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
echo CHtml::dropDownList('pvs',@$_POST["pv"],array('101'=>'Web','102'=>'Call Center'));
  //Barcode::getCodigo(385146947825);
  //echo 123456789123%10;
  //Barcode::getCodigo(5689567891234);
  /*$im = imagecreatetruecolor(300, 300);
  $black = ImageColorAllocate($im,0x00,0x00,0x00);
  $white = ImageColorAllocate($im,0xff,0xff,0xff);
  imagefilledrectangle($im, 0, 0, 300, 300, $white);
  
  $data = Barcode::gd($im, $black, 125, 125, 0, 'ean13',   array('code'=>1234569871234), 2, 50);
  ob_start (); 
  imagepng($im);
  $image_data = ob_get_contents (); 
  ob_end_clean (); 
  imagedestroy($im);	
  echo '<img src="data:image/png;base64,'.base64_encode ($image_data).'" />';*/
  
  /*header('Content-type: image/gif');
  imagegif($im);
  imagedestroy($im);*/

Yii::app()->clientScript->registerScript('carga',"$('#evento_id').change();",CClientScript::POS_LOAD);
//echo  Yii::app()->user->id;
/*$r = new ReportesFlex;
$data =  $r->getEventosAsignados();
foreach($data as $key => $evento):
echo $evento->EventoNom."<BR/>";
endforeach
//print_r($r->getEventosAsignados());*/
?>