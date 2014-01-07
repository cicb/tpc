<?php
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $baseUrl = Yii::app()->baseUrl; 
    $js = Yii::app()->getClientScript();
    $js->registerScriptFile($baseUrl.'/js/jquery.treeview.js');
    //$js->registerScriptFile($baseUrl.'/css/jquery.treeview.css');
    //$js->registerScriptFile($baseUrl.'/js/chosen.jquery.min.js');
    //$js->registerScriptFile($baseUrl.'/js/jquery-ui-timepicker-addon.js');
    //$js->registerScriptFile($baseUrl.'/css/chosen.css');
    //$js->registerScriptFile($baseUrl.'/css/style.css');
/* @var $this DescuentosController */
/* @var $model Descuentos */
/* @var $form CActiveForm */
//print_r($model->isNewRecord);
?>

    <?php 
        $this->widget( 'ext.EChosen.EChosen', array(
            'target' => '.chosen',
      ));
    ?>
<!--obtencion del cupon-->
<div class="span-16">
    <strong style="margin-left: 75px;">Tipo de Descuento</strong>
    <select id="tipo">
        <option value="cupon">Cup&oacute;n</option>
        <option value="descuento">Descuento</option>
    </select>
    <a id="boton_ayuda"  class="btn btn-primary" style="float: right;margin-right: 37px;"><i class="icon-wrench icon-white"></i>&nbsp;Ayuda</a>
</div>
<br /><br />
<div class="span-16" style="margin: 0;padding-bottom: 3px; border-bottom: silver solid 1px;text-align: right;">
    <!--<i class="icon-barcode"></i>-->
    <strong>C&oacute;digo del Cup&oacute;n:</strong>
    <input id="codigo" title="" class="" data-placement='left' data-id="-1" data-tipo="cupon" name="CuponesCod" style="margin:0;height:20px;" type="text" placeholder="Cupon" />&nbsp;&nbsp;&nbsp;
    <a id="generar_cupon" data-placement='top' title=""  class="btn btn-success" style="margin-right: 17px;"><i class="icon-repeat icon-white"></i>&nbsp;Generar Cup&oacute;n</a>
</div><!--fin de obtencion del cupon-->
<!-- Evento y eventosn relacionados -->
<div class="span-6" style="margin: 0;border-right: silver solid 1px;">
    <label><strong>Eventos</strong></label>
    <label>Seleciona por lo menos un evento</label>
    <select id="lista_eventos" multiple="" size="11">
    </select>
    <table>
        <tr>
        	<td>
            <a data-toggle="modal" data-target="#myModal_eventos" id="boton_eventos" class="btn btn-primary"><i class="icon-plus icon-white"></i>&nbsp;Agregar</a>
            </td>
        	<td>
            <a id="eliminar_lista_evento" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;Eliminar</a>
            </td>
        </tr>
    </table>
    <hr />
    <div id="seccion_eventos_relacionados">
        <label>Eventos Relacionados(opcional)</label>
        <select id="lista_eventos_relacionados" multiple="" size="10">
        </select>
        <table>
            <tr>
            	<td>
                <a id="boton_eventos_relacionados" class="btn btn-primary"><i class="icon-plus icon-white"></i>&nbsp;Agregar</a>
                </td>
            	<td>
                <a id="eliminar_lista_evento_releacionado" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;Eliminar</a>
                </td>
            </tr>
        </table>
    </div>
