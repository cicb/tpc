<!--Crear laz zonas interactivas del Mapa Grande-->
<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$cs = Yii::app()->getClientScript();
    //$cs->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');        
    //$cs->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js', CClientScript::POS_READY);
    
    //$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.qtip.js', CClientScript::POS_HEAD);
    //$cs->registerScriptFile(Yii::app()->baseUrl . '/css/qtip.css');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.maphilight.js', CClientScript::POS_HEAD);
    $cs->registerScript('maplight',
            "$(function() {
		$('.map').maphilight(
                    {fill: true,
                    fillColor: '000000',
                    fillOpacity: 0.5,
                    stroke: true,
                    strokeColor: 'ff0000',
                    strokeOpacity: 1,
                    strokeWidth: 1,
                    fade: true,
                    alwaysOn: false,
                    neverOn: false,
                    groupBy: false,
                    wrapClass: true,
                    shadow: false,
                    shadowX: 0,
                    shadowY: 0,
                    shadowRadius: 6,
                    shadowColor: '000000',
                    shadowOpacity: 0.8,
                    shadowPosition: 'outside',
                    shadowFrom: false}
                );
});", CClientScript::POS_HEAD);
?>
<input type="hidden" id="id_distribucion_nueva" value="<?php echo $id_distribucion_nueva;?>" />
<map name="zonasGrande">
<?php foreach ($funcion->getZonasInteractivasMapaGrande() as $subzona) : ?>
    <?php $pathUrl = '';  ?>

    <area shape="poly" data-delete="0" id="<?php echo str_replace(",","",$subzona->getCoordenadasComoCadena()); ?>" coords="<?php echo $subzona->getCoordenadasComoCadena(); ?>" href="#" data-zonaId="<?php echo $subzona->ZonasId ?>" data-subzonaid="<?php echo $subzona->SubzonaId ?>" alt="" title="<?php echo $subzona->zona->ZonasAli?>"/>
<?php endforeach; ?>
</map>

<div class="controles">

     <h2>  Configurador De Accesos </h2>
     
     <?php
     $form=$this->beginWidget('CActiveForm', array(
           'id'=>'usuarios-form',
           //'action'=>$this->createUrl('/asiento/main'),
           //'htmlOptions'=>array('target'=>'gridFrame'),
           'enableAjaxValidation'=>false,
           'clientOptions' => array('validateOnSubmit' => false)
     ));
     ?>
