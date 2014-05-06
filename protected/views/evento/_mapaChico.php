<style>
.coor-mapa-chico input[type=text]{
    width: 115px;
}
.coor-mapa-chico caption{
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
.area-imagen-chica{
    width: 370px;
    height: 270px;
    text-align: left;
    border:1px solid #EEE;
    position: relative;
}
#cargando{
    color: #FF8000;
    font-size: 14pt;
    font-weight: bold;
}
</style>
<div class="row">
    <div class="coor-menu span7">
     
        <?php
    	$subzonas = Subzona::model()->findAll(array('condition'=>"t.EventoId=$eventoId AND t.FuncionesId = (SELECT FuncionesId FROM subzona WHERE subzona.EventoId=$eventoId  ORDER BY subzona.FuncionesId ASC LIMIT 1)"));
        $funcionesId = Funciones::model()->findAll("EventoId=$eventoId");
        ?>
        <table>
            <tr class="controles-submenu">
                <td><?php echo CHtml::link('<i class="fa fa-eye"></i> Ver coordenadas','#',array('id'=>'ver-coordenadas','class'=>'btn btn-success'))?>
                </td>
                <td><?php echo CHtml::link('<i class="fa fa-repeat"></i> Descartar','#',array('id'=>'descartar','class'=>'btn btn-info'))?></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <br /><br /><br />
    <div class="coor-mapa-chico-img span4" id="coor-mapa-chico-img">
        <div class="area-imagen-chica" id="area-imagen-chica">
            <img src="" />
            <?php //echo TbHtml::imagePolaroid(strlen($funciones->getForoPequenio())>3?$funciones->getForoPequenio():'holder.js/150x150','',
                        //array('id'=>'img-imamapchi','style'=>'')); ?>
        </div>                
    </div>
    <div class="coor-mapa-chico offset4" style="">
        <div>
            <table>
                <caption>Coordenadas</caption>
                <thead>
                    <tr>
                        <td colspan="2">
                            <label>Sub-Zona:</label>
                            <select id="select-sub-zona">
                            <option data-zona="" data-subzona="">Selecciona una Sub-Zona</option>
                            <?php foreach($subzonas as $key => $subzona):?>
                                <option data-zona="<?php echo $subzona->zonas->ZonasId?>" data-subzona="<?php echo $subzona->SubzonaId?>"><?php echo $subzona->zonas->ZonasAli."-".$subzona->SubzonaId?></option>
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
                        <td><?php echo CHtml::link('<i class="fa fa-trash-o"></i> Eliminar','#',array('id'=>'eliminar-coordenada','class'=>'btn btn-danger'))?></td>
                        <td><?php echo CHtml::link('<i class="fa fa-save"></i> Guardar','#',array('id'=>'guardar-coordenada','class'=>'btn btn-primary'))?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="cargando"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    window.localStorage.clear()
    localStorage.setItem('coor_mapa_chico',0);
    var x1 = null;
    var x2 = null;
    var y1 = null;
    var y2 = null;
