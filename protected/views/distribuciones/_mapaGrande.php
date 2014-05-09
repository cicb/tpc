<style>
.coor-mapa-grande input[type=text]{
    width: 115px;
    margin-bottom: 0;
}
.coor-mapa-grande caption{
    font-weight: bold;
    background-color: #EEE;
}
.coor-menu label{
    /*display: inline-block;*/
}
.coor-menu table{
    width: 100%;
    text-align: right;
}
.coor-menu table tr.controles-submenu td{
    text-align: center;
    width: 25%;
    padding: 3px 0;
}
.area-imagen-grande{
    width: 785px;
    height: 563px;
    text-align: left;
    border:1px solid #EEE;
    position: relative;
}
#cargando-grande{
    color: #FF8000;
    font-size: 14pt;
    font-weight: bold;
}
</style>
<div class="row"> 
    <div class="coor-menu span7">
     
        <?php $subzonas = Subzona::model()->findAll(array('condition'=>"t.EventoId=$eventoId AND t.FuncionesId = (SELECT FuncionesId FROM subzona WHERE subzona.EventoId=$eventoId  ORDER BY subzona.FuncionesId ASC LIMIT 1)"));?>
        <table>
            <tr class="controles-submenu">
                <td><?php echo CHtml::link('<i class="fa fa-eye"></i> Ver coordenadas','#',array('id'=>'ver-coordenadas-mapa-grande','class'=>'btn btn-success'))?>
                </td>
                <td><?php echo CHtml::link('<i class="fa fa-repeat"></i> Descartar','#',array('id'=>'descartar-mapa-grande','class'=>'btn btn-info'))?></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <br /><br /><br />
    <div class="coor-mapa-grande-img span8" id="coor-mapa-grande-img">
        <div class="area-imagen-grande" id="area-imagen-grande">
            <img src="<?php echo $model->getForoGrande() ?>" />
        </div>                
    </div>
    <div class="coor-mapa-grande span3" style="">
        <div>
            <table>
                <caption>Coordenadas</caption>
                <thead>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <label>Sub-Zona:</label>
                            <select id="select-sub-zona-mapa-grande">
                                <option data-zona='' data-subzona=''>Selecciona una Sub-Zona</option>
                                <?php foreach($subzonas as $key => $subzona):?>
                                     <option data-zona='<?php echo $subzona->ZonasId?>' data-subzona='<?php echo $subzona->SubzonaId?>'><?php echo $subzona->zonas->ZonasAli."-".$subzona->SubzonaId?></option>";
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>X</th>
                        <th>Y</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x1" id="x1" /></td>
                        <td><input type="text" readonly="readonly" name="y1" id="y1" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x2" id="x2" /></td>
                        <td><input type="text" readonly="readonly" name="y2" id="y2" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x3" id="x3" /></td>
                        <td><input type="text" readonly="readonly" name="y3" id="y3" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x4" id="x4" /></td>
                        <td><input type="text" readonly="readonly" name="y4" id="y4" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x5" id="x5" /></td>
                        <td><input type="text" readonly="readonly" name="y5" id="y5" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x6" id="x6" /></td>
                        <td><input type="text" readonly="readonly" name="y6" id="y6" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x7" id="x7" /></td>
                        <td><input type="text" readonly="readonly" name="y7" id="y7" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x8" id="x8" /></td>
                        <td><input type="text" readonly="readonly" name="y8" id="y8" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x9" id="x9" /></td>
                        <td><input type="text" readonly="readonly" name="y9" id="y9" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x10" id="x10" /></td>
                        <td><input type="text" readonly="readonly" name="y10" id="y10" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x11" id="x11" /></td>
                        <td><input type="text" readonly="readonly" name="y11" id="y11" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x12" id="x12" /></td>
                        <td><input type="text" readonly="readonly" name="y12" id="y12" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x13" id="x13" /></td>
                        <td><input type="text" readonly="readonly" name="y13" id="y13" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly="readonly" name="x14" id="x14" /></td>
                        <td><input type="text" readonly="readonly" name="y14" id="y14" /></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td><?php echo CHtml::link('<i class="fa fa-trash-o"></i> Eliminar','#',array('id'=>'eliminar-coordenada-mapa-grande','class'=>'btn btn-danger'))?></td>
                        <td><?php echo CHtml::link('<i class="fa fa-save"></i> Guardar','#',array('id'=>'guardar-coordenada-mapa-grande','class'=>'btn btn-primary'))?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="cargando-grande"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="span3">
        <label style="text-align: center;font-weight: bold;background-color: #EEE;">Aforo por Zona</label>
        <?php echo $model->forolevel1->getTablaZonas(array('class'=>'table')); ?>
    </div>
