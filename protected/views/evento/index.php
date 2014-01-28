<?php
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $baseUrl = Yii::app()->baseUrl;
    $js = Yii::app()->getClientScript();
    $js->registerScriptFile($baseUrl.'/js/jquery.treeview.js');
    //$js->registerScriptFile($baseUrl.'/js/jquery-ui-timepicker-addon.js');
?>
<?php
        $this->widget( 'ext.EChosen.EChosen', array(
            'target' => '.chosen',
      ));
?>
<div class="controles">

    <h2>  Configurador De Accesos </h2>
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
    <?php
    $models = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order' => 'EventoNom'));
    $list = CHtml::listData($models, 'EventoId', 'EventoNom');
    // print_r($dataProvider->getData());
    ?>
    
     <div class='row' style="margin-left:20%">
    	<div class='span3'>
    	     <div class="row" id="evento">
    	          <?php
                       $fecha = date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));
    	               echo CHtml::label('Evento','', array('style'=>'width:70px; display:inline-table;'));
    	               //   $modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
                       //   $modeloEvento = Evento::model()->findAll(array('condition'=>"EventoSta='ALTA' AND EventoFecFin>='$fecha' order by EventoNom DESC"));
                       $modeloEvento = Evento::model()->findAll(array('condition'=>"EventoSta='ALTA' order by EventoNom DESC"));
                       //     $modeloEvento2 = Evento::model()->findAll(array('condition'=>"EventoSta='ALTA' order by EventoNom DESC"));
                       $eventoSelected = "'".@$_GET['EventoId']."'"==""?'':@$_GET['EventoId'];
                       $list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
                       echo CHtml::dropDownList('evento_id',$eventoSelected,Chtml::listData($modeloEvento,'EventoId','EventoNom'),array('ajax' => array(
    						'type' => 'POST',
    						'url' => CController::createUrl('funciones/cargarFuncionesDistribucion'),
    						'beforeSend' => 'function() { 
    						    $("#funciones_distribucion").hide();
                                $("#funciones_distribucion_n").hide();
                                $(".asignaciones").hide();
                                $(".asignaciones_nombre").hide();
                                $(".buttonsagrega").hide();
                                $("#distribucion_resumen").hide();
                                $(".resumen_nombre").hide();
                                $(".buttonsmodifica").hide();
                                $(".buttonsasignar").hide();
                                $("#fspin").addClass("fa fa-spinner fa-spin");
                              }',
    						'complete'   => 'function() {
    						$("#fspin").removeClass("fa fa-spinner fa-spin");
                            /*$("#funcion_id option:nth-child(2)").attr("selected", "selected");
    						//$("#funcion_id").change();*/
                            $("#funciones_distribucion").show();
                            $("#funciones_distribucion_n").show();
    						}',
    						'update' => '#funciones_distribucion',
    						),'empty'=>'--------------','style'=>'width:300px;','class'=>'chosen'));
    
    	         ?>
                 <script>
                 var eventoSelected = '<?php echo $eventoSelected?>';
                 if(eventoSelected!=""){
                    $.ajax({
                        url:'<?php echo Yii::app()->createUrl("funciones/cargarFuncionesDistribucion");?>',
                        type:'POST',
                        data:'evento_id='+eventoSelected,
                        beforeSend:function(){
                            $("#fspin").addClass("fa fa-spinner fa-spin");
                        },
                        success:function(data){
                            $("#fspin").removeClass("fa fa-spinner fa-spin");
                            $("#funciones_distribucion").html(data);
                            $("#funciones_distribucion").show();
                            $("#funciones_distribucion_n").show();
                        }
                    });
                 }
                 </script>
              </div>
     </div>
    	<div class='span5'>
    	     <div class="row">
                  <div class="row" id="">
                       <div id="funciones_distribucion_n"  style="display:none;">
                               <?php echo CHtml::label('Funciones','', array('style'=>'width:70px; display:inline-table;'));?>
                       </div>
    
                       <div id="funciones_distribucion" class="white-box" style="padding: 5px;margin-left:50px;height:200px;overflow:auto; display:none;">
                       </div>
                  </div>
             </div>
        </div>
        <script>
                var data_iddist = 0;
                var dist_foro = 0;
                var dist_foro2 = 0;
                var data_funcion_id = 0;
                $("#funciones_distribucion").click(function(){
                     var eventoId = $("#evento_id").val();
                     var funciones = new Array();
                     var nodoCheck = "";
                     $("#tabla_funciones input[type=checkbox]:checked").each(function(index, value){
                          if((this.value=="todas"))
                          {
                              if ($('#funcion_id_todas').attr('checked')) {
                                 funciones[index] = "1";
                                 $('input[name=funcion_id]').attr('checked', true);
                                 dist_foro=0;
                                 dist_foro2=0;
                                 data_funcion_id = 1;
                              }
                          }
                          else
                          {
                              dist_foro2=$(this).attr("data_foro_id");
                              if ((dist_foro!="0") && (dist_foro!=dist_foro2)) {
                                  $(this).removeAttr("checked");
                                  alert ("La funcion tiene Diferente Distribucion");
                              }
                              dist_foro = dist_foro2;
                              funciones[index] = this.value;
                              data_funcion_id=$(this).attr("data_funcion_id") }
                        nodoCheck = index;
                        console.log(index);      
                      });
                      if (data_funcion_id==0)
                          data_funcion_id = 1;
                       dist_foro=0;
                       dist_foro2=0;
                       if(funciones !="" ){
                            $.ajax({
                                      url:'<?php echo $this->createUrl('funciones/Asignaciones'); ?>',
                                      data:'EventoId='+eventoId+'&funciones='+funciones,
                                      beforeSend:function(){
                                            $(".asignaciones").hide();
                                           $(".asignaciones_nombre").hide();
                                            $(".buttonsagrega").hide();
                                            $("#distribucion_resumen").hide();
                                            $(".resumen_nombre").hide();
                                            $(".buttonsmodifica").hide();
                                            $(".buttonsasignar").hide();
                                            $("#fspin").addClass("fa fa-spinner fa-spin");
                                      },
                                      success:function(data){
                                        $("#fspin").removeClass("fa fa-spinner fa-spin");
                                           $(".asignaciones").show();
                                           $(".asignaciones_nombre").show();
                                            $(".buttonsagrega").show();
                
                                           $(".asignaciones").html(data);
                                           $("a#dist_puerta ").click(function(event){
                                                var data_evento_id = $(this).attr("data_evento_id");
                                                var data_funcion_id = $(this).attr("data_funcion_id");
                                                data_iddist = $(this).attr("data_id");
                                                var id_evento_distribucion = $(this).attr("data_evento_id");
                                                $("#id_distribucion").val(data_iddist);
                                                $("#id_evento_distribucion").val(id_evento_distribucion);
                                                $.ajax({
                                                        url:'<?php echo $this->createUrl('funciones/Resumen'); ?>',
                                                        data:'EventoId='+data_evento_id+'&IdDistribucion='+data_iddist+'&Idfuncion='+data_funcion_id,
                                                        beforeSend:function(){
                                                            $("#fspin").addClass("fa fa-spinner fa-spin");
                                                        },
                                                        success:function(data){
                                                            $("#fspin").removeClass("fa fa-spinner fa-spin");
                                                               $("#distribucion_resumen").show();
                                                               $(".resumen_nombre").show();
                                                               $(".buttonsmodifica").show();
                                                               $(".buttonsasignar").show();
                                                               $("#distribucion_resumen").html(data);
                                                               console.log(data);
                                                        }
                                                });
                                                return false;
                                           });
                                      }
                              });
                       }
                      
                });
             
        </script>
    
    </div>
    
     <div class='row' style="margin-left:20%">
    	<div class='span3' style="margin: 0; width: 300px;">
             <div id="distribucionpuerta" class="asignaciones_nombre " style="display:none;">
                       <?php echo CHtml::label('Asignaci&oacute;n de Puertas','', array('style'=>'width:150px; display:inline-table;')); ?>
             </div>
             <style>
             #tabla_funciones td{
                text-align: left !important;
             }
             #tabla_distribucionP td.distribucion_asignada{
                background-color: #FF8000;
             }
             #tabla_distribucionP td.distribucion_asignada a{
               color: white;
               font-weight: bold;
             }
             #tabla_distribucionP a{
                color: black;
                display: block;
                text-decoration: none;
             }
				.table{
						margin-bottom:1px !important;}
				td{	vertical-align:middle;
				}

             </style>
             <input type="hidden" id="id_distribucion" value="0"/>
             <input type="hidden" id="id_evento_distribucion" value="0"/>
             <div id="distribucionpuerta" class="asignaciones white-box" style="text-align:left;padding: 5px;margin-left:0px;height:200px;overflow:auto; display:none;">
                  
                  
             </div>
