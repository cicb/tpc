<div class="controles">
	<h1>Lugares</h1>
	<div id="cargador"  style="position:absolute; width:40px; height:40px;left:30%; top:150px; border:0px; margin-left:-40px; margin-top:-40px;" >
	</div>
	<div class="form">

		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'usuarios-form',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
			'enableAjaxValidation'=>false,
			'clientOptions' => array('validateOnSubmit' => false)
			));

			?>
			<div class='row' style="margin-left:30px">
				<div class='span4'>
					<div class="row">
						<?php
						echo CHtml::label('Evento','', array('style'=>'width:70px; display:inline-table;'));
						$modeloEvento = Evento::model()->findAll(array('condition' => 'EventoSta = "ALTA"','order'=>'EventoNom'));
						$list = CHtml::listData($modeloEvento,'EventoId','EventoNom');
						echo CHtml::dropDownList('evento_id','',$list,
							array(
								'ajax' => array(
									'type' => 'POST',
									'url' => CController::createUrl('funciones/cargarFunciones'),
									'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
									'complete'   => 'function() { 
										$("#fspin").removeClass("fa fa-spinner fa-spin");
										$("#funcion_id option:nth-child(2)").attr("selected", "selected");
										$("#funcion_id").change();
									}',
									'update' => '#funcion_id',
									),'prompt' => 'Seleccione un Evento...'
								));
								?>
							</div>

							<div class="row">
								<?php
								echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));

								echo CHtml::dropDownList('funcion_id','',array(),
									array(
										'ajax' => array(
											'type' => 'POST',
											'url' => CController::createUrl('zonas/cargarZonas'),
											'beforeSend' => 'function() { $("#zspin").addClass("fa fa-spinner fa-spin");}',
											'complete'   => 'function() { 
												$("#zspin").removeClass("fa fa-spinner fa-spin");
												$("#zona_id option:nth-child(2)").attr("selected", "selected");
											}',
											'update' => '#zona_id',
											),'prompt' => 'Seleccione una Funcion...'
										));
										?>
										<span id="fspin" class=""></span>
									</div>
									<div class="row">
										<?php
										echo CHtml::label('Zona','zona_id', array('style'=>'width:70px; display:inline-table;'));
										echo CHtml::dropDownList('zona_id','',array(),array('prompt'=>'Seleccione una Zona...'));
										?>
										<span id="zspin" class=""></span>
									</div>
								</div>
								<div class='span4'>
									<div class="row">
										<?php echo $form->labelEx($model,'filas', array('style'=>'width:70px; display:inline-table;')); ?>
										<?php echo $form->textField($model,'filas'); ?>
										<?php echo $form->error($model,'filas'); ?>
									</div>
									<div class="row">
										<?php echo $form->labelEx($model,'lugares', array('style'=>'width:70px; display:inline-table;')); ?>
										<?php echo $form->textField($model,'lugares'); ?>
										<?php echo $form->error($model,'lugares'); ?>
									</div>
									<div class="row">
										<input type="radio" name="tipo" value="asiento"  checked="checked" /> Asiento/Fila 
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="tipo" value="fecha" /> Fecha de venta
									</div>
								</div>
							</div>
							<div class=" buttons">
								<?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
							</div>



							<?php $this->endWidget(); ?>

						</div><!-- form -->



						<style>
							.CANCELADO{
								background-color:#FFCECE;}
							</style>
						</div>
						<?php if(( isset($dataProvider) and !is_null($dataProvider))): ?>
							<div id="Contenido" style=" overflow:auto;">
								<?php $this->widget('bootstrap.widgets.TbGridView', array(
									'id'=>'evento-grid',
									'type'=>array('condensed'),
									'dataProvider'=>$dataProvider,
									'columns'=>array(
										array(
											'name'=>'LugaresStatus',
											),
										array(
											'name'=>'TempLugaresFecHor',
											),
										array(
											'name'=>'FilasAli',
											),
										array(
											'name'=>'LugaresLug',  
											),

										array(
											'name'=>'DescuentosDes',
											),

										array(
											'name'=>'UsuariosId',
											),

										array(
											'name'=>'quienvende',
											),
										array(
											'name'=>'EventoId',
											),
										array(
											'name'=>'FuncionesId',
											),
										array(
											'name'=>'ZonasId',
											),
										array(
											'name'=>'SubzonaId',
											),
										array(
											'name'=>'FilasId',
											),
										array(
											'name'=>'LugaresId',
											)
										),
										)); ?>
									</div>
								<?php endif;?>
								<?php $this->widget('application.extensions.fancybox.EFancyBox', array(
									'target'=>'a#inline',
									'config'=>array(
										'scrolling' => 'false',
										'titleShow' => true,
										)
									)
								);
								?>                  


