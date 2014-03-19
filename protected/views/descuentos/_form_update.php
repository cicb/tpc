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

<!-- INICIO DE CONTROL-->
<div class="box5">
	
<div class="span3">
<?php echo TbHtml::textField('CuponesCod',  $CuponActual[0]->CuponesCod,
		array(
					'data-placement'=>'left',
					'data-id'=>-1,		
					'data-tipo'=>'cupon',		
					'id'=>'codigo',
					'span' => 2,
					'class'=>empty($_GET['cupon'])?'hidden':'',
					'placeholder'=>'Código del cupón',
                    'readonly'=>'readonly',)
			); ?>

    <label><strong>Eventos</strong></label>
    <label>Seleciona por lo menos un evento</label>
    <select id="lista_eventos" multiple="" size="11">
        <?php foreach($model as $key => $evento): ?>
        <option data-db="1" data-db-id="<?php echo $evento->DescuentosId; ?>" id="<?php echo $evento->EventoId; ?>" <?php echo $evento->EventoId==$EventoId?"selected='selected'":""; ?> value="<?php echo $evento->evento->EventoId; ?>"><?php echo $evento->evento->EventoNom; ?></option>
        <?php endforeach; ?>
    </select>
    <table width="100%">
        <tr>
        	<td>
			<a id="eliminar_lista_evento" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;Eliminar</a>
            </td>
        	<td>
			<a data-toggle="modal" data-target="#myModal_eventos" class="btn btn-success" id="boton_eventos"><i class="icon-plus icon-white"></i>&nbsp;Agregar</a>
            </td>
        </tr>
    </table>
    <hr />
    <div id="seccion_eventos_relacionados" style="<?php echo empty($_GET['cupon'])?"visibility:hidden;":""; ?>">
        <label>Eventos Relacionados(opcional)</label>
        <select id="lista_eventos_relacionados" multiple="" size="10">
            <?php foreach($EventosRelacionados as $key => $evento): ?>
            <option data-db="1"  value="<?php echo $evento->EventoId; ?>" id="<?php echo $evento->EventoId; ?>"><?php echo $evento->evento->EventoNom; ?></option>
            <?php endforeach; ?>
        </select>
        <table width="100%">
            <tr>
            	<td>
				<a id="eliminar_lista_evento_releacionado" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;Eliminar</a>
                </td>
            	<td>
				<a data-toggle="modal" data-target="#myModal" class="btn btn-success" id="boton_eventos_relacionados"><i class="icon-plus icon-white"></i>&nbsp;Agregar</a>
                </td>
            </tr>
        </table>
    </div>
<!-- fin de evento y eventosrelacionados -->
</div>
<div class="col-2">
	
<table border="0" width="90%">
    <tr>
    	<td>Descripci&oacute;n:</td>
    	<td><input data-log="1"  type="text" id="descripcion" class="data-id save_temp" data-id="<?php echo $EventoId; ?>" value="<?php echo $CuponActual[0]->DescuentosDes; ?>" name="DescuentosDes" /></td>
    </tr>
    <tr>
    	<td>Forma de descuento:</td>
    	<td>
        <select data-log="1" id="descuento" class="data-id save_temp chosen-select" data-id="<?php echo $EventoId; ?>" name="DescuentosPat">
            <option value="0">Selecciona una Opcion</option>
            <option <?php echo $CuponActual[0]->DescuentosPat == "PORCENTAJE"?"selected='selected'":""; ?> value="PORCENTAJE">Porcentaje</option>
            <option <?php echo $CuponActual[0]->DescuentosPat == "EFECTIVO"?"selected='selected'":""; ?> value="EFECTIVO">Efectivo</option>
            <option <?php echo $CuponActual[0]->DescuentosPat == "2X1"?"selected='selected'":""; ?> value="2X1">2X1</option>
            <option <?php echo $CuponActual[0]->DescuentosPat == "3X2"?"selected='selected'":""; ?> value="3X2">3X2</option>
        </select>
        
    </tr>
    <tr>
    	<td>Monto a descontar:</td>
    	<td><strong id="signo_monto">%</strong><input data-log="1" id="monto_descontar" class="data-id save_temp" data-id="<?php echo $EventoId; ?>" value="<?php echo $CuponActual[0]->DescuentosCan; ?>" type="text" name="DescuentosCan" style="width:195px;max-width:205px;" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    	<td>
        <input data-log="1" type="checkbox" name="DescuentoCargo" value="<?php echo $CuponActual[0]->DescuentoCargo=="si"?"no":"si"; ?>" <?php echo $CuponActual[0]->DescuentoCargo=="si"?"checked":""; ?> id="cargo" class="data-id save_temp" data-id="<?php echo $EventoId; ?>" />
        <label style="display: inline;" title="Al marcar esta opci&oacute;n se aplica el mismo descuento al cargo por servicio" for="cargo">Aplica a cargo por servicio</label>
