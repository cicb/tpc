<div class="controles">
	<h2>Cortes diarios</h2>
	<div class="row-fluid">
		<div class="span9" style="text-align:right">

		<table>
			<tr>
				<td><?php echo CHtml::label('Usuarios: ','usuario_id', array('style'=>'display:inline-table;')); ?></td>
				<td>				
						<?php $modelos = Usuarios::model()->findAll(array('condition' => 'UsuariosStatus = "ALTA"','order'=>'UsuariosNom'));
				$list = CHtml::listData($modelos,'UsuariosId','UsuariosNom');
				echo CHtml::dropDownList('usuario_id','',$list,
					array(
						'ajax' => array(
							'type' => 'POST',
							'url' => CController::createUrl('puntosVenta/cargarPuntosventa'),
							'beforeSend' => 'function() { $("#pvspin").addClass("fa fa-spinner fa-spin");
								$("#pvs").hide();}',
							'complete'   => 'function() { $("#pvspin").removeClass("fa fa-spinner fa-spin");
								$("#pvs").show();}',
							'update' => '#punto_venta_id',
							'data'=>array('usuario_id'=>'js:this.value'),
							),'prompt' => 'Seleccione a un usuario ...'
						));
						?>
						<i id="pvspin" ></i>
					</td>
				<td></td>
			</tr>

			<tr>
				<td><?php echo CHtml::label('Puntos de venta: ','puntos_venta_id', array('style'=>'display:inline-table;')); ?></td>
				<td>					
					<div id="pvs" class="row">
						<?php echo CHtml::dropDownList('punto_venta_id','',array()); ?>
					</div>
				</td>
				<td style="vertical-align:top">
					<?php echo CHtml::button('Mostrar todos',array('class'=>'btn','id'=>'btn_mostrar_pvs')) ?>
				</td>
			</tr>
		</table>

	</div>	
				<div class="span4">
<!-- aqui van las fechas -->
				</div>	
			</div>					
		</div>
		<?php 
		Yii::app()->clientScript->registerScript('ver_todos',"
			$('#btn_mostrar_pvs').on('click',function(){
				$.post('".$this->createUrl('puntosVenta/cargarPuntosventa')."',
					function(data){
						$('#punto_venta_id').html(data);
					}
					)
			});
			");
		 ?>