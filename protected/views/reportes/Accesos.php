<div class='controles'>
<h2>Control De Accesos</h2>
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'controles',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
     'enableAjaxValidation'=>false,
     'clientOptions' => array('validateOnSubmit' => false)
     ));
     ?>
       <div class='span4'  style="float:none;display:block;margin:auto;">
          <div class="row">
            <?php
            echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
			$eventos = Yii::app()->user->modelo->getEventosAsignados();
			$list = CHtml::listData($eventos,'EventoId','EventoNom');
			echo CHtml::dropDownList('evento_id',@$eventoId,$list,
              array(
                'ajax' => array(
                  'type' => 'POST',
                  'url' => CController::createUrl('funciones/cargarFuncionesFiltradas'),
                  'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
                  'complete'   => 'function() { 
                    $("#fspin").removeClass("fa fa-spinner fa-spin");
                    $("#funcion_id option:nth-child(2)").attr("selected", "selected");}',
                  'update' => '#funcion_id',
                  ),'prompt' => 'Seleccione un Evento...'
                ));
                ?>
            </div>
            <div class="row" id="funciones">
                <?php
                echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));
                echo CHtml::dropDownList('funcion_id',@$funcionesId,array());
                echo CHtml::hiddenField('grid_mode','view');
                echo CHtml::hiddenField('funcion',@$funcionesId);
                ?>
                <span id="fspin" class="fa"></span>
            </div>
        </div>

		<div class='row'>
				   <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary btn-medium','onclick'=>'$("#grid_mode").val("view");')); ?> 
		</div>

    <?php $this->endWidget(); ?>
</div>
<?php 
if (isset($eventoId, $funcionesId) and $eventoId>0) :
		$evento=Evento::model()->with(array('boletosVendidos','accesos'))->findByPk($eventoId);
$funcion="Todas";		
if ($funcionesId>0) {
		$funcionModel=Funciones::model()->findByPk(array('EventoId'=>$evento->EventoId,'FuncionesId'=>$funcionesId));		
		if (is_object($funcionModel)) {
				$funcion=$funcionModel->funcionesTexto;
		}	
}	
?>
<br />
<div class='centrado' ><b>Evento:</b> <?php echo $evento->EventoNom ; ?> <br>
<b>Función:</b> <?php echo $funcion ; ?></div>
<br />
<table cellspacing='0' class='table table-condensed table-bordered table-fit'>
        <tr>
                <th>Total Boletos Vendidos</th>
				<td style="text-align:right;padding:5px !important">
					<?php  echo $evento->boletosVendidos ; ?> 
				</td>
				<td style="text-align:right;padding:5px !important">100%</td>
        </tr>
        <tr>
                <th>Registrados:</th>
				<td style="text-align:right;padding:5px !important"> 
					<?php  echo $evento->accesos ; ?>
				<td style="text-align:right;padding:5px !important">
					<?php  echo number_format($evento->accesos/max($evento->boletosVendidos,1),3) ; ?>%
				</td>
				</td>
        </tr>
        <tr>
                <th>Pendientes:</th>
                <td style="text-align:right;padding:5px !important"><?php echo  $evento->boletosVendidos -$evento->accesos ; ?></td>
				<td style="text-align:right;padding:5px !important">
					<?php  echo number_format(($evento->boletosVendidos -$evento->accesos)/max($evento->boletosVendidos,1),3) ; ?>%
				</td>
        </tr>
</table>

<div class='centrado'><b>Accesos Por Zonas</b></div>

<?php 				
		$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'evento-grid',
		'dataProvider'=>$model->getAccesosPorZonas($eventoId,$funcionesId),
		'type'=>array('condensed','bordered'),
        'emptyText'=>'No se encontraron resultados',
		'columns'=>array(
				'ZonasAli',
                array(
                    'header'=>'Registrados',
                    'value'=>'number_format($data[\'Registrados\'],0)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
                array(
                    'header'=>'Pendientes',
                    'value'=>'number_format($data[\'Pendientes\'],0)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),
		),
		));
?>

<div class='centrado'><b>Accesos Por Terminal</b></div>
<?php 				
		$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'evento-grid',
		'dataProvider'=>$model->getAccesosPorPuertas($eventoId,$funcionesId),
		'type'=>array('condensed','bordered'),
        'emptyText'=>'No se encontraron resultados',
		'columns'=>array(
                array(
                    'header'=>'Terminal',
                    'name'=>'CatTerminalNom',
                    ),
                array(
                    'header'=>'Registrados',
                    'value'=>'number_format($data[\'Registrados\'],0)',
                    'type'=>'raw',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right;'
                        )
                    ),

		),
		));
?>
<?php endif;?>
<style type="text/css" media="screen">
	table{width:auto !important; margin:auto;}
	th,td{padding:3px !important;}	
</style>
