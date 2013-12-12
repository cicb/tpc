<div class='controles'>
        <h2>Reporte de ventas para Farmatodo</h2>

<script type="javascript">
//function habilitar(){
    //alert("hola");
    //selec = document.getElementById('mes');
    //if(selec.options[1])
    //{
        //alert("hola")
    //}
//};
</script>

<div id="cargador"  style="  border:0px; font-weight: bold; font-size: 15px;" align="center">
</div>
<div class="form">
<div style="display: inline-table;text-align:right;">
<?php 
echo CHtml::beginForm($this->createUrl('reportes/ventasFarmatodo'),'POST',array('name'=>'frmreporte','onchange'=>"habilitar();"));
?>
    <div class="row">
        <?php
            echo CHtml::label('Por Mes: ','mes');
            echo CHtml::dropDownList('mes',$indice,array(
                'todo'=>'Todos',
                '2011-01-01'=>'Enero',
                '2011-02-01'=>'Febrero',
                '2011-03-01'=>'Marzo',
                '2011-04-01'=>'Abril',
                '2011-05-01'=>'Mayo',
                '2011-06-01'=>'Junio',
                '2011-07-01'=>'Julio',
                '2011-08-01'=>'Agosto',
                '2011-09-01'=>'Septiembre',
                '2011-10-01'=>'Octubre',
                '2011-11-01'=>'Noviembre',
                '2011-12-01'=>'Diciembre',
            ));
        ?>
    </div>
    
    <div class="row">
    <?php
      echo CHtml::label('Por Turno: ','turno');
      echo CHtml::dropDownList('turno',$indiceTurno,array(
        'todo'=>'Ambos Turnos',
        '07:00:00-14:59:59'=>'de 7:00 AM a 2:59 PM',
        '15:00:00-23:59:59'=>'de 3:00 PM a 11:59 PM',
      )
      //array('disabled'=>'disabled')
      );
        ?>
    </div>
</div>
<div style="display: inline-table; margin-left: 50px; text-align:right;">
<b>Ordenar por:</b>
<?php
echo CHtml::beginForm($this->createUrl('reportes/ventasFarmatodo'),'POST',array('name'=>'frmreporteordenars'));
?>
<div class="row">
    <?php
      echo CHtml::label('Por Total de venta: ','totalventa');
      echo CHtml::dropDownList('totalventa',$indiceventa,array(
        'todo'=>'Selecionar',
        'total_de_venta_en_pesos ASC'=>'de menor a mayor',
        'total_de_venta_en_pesos DESC'=>'de mayor a menor',
      ));
        ?>
</div>
<div class="row">
    <?php
      echo CHtml::label('Por Total de Transacciones: ','totaltransacciones');
      echo CHtml::dropDownList('totaltransacciones',$indicetransaccion,array(
        'todo'=>'Seleccionar',
        'total_transacciones ASC'=>'de menor a mayor',
        'total_transacciones DESC'=>'de mayor a menor',
      ));
        ?>
</div>
<div class="row">
    <?php
      echo CHtml::label('Por Total de Boletos: ','totalboleto');
      echo CHtml::dropDownList('totalboleto',$indiceboleto,array(
        'todo'=>'Seleccionar',
        'total_de_boletos ASC'=>'de menor a mayor',
        'total_de_boletos DESC'=>'de mayor a menor',
      ));
        ?>
</div>

</div>
 <div class="row" >
        <?php echo CHtml::submitButton('Generar reporte', array('class'=>'btn btn-primary')); ?>
    </div>
<br />
</div><!-- form -->


                    
  <style>
label{display:inline-block;}
.CANCELADO{
        background-color:#FFCECE;}
</style>
<?php
$signo = "&#36";
?>

</div>
<div id="Contenido" >
<?php if (!is_null($dataproviderReporte)): ?>
    <?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'evento-grid',
        'emptyText'=>'No se encontraron coincidencias',
        'dataProvider'=>$dataproviderReporte,
        'summaryText'=>'Mostrando {start}-{end} de {end} resultados',
        'columns'=>array(
            array(
                'name'=>'PuntosventaNom',
                'value'=>'$data->PuntosventaNom',
            ),
            array(
                'name'=>'total_de_venta_en_pesos',
                'value'=>'"$".number_format($data->total_de_venta_en_pesos,2)',
                'type'=>'raw',
                'htmlOptions'=>array(
                'style'=>'text-align:right;'
            )
            ),
            array(
                'name'=>'total_transacciones',
                'value'=>'$data->total_transacciones',
                'htmlOptions'=>array(
                'style'=>'text-align:center;'
            )
            ),             
             array(
                'name'=>'total_de_boletos',
                'value'=>'$data->total_de_boletos',
                'htmlOptions'=>array(
                'style'=>'text-align:center;'
            )
            ),
            
            array(
                'name'=>'Fecha de la Ultima Transaccion',
                'value'=>'$data->VentasFecHor',
                   'htmlOptions'=>array(
                'style'=>'text-align:center;'
            )
            ),
        ),
    )); ?>
<?php endif;?>
</div>
   