</div><!-- fin de evento y eventosrelacionados -->
<!-- informacion de eventos -->
<div class="span-10" style="margin: 0 0 0 6px;">
<table border="1">
    <tr>
    	<td>Descripci&oacute;n:</td>
    	<td><input  type="text" id="descripcion" class="data-id save_temp" data-id="" name="DescuentosDes" /></td>
    </tr>
    <tr>
    	<td>Forma de descuento:</td>
    	<td>
        <select id="descuento" class="data-id save_temp chosen-select" data-id="" name="DescuentosPat">
            <option value="0">Selecciona una Opcion</option>
            <option value="PORCENTAJE">Porcentaje</option>
            <option value="EFECTIVO">Efectivo</option>
            <option value="2X1">2X1</option>
            <option value="3X2">3X2</option>
        </select>
        
    </tr>
    <tr>
    	<td>Monto a descontar:</td>
    	<td><strong id="signo_monto">%</strong><input id="monto_descontar" class="data-id save_temp" data-id="" type="text" name="DescuentosCan" style="width:195px;max-width:205px;" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    	<td>
        <input type="checkbox" name="DescuentoCargo" value="si" id="cargo" class="data-id save_temp" data-id="" />
        <label style="display: inline;" title="Al marcar esta opci&oacute;n se aplica el mismo descuento al cargo por servicio" for="cargo">Aplica a cargo por servicio</label>
        </td>
   	</tr>
    <tr>
    	<td>Fecha de inicio:</td>
    	<td>
            <?php

                    $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
                            'model'=>$model, //Model object
                            'id'=>'fecha_inicio',
                            'name'=>'DescuentosFecIni',
                            'attribute'=>'DescuentosFecIni', //attribute name
                            'language'=>'es',
                            'mode'=>'datetime', //use "time","date" or "datetime" (default)
                            'options'=>array(   'showAnim'=>'fold',
                                                'dateFormat' => 'yy-mm-dd ',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                                'timeFormat'=>"hh:mm:ss",
                                                'timeText'=>"Hora",
                                                'hourText'=>"Hora",
                                                'minuteText'=>"Minuto",
                                                ), // jquery plugin options
                            'htmlOptions'=>array(
                            'style'=>'height:20px;',
                            'readonly'=>'readonly',
                            'class'=>'data-id save_temp',
                            'data-id'=>""
                            ),
                        ));
                
             /* $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'language'=>'es',
                        'id'=>'fecha_inicio',
                        'name'=>'DescuentosFecIni',
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat' => 'yy-mm-dd 06:00:00',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;',
                            'readonly'=>'readonly',
                            'class'=>'data-id save_temp',
                            'data-id'=>""
                        ),
                    ));*/
            ?>
        </td>
    </tr>
    <tr>
    	<td>Caducidad:</td>
    	<td>
            <?php
                    $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
                            'model'=>$model, //Model object
                            'id'=>'fecha_fin',
                            'name'=>'DescuentosFecFin',
                            'attribute'=>'DescuentosFecFin', //attribute name
                            'language'=>'es',
                            'mode'=>'datetime', //use "time","date" or "datetime" (default)
                            'options'=>array(   'showAnim'=>'fold',
                                                'dateFormat' => 'yy-mm-dd ',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                                'timeFormat'=>"hh:mm:ss",
                                                'timeText'=>"Hora",
                                                'hourText'=>"Hora",
                                                'minuteText'=>"Minuto",
                                                ), // jquery plugin options
                            'htmlOptions'=>array(
                            'style'=>'height:20px;',
                            'readonly'=>'readonly',
                            'class'=>'data-id save_temp',
                            'data-id'=>"",
                        ),
                        ));
               /*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'language'=>'es',
                        'id'=>'fecha_fin',
                        'name'=>'DescuentosFecFin',
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat' => 'yy-mm-dd 23:59:00',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;',
                            'readonly'=>'readonly',
                            'class'=>'data-id save_temp',
                            'data-id'=>"",
                        ),
                    ));*/
            ?>
        </td>
    </tr>
    <tr>
    	<td>Aplica a los primeros:</td>
    	<td>
        <input type="text" id="cantidad_descuentos" class="data-id save_temp" data-id="" style="width: 178px;"  name="DescuentosExis" value="0"/>
        </td>
    </tr>
    <!--<tr>
    	<td>Funci&oacute;n:</td>
    	<td>
        <select id="funcion" class="data-id save_temp" data-id="" name="FuncionesId">
            <option value="0">Todas las funciones</option>
        </select>
        </td>
    </tr>
    <tr>
    	<td>Zona:</td>
    	<td>
            <select id="zona" class="data-id save_temp" data-id="" name="ZonasId">
                <option value="0">Todas las zonas</option>
            </select>
        </td>
    </tr>
    <tr>
    	<td>Subzona:</td>
    	<td>
            <select id="subzona" class="data-id save_temp" data-id="" name="SubzonaId">
                <option value="0">Todas las subzonas</option>
            </select>
        </td>
    </tr>
    <tr>
    	<td>Fila:</td>
    	<td>
            <select id="fila" class="data-id save_temp" data-id="" name="FilasId">
                <option value="0">Todas las filas</option>
            </select>
        </td>
    </tr>
    <tr>
    	<td>Lugar:</td>
    	<td>
            <select id="lugar" class="data-id save_temp" data-id="" name="LugaresId">
                <option value="0">Todos los lugares</option>
            </select>
     </td>
    </tr>-->
    <tr>
    	<td colspan="2" style="text-align: right;">
        &nbsp;&nbsp;
        <a data-toggle="modal" data-target="#myModal_resultado" id="previsualizar" class="btn btn-default"><i class="icon-th-list icon-black"></i>&nbsp;Ver lista de eventos</a>
        <a data-toggle="modal" data-target="#myModal_continuar" id="continuar" class="btn btn-success">Continuar&nbsp;<i class="icon-play icon-white"></i></a>
        </td>
    </tr>
    <tr>
        <td colspan="2" id="tree_view"></td>
        <!--<div id="tree_view" class="span-16">
        </div>-->
    </tr>
</table>
    <?php
           // echo CHtml::dateField('fecha','',array());
    ?>
</div><!-- fin de informacion de eventos -->
<br />

<?php
$eventos=Evento::model()->findAll("EventoSta='ALTA'",array('order'=>'EventoNom'));
?>
<?php //$this->widget( 'ext.EChosen.EChosen' ); ?>
<div id="myModal_eventos"  class="modal hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Selecciona un Evento</h4>
    </div>
    <div class="modal-body" style="height: 300px;">
        <?php
                echo CHtml::dropDownList('eventos','',Chtml::listData($eventos,'EventoId','EventoNom'),array('empty'=>'--------------','style'=>'width:500px','class'=>'chosen'));
        ?>
    </div>

    <div class="modal-footer">
     <a data-dismiss="modal" class="btn" href="#">Cerrar</a>    
    </div>
</div>

 <div id="myModal" class="modal hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Selecciona un Evento Relecionado</h4>
    </div>
    <div class="modal-body" style="height: 300px;">
        <?php
                echo CHtml::dropDownList('eventos_relacionados','',Chtml::listData($eventos,'EventoId','EventoNom'),array('empty'=>'--------------','style'=>'width:500px','class'=>'chosen'));
        ?>
    </div>

    <div class="modal-footer">
     <a data-dismiss="modal" class="btn" href="#">Cerrar</a>    
    </div>

