<?php 
Yii::app()->clientScript->registerScriptFile("js/holder.js"); 
?>

<div class="controles">
        <?php echo CHtml::tag('legend',array(), 'Configuración de la Distribución'); ?>
	<?php echo  CHtml::image('holder.js/500x200') ?>
	
	<div class="box white-box">
		<h3>Zonas</h3>
		<div id="area-zonas"> 
			<?php 
				foreach ($model->zonas as $zona) {
					# Zonas de la distribucion
					$this->renderPartial('_zona',array('model'=>$zona,'scenario'=>'insert'));
				}
			 ?>
			<i id="feedback-funcion" class="fa fa-3x hidden" ></i><br/><br/>
		</div>
	<?php 
	echo TbHtml::ajaxButton(' Agregar una zona',
		$this->createUrl('distribuciones/agregarZona',
			array(
				'EventoId'=>$zona->EventoId,
				'FuncionesId'=>$zona->FuncionesId
				)
			),
		array(
			// 'url'=>,
		'type'=>'POST',
		'success'=>"function(resp){
			$('#area-zonas').append(resp)
		}",
		'complete'=>'function(){ $("#feedback-funcion").toggleClass("fa-spinner fa-spin","hidden"); }'
		),
		array(
			'id'=>'btn-agregar-zona',
			'class'=>'btn btn-success fa fa-2x fa-plus-circle center'
			)
		); 
	?>
	</div>
</div>
<script type="text/javascript">
</script>