$("#area-imagen-chica").click(function(e){
    var par_xy = localStorage.getItem('coor_mapa_chico');
    if(par_xy<=4){
        var x = e.pageX - $(this).offset().left;
        var y = e.pageY - $(this).offset().top;
        x = Math.floor(x)
        y = Math.floor(y);
        par_xy++;
        $("#x"+par_xy).val(x);
        $("#y"+par_xy).val(y);
        localStorage.setItem('coor_mapa_chico',par_xy);
        if(x1==null && x2 ==null){
            x1 = x;
            y1 = y;        
        }else{
            x2 = x;
            y2 = y;
            createLine(x1,y1,x2,y2,this);
            x1 = x2;
            y1 = y2;
        }
    }else{
        alert('Ya se agregaron 5 coordenadas por favor Guarde para Agregar mas.');
    }
    
});
$("#descartar").click(function(){
    localStorage.setItem('coor_mapa_chico',0);
    resetLines();
    $('input[name^="x"]').val('');
    $('input[name^="y"]').val('');
    return false;
});
$("#select-sub-zona").change(function(){
    var zona      = $('option:selected',this).data('zona');
    var subzona   = $('option:selected',this).data('subzona');
    var eventoId  = '<?php echo $_GET['id']?>';
    var funcionId = $("#coor-funcionid").attr('data-funcionId');
    if(zona!="" && subzona!=""){
        //console.log(zona+'-'+subzona+'-'+eventoId+'-'+funcionId);
        $.ajax({
            url:'<?php echo $this->createUrl('evento/getCoordenadaMapaChico') ?>',
            type:'post',
            dataType:'json',
            beforeSend:function(){
                $("#cargando").html("Cargando Coordenadas");
            },
            data:{zona:zona,subzona:subzona,eventoId:eventoId,funcionId:funcionId},
            success:function(data){
                localStorage.setItem('coor_mapa_chico',0);
                resetLines();
                $('input[name^="x"]').val('');
                $('input[name^="y"]').val('');
                var mapa = $("#area-imagen-chica");
                if(data.x2!=""){
                    createLine(data.x1,data.y1,data.x2,data.y2,mapa);
                }
                if(data.x3!=""){
                    createLine(data.x2,data.y2,data.x3,data.y3,mapa);
                }
                if(data.x4!=""){
                    createLine(data.x3,data.y3,data.x4,data.y4,mapa);
                }
                if(data.x5!=""){
                    createLine(data.x4,data.y4,data.x5,data.y5,mapa);
                }
                $("#x1").val(data.x1);
                $("#y1").val(data.y1);
                $("#x2").val(data.x2);
                $("#y2").val(data.y2);
                $("#x3").val(data.x3);
                $("#y3").val(data.y3);
                $("#x4").val(data.x4);
                $("#y4").val(data.y4);
                $("#x5").val(data.x5);
                $("#y5").val(data.y5);
                //console.log(data);
                $("#cargando").html("");
            }
        });
    }
    
});
$("#ver-coordenadas").click(function(){
    var eventoId  = '<?php echo $_GET['id']?>';
    var funcionId = $("#coor-funcionid").attr('data-funcionId');
    $.ajax({
        url:'<?php echo $this->createUrl('evento/getCoordenadasMapaChico') ?>',
            type:'post',
            dataType:'json',
            beforeSend:function(){
                $("#cargando").html("Cargando Coordenadas");
            },
            data:{eventoId:eventoId,funcionId:funcionId},
            success:function(data){
                localStorage.setItem('coor_mapa_chico',0);
                resetLines();
                $('input[name^="x"]').val('');
                $('input[name^="y"]').val('');
                var mapa = $("#area-imagen-chica");
                
                $.each(data,function(zona){
                    $.each(data[zona],function(subzona){
                        if(data[zona][subzona].x2!=""){
                            createLine(data[zona][subzona].x1,data[zona][subzona].y1,data[zona][subzona].x2,data[zona][subzona].y2,mapa);
                        }
                        if(data[zona][subzona].x3!=""){
                            createLine(data[zona][subzona].x2,data[zona][subzona].y2,data[zona][subzona].x3,data[zona][subzona].y3,mapa);
                        }
                        if(data[zona][subzona].x4!=""){
                            createLine(data[zona][subzona].x3,data[zona][subzona].y3,data[zona][subzona].x4,data[zona][subzona].y4,mapa);
                        }
                        if(data[zona][subzona].x5!=""){
                            createLine(data[zona][subzona].x4,data[zona][subzona].y4,data[zona][subzona].x5,data[zona][subzona].y5,mapa);
                        }    
                        //console.log(subzona);
                    });
                    
                });
                //console.log(data);
                $("#cargando").html("");
            }
    });
    return false;
});
$("#guardar-coordenada").click(function(){
    var zona      = $('#select-sub-zona option:selected').data('zona');
    var subzona   = $('#select-sub-zona option:selected').data('subzona');
    var eventoId  = '<?php echo $_GET['id']?>';
    var funcionId = $("#coor-funcionid").attr('data-funcionId');
    var x1 = $("#x1").val();
    var y1 = $("#y1").val();
    var x2 = $("#x2").val();
    var y2 = $("#y2").val();
    var x3 = $("#x3").val();
    var y3 = $("#y3").val();
    var x4 = $("#x4").val();
    var y4 = $("#y4").val();
    var x5 = $("#x5").val();
    var y5 = $("#y5").val();
    
    if(zona!="" && subzona!=""){
        $.ajax({
                url:'<?php echo $this->createUrl('evento/guardarCoordenadasMapaChico') ?>',
                type:'post',
                dataType:'json',
                beforeSend:function(){
                    $("#cargando").html("Guardando Coordenadas");
                },
                data:{eventoId:eventoId,funcionId:funcionId,zona:zona,subzona:subzona,x1:x1,y1:y1,x2:x2,y2:y2,x3:x3,y3:y3,x4:x4,y4:y4,x5:x5,y5:y5},
                success:function(data){
                    if(data.update==true){
                        localStorage.setItem('coor_mapa_chico',0);
                        resetLines();
                        $('input[name^="x"]').val('');
                        $('input[name^="y"]').val('');
                    }else{ alert('No se puedo Guardar la Sub-Zona seleccionada'); }
                    $("#cargando").html("");
                }
        });
    }else{
        alert('Necesitas seleccionar la Sub-Zona a Guardar');
    }
    return false;
});
$("#eliminar-coordenada").click(function(){
    var zona      = $('#select-sub-zona option:selected').data('zona');
    var subzona   = $('#select-sub-zona option:selected').data('subzona');
    var eventoId  = '<?php echo $_GET['id']?>';
    var funcionId = $("#coor-funcionid").attr('data-funcionId');
    if(zona!="" && subzona!=""){
        var del = confirm("¿Deseas eliminar las coordenadas de la Sub-Zona Seleccionada?");
        if (del == true) {
            $.ajax({
                url:'<?php echo $this->createUrl('evento/deleteCoordenadaMapaChico') ?>',
                type:'post',
                beforeSend:function(){
                    $("#cargando").html("Eliminando Coordenadas");
                },
                dataType:'json',
                data:{eventoId:eventoId,funcionId:funcionId,zona:zona,subzona:subzona},
                success:function(data){
                    if(data.update==true){
                        localStorage.setItem('coor_mapa_chico',0);
                        resetLines();
                        $('input[name^="x"]').val('');
                        $('input[name^="y"]').val('');
                    }else{ alert('No se puedo eliminar la Sub-Zona seleccionada'); }
                    //console.log(data);
                    $("#cargando").html("");
                }
            });
           //console.log('eliminado');
        }
    }else{
        alert('Necesitas seleccionar la Sub-Zona a eliminar');
    }
    return false;
});
function resetLines(){
     $('#area-imagen-chica .line').fadeOut(300, function(){ $(this).remove(); });
     this.x1 = null;
     this.x2 = null;
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