<style>
ul.puertas{
    list-style: none;
    margin: 0;
}
ul.puertas li a{
    text-align: left;
    display: block;
    text-decoration: none;
    color: black;
}
ul.puertas li a:hover{
    color: white;
    background: blue;
}
.seleccionado{
    color: white !important;
    background: blue;
}
</style>
     <div class='row' style="margin-left:0px">
	      <div class='span3'>
	           <div class="row" id="puerta">
	                <?php echo CHtml::label('Puertas','', array('style'=>'display:inline-table;')); ?>
               </div>
               <select class="puertas" multiple="" size="20" >
                    <?php  foreach($puertas as $key => $puerta): ?>
                    <option value="<?php echo $puerta['idCatPuerta'];?>" id="puerta" data_id_puerta='<?php echo $puerta['idCatPuerta'];?>' data-eventoId='<?php echo $_GET['EventoId'];?>' data-funcionId='<?php echo $_GET['funciones'] ?>' data-distribucionId='<?php echo $id_distribucion_nueva;?>' >
                             <?php echo $puerta['CatPuertaNom']; ?>
                    </option>    
                     <?php endforeach; ?>
               </select>
               <div class="row" id="agregar_puerta">
                    <?php echo CHtml::button('+ Agregar Puerta',array('class'=>'btn btn-primary','id'=>'agregar_puerta')); ?>
               </div>
               <script>
                   $("select.puertas").change(function(){
                        var funciones = '<?php echo $_GET['funciones'];?>';
                        $.ajax({
                            url:'<?php echo Yii::app()->createUrl('evento/GetCoordPuerta'); ?>',
                            dataType:'json',
                            beforeSend:function(){
                                $("#loading").show();    
                                },
                            data:'id_distribucion=<?php echo $id_distribucion_nueva ?>&id_puerta='+this.value+'&id_evento=<?php echo $_GET['EventoId'];?>&funciones='+funciones.split(","),
                            success:function(data){
                                $("div").remove(".line");
                                 $("#loading").hide();
                                 $("map area").each(function(index){
                                    $(this).attr('data-delete','0');
                                 });
                                function createLine(x1,y1, x2,y2,id){
                                	var length = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
                                    var angle  = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
                                    var transform = 'rotate('+angle+'deg)';
                                    
                                    //console.log("linex:"+x1+"liney:"+y1);
                                		var line = $('<div id="'+id+'">')
                                			.appendTo('#content-img')
                                			.addClass('line')
                                			.css({
                                			  'position': 'absolute',
                                			  '-webkit-transform':  transform,
                                			  '-moz-transform':     transform,
                                			  'transform':          transform,
                                              'left':               parseInt(x1),
                                              'top' :               parseInt(y1)
                                			})
                                			.width(length);
                                		return line;
                                	}
                                                                /*$("map area").each(function(){
                                    $(this).attr('data-delete','0');
                                });*/
                                $.each(data,function(index,obj){
                                    last_x = 0;
                                    last_y = 0;
                                    var id = obj.id;
                                    
                                    $("map area#"+id).attr('data-delete','1');
                                    var coordenadas = obj.coords.split(",");
                                    if(typeof coordenadas[2]!="undefined"){
                                        createLine(coordenadas[0],coordenadas[1], coordenadas[2],coordenadas[3],id);
                                        last_x = coordenadas[2];
                                        last_y = coordenadas[3];
                                    }
                                    if(typeof coordenadas[4]!="undefined"){
                                        createLine(coordenadas[2],coordenadas[3], coordenadas[4],coordenadas[5],id);
                                        last_x = coordenadas[4];
                                        last_y = coordenadas[5];
                                    }
                                    if(typeof coordenadas[6]!="undefined"){
                                        createLine(coordenadas[4],coordenadas[5], coordenadas[6],coordenadas[7],id);
                                        last_x = coordenadas[6];
                                        last_y = coordenadas[7];
                                    }
                                    if(typeof coordenadas[8]!="undefined"){
                                        createLine(coordenadas[6],coordenadas[7], coordenadas[8],coordenadas[9],id);
                                        last_x = coordenadas[8];
                                        last_y = coordenadas[9];
                                        
                                    }
                                    if(typeof coordenadas[10]!="undefined"){
                                        createLine(coordenadas[8],coordenadas[9], coordenadas[10],coordenadas[11],id);
                                        last_x = coordenadas[10];
                                        last_y = coordenadas[11];
                                    }
                                    if(typeof coordenadas[12]!="undefined"){
                                        createLine(coordenadas[10],coordenadas[11], coordenadas[12],coordenadas[13],id);
                                        last_x = coordenadas[12];
                                        last_y = coordenadas[13];
                                    }
                                    if(typeof coordenadas[14]!="undefined"){
                                        createLine(coordenadas[12],coordenadas[13], coordenadas[14],coordenadas[15],id);
                                        last_x = coordenadas[14];
                                        last_y = coordenadas[15];
                                    }
                                    if(typeof coordenadas[16]!="undefined"){
                                        createLine(coordenadas[14],coordenadas[15], coordenadas[16],coordenadas[17],id);
                                        last_x = coordenadas[16];
                                        last_y = coordenadas[17];
                                    }
                                    if(typeof coordenadas[18]!="undefined"){
                                        createLine(coordenadas[16],coordenadas[17], coordenadas[18],coordenadas[19],id);
                                        last_x = coordenadas[18];
                                        last_y = coordenadas[19];
                                    }
                                    if(typeof coordenadas[20]!="undefined"){
                                        createLine(coordenadas[18],coordenadas[19], coordenadas[20],coordenadas[21],id);
                                        last_x = coordenadas[20];
                                        last_y = coordenadas[21];
                                    }
                                    if(typeof coordenadas[22]!="undefined"){
                                        createLine(coordenadas[20],coordenadas[21], coordenadas[22],coordenadas[23],id);
                                        last_x = coordenadas[22];
                                        last_y = coordenadas[23];
                                    }
                                    if(typeof coordenadas[24]!="undefined"){
                                        createLine(coordenadas[22],coordenadas[23], coordenadas[24],coordenadas[25],id);
                                        last_x = coordenadas[24];
                                        last_y = coordenadas[25];
                                    }
                                    if(typeof coordenadas[26]!="undefined"){
                                        createLine(coordenadas[24],coordenadas[25], coordenadas[26],coordenadas[27],id);
                                        last_x = coordenadas[26];
                                        last_y = coordenadas[27];
                                    }
                                    if(typeof coordenadas[0]!="undefined"){
                                        createLine(last_x,last_y, coordenadas[0],coordenadas[1],id);
                                    }
                                    
                                });
                                    
                            }
                        });
                        
                    })
                    $("#agregar_puerta").click(function(event){
                        var nombre_puerta = prompt("Escriba el nombre de la Nueva Puerta");
                        if(nombre_puerta==""){    
                        }else if(nombre_puerta == 'null'){
                        }else if(nombre_puerta == null){
                        }else{
                            $.ajax({
                                url:'<?php echo Yii::app()->createUrl('evento/PuertaNueva'); ?>',
                                dataType:'json',
                                beforeSend:function(){
                                     $("#loading").show();
                                },
                                data:'id_distribucion=<?php echo $id_distribucion_nueva ?>&nombre_puerta='+nombre_puerta,
                                success:function(data){
                                    $("#loading").hide();
                                    if(data.ok=="0")
                                    alert("El Nombre de la puerta ya existe, por favor trate con otro");
                                    else{
                                        $("body").attr('onbeforeunload','return cambios();');
                                        $("#boton_guardar").show();
                                        $("select.puertas").append("<option value='"+data.id_puerta+"' id='puerta'  data_id_puerta='"+data.id_puerta+"' data-eventoid='"+<?php echo $_GET['EventoId'];?>+"' data-funcionid='"+<?php echo "0";?>+"' data-distribucionid='"+<?php echo $id_distribucion_nueva;?>+"' class=''>"+nombre_puerta+"</option>");
                                    }
                                    
                                }
                            });  
                        }
                    });
               </script>
          </div>
          
          <div class="span9">
               <div id="content-img" style="position: relative;text-align: left !important;">
                    <?php
                         $img = $funcion->getForoGrande();
                         if ($img == '') {
                            echo 'Aún no existe imagen Grande del Foro.';
                         }
                         else{
                            echo CHtml::image($funcion->getForoGrande(), '', array('class'=>'map','id'=>'mapa_grande', 'usemap'=>'#zonasGrande'));
                         }
                    ?>
               </div>
          </div>
     </div>
