<?php
/* @var $this DescuentosController */
/* @var $model Descuentos */
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $baseUrl = Yii::app()->baseUrl; 
    $js = Yii::app()->getClientScript();
    $js->registerScriptFile($baseUrl.'/js/jquery.dataTables.js');
    
$this->breadcrumbs=array(
	'Descuentos y Cupones'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Descuentos', 'url'=>array('index')),
	array('label'=>'Create Descuentos', 'url'=>array('create')),
);
    
?>

    <?php 
        $this->widget( 'ext.EChosen.EChosen', array(
            'target' => '.chosen',
      ));
    ?>
<div class='controles'>

<h1>
	<?php echo $_GET['tipo']!='descuento'?'Cupones':'Descuentos';?></h1>
	<div class="form">
		<div style='float:none;margin:auto' class='span4'>
	            Ver:
	            <select id="tipo" style="width: 115px;">
	                <option value="cupon">Cupones</option>
	                <option value="descuento" <?php echo $_GET['tipo']!='descuento'?'':'selected'; ?>>Descuentos</option>
	            </select>
		</div>
<br />
				<a href="<?php echo Yii::app()->createUrl('descuentoslevel1/admin&query=').($_GET['tipo']!='descuento'?'&tipo=cupon':'&tipo=descuento');  ?>" id="boton_query" style="margin-bottom: 15px;" class="btn <?php echo $_GET['query']=="inactivos"?"":"ocultar";?>">
				<span class="fa fa-eye"></span><?php echo $_GET['tipo']!='descuento'?'Ver todos los cupones':'Ver todos los descuentos';?></a>

				<a href="<?php echo Yii::app()->createUrl('descuentoslevel1/admin&query=inactivos').($_GET['tipo']!='descuento'?'&tipo=cupon':'&tipo=descuento');  ?>" id="boton_query" style="margin-bottom: 15px;" class="btn <?php echo $_GET['query']=="inactivos"?"ocultar":"";?>">
<span class="fa fa-eye"></span> <?php echo $_GET['tipo']!='descuento'?'Ver cupones inactivos':'Ver descuentos inactivos';?></a>

	    	    <a id="desactivar_seleccion"  class="btn" style="margin-left: 0px;margin-bottom: 15px;"><span class=" fa fa-minus-square-o"></span> Desactivar seleccionados</a>

	            <?php echo CHtml::link("<i class='icon-barcode icon-white'></i>&nbsp;Crear Cupones o Descuentos",array('descuentos/create'),array('title'=>'','class'=>'btn btn-primary','style'=>'margin-left:0px;margin-bottom: 15px;')); ?>
	
	    
	</div>
</div>
    <!--<a id="abrir_cupon"  class="btn btn-success" data-placement='top' title="" style="margin-right: 0px;"><i class="icon-folder-open icon-white"></i>&nbsp;Abrir cup&oacute;n seleccinado</a>-->
    
    
    <?php //echo CHtml::link("<i class='icon-wrench icon-white'></i>&nbsp;Ayuda",array('descuentoslevel1/admin#'),array('title'=>'','class'=>'btn btn-primary')); ?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div id="resultado_elimnar"></div>