</div>
<div >
	<?php  echo TbHtml::fileField('imamapgra','' , array('span'=>2,'maxlength'=>200, 'class'=>'hidden')); ?>
					<?php echo TbHtml::button('<i class="fa fa-picture-o"></i> Cambiar imagen',array('class'=>'btn btn-warning','id'=>'btn-subir-imamapgra')); ?>
</div>
<script>
var ext= ['jpg','png','bmp','jpeg'];
            $('#btn-subir-imamapgra').on('click',function(){ 
                var guardarImagen = confirm('¿Desea cambiar la imagen? Los cambios afectaran a todos los eventos asociados a la imagen ');
                if(guardarImagen){
                    $('#imamapgra').trigger('click');
                }
            });
            $('#imamapgra').on('change',function(){
                var eventoId = '<?php echo $eventoId; ?>';
                var funcionId = '<?php echo $funcionId; ?>';
					 if ($(this).val()!='' && $(this).val()!=null) {
							 if ($.inArray($(this).val().split('.').pop(),ext)==-1) {
									 alert('El archivo no tiene extension valida, (jpg,png,bmp,jpeg), por favor seleccione otro.');
									$(this).val('');	
					         }else{	
								var fd = new FormData();
								var imagen = document.getElementById('imamapgra');
								fd.append('imagen', imagen.files[0]);
								fd.append('prefijo', 'mapaGrande_');
                                fd.append('eventoId', eventoId);
                                fd.append('funcionId', funcionId);
                                //console.log(fd);
								$.ajax({
										url: '<?php echo Yii::app()->createUrl('distribuciones/subirImagenMapaGrande')?>',
												type: 'POST',
												data: fd,
												processData: false,  // tell jQuery not to process the data
												contentType: false,   // tell jQuery not to set contentType
												success: function(data){ 
												    console.log(data);
														if (data) {
																$('#area-imagen-grande img').attr('src','../imagesbd/'+data);

														}	
												 }
								}).fail(function(){alert('Error!')});	
                            }	
				 }
			});
    localStorage.setItem('coor_mapa_grande',0);
    var g_x1 = null;
    var g_x2 = null;
    var g_y1 = null;
    var g_y2 = null;