</div>
<style>
.resultado{
}
.resultado ul.result {
    width: 700px;
}
.resultado ul.result li.info{
    list-style: none;
    border:2px #dff0d8 solid;
    width: 340px;
    height: 350px;
    float: left;
    margin-right: 3px;
    margin-bottom: 3px;
    padding-left: 3px;
    overflow: auto;
}
</style>
<div id="myModal_resultado" style="width: 800px;left: 40%;" class="modal hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Previzualizaci&oacute;n de los Eventos</h4>
        <h4 id="cupon_generado_resultado" style="font-size: 20pt;"></h4>
    </div>
        <div class="modal-body">
            <div id="resultado" class="resultado">
            </div><br />
            <div id="resultado_eventos_relacionados" class="resultado_eventos_relacionados">
            </div>
        </div> 
    <div class="modal-footer">
     <a data-dismiss="modal" class="btn" href="#">Cerrar</a>    
    </div>

</div>
<div id="myModal_continuar" style="width: 800px;left: 40%;" class="modal hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Guardar Cupones de Descuento</h4>
        <h4 id="cupon_generado" style="font-size: 20pt;"></h4>
    </div>
    <div class="modal-body">
        <div id="resultado_antes_guardar" class="resultado">
        </div>
        <br />
            <div id="resultado_eventos_relacionados_guardar" class="resultado_eventos_relacionados">
        </div>
    </div>

    <div class="modal-footer">
     <a  class="btn btn-success" id="boton_guardar" style="display: none;" href="<?php echo Yii::app()->createUrl('descuentos/GuardarTemp'); ?>"><i class="icon-ok icon-white"></i>&nbsp;Guardar</a>
     <a  class="btn btn-primary" id="boton_correo" style="" href="#"><i class=" icon-envelope icon-white"></i>&nbsp;Enviar a correo</a>
     <a data-dismiss="modal" class="btn" href="#">Cerrar</a>    
    </div>

</div>
<!--<input type="text" name="fecha" id="fecha" value="" />-->
<?php
Yii::app()->getSession()->remove('descuentos');
Yii::app()->getSession()->remove('descuentos_relacionados');
?>
<div id="ayuda" class="ayuda alert fade-in oculto" style="position: fixed;left:930px;width: 250px;top:80px;">
  <a class="close" id="cerrar_ayuda" href="#">&times;</a>
  <strong>Pasos</strong>
  <ol>
    <li><a id="cerrar_p" paso-id="1" href="#">Genera el C&oacutedigo del Cup&oacute;n</a></li>
    <li><a paso-id="2" href="#">Agregar Evento</a></li>
    <li><a paso-id="3" href="#">Seleccionar un Evento</a></li>
    <li><a paso-id="4" href="#">Agregar descripci&oacute;n</a></li>
    <li><a paso-id="5" href="#">Seleccionar forma de descuento</a></li>
    <li><a paso-id="6" href="#">Agregar Monto</a></li>
    <li><a paso-id="7" href="#">Aplicar cargo por servicio</a></li>
    <li><a paso-id="8" href="#">Agregar fecha de inicio</a></li>
    <li><a paso-id="9" href="#">Agregar fecha de caducidad</a></li>
    <li><a paso-id="10" href="#">Aplicar a los primeros</a></li>
    <li><a paso-id="11" href="#">Seleccionar Funci&oacute;n</a></li>
    <li><a paso-id="12" href="#">Seleccionar Zona</a></li>
    <li><a paso-id="13" href="#">Seleccionar Subzona</a></li>
    <li><a paso-id="14" href="#">Seleccionar Fila</a></li>
    <li><a paso-id="15" href="#">Seleccionar Lugar</a></li>
    <li><a paso-id="16" href="#">Agregar Eventos relacionados</a></li>
  </ol>