<br/>
        </td>
   	</tr>
    <tr>
    	<td>Fecha de inicio:</td>
    	<td>
            <?php
                         $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'language'=>'es',
                        'id'=>'fecha_inicio',
                        'name'=>'DescuentosFecIni',
                        'value'=>$CuponActual[0]->DescuentosFecIni,
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
                            'data-id'=>$EventoId,
                            'data-log'=>"1",
                        ),
                    ));
            ?>
        </td>
    </tr>
    <tr>
    	<td>Caducidad:</td>
    	<td>
            <?php
                         $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'language'=>'es',
                        'id'=>'fecha_fin',
                        'name'=>'DescuentosFecFin',
                        'value'=>$CuponActual[0]->DescuentosFecFin,
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
                            'data-id'=>$EventoId,
                            'data-log'=>"1",
                        ),
                    ));
            ?>
        </td>
    </tr>
    <tr>
    	<td>Aplica a los primeros:</td>
    	<td>
        <input data-log="1" type="text" id="cantidad_descuentos" value="<?php echo $CuponActual[0]->DescuentosExis; ?>" class="data-id save_temp" data-id="<?php echo $EventoId; ?>" style="width: 178px;"  name="DescuentosExis" value="0"/>
        </td>
    </tr>
    <tr>
        <td>Punto de Venta:</td>
        <td>
        <br />
        <?php
        echo $pv;
        $puntos_venta = Puntosventa::model()->findAll(array('condition'=>"PuntosventaNom!='' AND PuntosventaSta='ALTA'",'order'=>'PuntosventaNom ASC'));
        echo CHtml::dropDownList('DescuentosValRef',$pv,CHtml::listData($puntos_venta,'PuntosventaId','PuntosventaNom'),array('empty'=>array('todos'=>'Todos'),'style'=>'width:220px','class'=>'data-id save_temp','data-id'=>"$EventoId",'data-log'=>"1"));
        ?>
        </td>
        </tr>
    <tr>
		<td colspan="2" style="text-align: right;">
<br/><br/>
        &nbsp;&nbsp;
        <a data-toggle="modal" data-target="#myModal_resultado" id="previsualizar" class="btn btn-default"><i class="icon-th-list icon-black"></i>&nbsp;Ver lista de eventos</a>
        <a data-toggle="modal" data-target="#myModal_continuar" id="continuar" class="btn btn-primary">Continuar&nbsp;<i class="icon-play icon-white"></i></a>
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
<!-- fin de informacion de eventos -->
</div>



</div> <!---FIN de controles-->
<!-- informacion de eventos -->
<?php
$eventos=Evento::model()->findAll("EventoSta='ALTA'",array('order'=>'EventoNom'));
?>
<?php //$this->widget( 'ext.EChosen.EChosen' ); ?>
<div id="myModal_eventos" class="modal hide fade">
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
        <h4>Guardar <?php echo empty($cupon)?"Descuento":"Cupones de Descuento"; ?></h4>
    </div>
    <div class="modal-body">
        <div id="resultado_antes_guardar" class="resultado">
        </div>
        <br />
            <div id="resultado_eventos_relacionados_guardar" class="resultado_eventos_relacionados">
        </div>
    </div>

    <div class="modal-footer">
     <a  class="btn btn-success" href="<?php echo Yii::app()->createUrl('descuentos/GuardarTemp'); ?>"><i class="icon-ok icon-white"></i>&nbsp;Guardar</a>
     <a  class="btn btn-primary" id="boton_correo" style="" href="#"><i class=" icon-envelope icon-white"></i>&nbsp;Enviar a correo</a>
     <a data-dismiss="modal" class="btn" href="#">Cerrar</a>    
    </div>