$("#area-imagen-grande").click(function(e){
    var par_xy = localStorage.getItem('coor_mapa_grande');
    if(par_xy<=14){
        var x = e.pageX - $(this).offset().left;
        var y = e.pageY - $(this).offset().top;
        x = Math.floor(x)
        y = Math.floor(y);
        par_xy++;
        $(".coor-mapa-grande #x"+par_xy).val(x);
        $(".coor-mapa-grande #y"+par_xy).val(y);
        localStorage.setItem('coor_mapa_grande',par_xy);
        if(g_x1==null && g_x2 ==null){
            g_x1 = x;
            g_y1 = y;        
        }else{
            g_x2 = x;
            g_y2 = y;
            createLine(g_x1,g_y1,g_x2,g_y2,this);
            g_x1 = g_x2;
            g_y1 = g_y2;
        }
    }else{
        alert('Ya se agregaron 14 coordenadas por favor Guarde para Agregar mas.');
    }
    
});
$("#descartar-mapa-grande").click(function(){
    localStorage.setItem('coor_mapa_grande',0);
    resetLinesGrande();
    $('input[name^="x"]').val('');
    $('input[name^="y"]').val('');
    return false;
});
$("#select-sub-zona-mapa-grande").change(function(){
    var zona      = $('option:selected',this).data('zona');
    var subzona   = $('option:selected',this).data('subzona');
    var eventoId  = '<?php echo $eventoId?>';
    var funcionId = '<?php echo $funcionId?>';
    if(zona!="" && subzona!=""){
        //console.log(zona+'-'+subzona+'-'+eventoId+'-'+funcionId);
        $.ajax({
            url:'<?php echo $this->createUrl('distribuciones/getCoordenadaMapaGrande') ?>',
            type:'post',
            dataType:'json',
            beforeSend:function(){
                $("#cargando-grande").html("Cargando Coordenadas");
            },
            data:{zona:zona,subzona:subzona,eventoId:eventoId,funcionId:funcionId},
            success:function(data){
                localStorage.setItem('coor_mapa_grande',0);
                resetLinesGrande();
                $('input[name^="x"]').val('');
                $('input[name^="y"]').val('');
                var mapa = $("#area-imagen-grande");
                if(data.x2!=null && data.x2!="" && data.x2!=0){
                    createLine(data.x1,data.y1,data.x2,data.y2,mapa);
                }
                if(data.x3!=null && data.x3!="" && data.x3!=0){
                    createLine(data.x2,data.y2,data.x3,data.y3,mapa);
                }
                if(data.x4!=null && data.x4!="" && data.x4!=0){
                    createLine(data.x3,data.y3,data.x4,data.y4,mapa);
                }
                if(data.x5!=null && data.x5!="" && data.x5!=0){
                    createLine(data.x4,data.y4,data.x5,data.y5,mapa);
                }
                if(data.x6!=null && data.x6!="" && data.x6!=0){
                    createLine(data.x5,data.y5,data.x6,data.y6,mapa);
                }
                if(data.x7!=null && data.x7!="" && data.x7!=0){
                    createLine(data.x6,data.y6,data.x7,data.y7,mapa);
                }
                if(data.x8!=null && data.x8!="" && data.x8!=0){
                    createLine(data.x7,data.y7,data.x8,data.y8,mapa);
                }
                if(data.x9!=null && data.x9!="" && data.x9!=0){
                    createLine(data.x8,data.y8,data.x9,data.y9,mapa);
                }
                if(data.x10!=null && data.x10!="" && data.x10!=0){
                    createLine(data.x9,data.y9,data.x10,data.y10,mapa);
                }
                if(data.x11!=null && data.x11!="" && data.x11!=0){
                    createLine(data.x10,data.y10,data.x11,data.y11,mapa);
                }
                if(data.x12!=null && data.x12!="" && data.x12!=0){
                    createLine(data.x11,data.y11,data.x12,data.y12,mapa);
                }
                if(data.x13!=null && data.x13!="" && data.x13!=0){
                    createLine(data.x12,data.y12,data.x13,data.y13,mapa);
                }
                if(data.x14!=null && data.x14!="" && data.x14!=0){
                    createLine(data.x13,data.y13,data.x14,data.y14,mapa);
                }
                
                $(".coor-mapa-grande #x1").val(data.x1);
                $(".coor-mapa-grande #y1").val(data.y1);
                $(".coor-mapa-grande #x2").val(data.x2);
                $(".coor-mapa-grande #y2").val(data.y2);
                $(".coor-mapa-grande #x3").val(data.x3);
                $(".coor-mapa-grande #y3").val(data.y3);
                $(".coor-mapa-grande #x4").val(data.x4);
                $(".coor-mapa-grande #y4").val(data.y4);
                $(".coor-mapa-grande #x5").val(data.x5);
                $(".coor-mapa-grande #y5").val(data.y5);
                $(".coor-mapa-grande #x6").val(data.x6);
                $(".coor-mapa-grande #y6").val(data.y6);
                $(".coor-mapa-grande #x7").val(data.x7);
                $(".coor-mapa-grande #y7").val(data.y7);
                $(".coor-mapa-grande #x8").val(data.x8);
                $(".coor-mapa-grande #y8").val(data.y8);
                $(".coor-mapa-grande #x9").val(data.x9);
                $(".coor-mapa-grande #y9").val(data.y9);
                $(".coor-mapa-grande #x10").val(data.x10);
                $(".coor-mapa-grande #y10").val(data.y10);
                $(".coor-mapa-grande #x11").val(data.x11);
                $(".coor-mapa-grande #y11").val(data.y11);
                $(".coor-mapa-grande #x12").val(data.x12);
                $(".coor-mapa-grande #y12").val(data.y12);
                $(".coor-mapa-grande #x13").val(data.x13);
                $(".coor-mapa-grande #y13").val(data.y13);
                $(".coor-mapa-grande #x14").val(data.x14);
                $(".coor-mapa-grande #y14").val(data.y14);
                
                //console.log(data);
                $("#cargando-grande").html("");
            }
        });
    }
    
});
$("#ver-coordenadas-mapa-grande").click(function(){
     var eventoId  = '<?php echo $eventoId?>';
    var funcionId = '<?php echo $funcionId?>';
    $.ajax({
        url:'<?php echo $this->createUrl('distribuciones/getCoordenadasMapaGrande') ?>',
            type:'post',
            dataType:'json',
            beforeSend:function(){
                $("#cargando-grande").html("Cargando Coordenadas");
            },
            data:{eventoId:eventoId,funcionId:funcionId},
            success:function(data){
               localStorage.setItem('coor_mapa_grande',0);
                resetLinesGrande();
                $('input[name^="x"]').val('');
                $('input[name^="y"]').val('');
                var mapa = $("#area-imagen-grande");
                
                $.each(data,function(zona){
                    $.each(data[zona],function(subzona){
                        if(data[zona][subzona].x2!=null && data[zona][subzona].x2!="" && data[zona][subzona].x2!=0){
                            createLine(data[zona][subzona].x1,data[zona][subzona].y1,data[zona][subzona].x2,data[zona][subzona].y2,mapa);
                        }
                        if(data[zona][subzona].x3!=null && data[zona][subzona].x3!="" && data[zona][subzona].x3!=0){
                            createLine(data[zona][subzona].x2,data[zona][subzona].y2,data[zona][subzona].x3,data[zona][subzona].y3,mapa);
                        }
                        if(data[zona][subzona].x4!=null && data[zona][subzona].x4!="" && data[zona][subzona].x4!=0){
                            createLine(data[zona][subzona].x3,data[zona][subzona].y3,data[zona][subzona].x4,data[zona][subzona].y4,mapa);
                        }
                        if(data[zona][subzona].x5!=null && data[zona][subzona].x5!="" && data[zona][subzona].x5!=0){
                            createLine(data[zona][subzona].x4,data[zona][subzona].y4,data[zona][subzona].x5,data[zona][subzona].y5,mapa);
                        }   
                        if(data[zona][subzona].x6!=null && data[zona][subzona].x6!="" && data[zona][subzona].x6!=0){
                            createLine(data[zona][subzona].x5,data[zona][subzona].y5,data[zona][subzona].x6,data[zona][subzona].y6,mapa);
                        } 
                        if(data[zona][subzona].x7!=null && data[zona][subzona].x7!="" && data[zona][subzona].x7!=0){
                            createLine(data[zona][subzona].x6,data[zona][subzona].y6,data[zona][subzona].x7,data[zona][subzona].y7,mapa);
                        }
                        if(data[zona][subzona].x8!=null && data[zona][subzona].x8!="" && data[zona][subzona].x8!=0){
                            createLine(data[zona][subzona].x7,data[zona][subzona].y7,data[zona][subzona].x8,data[zona][subzona].y8,mapa);
                        }
                        if(data[zona][subzona].x9!=null && data[zona][subzona].x9!="" && data[zona][subzona].x9!=0){
                            createLine(data[zona][subzona].x8,data[zona][subzona].y8,data[zona][subzona].x9,data[zona][subzona].y9,mapa);
                        }
                        if(data[zona][subzona].x10!=null && data[zona][subzona].x10!="" && data[zona][subzona].x10!=0){
                            createLine(data[zona][subzona].x9,data[zona][subzona].y9,data[zona][subzona].x10,data[zona][subzona].y10,mapa);
                        }
                        if(data[zona][subzona].x11!=null && data[zona][subzona].x11!="" && data[zona][subzona].x11!=0){
                            createLine(data[zona][subzona].x10,data[zona][subzona].y10,data[zona][subzona].x11,data[zona][subzona].y11,mapa);
                        }
                        if(data[zona][subzona].x12!=null && data[zona][subzona].x12!="" && data[zona][subzona].x12!=0){
                            createLine(data[zona][subzona].x11,data[zona][subzona].y11,data[zona][subzona].x12,data[zona][subzona].y12,mapa);
                        }
                        if(data[zona][subzona].x13!=null && data[zona][subzona].x13!="" && data[zona][subzona].x13!=0){
                            createLine(data[zona][subzona].x12,data[zona][subzona].y12,data[zona][subzona].x13,data[zona][subzona].y13,mapa);
                        }
                        if(data[zona][subzona].x14!=null && data[zona][subzona].x14!="" && data[zona][subzona].x14!=0){
                            createLine(data[zona][subzona].x13,data[zona][subzona].y13,data[zona][subzona].x14,data[zona][subzona].y14,mapa);
                        }
                        //console.log(subzona);
                    });
                    
                });
                 console.log(data);
                $("#cargando-grande").html("");
            }
    });
    return false;
});
$("#guardar-coordenada-mapa-grande").click(function(){
    var zona      = $('#select-sub-zona-mapa-grande option:selected').data('zona');
    var subzona   = $('#select-sub-zona-mapa-grande option:selected').data('subzona');
    var eventoId  = '<?php echo $eventoId?>';
    var funcionId = '<?php echo $funcionId?>';
    var escenario = '<?php echo @$_GET['escenario']?>';
    var x1 = $(".coor-mapa-grande #x1").val();
    var y1 = $(".coor-mapa-grande #y1").val();
    var x2 = $(".coor-mapa-grande #x2").val();
    var y2 = $(".coor-mapa-grande #y2").val();
    var x3 = $(".coor-mapa-grande #x3").val();
    var y3 = $(".coor-mapa-grande #y3").val();
    var x4 = $(".coor-mapa-grande #x4").val();
    var y4 = $(".coor-mapa-grande #y4").val();
    var x5 = $(".coor-mapa-grande #x5").val();
    var y5 = $(".coor-mapa-grande #y5").val();
    var x6 = $(".coor-mapa-grande #x6").val();
    var y6 = $(".coor-mapa-grande #y6").val();
    var x7 = $(".coor-mapa-grande #x7").val();
    var y7 = $(".coor-mapa-grande #y7").val();
    var x8 = $(".coor-mapa-grande #x8").val();
    var y8 = $(".coor-mapa-grande #y8").val();
    var x9 = $(".coor-mapa-grande #x9").val();
    var y9 = $(".coor-mapa-grande #y9").val();
    var x10 = $(".coor-mapa-grande #x10").val();
    var y10 = $(".coor-mapa-grande #y10").val();
    var x11 = $(".coor-mapa-grande #x11").val();
    var y11 = $(".coor-mapa-grande #y11").val();
    var x12 = $(".coor-mapa-grande #x12").val();
    var y12 = $(".coor-mapa-grande #y12").val();
    var x13 = $(".coor-mapa-grande #x13").val();
    var y13 = $(".coor-mapa-grande #y13").val();
    var x14 = $(".coor-mapa-grande #x14").val();
    var y14 = $(".coor-mapa-grande #y14").val();
    
    if(zona!="" && subzona!=""){
        $.ajax({
                url:'<?php echo $this->createUrl('distribuciones/guardarCoordenadasMapaGrande') ?>',
                type:'post',
                dataType:'json',
                beforeSend:function(){
                    $("#cargando-grande").html("Guardando Coordenadas");
                },
                data:{eventoId:eventoId,funcionId:funcionId,zona:zona,subzona:subzona,escenario:escenario,x1:x1,y1:y1,x2:x2,y2:y2,x3:x3,y3:y3,x4:x4,y4:y4,x5:x5,y5:y5,x6:x6,y6:y6,x7:x7,y7:y7,x8:x8,y8:y8,x9:x9,y9:y9,x10:x10,y10:y10,x11:x11,y11:y11,x12:x12,y12:y12,x13:x13,y13:y13,x14:x14,y14:y14},
                success:function(data){
                    if(data.update==true){
                        localStorage.setItem('coor_mapa_grande',0);
                        resetLinesGrande();
                        $('input[name^="x"]').val('');
                        $('input[name^="y"]').val('');
                    }else{ alert('No se puedo Guardar la Sub-Zona seleccionada'); }
                    $("#cargando-grande").html("");
                }
        });
    }else{
        alert('Necesitas seleccionar la Sub-Zona a Guardar');
    }
    return false;
});
$("#eliminar-coordenada-mapa-grande").click(function(){
    var zona      = $('#select-sub-zona-mapa-grande option:selected').data('zona');
    var subzona   = $('#select-sub-zona-mapa-grande option:selected').data('subzona');
    var eventoId  = '<?php echo $eventoId?>';
    var funcionId = '<?php echo $funcionId?>';
    var escenario = '<?php echo @$_GET['escenario']?>';
    if(zona!="" && subzona!=""){
        var del = confirm("¿Deseas eliminar las coordenadas de la Sub-Zona Seleccionada?");
        if (del == true) {
            $.ajax({
                url:'<?php echo $this->createUrl('distribuciones/deleteCoordenadaMapaGrande') ?>',
                type:'post',
                beforeSend:function(){
                    $("#cargando-grande").html("Eliminando Coordenadas");
                },
                dataType:'json',
                data:{eventoId:eventoId,funcionId:funcionId,zona:zona,subzona:subzona,escenario:escenario},
                success:function(data){
                    if(data.update==true){
                        localStorage.setItem('coor_mapa_grande',0);
                        resetLinesGrande();
                        $('input[name^="x"]').val('');
                        $('input[name^="y"]').val('');
                    }else{ alert('No se pudo eliminar la Sub-Zona seleccionada'); }
                    //console.log(data);
                    $("#cargando-grande").html("");
                    console.log(data);
                }
            });
           
        }
    }else{
        alert('Necesitas seleccionar la Sub-Zona a eliminar');
    }
    return false;
});
function resetLinesGrande(){
     $('#area-imagen-grande .line').fadeOut(300, function(){ $(this).remove(); });
     this.g_x1 = null;
     this.g_x2 = null;
 }