<style>
.resumen_desplegable{
    display: block;
    background-color: #0080FF;
    color: white;
    text-decoration: none;
}
.resumen_desplegable:hover{
    color: white;
    text-decoration: none;
}
</style>

     <div class='row' style="margin-left:0;border: black 1px solid;"> 
          <a href="#" class="resumen_desplegable" id="resumen_desplegable">Resumen <i class="icon-white icon-chevron-down"></i></a> 
          <div class="resumen" id="resumen" style="display: none;">
          <table id='tabla_resumen' border='0'>
           <?php 
           foreach($resumen_distribucion as $key => $puerta):
           ?>
                    <tr style='border-bottom:1px solid gray;'>
                        <td style='max-width:300px;min-width:100px;'>
                            <?php echo ($puerta['CatPuertaNom']); ?>
                        </td>
                        <td>
                            <table border='0'>
                                <?php
                                  $valuez = $model->getZonas($puerta['idCatPuerta'],$id_distribucion_nueva,$_GET['EventoId']);
                                  foreach($valuez as $key => $zonas):
                                 ?>               
                                 <tr style=''>
                                    <td style='max-width:300px;min-width:100px;border:1px solid black;'>
                                        <?php echo $zonas['ZonasAli'];?>
                                    </td>
                                    <td>
                                        <table border='1'>
                                        <?php
                                        $values = $model->getSubZonas($_GET['EventoId'],$zonas['ZonasId'],$id_distribucion_nueva,$puerta['idCatPuerta']);
                                        foreach($values as $key => $subzonas):
                                        ?>
                                          <tr>
                                            <td style='max-width:300px;min-width:100px;'>
                                             <?php echo ($subzonas['SubzonaAcc']);?>
                                            </td>
                                          </tr>                    
                                        <?php endforeach;?>
                                        </table>
                                    </td>
                                    </tr>
                                    <?php endforeach;?>                       
                                                
        
                            </table>
                        </td>
                    </tr>
           <?php endforeach;?>
          </table>
          </div>
           
     </div>