<div id="evento-grid" class="">
    <table class="table table-bordered table-hover">
        <thead>
        <th>Activo</th>
        <th>Selecci&oacute;n</th>
        <?php if($_GET['tipo']!='descuento'): ?>
        <th>Cup&oacute;n</th>
        <?php endif; ?>
        <th>Evento</th>
        <th>Descripci&oacute;n</th>
        <th>Forma</th>
        <th>Descuento</th>
        <th>Existencia</th>
        <th>Usados</th>
        <th>CargoXServ</th>
        <th>Acciones</th>
        </thead>
        <tbody>
        <?php
            foreach($model as $key =>$descuentos ):
        ?>
        <tr class="<?php echo ($key%2)==0?'odd':"even"; ?>">
            <td data-cupon="<?php echo $descuentos->descuentos->CuponesCod;  ?>" data-id="<?php echo $descuentos->descuentos->DescuentosId;  ?>" data-EventoId="<?php echo $descuentos->EventoId;  ?>"><?php echo $descuentos->descuentos->DescuentosFecIni=="0000-00-00 00:00:00"?"<i class='icon-remove'></i>":""; ?></td>
            <td class="checkbox-column"><?php echo CHtml::checkBox('delete_checkBox','',array('value'=>$descuentos->DescuentosId,'disabled'=>$descuentos->descuentos->DescuentosFecIni=="0000-00-00 00:00:00"?"disabled":"")); ?></td>
            <?php if($_GET['tipo']!='descuento'): ?>
            <td class="cupon"><?php echo CHtml::link($descuentos->descuentos->CuponesCod,array('descuentoslevel1/admin','query'=> $descuentos->descuentos->CuponesCod,'tipo'=>'cupon'),array('title'=>"Da click para buscar el cupon")); ?></td>
            <?php endif; ?>
            <td><?php echo $descuentos->evento->EventoNom; ?></td>
            <td><?php echo $descuentos->descuentos->DescuentosDes; ?></td>
            <td><?php echo $descuentos->descuentos->DescuentosPat; ?></td>
            <td><?php echo $descuentos->descuentos->DescuentosCan; ?></td>
            <td><?php echo $descuentos->descuentos->DescuentosExis; ?></td>
            <td><?php echo $descuentos->descuentos->DescuentosUso; ?></td>
            <td><?php echo $descuentos->descuentos->DescuentoCargo; ?></td>
            <td>
                <a data-toggle="modal" data-target="#myModal" data-id="<?php echo $descuentos->DescuentosId;  ?>" data-cupon="<?php echo $descuentos->descuentos->CuponesCod;  ?>"  title="view" class="" id="evento_view"><i class="icon-eye-open"></i></a>
                <?php echo CHtml::link("<i class='icon-pencil'></i>",array('descuentos/update','id'=>$descuentos->descuentos->DescuentosId,'cupon'=>$descuentos->descuentos->CuponesCod,'EventoId'=>$descuentos->EventoId),array('title'=>'update')); ?>
                <?php echo $descuentos->descuentos->DescuentosFecIni=="0000-00-00 00:00:00"?"<i class='icon-white icon-trash'></i>":CHtml::link("<i class='icon-trash'></i>",array('delete','id'=>$descuentos->descuentos->DescuentosId,'idnum'=>$descuentos->DescuentosNum),array('title'=>'delete','onclick'=>'return confirm("Deseas eliminar el registro seleccionado?")')); ?>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
        </tbody>    
    </table>
</div>
<style>
ul{
    list-style: none;
}
</style>
<div id="myModal" class="modal hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Detalle</h4>
    </div>
    <div class="modal-body">
        <?php
               // echo CHtml::dropDownList('eventos','',Chtml::listData($eventos,'EventoId','EventoNom'),array('empty'=>'--------------','style'=>'width:500px','class'=>'chosen-select'));
        ?>
        <div id="resultado"></div>
    </div>

    <div class="modal-footer">
     <a data-dismiss="modal" class="btn" href="#">Cerrar</a>    
    </div>
</div>
<script>
$("#tipo").change(function(){
    var url = '<?php echo Yii::app()->createUrl('descuentoslevel1/admin&');  ?>query=&tipo='+this.value;
    window.location.href = url; 
});
$("table.items").dataTable({
        "oLanguage": {
            "sLengthMenu"   : "Mostrar _MENU_ registros por p&aacute;gina",
            "sZeroRecords"  : "Sin resultados",
            "sInfo"         : "Mostrando _START_ de _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty"    : "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered" : "(filtrado de _MAX_  registros)",
            "sSearch"       : "B&uacute;squeda",
            "sPrevious"     : "Anterior",
            "sNext"         : "Siguiente",
        }
    });