</div>
<style>
.oculto{
    opacity:0;
    pointer-events:none;
}
</style> 
<script>
    $("#tipo").change(function(){
        if(this.value=="descuento"){
            $("#seccion_eventos_relacionados").attr('style',"visibility:hidden;");
            $("#generar_cupon").attr('style',"visibility:hidden;");
            $("#codigo").attr('data-tipo','descuento');
            $("#codigo").attr('readonly','readonly');
            $("#codigo").val("");
            $("#codigo").focus();
            $("#boton_guardar").show();
        }else{
            $("#seccion_eventos_relacionados").attr('style',"visibility:visible;");
            $("#generar_cupon").attr('style',"visibility:visible;");
            $("#codigo").attr('data-tipo','cupon');
            $("#codigo").attr('readonly',false);
            $("#codigo").focus();
            $("#boton_guardar").hide();
        }
    });
    $("#boton_correo").click(function(event){
        var correo=prompt("Por favor ingrese el correo al que se le enviaran los datos","");
        console.log(correo);
         $.get('<?php echo Yii::app()->createUrl('descuentos/TempDescuentosCorreo'); ?>',{correo:correo});
    });    
     //$(".chosen-select").chosen();
    /*$('#fecha').datetimepicker({showSecond:true});*/
    $("#browser").treeview();
    $("#boton_ayuda").click(function(event){
        event.preventDefault();
        $("#ayuda").removeClass('oculto');
        
    });
    $("#cerrar_ayuda").click(function(event){
        event.preventDefault();
        $("#ayuda").addClass('oculto');
    });
    $("#ayuda a").click(function(event){
        $("#ayuda ol li a").each(function(index){
            $(this).css('color','#0088cc');
        });
        $(this).css('color','red');
        var paso_id = $(this).attr('paso-id');
        var paso;
        var title="";
        $("*").popover("destroy");
        switch (paso_id){
        case "1" : paso  = $("#generar_cupon");
                   title = "Puedes Generar el C&oacute;digo del cup&oacute;n o escribir tu C&oacute;digo";
                   break;
        case "2":  paso  = $("#boton_eventos");
                   title = "Agrega un evento";
                   break;
        case "3":  paso  = $("#lista_eventos");
                   title = "Selecciona un Evento de la Lista";
                   break;
        case "4":  paso  = $("#descripcion");
                   title = "Agrega una descripci&oacute;n al evento seleccionado";
                   break; 
        case "5":  paso  = $("#descuento");
                   title = "Selecciona una forma de descuento";
                   break;
        case "6":  paso  = $("#monto_descontar");
                   title = "Ingresa el monto a descontar solo si es la opcion anterior es Porcentaje o Efectivo";
                   break;
        case "7":  paso  = $("#cargo");
                   title = "(Opcional) Selecciona cargo por servicio";
                   break;         
        case "8":  paso  = $("#fecha_inicio");
                   title = "Agrega una fecha de inicio";
                   break;
        case "9":  paso  = $("#fecha_fin");
                   title = "Agrega una fecha de caducidad";
                   break;
        case "10": paso  = $("#cantidad_descuentos");
                   title = "Agrega el n&uacute;mero de personas a qui&eacute;n se le aplicar&aacute; los descuentos";
                   break;
        case "11": paso  = $("#tree_view");
                   title = "(Opcional) Selecciona una funci&oacute;n";
                   break;
        case "12": paso  = $("#tree_view");
                   title = "(Opcional) Selecciona una zona";
                   break;
        case "13": paso  = $("#tree_view");
                   title = "(Opcional) Selecciona una subzona";
                   break;
        case "14": paso  = $("#tree_view");
                   title = "(Opcional) Selecciona una fila";
                   break;
        case "15": paso  = $("#tree_view");
                   title = "(Opcional) Selecciona un lugar";
                   break;  
        case "16": paso  = $("#boton_eventos_relacionados");
                   title = "(Opcional) Agrega eventos relacionados";
                   break;                                                            
        } 
        //paso.attr("data-placement",'top');
        paso.attr('title',title);
        paso.popover('show');
           
    });
    $(".data-id").attr('disabled',true);
    $("#cantidad_descuentos").spinner({min:0,max:1000});
    $("label").tooltip();
    
    $("#generar_cupon").click(function(){
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GenerarCupon'); ?>',
            dataType:'json',
            beforeSend:function(){
                $("#cargando").remove();
                $("#codigo").after("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
                $("#generar_cupon").attr('disabled',true);
            },
            success:function(data){
                //console.log(data[0].cupon);
                $("#codigo").val(data[0].cupon);
                 $("#codigo").focus();
                $("#cargando").remove();
                $("#generar_cupon").attr('disabled',false);
            }
        });
    });
    $("#monto_descontar").focusout(function(){
        var descuento = $("#descuento option:selected").val();
        if(this.value=="" || this.value <= 0 && (descuento=="PORCENTAJE" || descuento=="EFECTIVO")){
            alert("El Monto a descontar debe ser un numero mayor a 0");
            $(this).val("");
            $(this).focus();
        }else if(!$.isNumeric(this.value) && (descuento=="PORCENTAJE" || descuento=="EFECTIVO")){
            alert("El Monto a descontar No es un numero valido");
            $(this).val("");
            $(this).focus();
        }
    });
    $("#descuento").change(function(){
        //console.log(this.value);
        if(this.value == "PORCENTAJE"){
            $("#signo_monto").html("%");
            $("#monto_descontar").attr('disabled',false).val("");
            $("#monto_descontar").focus();     
        }else if(this.value == "EFECTIVO"){
            $("#signo_monto").html("$");
            $("#monto_descontar").attr('disabled',false).val("");
            $("#monto_descontar").focus(); 
        }else{
            $("#signo_monto").html("&nbsp;&nbsp;&nbsp;"); 
            $("#monto_descontar").attr('disabled',true).val("0");
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>',
                data:'EventoId='+$(this).attr('data-id')+"&name=DescuentosCan&value=0",
                success:function(data){
                    console.log('ok');
                    //$("#funcion").html(data);
                    }
            });              
        }
    });
    $("#codigo").focusout(function(){
        var tipo = $(this).attr('data-tipo');
        if(this.value=="" && tipo=='cupon') {
            $(this).attr('title','Necesitas crear un cupon');
             $(this).focus();
            $(this).popover('show'); 
        }else if($(this).attr('data-id')=='-1'){
           $(this).popover('destroy');
           $(this).attr('title','Necesitas seleccionar un Evento');
           $(this).popover('show'); 
        }else if(tipo=='cupon'){
            $(this).attr('title','');
            $(this).popover('destroy');
                $.ajax({
                        url:'<?php echo Yii::app()->createUrl('descuentos/ValidarCupon'); ?>',
                        data:'texto='+this.value,
                        contentType: "charset=iso-8859-1",
                        beforeSend:function(){
                          $("#cargando").remove();  
                          $("#codigo").after("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");  
                        },
                        dataType:'json',
                        success:function(data){
                            console.log(data);
                            $("#cargando").remove();
                            if(data.validacion=='1'){
                                $("#codigo").after("<i class='icon-ok' id='cargando' style='margin-left:5px;'></i>");
                                $("#codigo").val(data.texto);
                                $("#cupon_generado").html("C&oacute;digo del Cup&oacute;n: "+data.texto);
                                $("#cupon_generado_resultado").html("C&oacute;digo del Cup&oacute;n: "+data.texto);
                                $("#boton_guardar").show();
                            }else{
                                $("#codigo").after("<i class='icon-remove'  id='cargando' style='margin-left:5px;'></i>");
                                $("#codigo").val(data.texto);
                                $("#cupon_generado").html("<strong class='alert alert-error'>C&oacute;digo del Cup&oacute;n: ("+data.texto+") Incorrecto</strong>");
                                $("#cupon_generado_resultado").html("<strong class='alert alert-error'>C&oacute;digo del Cup&oacute;n: ("+data.texto+") Incorrecto</strong>");
                                $("#boton_guardar").hide();
                            }
                            
                  
                        }
                 });
        }else{
           $(this).popover('destroy');
        }
        
    });
    $("#fecha_inicio,#fecha_fin").change(function(){
           
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!=""){
            //console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>',
                data:'EventoId='+EventoId+"&name="+name+"&value="+this.value,
                success:function(data){
                    //console.log('ok');
                    //$("#funcion").html(data);
                    }
            });
            var inicio = $("#fecha_inicio").val();
            var fin    = $("#fecha_fin").val();
            var fecha_inicio =  new Date(inicio);
            var fecha_fin = new Date(fin);
            //console.log(fecha_inicio+"-"+ fecha_fin);
            if(fecha_inicio > fecha_fin){
                alert("La fecha de Caducidad es menor que la fecha de Inicio");
                //console.log("la fecha fin menor");
            } 
        }
    });
  
    $("input[type=text].save_temp").focusout(function(){
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!="" || this.value!="-1"){
            console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>',
                data:'EventoId='+EventoId+"&name="+name+"&value="+this.value,
                success:function(data){
                    console.log('ok');
                    
                    //$("#codigo").val();
                    //$("#funcion").html(data);
                    }
            }); 
        }       
    }); 
    $("input[type=checkbox].save_temp").click(function(){
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!=""){
            console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>',
                data:'EventoId='+EventoId+"&name="+name+"&value="+this.value,
                success:function(data){
                    console.log('ok');
                    //$("#funcion").html(data);
                    }
            }); 
            if($(this).attr("value")=="si"){
                $(this).attr("value","no");
            }else{
                $(this).attr("value","si");
            }
            
        }       
    }); 
    $("select.save_temp").change(function(){
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!=""){
            console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>',
                data:'EventoId='+EventoId+"&name="+name+"&value="+this.value,
                success:function(data){
                    console.log('ok');
                    //$("#funcion").html(data);
                    }
            }); 
        }       
    }); 
    $("#previsualizar").click(function(){
        var lista_eventos = $("#lista_eventos option:selected").length;
        var codigo = $("#codigo").val();
        var tipo = $("#codigo").attr('tipo');
         if(codigo =="" && tipo=='cupon'){
            alert('Necesitas crear un cupon');
            $('#codigo').focus();
            //$('#myModal_continuar').modal('hide');
         }else if(lista_eventos<=0){
            alert('Necesitas seleccionar un evento');
            //$('#myModal_continuar').modal('hide');
         }else{
            $("#lista_eventos option").each(function(index){
                $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>',
                data:'EventoId='+this.value+"&name=CuponesCod&value="+codigo,
                success:function(data){
                    console.log('ok');
                    //$("#funcion").html(data);
                    }
                });
            });
            
             $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/DeleteAllTempDescuentosRelacionados'); ?>',
               });
            $("#lista_eventos_relacionados option").each(function(index){
                console.log(this.value);
                    $.ajax({
                        url:'<?php echo Yii::app()->createUrl('descuentos/TempDescuentosRelacionados'); ?>',
                        data:'EventoId='+this.value+"&cupon="+codigo,
                        success:function(data){
                            console.log('ok');
                            //$("#funcion").html(data);
                        }
                    });
            });
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/GetTempDescuentos'); ?>',
                beforeSend:function(){
                    $("#resultado").html("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
                },
                success:function(data){
                    //console.log('ok');
                    $("#resultado").html(data);
                    $("[id^='funciones_info']").treeview({persist: "location",
                                         animated: "fast",
                                         collapsed: true,
                                         unique: true,
                                         });
                }
            });
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/GetTempDescuentosRelacionados'); ?>',
                beforeSend:function(){
                    $("#resultado_eventos_relacionados").html("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
                },
                success:function(data){
                    //console.log('ok');
                    $("#resultado_eventos_relacionados").html(data);
                }
            });
         }
    });  
    $("#continuar").click(function(){
        var lista_eventos = $("#lista_eventos option:selected").length;
        var codigo = $("#codigo").val();
         var tipo = $("#codigo").attr('data-tipo');
         if(codigo =="" && tipo=='cupon'){
            alert('Necesitas crear un cupon');
            $('#codigo').focus();
            //$('#myModal_continuar').modal('hide');
         }else if(lista_eventos<=0){
            alert('Necesitas seleccionar un evento');
            //$('#myModal_continuar').modal('hide');
         }else{
            $("#lista_eventos option").each(function(index){
                $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>',
                data:'EventoId='+this.value+"&name=CuponesCod&value="+codigo,
                success:function(data){
                    console.log('ok');
                    //$("#funcion").html(data);
                    }
                });
            });
            
             $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/DeleteAllTempDescuentosRelacionados'); ?>',
               });
            $("#lista_eventos_relacionados option").each(function(index){
                console.log(this.value);
                    $.ajax({
                        url:'<?php echo Yii::app()->createUrl('descuentos/TempDescuentosRelacionados'); ?>',
                        data:'EventoId='+this.value+"&cupon="+codigo,
                        success:function(data){
                            console.log('ok');
                            //$("#funcion").html(data);
                        }
                    });
            });
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/GetTempDescuentosAntesGuardar'); ?>',
                beforeSend:function(){
                    $("#resultado_antes_guardar").html("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
                },
                success:function(data){
                    //console.log('ok');
                    $("#resultado_antes_guardar").html(data);
                }
            });
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/GetTempDescuentosRelacionados'); ?>',
                beforeSend:function(){
                    $("#resultado_eventos_relacionados_guardar").html("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
                },
                success:function(data){
                    //console.log('ok');
                    $("#resultado_eventos_relacionados_guardar").html(data);
                }
            });
        }    
    });  
