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
				'EventoId'=>$model->EventoId,
				'FuncionesId'=>$model->FuncionesId
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
<br />
<br />
<div class='row-fluid'>
	<?php
		echo TbHtml::link(' Regresar',array('evento/actualizar','id'=>$model->EventoId),
		array('class'=>'btn fa fa-arrow-left'));
	 ?>
	<?php
echo  TbHtml::ajaxButton( 
		' Asignar esta distribución a todas las funciones',
		$this->createUrl('distribuciones/asignarATodas'),
		array(
				'beforeSend'=>'function(){return  confirm("¿Confirma asignar esta distribución a todas las demas funciones?\nEsto implica perder cualquier distribución previamente asignada a las demas funciones"); }',
				'success'=>'function(resp){alert(resp);}',
				'type'=>'POST',
				'data'=>array(
						'ForoId'=>$model->ForoId,
						'ForoMapIntId'=>$model->ForoMapIntId,
						'EventoId'=>$model->EventoId,
						'FuncionesId'=>$model->FuncionesId,
				),
		),
		array(
				'id'=>'btn-asignar-todas',
				'class'=>'btn btn-info fa fa-th'
		)
		);
	?>
</div>


	</div>
</div>
<?php 
$EventoId=$model->EventoId;
$FuncionesId=$model->FuncionesId;
//$ZonasId=$zona->ZonasId;

Yii::app()->clientScript->registerScript('controles',"
function cambiarValores(control){
		var key=control.attr('name');
		var value=control.val();
		var data={Zonas:{ EventoId:$EventoId, FuncionesId:$FuncionesId, ZonasId:control.data('id') }};
		data['Zonas'][key]=value;
		$.ajax({
				url: '".$this->createUrl('AsignarValorZona')."',
						type:'POST',
						data:data,
		});
}
$('.ZonasCantSubZon').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasCanLug').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasCosBol').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasAli').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasTipo').live('change',function(){
		cambiarValores($(this));
});

$( '.nodo-toggle').live('click',function(){
	var uid= $(this).data('uid');
	var link= $(this);
	if (link.data('estado')=='inicial') {
		var href= link.attr('href');
		$.ajax({
			url:href,
			success:function(data){ 
				$('#hijos-'+uid).append(data);
				link.data('estado','toggle')
				link.toggleClass('fa-minus-square');
			}
		});
	}
	else if (link.data('estado')=='toggle'){
		link.toggleClass('fa-minus-square');
		$('#rama-'+uid).toggle();
	}
	return false;
})
"); ?>
<style type="text/css" media="screen">
	li.nodo{
		list-style-type:none;
}
</style>
