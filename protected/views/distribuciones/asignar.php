<div class="controles">
        <?php echo CHtml::tag('legend',array(), 'Configuración de la Distribución'); ?>
	<?php $this->renderPartial('actualizar',compact('model'),false,true); ?>
	
	<div class="box white-box">
		<h3>Zonas</h3>
		<div id="area-zonas"> 
			<?php 
				foreach ($model->zonas as $zona) {
					# Zonas de la distribucion
					$this->renderPartial('_zona',array('model'=>$zona,'editar'=>false));
				}
			 ?>
			<i id="feedback-funcion" class="fa fa-3x hidden" ></i><br/><br/>
		</div>
<br />
<div class='row-fluid'>
	<?php
		echo TbHtml::link(' Regresar',array('evento/actualizar','id'=>$model->EventoId),
		array('class'=>'btn fa fa-arrow-left'));
	 ?>
	<?php
		echo TbHtml::link(' Desasignar de esta distribución',array(
				'funciones/desasignarDistribucion',
				'EventoId'=>$model->EventoId,
				'FuncionesId'=>$model->FuncionesId,
		),
		array(
				'id'=>'btn-desasignar',
				'class'=>'btn btn-danger fa fa-minus-circle'));
	 ?>
	<?php
//echo  TbHtml::ajaxButton( 
		//' Asignar esta distribución a todas las funciones',
		//$this->createUrl('distribuciones/asignarATodas'),
		//array(
				//'beforeSend'=>'function(){return  confirm("¿Confirma asignar esta distribución a todas las demas funciones?\nEsto implica perder cualquier distribución previamente asignada a las demas funciones"); }',
				//'success'=>'function(resp){alert(resp);}',
				//'type'=>'POST',
				//'data'=>array(
						//'ForoId'=>$model->ForoId,
						//'ForoMapIntId'=>$model->ForoMapIntId,
						//'EventoId'=>$model->EventoId,
						//'FuncionesId'=>$model->FuncionesId,
				//),
		//),
		//array(
				//'id'=>'btn-asignar-todas',
				//'class'=>'btn btn-info fa fa-th'
		//)
		//);
	?>
</div>


	</div>
</div>
<?php 
$EventoId=$model->EventoId;
$FuncionesId=$model->FuncionesId;
//$ZonasId=$zona->ZonasId;

Yii::app()->clientScript->registerScript('controles',"
 var start=Math.round((new Date()).getTime() / 1000);

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

$('.ZonasCosBol').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasAli').live('focusout',function(){
		cambiarValores($(this));
});

$('#btn-desasignar').on('click',function(){
		if (confirm('¿Esta seguro de quitar la distribución actual de la funcion? Esto eliminara todas su zonas, subzonas, filas y lugares permanentemente.')) {
				var obj=$(this);
				$.ajax({
						url:obj.attr('href'),
								type:'post',
								dataType:'json'
						success:function(resp){alert(resp);if(resp){window.location='".$this->createUrl('evento/actualizar',array('id'=>$EventoId))."'}}
						
});
		return false;
		}	

});
"); ?>
<?php $this->renderPartial('/distribuciones/js/arbol',array('EventoId'=>$EventoId,'FuncionesId'=>$FuncionesId),false,true); ?>
<style type="text/css" media="screen">
	li.nodo{
		list-style-type:none;
}
</style>