</div>
<!--<input type="text" name="fecha" id="fecha" value="" />-->
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
$("#boton_correo").click(function(event){
        var correo=prompt("Por favor ingrese el correo al que se le enviaran los datos","");
        console.log(correo);
         $.get('<?php echo Yii::app()->createUrl('descuentos/TempDescuentosCorreo'); ?>',{correo:correo});
});
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
        case "1" : paso  = $("#codigo");
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
    /*$.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetFunciones'); ?>',
            data:'EventoId='+<?php echo $EventoId; ?>,
            success:function(data){
                //console.log(data);
                $("#funcion").html(data);
            }
    });*/
     //$(".chosen-select").chosen();
    /*$('#fecha').datetimepicker({showSecond:true});*/
    //$(".data-id").attr('disabled',true);
    $("#cantidad_descuentos").spinner({min:0,max:1000});
    $("#cantidad_descuentos").focusout(function(){
        if(this.value=="" || this.value < 0 ){
            alert("Aplica a los primeros debe ser un numero mayor a 0");
            $(this).val("");
            $(this).focus();
        }else if(!$.isNumeric(this.value)){
            alert("Aplica a los primeros No es un numero valido");
            $(this).val("");
            $(this).focus();
        }
    });
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
        console.log(this.value);
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
    $("#codigo").keyup(function(event){
      if(this.value.length > 1){
           if(event.which == 37 || event.which == 39 ){
            }else{   
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
                            }else{
                                $("#codigo").after("<i class='icon-remove'  id='cargando' style='margin-left:5px;'></i>");
                            }
                            $("#codigo").val(data.texto);
                            //$("#funcion").html(data);
                  
                  }
           });
        }     
      } 
    }).
    focusout(function(){
        if(this.value=="") {
            $(this).attr('title','Necesitas crear un cupon');
             $(this).focus();
            $(this).popover('show'); 
        }else if($(this).attr('data-id')=='-1'){
           $(this).popover('destroy');
           $(this).attr('title','Necesitas seleccionar un Evento');
           $(this).popover('show'); 
        }else{
            $(this).attr('title','');
            $(this).popover('destroy');
        }
        
    });
    $("#fecha_inicio,#fecha_fin").change(function(){
        var data_log = $(this).attr("data-log");
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!=""){
            //console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:name,value:this.value } );
            if(data_log == "1"){
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:"Edit",value:"1" } );
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name: name+"Log",value:this.value } );  
            }
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
        var data_log = $(this).attr("data-log");
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!="" || this.value!="-1"){
            //console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:name,value:this.value } );
            if(data_log == "1"){
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:"Edit",value:"1" } );
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name: name+"Log",value:this.value } );  
            }
        }       
    }); 
    $("input[type=checkbox].save_temp").click(function(){
        var data_log = $(this).attr("data-log");
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!=""){
            //console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:name,value:this.value } );
            if(data_log == "1"){
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:"Edit",value:"1" } );
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name: name+"Log",value:this.value } );  
            } 
            if($(this).attr("value")=="si"){
                $(this).attr("value","no");
            }else{
                $(this).attr("value","si");
            }
            
        }       
    }); 
    $("select.save_temp").change(function(){
        var data_log = $(this).attr("data-log");
        if($(this).attr("data-id")==""){
            alert("Necesitas seleccionar un evento");
        }
        else if(this.value!=""){
            console.log(this.value+"-"+$(this).attr("data-id")+"-"+$(this).attr("name"));
            var EventoId = $(this).attr("data-id");
            var name     = $(this).attr("name");
            $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:name,value:this.value } );
            if(data_log == "1"){
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name:"Edit",value:"1" } );
               $.get('<?php echo Yii::app()->createUrl('descuentos/TempInput'); ?>', { EventoId:EventoId, name: name+"Log",value:this.value } );  
            }  
        }       
    }); 
    $("#previsualizar").click(function(){
        var lista_eventos = $("#lista_eventos option:selected").length;
        var codigo = $("#codigo").val();
        var cupon = '<?php echo $_GET['cupon'] ?>';
         if(codigo =="" && cupon!=""){
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
         var cupon = '<?php echo $_GET['cupon'] ?>';
         if(codigo =="" && cupon!=""){
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
        var cupon = '<?php echo $_GET['cupon'] ?>';
        if(codigo=="" && cupon!=""){
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
        var evento     = $("#lista_eventos  option:selected").val();
        var data_db    = $("#lista_eventos  option:selected").attr("data-db");
        var data_db_id = $("#lista_eventos  option:selected").attr("data-db-id");
        if(data_db=="1"){
            var confirmar = confirm("Este registro se encuentra almacenado en la Base de Datos desea continuar con su eliminacion?");
            if(confirmar){
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl('descuentoslevel1/DeleteAjax'); ?>',
                    data:'id='+data_db_id,
                    success:function(data){
                        alert("El registro se elimino correctamente");
                        //console.log('ok');
                    }
                });
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl('descuentos/DeleteTempDescuentos'); ?>',
                    data:'EventoId='+evento,
                    success:function(data){
                        //console.log('ok');
                        $("#lista_eventos  option#"+evento).remove();
                        //$("#funcion").html(data);
                    }
                });
            }
        }else{
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/DeleteTempDescuentos'); ?>',
                data:'EventoId='+evento,
                success:function(data){
                    //console.log('ok');
                    $("#lista_eventos  option#"+evento).remove();
                    //$("#funcion").html(data);
                }
            });
        }
        
        
    });