///////////////////////////////////////////////////////////////////////////
//Eventos     
    $("#eventos").change(function(){
        var texto = $("option:selected",this).html();
        var value = $(this).val();
        var codigo = $("#codigo").val();
        var tipo = $("#codigo").attr('data-tipo');
        if(codigo=="" && tipo=='cupon'){
            $('#myModal_eventos').modal('hide');
            alert("No hay cupon creado para relacionar");
            
        }
        else if(value!=""){
            $('#myModal_eventos').modal('hide');
                if($("#lista_eventos  option[value='"+value+"']").length == 0) {
                    //console.log("no existe");
                     $("#lista_eventos").append('<option id="'+value+'" value="'+value+'">'+texto+'</option>');
                     $.ajax({
                        url:'<?php echo Yii::app()->createUrl('descuentos/TempDescuentos'); ?>',
                        data:'EventoId='+this.value,
                        success:function(data){
                            console.log('ok');
                            //$("#funcion").html(data);
                        }
                    });
                }else{
                    //console.log("existe");
                    alert("El evento ya fue agregado anteriormente");
                }
                
        }
    });
    $("#eliminar_lista_evento").click(function(){
        //console.log($("#lista_eventos  option:selected").val());
        var evento = $("#lista_eventos  option:selected").val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/DeleteTempDescuentos'); ?>',
            data:'EventoId='+evento,
            success:function(data){
                //console.log('ok');
                $("#lista_eventos  option#"+evento).remove();
                //$("#funcion").html(data);
            }
        });
        
    });
    $("#lista_eventos").change(function(){
        //console.log(this.value);
        $(".data-id").attr("data-id",this.value);
        $(".data-id").attr('disabled',false);
        $("#codigo").attr("data-id",this.value);
        $("#codigo").focus();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetTempDescuentosJson'); ?>',
            dataType:'json',
            data:'EventoId='+this.value,
            success:function(data){
                console.log(data);
                $("#descripcion").val(data.DescuentosDes);
                $("#monto_descontar").val(data.DescuentosCan);
                $("#fecha_inicio").val(data.DescuentosFecIni);
                $("#fecha_fin").val(data.DescuentosFecFin);
                $("#cantidad_descuentos").val(data.DescuentosExis);
                if(data.DescuentoCargo =="si"){
                    $("#cargo").attr('checked',true);
                    $("#cargo").attr('value','no');
                }else{
                    $("#cargo").attr('checked',false);
                    $("#cargo").attr('value','si');
                }
                $("#descuento option").each(function(index){
                    $(this).attr('selected',false);
                    if(data.DescuentosPat ==$(this).attr('value')){
                        $(this).attr('selected',true);
                    }
                    
                });
                $("#zona").html("<option value='0'>Todas las zonas</option>");
                $("#subzona").html("<option value='0'>Todas las subzonas</option>");
                $("#fila").html("<option value='0'>Todas las filas</option>");
                $("#lugar").html("<option value='0'>Todas los lugares</option>");
            }
        });
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetFunciones'); ?>',
            data:'EventoId='+this.value,
            success:function(data){
                //console.log(data);
                $("#funcion").html(data);
            }
        });
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetTreeView'); ?>',
            data:'EventoId='+this.value,
            beforeSend:function(){
                $("#tree_view").html("<img id='cargando' width='25' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
            },
            success:function(data){
                $("#tree_view").html(data);
                $("#treeview").treeview({persist: "location",
                                         animated: "fast",
                                         collapsed: true,
                                         unique: true,
                                         });
                ///Funcion treeview
                $("ul  li[id^=nodo_funcion]").click(function(){
                    var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                    var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                    
                    if(!$("input[type=checkbox]:first",this).is(":checked")){
                        $("input[type=checkbox]",this).attr('checked',false);
                        $("ul  li[id^=nodo_zona] input[type=checkbox]",this).attr('disabled',true);
                        $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFuncionDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId});
                    }else {
                        //console.log($("input[type=checkbox]#check_zona",this).is(":checked"));
                        if(!$("input[type=checkbox]#check_zona",this).is(":checked")){
                            $("ul  li[id^=nodo_zona] input[type=checkbox]#check_zona",this).attr('disabled',false);
                            //console.log(EventoId+"-"+FuncionesId);
                            $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFuncion'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId});
                        }
                        
                    }
                });                         
                ///Zona treeview
                $("ul  li[id^=nodo_zona]").click(function(){
                    var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                    var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                    var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                    
                    if(!$("input[type=checkbox]:first",this).is(":checked")){
                        $("input[type=checkbox]",this).attr('checked',false);
                        $("ul  li[id^=nodo_subzona] input[type=checkbox]",this).attr('disabled',true);
                        $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoZonaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                    }else{
                        if(!$("input[type=checkbox]#check_subzona",this).is(":checked")){
                            $("ul  li[id^=nodo_subzona] input[type=checkbox]#check_subzona",this).attr('disabled',false);
                            //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId);
                            $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoZona'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                       } 
                    }
                });
                                                                                  
                ///Subzona treeview
                $("ul  li[id^=nodo_subzona] ").click(function(){
                    var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                    var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                    var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                    var SubzonaId   = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                    
                    if(!$("input[type=checkbox]:first",this).is(":checked")){
                        $("input[type=checkbox]",this).attr('checked',false);
                        $("ul  li[id^=nodo_fila] input[type=checkbox]",this).attr('disabled',true);
                        $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoSubzonaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                    }else{
                        if(!$("input[type=checkbox]#check_fila",this).is(":checked")){
                            $("ul  li[id^=nodo_fila] input[type=checkbox]#check_fila",this).attr('disabled',false);
                            //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId); 
                            $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoSubzona'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                       } 
                    }
                });                         
                  
                ///Fila treeview
                $("ul  li[id^=nodo_fila]").click(function(){
                    var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                    var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                    var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                    var SubzonaId   = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                    var FilasId     = $("input[type=checkbox]",this).attr("check-data-filasid");
                    if(!$("input[type=checkbox]:first",this).is(":checked")){
                        $("input[type=checkbox]",this).attr('checked',false);
                        $("ul  li[id^=nodo_lugar] input[type=checkbox]",this).attr('disabled',true);
                        $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFilaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                    }else{
                        if(!$("input[type=checkbox]#check_lugar",this).is(":checked")){
                            $("ul  li[id^=nodo_lugar] input[type=checkbox]#check_lugar",this).attr('disabled',false);
                            //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId+"-"+FilasId);
                            $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFila'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                        }  
                    }
                });
                
                $("ul  li[id^=nodo_lugar]").click(function(){
                    var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                    var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                    var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                    var SubzonaId   = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                    var FilasId     = $("input[type=checkbox]",this).attr("check-data-filasid");
                    var LugaresId   = $("input[type=checkbox]",this).attr("check-data-lugaresid");
                    if(!$("input[type=checkbox]:first",this).is(":checked")){
                        $("input[type=checkbox]",this).attr('checked',false);
                        $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoLugarDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});
                    }else{
                        //if(!$("input[type=checkbox]#check_lugar",this).is(":checked")){
                            console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId+"-"+FilasId+"-"+LugaresId);
                             $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoLugar'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});
                       //}  
                    }
                });
            }
        });
        
    }); 