<br />
             <div id="botonagrega" class="buttonsagrega" style="display: none;">
                   <?php //echo CHtml::link("+",array('evento/create'),array('title'=>'','class'=>'btn','style'=>'margin-left:0px;margin-bottom: 15px;','id'=>'boton_agregar')); ?>
                   <?php echo CHtml::button('+ Nuevo',array('class'=>'btn btn-success','id'=>'boton_agregar')); ?>
             </div>
         </div>
    
         <div class='span5'>
             <div id="nombre_resumen" class="resumen_nombre" style="display:none;">
                       <?php echo CHtml::label('Resumen','', array('style'=>'width:70px; display:inline-table;')); ?>
             </div>
             <div id="distribucion_resumen" class="distribucion_resumen white-box" style="padding: 5px;margin-left:0;height:200px;overflow:auto; display:none;">
    
                  <div id="inf_resumen" style="margin-left:0;height:200px;overflow:auto;border: black solid 1px;">
    
                  </div>
             </div>
<br />
			<div class='span2'>  
				<div id="botonmodificar" class="buttonsmodifica" style="display: none;" >
					   <?php echo CHtml::button('Modificar',array('class'=>'btn btn-info','id'=>'boton_modificar')); ?>
				 </div>
			 </div>
             <div class='span2'>
                 <div id="botonasignar" class="buttonsasignar" style="display: none;">
                       <?php echo CHtml::button('Asignar',array('class'=>'btn btn-primary','id'=>'boton_asignar')); ?>
                  </div>
              </div>
         </div>
         <div class='span2'>
             
         </div>
    </div>
    <?php $this->endWidget(); ?>
    </div>
