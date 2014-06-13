<?php 
$dist=$model->forolevel1;
Yii::app()->clientScript->registerScriptFile("js/holder.js"); 
Yii::app()->clientScript->registerScriptFile('js/mindmup-editabletable.js') ?>

<div class="controles">
<!--- ------------------------------------------------------------------------- Distribucion-------- --!>

        <?php echo CHtml::tag('legend',array(), 'Configuración de la Distribución'); ?>
	<div class="box box4  white-box">
		<h3>Información básica</h3>
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'form-forolevel1',
		'enableAjaxValidation'=>false,
		'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
		)); ?>

<?php echo $form->dropDownListControlGroup($dist,'ForoId',
		CHtml::listData(
				Foro::model()->findAll(),
				'ForoId','ForoNom'),
		array('class'=>'','disabled'=>true)		
		); ?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
		<?php echo $form->textFieldControlGroup($dist,'ForoMapIntNom',
		array('class'=>'forolevel1')		
); ?>
<?php echo TbHtml::hiddenField('YII_CSRF_TOKEN',Yii::app()->request->csrfToken) ?>
<?php //echo TbHtml::submitButton(' Guardar información', 
//array(
		//'id'=>'btn-guardar',
		//'class'=> 'btn fa fa-save ')
		//); ?>
<?php $this->endWidget(); ?>
	</div>

<!--- ------------------------------------------------------------------------- Distribucion-------- -->
	<div class="box box6 white-box">
		<h3>Configuración del mapa</h3>
		<?php $this->renderPartial('actualizar',compact('model'),false,true); ?>
	</div>
	
	<div class="box white-box">
		<h3>Zonas</h3>
		<div id="area-zonas"> 
			<?php 
				foreach ($model->zonas as $zona) {
					# Zonas de la distribucion
					$this->renderPartial('_zona',array('model'=>$zona,'editar'=>true));
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
			'class'=>'btn btn-success fa fa-2x fa-plus-circle center '
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
				'success'=>'function(resp){if(resp=="true"){alert("Se ha aplicado esta distribución a todas las demás funciones");window.location="'.$this->createUrl('Evento/actualizar',array('id'=>$model->EventoId,'#'=>'funciones')).'";}else{alert("No se ha completado la asignación a las demás funciones.")}}',
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
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'dlg-asientos',
    'header' => 'Generación de asientos',
    'content' => '<div id=\'dlg-asientos-contenido\'></div>',
    'footer' => implode(' ', array(
			TbHtml::button('Cerrar', array('data-dismiss' => 'modal')),
			TbHtml::button('Aceptar', array(
            'data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY)
        ),
     )),
)); ?>
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
function cambiarValoresFilas(control){
		var key=control.attr('name');
		var value=control.val();
		var data={Filas:{ EventoId:$EventoId, FuncionesId:$FuncionesId, 
				ZonasId:control.data('zid'), SubzonaId:control.data('sid'),
				FilasId:control.data('fid'),
		}};
		data['Filas'][key]=value;
		$.ajax({
				url: '".$this->createUrl('AsignarValorFila')."',
				type:'POST',
				data:data,
		});
}

$('.ZonasCantSubZon').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasCanLug').live('focusout',function(){
		cambiarValores($(this));
		var zid=$(this).data('id');
		$('#btn-generar-asientos-'+zid).addClass('btn-primary');
});
$('.ZonasCosBol').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasAli').live('focusout',function(){
		cambiarValores($(this));
});
$('.ZonasTipo').live('change',function(){
		cambiarValores($(this));
		var zid=$(this).data('id');
		if ($(this).val()==1) {
				/* Cuando sea general */
			$('#ZonasCantSubZon-'+zid).val(1);	
			$('#ZonasCantSubZon-'+zid).hide(500);	
		}else{
				$('#ZonasCantSubZon-'+zid).show(500);	
				$('#ZonasCantSubZon-'+zid).prop('disabled',false);	
				
}	

});
$('.btn-eliminar-zona').live('click',function(){ 
		var obj=$(this);
		var zid=obj.data('zid');
		$.ajax({
				url:obj.attr('href'),
						type:'post',
						data:{Zonas:{EventoId:$EventoId,FuncionesId:$FuncionesId,ZonasId:zid}},
						success:function(resp){ 
								if(resp=='true'){ $('#zona-'+zid).remove();}
								else {
										alert('No se puede eliminar esta zona.Verifique que el Evento no tenga ventas');}},
												beforeSend:function(){
													   	return confirm('¿Esta seguro de que desea eliminar esta zona?\\nEsta operación es irreversible.');						}						

		});
return false;
})
		$('.btn-generar-asientos').live('click',function(){
				var zid=$(this).data('id');
				$(this).toggleClass('btn-primary','btn-success');
				if ($('#ZonasTipo-'+zid).val()==1) {
						$.ajax({
								url:'".$this->createUrl('generarAsientosGenerales',compact('EventoId','FuncionesId'))."',
								type:'post',
								data:{ZonasId:zid},
								dataType:'json',
								success:function(e){
										$('#dlg-asientos-contenido').html(
												'<div class=\'alert \'><h3>Asientos generados.</h3> <p>Se han generado '+e.lugares+' lugares </p></div> ');},
						});
						return false;
				}
				//return false;		
			});

function actualizar(){
		data=$('#form-forolevel1').serialize();
		$.ajax({
			url:'".$this->createUrl('actualizar', compact('EventoId','FuncionesId'))."',
			data: data,		
			type:'post',
				
		});
}	

$('.forolevel1').on('change',function(){
		actualizar();
});


		"); ?>

<?php $this->renderPartial('/distribuciones/js/arbol',array('EventoId'=>$EventoId,'FuncionesId'=>$FuncionesId),false,true); ?>
<style type="text/css" media="screen">
	li.nodo{
		list-style-type:none;
}
tr{padding:5px;margin:7px;}
#tabla-filas th{padding:8px;line-height:20px;}
#dlg-asientos{width:65%;left:35%;}
</style>



