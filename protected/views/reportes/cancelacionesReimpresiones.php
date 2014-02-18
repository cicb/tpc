<div class='controles'>
<h2>Cancelaciones Y Reimpresiones</h2>
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'controles',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
     'enableAjaxValidation'=>false,
     'clientOptions' => array('validateOnSubmit' => false)
     ));
     ?>
       <div class='col-4' >
          <div class="row">
            <?php
			echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
			if (!Yii::app()->user->isGuest) {
						$eventos = Yii::app()->user->modelo->getEventosAsignados();
						$list = CHtml::listData($eventos,'EventoId','EventoNom');
						echo CHtml::dropDownList('evento_id',@$_POST['evento_id'],$list,
								array(
										'ajax' => array(
												'type' => 'POST',
												'data'=>array('evento_id'=>'js:this.value'),
												'url' => CController::createUrl('funciones/cargarFuncionesFiltradas'),
												'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
												'complete'   => 'function() { 
														$("#fspin").removeClass("fa fa-spinner fa-spin");
														$("#funcion_id option:nth-child(2)").attr("selected", "selected");}',
																'update' => '#funcion_id',
														),'prompt' => 'Seleccione un Evento...'
												));
			}	
?>
            </div>
            <div class="row" id="funciones">
                <?php
                echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));
                echo CHtml::dropDownList('funcion_id',@$_POST['funcion_id'],array());
                echo CHtml::hiddenField('grid_mode','view');
                echo CHtml::hiddenField('funcion',@$funcionesId);
                ?>
                <span id="fspin" class="fa"></span>
            </div>

        </div>
		<div class='col-4'>
				<div class="input-append">
				<?php echo CHtml::label('Desde: ','desde',array('style'=>'display:inline-block')); ?>
				<?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
						'name' => 'desde',
						'pluginOptions' => array(
						'format' => 'yyyy-mm-dd'
						)
				));
				?>
				<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
				<br />
				<div class="input-append">
				<?php echo CHtml::label('Hasta: ','hasta',array('style'=>'display:inline-block')); ?>
				<?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
						'name' => 'hasta',
						'pluginOptions' => array(
						'format' => 'yyyy-mm-dd'
						)
				));
				?>
				<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
		</div>
<br />
    <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary btn-medium centrado')); ?> 
	<?php $this->endWidget(); ?>
</div>
<div id='reporte'>
<?php 
				if (isset($eventoId) and $eventoId>0) {
						$this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
								'id'=>'cancel-reimp-grid',
								'dataProvider' => $model->getCancelacionesYReimpresiones($eventoId,$funcionesId),
								'template'=>'{items}<div class="col-4 centrado"> {pager}</div>',
								'type'=>'striped hover',
								'mergeColumns'=>array('VentasId','boleto'),
								'columns' => array(
										'boleto',
										array(
												'header'=>'Venta',
												'name'=>'VentasId'
										),
										array(
												'header'=>'Num.Boleto Actual',
												'name'=>'LugaresNumBol'
										),
										array(
												'header'=>'Usuario',
												'name'=>'UsuariosNom'
										),
										array(
												'header'=>'Tipo',
												'type'=>'html',
												'value'=>'"<span class=\'\'>".$data["tipo"]."</span>"',
										),
										array(
												'header'=>'Num. Bol Anterior',
												'name'=>'NumBol'
										),
										array(
												'header'=>'Fecha/Hora',
												'name'=>'fecha'
										),
										array(
												'header'=>'Estatus actual',
												'name'=>'VentasSta'
										),
										array(
												'header'=>'Cancelacion',
												'name'=>'cancelacion'
										),
										array(
												'header'=>'Punto de Venta',
												'name'=>'PuntosventaNom'
										),

										//array(
												//'header'=>'C',
												//'name'=>'fecha'
										//),
										//array(
										//'class'=>'CButtonColumn',
										//'header'=>'',
										//'template'=>'{eliminar}  ',
										//'buttons'=>array(
										//'eliminar'=>array(
										//'label'=>'<span class="text-error fa fa-times-circle"> Quitar</span>',
										//'url'=>'Yii::app()->createUrl("usuarios/desasignarEvento",array(
										//"id"=>$data->UsuarioId,
										//"evento"=>$data->usrValIdRef,
										//"nick"=>"'.$model->UsuariosNick.'",
										//"funcion"=>$data->usrValIdRef2))',
										//'click'=>'function(event){
										//$.get( $(this).attr("href")).done( function(){ $.fn.yiiGridView.update("usrval-grid"); });
										//event.preventDefault(); }',

										//),
										//)

										//)


								),
						));
				}
?>
</div>
