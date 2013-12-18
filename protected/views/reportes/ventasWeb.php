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
echo CHtml::dropDownList('evento_id',$itemselected,$list,
		array(
				'ajax' => array(
						'type' => 'POST',
						'url' => CController::createUrl('funciones/cargarFunciones'),
						'beforeSend' => 'function() { $("#cargador").addClass("loading");}',
						'complete'   => 'function() { $("#cargador").removeClass("loading");}',
						'update' => '#Ventaslevel1_funcion',
				),'prompt' => 'Seleccione un Evento...'
		));
?>
	</div>

	<div class="row">
<?php
echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));
echo CHtml::dropDownList('Ventaslevel1[funcion]',"",array(),
		array(
				'prompt' => 'Seleccione una Funcion...'
		));
?>
	</div>
	<div class='row'>
	<?php echo CHtml::hiddenField('grid_mode', 'view'); ?>
        <?php
            if(!empty($download)):
            ?>
             <a href="<?php echo $download;?>">Descargar</a>
            <?php
            endif;
        ?>                                                                             
		<?php echo $form->error($model,'evento_id'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary')); ?>
		<?php echo CHtml::submitButton('Exportar',array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ;
		 ?>
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

<?php
//print_r($dataProvider->getData());
if(isset($dataProvider) and !is_null($dataProvider) ):
		$datos = $dataProvider->getData();
echo "Se muestran ".count($dataProvider->getData())." resultados(s)" ;
?>

</div>
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
<?php

?>    
<?php
elseif(!empty($itemselected)):
    echo "No hay informacion para Ventas en Web y Call Center";
endif;
?>
</div> 