<script>
$("a#resumen_desplegable").click(function(event){
    
    $("#resumen").toggle();
    return false;
});
</script>
     <div class='row' style="margin-left:0px">
          <div class='span3'>
               <div class="row" id="boton1">
                    <?php echo CHtml::button('Regresar',array('class'=>'btn btn-danger','onclick'=>'window.history.back();','id'=>'boton_regresar')); ?>
               </div>
          </div>
          <div class='span3'>
          </div>
          <div class='span4'>
               <div class="row" >
                    <?php echo CHtml::button('guardar',array('class'=>'btn btn-success','id'=>'boton_guardar','style'=>'display:none;')); ?>
                    <script>
                        $("#boton_guardar").click(function(){
                            var nombre_distribucion = prompt("Escriba el nombre de la Nueva Distribucion");
                            if(nombre_distribucion == ""){    
                            }else if(nombre_distribucion == 'null'){
                            }else if(nombre_distribucion == null){
                            }else{
                                $.ajax({
                                    url:'<?php echo Yii::app()->createUrl('funciones/Asignar'); ?>',
                                    dataType:'json',
                                    beforeSend:function(){
                                         $("#loading").show();
                                    },
                                    data:'id_distribucion=<?php echo $id_distribucion_nueva ?>&nombre_distribucion='+nombre_distribucion,
                                    success:function(data){
                                        $("#loading").hide();
                                        if(data.ok=="0")
                                        alert("El Nombre asignacion ya existe, por favor trate con otro");
                                        else{
                                            $("body").attr('onbeforeunload','');
                                            //$("#boton_guardar").show();
                                            window.location.href = '<?php echo Yii::app()->createUrl('evento/Index'); ?>';
                                        }
                                        
                                    }
                                });  
                            }
                        $.ajax({
                            url:'<?php echo $this->createUrl('funciones/Asignar'); ?>',
                            data:'EventoId='+EventoId+'&IdDistribucion='+IdDistribucion+'&Idfuncion='+funciones+'&idPuerta='+data_id_puerta,
                            success:function(data){
                                console.log(data);
                            }
                       });
                  });
               </script>
               </div>
          </div>
     </div>

    <?php $this->endWidget(); ?>
    
</div>
<script>

