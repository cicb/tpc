<div class="controles">
	<h3>Asignacion de puertas a subzonas</h3>
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
			echo CHtml::dropDownList('evento_id','<?php @echo $_POST["evento_id"]; ?>',$list,
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
					echo CHtml::label('Funcion','Ventaslevel1_funcion', array('style'=>'width:70px; display:inline-table;'));
					echo CHtml::dropDownList('Ventaslevel1[funcion]','',array(),
						array(
							'prompt' => 'Seleccione una Funcion...'
							));
							?>
						</div>
						<div class='row'>
							<?php echo CHtml::hiddenField('grid_mode', 'view'); ?>                                                                      
							<?php echo CHtml::hiddenField('funcion_id', '<?php @echo $_POST["Ventaslevel1"]["funcion"]; ?>'); ?>                                                                      
						</div>


						<div class="row buttons">
							<?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary','onclick'=>'$("#grid_mode").val("show");')); ?>
							<?php echo CHtml::submitButton('Exportar',array('class'=>'btn btn-medium','onclick'=>'$("#grid_mode").val("export");')) ;
							?>
						</div>

						<?php $this->endWidget(); ?>

					</div><!-- form -->
				</div>