function createLine(x1,y1, x2,y2,mapa_coordenadas){
	var length = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
    var angle  = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
    var transform = 'rotate('+angle+'deg)';
    //console.log("linex:"+x1+"liney:"+y1);
		var line = $('<div>')
			.appendTo(mapa_coordenadas)
			.addClass('line')
			.css({
			  'position': 'absolute',
			  '-webkit-transform':  transform,
			  '-moz-transform':     transform,
			  'transform':          transform,
              'left': x1+'px',
              'top': y1+'px'
			})
			.width(length);

		return line;
	}
</script>
<style>
/* Lines can be styled with normal css: */
  div.line{
    -webkit-transform-origin: 0 50%;
       -moz-transform-origin: 0 50%;
            transform-origin: 0 50%;
                 
    height: 3px; /* Line width of 3 */
    background: #FF9900; /* Black fill */
    opacity: 0.8;
    box-shadow: 0 0 4px #B99B7E;
    
    /* For some nice animation on the rotates: */
    -webkit-transition: -webkit-transform 1s;
       -moz-transition:    -moz-transform 1s;
            transition:         transform 1s;
  }
  
  div.line:hover{
    background: #C30;
    box-shadow: 0 0 4px #C30;
    opacity: 1;
  }
  
  div.line.active{
    background: #666;
    box-shadow: 0 0 4px #666;
    opacity: 1;
  }
</style>