<div class="controles">
<<<<<<< HEAD
<h1>Ventas Call Center</h1>
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
        echo CHtml::label('Puntos de Venta','pv_id', array('style'=>'width:70px; display:inline-table;'));
        $modeloPuntoVenta = Puntosventa::model()->findAll(array('condition' => "(PuntosventaId BETWEEN '103' AND '200') ",'order'=>'PuntosventaNom'));
        $list = CHtml::listData($modeloPuntoVenta,'PuntosventaId','PuntosventaNom');
        echo CHtml::dropDownList('pv_id','',$list);
        ?>
	</div>
    <div class="row">
        <?php
        echo CHtml::label('Usuarios','usuario_id', array('style'=>'width:70px; display:inline-table;'));
        $modeloUsuarios = Usuarios::model()->findAll(array('condition' => "(TipUsrId = '3')",'order'=>'	UsuariosNom'));
        $listusr = CHtml::listData($modeloUsuarios,'UsuariosId','UsuariosNom');
        echo CHtml::dropDownList('usuario_id','',$listusr);
        ?>
	</div>
	<div class="row">
       <div class=" buttons">
        <?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
    </div>
    
 </div>   
</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
table.items{
    min-width: 900px !important;
}
</style>
 
  <style>
.CANCELADO{
        background-color:#FFCECE;}
</style>
</div>
=======
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
>>>>>>> c52a81de0ec64d54466d14a8bf16872eac11decc