////////////////////////////////////Tree View///////////////////////////////////////////////////
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl('descuentos/GetTreeView'); ?>',
                    data:'EventoId='+<?php echo $EventoId; ?>+'&DescuentosId='+<?php echo $DescuentosId; ?>+"&CuponesCod=<?php echo $cupon; ?>",
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
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_zona] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFuncionDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFuncionDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId});
                                }
                            }else {
                                //console.log($("input[type=checkbox]#check_zona",this).is(":checked"));
                                if(!$("input[type=checkbox]#check_zona",this).is(":checked")){
                                    $("ul  li[id^=nodo_zona] input[type=checkbox]#check_zona",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId);
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFuncion'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFuncionUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId});
                                    }
                                }
                                
                            }
                        });                         
                        ///Zona treeview
                        $("ul  li[id^=nodo_zona]").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_subzona] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoZonaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoZonaDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                }
                            }else{
                                if(!$("input[type=checkbox]#check_subzona",this).is(":checked")){
                                    $("ul  li[id^=nodo_subzona] input[type=checkbox]#check_subzona",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId);
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoZona'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoZonaUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                    }
                               } 
                            }
                        });
                                                                                          
                        ///Subzona treeview
                        $("ul  li[id^=nodo_subzona] ").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            var SubzonaId   = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                            
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_fila] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoSubzonaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoSubzonaDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                }
                            }else{
                                if(!$("input[type=checkbox]#check_fila",this).is(":checked")){
                                    $("ul  li[id^=nodo_fila] input[type=checkbox]#check_fila",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId); 
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoSubzona'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoSubzonaUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                    }    
                               } 
                            }
                        });                         
                          
                        ///Fila treeview
                        $("ul  li[id^=nodo_fila]").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            var SubzonaId   = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                            var FilasId     = $("input[type=checkbox]",this).attr("check-data-filasid");
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_lugar] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFilaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFilaDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                }
                            }else{
                                if(!$("input[type=checkbox]#check_lugar",this).is(":checked")){
                                    $("ul  li[id^=nodo_lugar] input[type=checkbox]#check_lugar",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId+"-"+FilasId);
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFila'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFilaUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                    }
                                }  
                            }
                        });
                        
                        $("ul  li[id^=nodo_lugar]").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId     = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId  = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId      = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            var SubzonaId    = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                            var FilasId      = $("input[type=checkbox]",this).attr("check-data-filasid");
                            var LugaresId    = $("input[type=checkbox]",this).attr("check-data-lugaresid");
                             if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoLugarDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId}); 
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoLugarDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});
                                }
                             }else{
                                console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId+"-"+FilasId+"-"+LugaresId);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoLugar'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});  
                                if(DescuentosId > 0){
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/NodoLugarUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});
                                }
                             }
                            
                        });
                    }
                });
