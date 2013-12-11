<div class='controles'>
<h2>Reportes de ventas web</h2>
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
echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
$modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
$list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
echo CHtml::dropDownList('buscar','',$list,
		array(
				'ajax' => array(
						'type' => 'POST',
						'url' => CController::createUrl('funciones/cargarFunciones'),
						'beforeSend' => 'function() { $("#cargador").addClass("loading");}',
						'complete'   => 'function() { $("#cargador").removeClass("loading");}',
						'update' => '#Ventaslevel1[funcion]',
				),'prompt' => 'Seleccione un Evento...'
		));
?>
	</div>

	<div class="row">
<?php
echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));

echo CHtml::dropDownList('Ventaslevel1[funcion]','',array(),
		array(
				'prompt' => 'Seleccione una Funcion...'
		));
?>
	</div>
	<div class='row'>
	<?php echo CHtml::checkBox('Ventaslevel1[excel]', '', array()); ?>
        <?php echo CHtml::label('Exportar a Excel',false,array()); ?>                          
        <?php
            if(!empty($download)):
            ?>
             <a href="<?php echo $download;?>">Descargar</a>
            <?php
            endif;
        ?>                                                                             
		<?php echo $form->error($model,'buscar'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary')); ?>
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

</div>

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
<style>
.even{
    background-color: #D7FDF6;
}
</style>
<?php
$datos = $dataProvider->getData();
//print_r($dataProvider->getData());
if(!empty($datos[0]['id'])):
echo "Total ".count($dataProvider->getData())." Result(s)" ;
?>
<div id="evento-grid" class="grid-view">
    <table class="items">
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
            <td><?php echo $data['ClientesEma'];//.$data['VentasCon']; ?></td>
            <td>
            <?php 
                $string = $data['VentasCon'];

                if(!empty($string)):
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
</div>
<?php
elseif(!empty($itemselected)):
    echo "No hay informacion para Ventas en Web y Call Center";
endif;
?> 

<style>
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