<?php
foreach($distribucionpl1 as $key => $distribucion):
    $coordenadas = ConfigurlMapaGrandeCoordenadas::model()->with('mapa')->findAll(array('condition'=>"mapa.EventoId=$distribucion->EventoId AND mapa.FuncionId=$distribucion->FuncionesId AND t.ZonasId=$distribucion->ZonasId AND t.SubzonaId=$distribucion->SubzonaId"));
    foreach($coordenadas as $key => $coordenada):
       $id = $coordenada->x1.$coordenada->y1.$coordenada->x2.$coordenada->y2.$coordenada->x3.$coordenada->y3.$coordenada->x4.$coordenada->y4.$coordenada->x5.$coordenada->y5.$coordenada->x6.$coordenada->y6.$coordenada->x7.$coordenada->y7.$coordenada->x8.$coordenada->y8.$coordenada->x9.$coordenada->y9.$coordenada->x10.$coordenada->y10.$coordenada->x11.$coordenada->y11.$coordenada->x12.$coordenada->y12.$coordenada->x13.$coordenada->y13.$coordenada->x14.$coordenada->y14;
       $last_x = 0;
       $last_y = 0;
       echo "$('map area#$id').attr('data-delete','1');";
       if(!empty($coordenada->x2)):
            echo "createLine($coordenada->x1,$coordenada->y1,$coordenada->x2,$coordenada->y2,'$id');";
            $last_x = $coordenada->x2;
            $last_y = $coordenada->y2;
        endif;
        if(!empty($coordenada->x3)):
            echo "createLine($coordenada->x2,$coordenada->y2,$coordenada->x3,$coordenada->y3,'$id');";
            $last_x = $coordenada->x3;
            $last_y = $coordenada->y3;
        endif;
        if(!empty($coordenada->x4)):
            echo "createLine($coordenada->x3,$coordenada->y3,$coordenada->x4,$coordenada->y4,'$id');";
            $last_x = $coordenada->x4;
            $last_y = $coordenada->y4;
        endif;
        if(!empty($coordenada->x5)):
            echo "createLine($coordenada->x4,$coordenada->y4,$coordenada->x5,$coordenada->y5,'$id');";
            $last_x = $coordenada->x5;
            $last_y = $coordenada->y5;
        endif;
        if(!empty($coordenada->x6)):
            echo "createLine($coordenada->x5,$coordenada->y5,$coordenada->x6,$coordenada->y6,'$id');";
            $last_x = $coordenada->x6;
            $last_y = $coordenada->y6;
        endif;
        if(!empty($coordenada->x7)):
            echo "createLine($coordenada->x6,$coordenada->y6,$coordenada->x7,$coordenada->y7,'$id');";
            $last_x = $coordenada->x7;
            $last_y = $coordenada->y7;
        endif;
        if(!empty($coordenada->x8)):
            echo "createLine($coordenada->x7,$coordenada->y7,$coordenada->x8,$coordenada->y8,'$id');";
            $last_x = $coordenada->x8;
            $last_y = $coordenada->y8;
        endif;
        if(!empty($coordenada->x9)):
            echo "createLine($coordenada->x8,$coordenada->y8,$coordenada->x9,$coordenada->y9,'$id');";
            $last_x = $coordenada->x9;
            $last_y = $coordenada->y9;
        endif;
        if(!empty($coordenada->x10)):
            echo "createLine($coordenada->x9,$coordenada->y9,$coordenada->x10,$coordenada->y10,'$id');";
            $last_x = $coordenada->x10;
            $last_y = $coordenada->y10;
        endif;
        if(!empty($coordenada->x11)):
            echo "createLine($coordenada->x10,$coordenada->y10,$coordenada->x11,$coordenada->y11,'$id');";
            $last_x = $coordenada->x11;
            $last_y = $coordenada->y11;
        endif;
        if(!empty($coordenada->x12)):
            echo "createLine($coordenada->x11,$coordenada->y11,$coordenada->x12,$coordenada->y12,'$id');";
            $last_x = $coordenada->x12;
            $last_y = $coordenada->y12;
        endif;
        if(!empty($coordenada->x13)):
            echo "createLine($coordenada->x12,$coordenada->y12,$coordenada->x13,$coordenada->y13,'$id');";
            $last_x = $coordenada->x13;
            $last_y = $coordenada->y13;
        endif;
        if(!empty($coordenada->x14)):
            echo "createLine($coordenada->x13,$coordenada->y13,$coordenada->x14,$coordenada->y14,'$id');";
            $last_x = $coordenada->x14;
            $last_y = $coordenada->y14;
        endif;
        if(!empty($coordenada->x1)):
            echo "createLine($last_x,$last_y,$coordenada->x1,$coordenada->y1,'$id');";
        endif;
    endforeach;