///////////////////////////////////////////////////////////////////////////
//Funciones,Zonas,Subzona,Fila, Lugar

    
    $("#funcion").change(function(){
        //console.log(this.value+""+$("#lista_eventos option:selected").val());
        var eventoId = $("#lista_eventos option:selected").val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetZonas'); ?>',
            data:'FuncionesId='+this.value+"&EventoId="+eventoId,
            success:function(data){
                //console.log(data);
                $("#zona").html(data);
            }
        });
        $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { name: "ZonasId", EventoId: eventoId , value:"0" } );
        $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { name: "SubzonaId", EventoId: eventoId , value:"0" } );
        $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { name: "FilasId", EventoId: eventoId , value:"0" } );
        $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { name: "LugaresId", EventoId: eventoId , value:"0" } );
    }); 
    $("#zona").change(function(){
        //console.log(this.value+""+$("#lista_eventos option:selected").val());
        var eventoId = $("#lista_eventos option:selected").val();
        var funcionId = $("#funcion option:selected").val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetSubZonas'); ?>',
            data:'ZonasId='+this.value+'&FuncionesId='+funcionId+"&EventoId="+eventoId,
            success:function(data){
                //console.log(data);
                $("#subzona").html(data);
            }
        });
    }); 
    $("#subzona").change(function(){
        var eventoId = $("#lista_eventos option:selected").val();
        var funcionId = $("#funcion option:selected").val();
        var zonasId = $("#zona option:selected").val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetFilas'); ?>',
            data:'SubzonaId='+this.value+'&ZonasId='+zonasId+'&FuncionesId='+funcionId+"&EventoId="+eventoId,
            success:function(data){
                //console.log(data);
                $("#fila").html(data);
            }
        });
    });
    $("#fila").change(function(){
        var eventoId = $("#lista_eventos option:selected").val();
        var funcionId = $("#funcion option:selected").val();
        var zonasId = $("#zona option:selected").val();
        var subzonasId = $("#subzona option:selected").val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetLugares'); ?>',
            data:'FilasId='+this.value+'&SubzonaId='+subzonasId+'&ZonasId='+zonasId+'&FuncionesId='+funcionId+"&EventoId="+eventoId,
            success:function(data){
                //console.log(data);
                $("#lugar").html(data);
            }
        });
    });            