</div>
<span id="fspin" style="position: fixed;top:300px;left: 50%;" class=""></span>
                       <script>
                          $("#boton_asignar").click(function(){
                               var eventoId = $("#evento_id").val();
                               var funciones = new Array();
                               var id_distribucion = $("#id_distribucion").val();
                               var seleccion = $("#tabla_funciones input[type=checkbox]:checked").length;
                               if(seleccion<="0"){
                                    alert("Necesitas seleccionar una funcion");
                               }else{
                                   $("#tabla_funciones input[type=checkbox]:checked").each(function(index){
                                   if(this.value=="todas")
                                     funciones[index] = "0";
                                   else
                                     funciones[index] = this.value;
                                   });
                                   console.log(id_distribucion);
                                   $.ajax({
                                        url:'<?php echo $this->createUrl('funciones/AsignarDistribucion'); ?>',
                                        beforeSend:function(){
                                            $("#fspin").addClass("fa fa-spinner fa-spin");
                                        },
                                        data:'EventoId='+eventoId+'&IdDistribucion='+id_distribucion+'&Idfuncion='+funciones,
                                        success:function(data){
                                            $("#fspin").removeClass("fa fa-spinner fa-spin");
                                                alert("La asignacion se hizo correctamente");
                                            }
                                   });
                              }     
                          });
                       </script>
                       <script>
                          $("#boton_modificar").click(function(){
                               var eventoId = $("#evento_id").val();
                               var funciones = new Array();
                               var id_distribucion = $("#id_distribucion").val();
                               var id_evento_distribucion = $("#id_evento_distribucion").val();
                               var ForoMapIntId = 0;
                               var ForoId = 0;
                               var seleccion = $("#tabla_funciones input[type=checkbox]:checked").length;
                               if(seleccion<="0"){
                                    alert("Necesitas seleccionar una funcion");
                               }else{
                                   $("#tabla_funciones input[type=checkbox]:checked").each(function(index){
                                    ForoMapIntId = $(this).attr('data-mapintId');
                                    ForoId = $(this).attr('data-foroId');
                                   if(this.value=="todas")
                                     funciones[index] = "0";
                                   else
                                     funciones[index] = this.value;
                                   });
                                   window.location.href='<?php echo $this->createUrl('evento/create'); ?>'+'&EventoId='+eventoId+'&EventoDistribucionId='+id_evento_distribucion+'&funcionId=1'+'&funciones='+funciones+'&IdDistribucion='+id_distribucion+"&ForoId="+ForoId+"&ForoMapIntId="+ForoMapIntId;
                            }     
                          });
                          
                       </script>
                   <script>  
                      $("#boton_agregar").click(function(){
                           var eventoId = $("#evento_id").val();
                           var funciones = new Array();
                           var eventoId = $("#evento_id").val();
                               var funciones = new Array();
                               var id_evento_distribucion = $("#id_evento_distribucion").val();
                               var ForoMapIntId = 0;
                               var ForoId = 0;
                               var seleccion = $("#tabla_funciones input[type=checkbox]:checked").length;
                               if(seleccion<="0"){
                                    alert("Necesitas seleccionar una funcion");
                               }else{
                                   $("#tabla_funciones input[type=checkbox]:checked").each(function(index,value){
                                   if($(this).val()=="todas")
                                     funciones[index] = "0";
                                   else
                                     funciones[index] = $(this).attr("data_funcion_id");
                                   });
                                   window.location.href='<?php echo $this->createUrl('evento/create'); ?>'+'&EventoId='+eventoId+'&EventoDistribucionId=0&funcionId=1'+'&funciones='+funciones+'&IdDistribucion=0&ForoId='+ForoId+"&ForoMapIntId="+ForoMapIntId
                                }
                      });
                   </script>

