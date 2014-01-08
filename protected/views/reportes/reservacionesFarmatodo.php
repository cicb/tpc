<div class='controles'>
        <h2>Reservaciones Farmatodo</h2>
		<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'form-ventaslevel1',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
				'validateOnSubmit'=>true,
		),
		)); ?>

		<div class="row form-search">
				<?//php echo $form->labelEx($model,'buscar'); ?>
				
				<?php echo CHtml::textField('buscar',$ref,array('placeholder'=>'Número de reservacion','required'=>'required')); ?>
				<?php echo CHtml::submitButton('Buscar', array('class'=>'btn btn-primary')); ?>
		</div>


		<div class="row buttons">
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


<?php 
/*$datos = $dataProvider->getData();
if(!empty($datos[0]['id'])):
 $visible = $datos[0]['Estatus']=="CANCELADO"?"0":"1";
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evento-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'Evento',
		'Funcion',
		'Zona',
		'Fila',
		'Asiento',
		'Venta',
		'Fecha',
		'Referencia',
        'Estatus',
        array(
        'class'=>'zii.widgets.grid.CButtonColumn',
        'template'=>'{delete}',
        'buttons'=>array(
                    'delete'=>array('url'=>'Yii::app()->createUrl("/farmatodo/delete", array("id"=>$data["Referencia"]))')),
                    'visible'=>"$visible",
                    
            ),
	       ),
)); 
endif;*/
?>
<?php

if(!is_null($ref)):
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'form-ventaslevel1',
    'action'=>Yii::app()->createUrl('/farmatodo/delete'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
)); 
?>
</div>
<?php
//$this->widget('bootstrap.widgets.TbGridView', array(
   //'dataProvider' => $model->getReservacionesFarmatodo($ref),
   //'template' => "{items}",
   //'type' => TbHtml::GRID_TYPE_STRIPED,

   //'columns' => array(
		//'Evento',
		//'Funcion',
		//'Zona',
		//'Fila',
		//'Asiento',
		//'Venta',
		//'Fecha',
		//'Referencia',
		//'Estatus',
		//'Fecha',
		//array(
			////'type'=>'',
			//'value'=>'CHtml::checkbox(\'x\')'
		//),

	//),
//)); 
?>

<div id="evento-grid" class="grid-view">
    <table class="items table table-collapsed table-condensed">
        <thead>
        <th>Evento</th>
        <th>Función</th>
        <th>Zona</th>
        <th>Fila</th>
        <th>Asiento</th>
        <th>Venta</th>
        <th>Fecha</th>
        <th>Referencia</th>
        <th>Estatus</th>
        <th>Cancelar</th>
        </thead>
        <tbody>
<?php
        foreach($model->getReservacionesFarmatodo($ref)->getData() as $key => $data):
        ?>
        <tr class="<?php echo ($key%2)==0?'odd':"even"; ?>">
            <td><?php echo $data['Evento']; ?></td>
            <td><?php echo $data['Funcion']; ?></td>
            <td><?php echo $data['Zona']; ?></td>
            <td><?php echo $data['Fila']; ?></td>
            <td><?php echo $data['Asiento']; ?></td>
            <td><?php echo $data['Venta']; ?></td>
            <td><?php echo $data['Fecha']; ?></td>
            <td><?php echo $data['Referencia'];?></td>
            <td><?php echo $data['Estatus'];?></td>
            <td style="text-align: center !important; ">
                <?php 
                    if($data['Estatus']!='CANCELADO' AND !empty($data['VentasNumRef'])):
                        echo CHtml::checkBox("delete[]",false,array ('value'=>$data['Referencia'].'_'.$data['Lug'].'_'.$data['Venta']."_".$data['Evento']."_".$data['Funcion']."_".$data['Zona'].'_'.$data['Fila'].'_'.$data['Asiento']));
                    endif;    
                ?>
            </td>
        </tr>
        <?php
        endforeach;
        ?>
       <tr>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td><?php if(!empty($data['VentasNumRef'])) echo CHtml::submitButton('Cancelar'); ?></td>
       </tr>
        </tbody>    
    </table>
</div>
<?php
$this->endWidget(); 
else:
    echo $ref;
endif;
?> 
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-success flash-' . $key . '">' . $message . "</div>\n";
    }
?> 