/*$("#boton_query").click(function(event){
    $("#descuentos-form").submit();
});*/
$("td a").tooltip();
$("#abrir_cupon").click(function(){
    var cupon = $("tr.selected td:first").attr('data-cupon');
    var id = $("tr.selected td:first").attr('data-id');
    var EventoId = $("tr.selected td:first").attr('data-EventoId');
    if(cupon==null) {
        $(this).attr('title','Debes seleccionar un Cupon');
        $(this).popover('show'); 
    }else{
        $(this).attr('title','');
        $(this).popover('destroy');
        var url = '<?php echo Yii::app()->createUrl('descuentos/update&');  ?>id='+id+'&cupon='+cupon+'&EventoId='+EventoId;
        window.location.href = url;   
    }
    
});
$(".grid-view table.items a#evento_view").click(function(evento){
    var id    = $(this).attr("data-id");
    var cupon = $(this).attr("data-cupon");
    $.ajax({
            url:'<?php echo Yii::app()->createUrl('descuentoslevel1/GetDescuentos'); ?>',
            data:"id="+id+"&cupon="+cupon,
            beforeSend:function(){
                $("#resultado").html("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
            },
            success:function(data){
                //console.log('ok');
                $("#resultado").html(data);
            }
        });
    console.log(id);
});
$("#desactivar_seleccion").click(function(){
    var data= new Array();
    var confirmar = confirm("Desea eliminar los registros seleccionados?");
    if(confirmar){
       $("td.checkbox-column input[type=checkbox]:checked").each(function(index){
            data[index] = this.value;      
            
        });
        if(data.length>0){
            $.ajax({
                url:'<?php echo Yii::app()->createUrl('descuentoslevel1/GetDeleteSeleccion'); ?>',
                data:"data="+data,
                beforeSend:function(){
                    $("#resultado_eliminar").html("<img id='cargando' width='15' src='<?php echo Yii::app()->baseUrl.'/images/loading.gif'; ?>'>");
                },
                success:function(data){
                    console.log(data);
                    $("#resultado_eliminar").html('<div class="flash-error">Registro(s) elimnado(s) existosamente!!!</div>');
                    window.location.reload();
                }
            });
        } 
    }
    
});
$("tr").click(function(event){
    $(".grid-view table.items tr").each(function(){
        $(this).removeClass("selected");
    });
    $(this).addClass("selected");
    
    //console.log("tr");
});
</script>

<style>
.ocultar{
    display: none;
}
.dataTables_length {
	width: 40%;
	float: right;
    text-align: right;
}
.dataTables_length select{
    width: 70px;
}
.dataTables_filter {
	width: 50%;
	float: left;
	text-align: left;
}
.dataTables_info {
	width: 60%;
	float: left;
}

.dataTables_paginate {
	float: right;
	text-align: right;
}
.grid-view
{
	padding: 15px 0;
}

.grid-view table.items
{
	background: white;
	border-collapse: collapse;
	width: 100%;
	border: 1px #D0E3EF solid;
}

.grid-view table.items th, .grid-view table.items td
{
	font-size: 0.9em;
	border: 1px white solid;
	padding: 0.3em;
}

.grid-view table.items th
{
	color: white;
	background-color:#65BAFA ;
	text-align: center;
}

.grid-view table.items th a
{
	color: #EEE;
	font-weight: bold;
	text-decoration: none;
}

.grid-view table.items th a:hover
{
	color: #FFF;
}

.grid-view table.items th a.asc
{
	background:url(up.gif) right center no-repeat;
	padding-right: 10px;
}

.grid-view table.items th a.desc
{
	background:url(down.gif) right center no-repeat;
	padding-right: 10px;
}

.grid-view table.items tr.even
{
	background: #F8F8F8;
}

.grid-view table.items tr.odd
{
	background: #E5F1F4;
}

.grid-view table.items tr.selected
{
	background: #BCE774;
}
.grid-view table.items tr.selected td { background: #EA635B; }
.grid-view table.items tr:hover.selected
{
	background: #CCFF66;
}

.grid-view table.items tbody tr:hover
{
	background: #ECFBD4;
}

.grid-view .link-column img
{
	border: 0;
}

.grid-view .button-column
{
	text-align: center;
	width: 60px;
}

.grid-view .button-column img
{
	border: 0;
}

.grid-view .checkbox-column
{
	width: 15px;
}

.grid-view .summary
{
	margin: 0 0 5px 0;
	text-align: right;
}

.grid-view .pager
{
	margin: 5px 0 0 0;
	text-align: right;
}

.grid-view .empty
{
	font-style: italic;
}

.grid-view .filters input,
.grid-view .filters select
{
	width: 100%;
	border: 1px solid #ccc;
}
</style>