///////////////////////////////////////////////////////////////////////////
//Eventos Relacionados    
    $("#eventos_relacionados").change(function(){
        
        var texto = $("option:selected",this).html();
        var value = $(this).val();
        var codigo = $("#codigo").val();
        if(codigo==""){
            $('#myModal').modal('hide');
            alert("No hay cupon creado para relacionar");
            
        }else if($("#lista_eventos option#"+value).length > 0){
            alert("El evento relacionado no puede ser igual al evento principal");   
        }else if(value!=""){
              $('#myModal').modal('hide');
                if($("#lista_eventos_relacionados  option[value='"+value+"']").length == 0) {
                    //console.log("no existe");
                     $("#lista_eventos_relacionados").append('<option id="'+value+'" value="'+value+'">'+texto+'</option>');
                     $.ajax({
                        url:'<?php echo Yii::app()->createUrl('descuentos/TempDescuentosRelacionados'); ?>',
                        data:'EventoId='+this.value+"&cupon="+codigo,
                        success:function(data){
                            console.log('ok');
                            //$("#funcion").html(data);
                        }
                    });
                }else{
                    //console.log("existe");
                    alert("El evento ya fue agregado anteriormente");
                }
         }       
                
    });
    $("#boton_eventos_relacionados").click(function(){
        var lista_eventos = $("#lista_eventos option").length;
        console.log(lista_eventos);
        if(lista_eventos<=0){
            alert("Necesitas agregar primero un evento");
        }else{
            $('#myModal').modal();
        }
        
    });
    $("#eliminar_lista_evento_releacionado").click(function(){
        var evento = $("#lista_eventos_relacionados  option:selected").val();
        
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/DeleteTempDescuentosRelacionados'); ?>',
            data:'EventoId='+evento,
            success:function(data){
                console.log('ok_evento_relecionado');
                $("#lista_eventos_relacionados  option#"+evento).remove();
                //$("#funcion").html(data);
            }
        });
    });