endforeach;
?>

 $("map area").click(function(event){
    var coordenadas           = $(this).attr('coords').split(",");
    var id                    = $(this).attr('id');
    var data_delete           = $(this).attr('data-delete');
    var puerta                = $("select.puertas option:selected").length;
    var id_puerta             = $("select.puertas option:selected").val();
    var id_distribucion_nueva = $("#id_distribucion_nueva").val();
    var id_evento             = '<?php echo $_GET['EventoId'];?>';
    var funciones             = '<?php echo $_GET['funciones'];?>';
    var id_zona               = $(this).attr('data-zonaid');
    var id_subzona            = $(this).attr('data-subzonaid');
    var last_x                = 0;
    var last_y                = 0;
    if(puerta<=0){
        alert("Necesitas seleccionar una puerta");
    }else if(puerta>1){
        alert("Solo puedes seleccionar una Puerta a la vez");
    }
    else if(data_delete=="0"){
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('evento/AddZona'); ?>',
            data:'id_puerta='+id_puerta+'&id_distribucion_nueva='+id_distribucion_nueva+'&id_evento='+id_evento+'&funciones='+funciones.split(",")+'&id_zona='+id_zona+'&id_subzona='+id_subzona,
            beforeSend:function(){
                $("#loading").show();
                $("#content-img").css({'visibility':'hidden'});
            },
            success:function(data){
                $("#loading").hide();
                $("body").attr('onbeforeunload','return cambios();');
                $("#boton_guardar").show();
                $("#content-img").css({'visibility':'visible'});
                console.log(data);
                if(typeof coordenadas[2]!="undefined"){
                    createLine(coordenadas[0],coordenadas[1], coordenadas[2],coordenadas[3],id);
                    last_x = coordenadas[2];
                    last_y = coordenadas[3];
                }
                if(typeof coordenadas[4]!="undefined"){
                    createLine(coordenadas[2],coordenadas[3], coordenadas[4],coordenadas[5],id);
                    last_x = coordenadas[4];
                    last_y = coordenadas[5];
                }
                if(typeof coordenadas[6]!="undefined"){
                    createLine(coordenadas[4],coordenadas[5], coordenadas[6],coordenadas[7],id);
                    last_x = coordenadas[6];
                    last_y = coordenadas[7];
                }
                if(typeof coordenadas[8]!="undefined"){
                    createLine(coordenadas[6],coordenadas[7], coordenadas[8],coordenadas[9],id);
                    last_x = coordenadas[8];
                    last_y = coordenadas[9];
                    
                }
                if(typeof coordenadas[10]!="undefined"){
                    createLine(coordenadas[8],coordenadas[9], coordenadas[10],coordenadas[11],id);
                    last_x = coordenadas[10];
                    last_y = coordenadas[11];
                }
                if(typeof coordenadas[12]!="undefined"){
                    createLine(coordenadas[10],coordenadas[11], coordenadas[12],coordenadas[13],id);
                    last_x = coordenadas[12];
                    last_y = coordenadas[13];
                }
                if(typeof coordenadas[14]!="undefined"){
                    createLine(coordenadas[12],coordenadas[13], coordenadas[14],coordenadas[15],id);
                    last_x = coordenadas[14];
                    last_y = coordenadas[15];
                }
                if(typeof coordenadas[16]!="undefined"){
                    createLine(coordenadas[14],coordenadas[15], coordenadas[16],coordenadas[17],id);
                    last_x = coordenadas[16];
                    last_y = coordenadas[17];
                }
                if(typeof coordenadas[18]!="undefined"){
                    createLine(coordenadas[16],coordenadas[17], coordenadas[18],coordenadas[19],id);
                    last_x = coordenadas[18];
                    last_y = coordenadas[19];
                }
                if(typeof coordenadas[20]!="undefined"){
                    createLine(coordenadas[18],coordenadas[19], coordenadas[20],coordenadas[21],id);
                    last_x = coordenadas[20];
                    last_y = coordenadas[21];
                }
                if(typeof coordenadas[22]!="undefined"){
                    createLine(coordenadas[20],coordenadas[21], coordenadas[22],coordenadas[23],id);
                    last_x = coordenadas[22];
                    last_y = coordenadas[23];
                }
                if(typeof coordenadas[24]!="undefined"){
                    createLine(coordenadas[22],coordenadas[23], coordenadas[24],coordenadas[25],id);
                    last_x = coordenadas[24];
                    last_y = coordenadas[25];
                }
                if(typeof coordenadas[26]!="undefined"){
                    createLine(coordenadas[24],coordenadas[25], coordenadas[26],coordenadas[27],id);
                    last_x = coordenadas[26];
                    last_y = coordenadas[27];
                }
                if(typeof coordenadas[0]!="undefined"){
                    createLine(last_x,last_y, coordenadas[0],coordenadas[1],id);
                }
                $.get('<?php echo Yii::app()->createUrl('funciones/Resumen'); ?>', {IdDistribucion: id_distribucion_nueva, EventoId:id_evento,Idfuncion:"0"}, function(respuesta){
                       $("#resumen").html(respuesta);
                    });
                                    
            }
        });
        $(this).attr('data-delete',"1");
    }else{
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('evento/DeleteZona'); ?>',
            data:'id_puerta='+id_puerta+'&id_distribucion_nueva='+id_distribucion_nueva+'&id_evento='+id_evento+'&funciones='+funciones.split(",")+'&id_zona='+id_zona+'&id_subzona='+id_subzona,
            beforeSend:function(){
                $("#loading").show();
            },
            success:function(data){
                $("#loading").hide();
                $.get('<?php echo Yii::app()->createUrl('funciones/Resumen'); ?>', {IdDistribucion: id_distribucion_nueva, EventoId:id_evento,Idfuncion:"0"}, function(respuesta){
                       $("#resumen").html(respuesta);
                    });
            }
         });       
        $("div").remove("#"+id);
        $(this).attr('data-delete',"0");
    } 
  return false;  
 });
 function createLine(x1,y1, x2,y2,id){
	var length = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
    var angle  = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
    var transform = 'rotate('+angle+'deg)';
    
    //console.log("linex:"+x1+"liney:"+y1);
		var line = $('<div id="'+id+'">')
			.appendTo('#content-img')
			.addClass('line')
			.css({
			  'position': 'absolute',
			  '-webkit-transform':  transform,
			  '-moz-transform':     transform,
			  'transform':          transform,
              'left':               parseInt(x1),
              'top' :               parseInt(y1)
			})
			.width(length);
		return line;
	}
    function cambios(){
        return "Se han hecho modificaciones si continua los perdera";
    }
</script>
<style>
/* Lines can be styled with normal css: */
  div.line{
    -webkit-transform-origin: 0 50%;
       -moz-transform-origin: 0 50%;
            transform-origin: 0 50%;
                 
    height: 5px; /* Line width of 3 */
    background: green; /* Black fill */
    opacity: 0.8;
    box-shadow: 0 0 8px #B99B7E;
    
    /* For some nice animation on the rotates: */
    -webkit-transition: -webkit-transform 1s;
       -moz-transition:    -moz-transform 1s;
            transition:         transform 1s;
  }
  
  /*div.line:hover{
    background: red;
    box-shadow: 0 0 8px red;
    opacity: 1;
  }*/
  
  div.line.active{
    background: green;
    box-shadow: 0 0 8px #666;
    opacity: 1;
  }
  .loading{
    position: fixed;
    margin-left: 40%;
    top: 200px;
    display: none;
  }
</style>

<div class="loading" id="loading">
<?php
echo CHtml::image("images/loading.gif");
?>
</div>