////////////////////////////////////Tree View///////////////////////////////////////////////////     
    $("#lista_eventos").change(function(){
        //console.log(this.value);
        var EventoId = this.value;
        $(".data-id").attr("data-id",this.value);
        $(".data-id").attr('disabled',false);
        $("#codigo").attr("data-id",this.value);
        $("#codigo").focus();
        var data_db = $("option:selected",this).attr("data-db");
        //console.log(data_db);
        if(data_db=="1"){
            $(".save_temp").attr("data-log","1");
        }else{
            $(".save_temp").attr("data-log","-1");
        }
        $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentos/GetTempDescuentosJson'); ?>',
            dataType:'json',
            data:'EventoId='+this.value,
            success:function(data){
                //console.log(data);
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
                //console.log(data.DescuentosPat);
                $("#descuento option").each(function(index){
                    //console.log($(this).attr('value'));
                    $(this).attr('selected',false);
                    if(data.DescuentosPat ==$(this).attr('value')){
                        $(this).attr('selected',true);
                    }
                    
                });
               /* $("#zona").html("<option value='0'>Todas las zonas</option>");
                $("#subzona").html("<option value='0'>Todas las subzonas</option>");
                $("#fila").html("<option value='0'>Todas las filas</option>");
                $("#lugar").html("<option value='0'>Todas los lugares</option>");*/
////////////////////////////////////Tree View///////////////////////////////////////////////////
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl('descuentos/GetTreeView'); ?>',
                    data:'EventoId='+EventoId+'&DescuentosId='+data.DescuentosId+"&CuponesCod="+data.CuponesCod,
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
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_zona] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFuncionDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFuncionDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId});
                                }
                            }else {
                                //console.log($("input[type=checkbox]#check_zona",this).is(":checked"));
                                if(!$("input[type=checkbox]#check_zona",this).is(":checked")){
                                    $("ul  li[id^=nodo_zona] input[type=checkbox]#check_zona",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId);
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFuncion'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFuncionUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId});
                                    }
                                }
                                
                            }
                        });                         
                        ///Zona treeview
                        $("ul  li[id^=nodo_zona]").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_subzona] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoZonaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoZonaDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                }
                            }else{
                                if(!$("input[type=checkbox]#check_subzona",this).is(":checked")){
                                    $("ul  li[id^=nodo_subzona] input[type=checkbox]#check_subzona",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId);
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoZona'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoZonaUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId});
                                    }
                               } 
                            }
                        });
                                                                                          
                        ///Subzona treeview
                        $("ul  li[id^=nodo_subzona] ").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            var SubzonaId   = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                            
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_fila] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoSubzonaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoSubzonaDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                }
                            }else{
                                if(!$("input[type=checkbox]#check_fila",this).is(":checked")){
                                    $("ul  li[id^=nodo_fila] input[type=checkbox]#check_fila",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId); 
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoSubzona'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoSubzonaUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId});
                                    }    
                               } 
                            }
                        });                         
                          
                        ///Fila treeview
                        $("ul  li[id^=nodo_fila]").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId    = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId     = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            var SubzonaId   = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                            var FilasId     = $("input[type=checkbox]",this).attr("check-data-filasid");
                            if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $("ul  li[id^=nodo_lugar] input[type=checkbox]",this).attr('disabled',true);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFilaDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFilaDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                }
                            }else{
                                if(!$("input[type=checkbox]#check_lugar",this).is(":checked")){
                                    $("ul  li[id^=nodo_lugar] input[type=checkbox]#check_lugar",this).attr('disabled',false);
                                    //console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId+"-"+FilasId);
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoFila'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                    if(DescuentosId > 0){
                                        $.get('<?php echo Yii::app()->createUrl('descuentos/NodoFilaUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId});
                                    }
                                }  
                            }
                        });
                        
                        $("ul  li[id^=nodo_lugar]").click(function(){
                            var DescuentosId = $("input[type=checkbox]",this).attr("check-data-descuentosid");
                            var CuponesCod   = $("input[type=checkbox]",this).attr("check-data-cuponescod");
                            var EventoId     = $("input[type=checkbox]",this).attr("check-data-eventoid");
                            var FuncionesId  = $("input[type=checkbox]",this).attr("check-data-funcionesid");
                            var ZonasId      = $("input[type=checkbox]",this).attr("check-data-zonasid");
                            var SubzonaId    = $("input[type=checkbox]",this).attr("check-data-subzonaid");
                            var FilasId      = $("input[type=checkbox]",this).attr("check-data-filasid");
                            var LugaresId    = $("input[type=checkbox]",this).attr("check-data-lugaresid");
                             if(!$("input[type=checkbox]:first",this).is(":checked")){
                                $("input[type=checkbox]",this).attr('checked',false);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoLugarDelete'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId}); 
                                if(DescuentosId > 0){
                                     $.get('<?php echo Yii::app()->createUrl('descuentos/NodoLugarDelete'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});
                                }
                             }else{
                                console.log(EventoId+"-"+FuncionesId+"-"+ZonasId+"-"+SubzonaId+"-"+FilasId+"-"+LugaresId);
                                $.get('<?php echo Yii::app()->createUrl('descuentos/TempNodoLugar'); ?>',{EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});  
                                if(DescuentosId > 0){
                                    $.get('<?php echo Yii::app()->createUrl('descuentos/NodoLugarUpdate'); ?>',{CuponesCod:CuponesCod,DescuentosId:DescuentosId,EventoId:EventoId,FuncionesId:FuncionesId,ZonasId:ZonasId,SubzonaId:SubzonaId,FilasId:FilasId,LugaresId:LugaresId});
                                }
                             }
                            
                        });
                    }
                });