</script>
<style>
.treeview, .treeview ul { 
	padding: 0;
	margin: 0;
	list-style: none;
}

.treeview ul {
	background-color: white;
	margin-top: 4px;
}

.treeview .hitarea {
	background: url(<?php echo $baseUrl; ?>/images/images/treeview-default.gif) -64px -25px no-repeat;
	height: 16px;
	width: 16px;
	margin-left: -16px;
	float: left;
	cursor: pointer;
}
/* fix for IE6 */
* html .hitarea {
	display: inline;
	float:none;
}

.treeview li { 
	margin: 0;
	padding: 3px 0pt 3px 16px;
}

.treeview a.selected {
	background-color: #eee;
}

#treecontrol { margin: 1em 0; display: none; }

.treeview .hover { color: red; cursor: pointer; }

.treeview li { background: url(<?php echo $baseUrl; ?>/images/images/treeview-default-line.gif) 0 0 no-repeat; }
.treeview li.collapsable, .treeview li.expandable { background-position: 0 -176px; }

.treeview .expandable-hitarea { background-position: -80px -3px; }

.treeview li.last { background-position: 0 -1766px }
.treeview li.lastCollapsable, .treeview li.lastExpandable { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-default.gif); }  
.treeview li.lastCollapsable { background-position: 0 -111px }
.treeview li.lastExpandable { background-position: -32px -67px }

.treeview div.lastCollapsable-hitarea, .treeview div.lastExpandable-hitarea { background-position: 0; }

.treeview-red li { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-red-line.gif); }
.treeview-red .hitarea, .treeview-red li.lastCollapsable, .treeview-red li.lastExpandable { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-red.gif); } 

.treeview-black li { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-black-line.gif); }
.treeview-black .hitarea, .treeview-black li.lastCollapsable, .treeview-black li.lastExpandable { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-black.gif); }  

.treeview-gray li { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-gray-line.gif); }
.treeview-gray .hitarea, .treeview-gray li.lastCollapsable, .treeview-gray li.lastExpandable { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-gray.gif); } 

.treeview-famfamfam li { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-famfamfam-line.gif); }
.treeview-famfamfam .hitarea, .treeview-famfamfam li.lastCollapsable, .treeview-famfamfam li.lastExpandable { background-image: url(<?php echo $baseUrl; ?>/images/images/treeview-famfamfam.gif); } 

.treeview .placeholder {
	background: url(images/ajax-loader.gif) 0 0 no-repeat;
	height: 16px;
	width: 16px;
	display: block;
}

.filetree li { padding: 3px 0 2px 16px; }
.filetree span.folder, .filetree span.file { padding: 1px 0 1px 16px; display: block; }
.filetree span.folder { background: url(<?php echo $baseUrl; ?>/images/images/folder.gif) 0 0 no-repeat; }
.filetree li.expandable span.folder { background: url(<?php echo $baseUrl; ?>/images/images/folder-closed.gif) 0 0 no-repeat; }
.filetree span.file { background: url(<?php echo $baseUrl; ?>/images/images/file.gif) 0 0 no-repeat; }
</style>