////////////////////////////////////Tree View///////////////////////////////////////////////////                        
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
    $("#eliminar_lista_evento_releacionado").click(function(){
        var evento  = $("#lista_eventos_relacionados  option:selected").val();
        var data_db = $("#lista_eventos_relacionados  option:selected").attr("data-db");
        var cupon   = $("#codigo").val();
        if(data_db=="1"){
            var confirmar = confirm("Este registro se encuentra almacenado en la Base de Datos desea continuar con su eliminacion?");
            if(confirmar){
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl('descuentos/DeleteEventosRelacionadosAjax'); ?>',
                    data:'id='+evento+'&cupon='+cupon,
                    success:function(data){
                        alert("El registro se elimino correctamente");
                        //$("#funcion").html(data);
                        }
                  });
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl('descuentos/DeleteTempDescuentosRelacionados'); ?>',
                    data:'EventoId='+evento,
                    success:function(data){
                        $("#lista_eventos_relacionados  option#"+evento).remove();
                        //$("#funcion").html(data);
                        }
                  });
            }
        }else{
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentos/DeleteTempDescuentosRelacionados'); ?>',
                data:'EventoId='+evento,
                success:function(data){
                    console.log('ok_evento_relecionado');
                    $("#lista_eventos_relacionados  option#"+evento).remove();
                    //$("#funcion").html(data);
                }
            });
        }    
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

</div>
