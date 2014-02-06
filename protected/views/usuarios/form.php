<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'usuarios-form-form',
		'enableAjaxValidation'=>false,
		'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,

)); ?>
<?php
        $this->widget( 'ext.EChosen.EChosen', array(
            'target' => '.chosen',
      ));
?>
<style type='text/css'>
form .form-inline{text-align:right}
.white-box{text-align:left}
.row{ margin:5px; }
td{font-family:FontAwesome !important;}
</style>

<div class='controles' style="min-height:100%">
<?php echo sprintf("<h2>%s</h2>",$model->scenario=="insert"?'Nuevo Registro De Usuario':'Actualizar Datos'); ?>
<div class="form form-inline span12" style="float:none;margin:auto">
	<?php echo $form->errorSummary($model,NULL,NUll,array('class'=>'alert')); ?>
<div class='row'>
        <div class='span5 white-box' style="text-align:right">
		<h3>Información básica</h3>
	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

    <div class="row">
		<?php echo $form->labelEx($model,'TipUsrId'); ?>
        <?php echo $form->dropDownList($model, 'TipUsrId',
            CHtml::listData(Tipusr::model()->findAll('tipUsrId<>1'), 'tipUsrId', 'tipUsrIdDes'),
            array('empty'=>'---', )
        ); ?>	
		<?php echo $form->error($model,'TipUsrId'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosNom'); ?>
		<?php echo $form->textField($model,'UsuariosNom'); ?>
		<?php echo $form->error($model,'UsuariosNom'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosNick'); ?>
		<?php echo $form->textField($model,'UsuariosNick'); ?>
		<?php echo $form->error($model,'UsuariosNick'); ?>
	</div>
<?php if ($model->scenario=='insert'): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosPass'); ?>
		<?php echo $form->passwordField($model,'UsuariosPass'); ?>
		<?php echo $form->error($model,'UsuariosPass'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosPasCon'); ?>
		<?php echo $form->passwordField($model,'UsuariosPasCon'); ?>
		<?php echo $form->error($model,'UsuariosPasCon'); ?>
	</div>
<?php endif;?>
	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosEmail'); ?>
		<?php echo $form->textField($model,'UsuariosEmail'); ?>
		<?php echo $form->error($model,'UsuariosEmail'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosCiu'); ?>
		<?php echo $form->textField($model,'UsuariosCiu'); ?>
		<?php echo $form->error($model,'UsuariosCiu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosTelMov'); ?>
		<?php echo $form->textField($model,'UsuariosTelMov'); ?>
		<?php echo $form->error($model,'UsuariosTelMov'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosStatus'); ?>
		<?php echo $form->dropDownList($model,'UsuariosStatus', 
              array('ALTA' => 'Alta', 'BAJA' => 'Baja')); ?>
		<?php echo $form->error($model,'UsuariosStatus'); ?>
	</div>
<br />
<div class='muted'>INFORMACION ADICIONAL</div>
<br />
	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosNot'); ?>
		<?php echo $form->textArea($model,'UsuariosNot',array('cols'=>7,'rows'=>5,'style'=>'width:300px')); ?>
		<?php echo $form->error($model,'UsuariosNot'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosRegion'); ?>
		<?php echo $form->numberField($model,'UsuariosRegion'); ?>
		<?php echo $form->error($model,'UsuariosRegion'); ?>
	</div>
<?php $dateinput = $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
		'attribute' => 'UsuariosVigencia',
		'model'=>$model,
		'pluginOptions' => array(
				'format' => 'yyyy-mm-dd',
				'language' => 'es',
		),
),true);
                    ?>
            <?php echo $form->customControlGroup($dateinput,$model,'UsuariosVigencia',array('myappend_icon'=>'fa fa-calendar')); ?>

<br />
		</div><!--Division de columna-->
<?php if ($model->scenario=='update'): ?>
	<div class=' white-box span5' >
		<h3 >Permisos en taquilla</h4>
		<div class='row'>
		
			<?php echo $form->labelEx($model,'taquillaPrincipal'); ?>
			<?php echo $form->dropDownList($model,'taquillaPrincipal',
					 CHtml::listData(
							Puntosventa::model()->findAll(),
							'PuntosventaId','PuntosventaNom'),
					array('empty'=>'Sin taquilla','class'=>'span3')
			) ; ?>
			<?php echo $form->error($model,'taquillaPrincipal'); ?>
		
		</div>
		<div class='row' >
				<?php echo $form->checkBox($model,'boletosDuros'); ?>
				<?php echo $form->labelEx($model,'boletosDuros'); ?>
		</div>
		<div class='row' >
				<?php echo $form->checkBox($model,'cortesias'); ?>
				<?php echo $form->labelEx($model,'cortesias'); ?>
		</div>
		<div class='row' >
				<?php echo $form->checkBox($model,'cupones'); ?>
				<?php echo $form->labelEx($model,'cupones'); ?>
		</div>
		<div class='row' >
				<?php echo $form->checkBox($model,'descuentos'); ?>
				<?php echo $form->labelEx($model,'descuentos'); ?>
		</div>
		<div class='row' >
				<?php echo $form->checkBox($model,'reservaciones'); ?>
				<?php echo $form->labelEx($model,'reservaciones'); ?>
		</div>
		<div class='row' >
				<?php echo $form->checkBox($model,'reimpresiones'); ?>
				<?php echo $form->labelEx($model,'reimpresiones'); ?>
		</div>

</div>
		<div class='span5 white-box' style="text-align:center">
				<h3 >Eventos asignados</h3>

<label>Disponibles:</label>
<?php echo CHtml::dropDownList( 'evento_id','0', CHtml::listData( 
		Evento::model()->findAll( "EventoSta='ALTA'"),
				'EventoId','EventoNom'),
				array(
						'empty'=>array('TODAS'=>'TODOS'),
						'class'=>'chosen span3 ' ,
						'ajax' => array(
								'type' => 'POST',
								'data'=>array('evento_id'=>'js:this.value'),
								'url' => CController::createUrl('funciones/cargarFunciones'),
								'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
								'complete'   => 'function() { 
										$("#fspin").removeClass("fa fa-spinner fa-spin");
										$("#funcion_id option:nth-child(2)").attr("selected", "selected");}',
												'update' => '#funcion_id',
										)#,'prompt' => 'TODOS'
								)); ?>
  
<?php echo TbHtml::button(' Asignar',array('id'=>'btn-asignar-evento','class'=>'btn-success fa fa-plus', 'style'=>'padding:3px')) ; ?>
<br />
<br />
<?php
$usrval=new Usrval('search');
$usrval->UsuarioId=$model->UsuariosId;
//$usrval->UsrValRef='evento.EventoId';
//$usrval->UsrValRef2='funciones.FuncionesId';
$usrval->usrValIdRef2='TODAS';
$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'usrval-grid',
   'dataProvider' => $usrval->search(),
   'template' => "{items}\n{pager}",
   'type'=>'striped hover',
   'columns' => array(
		   array(
				   'header'=>'Evento',
				   'value'=>'coalesce(@$data->evento->EventoNom,$data->usrValIdRef)'
		   ),
		   array(
				   'header'=>'Funcion',
				   'value'=>'coalesce(@$data->funcion->funcionesTexto,$data->usrValIdRef2)'
		   ),

					array(
							'class'=>'CButtonColumn',
							'header'=>'',
							'template'=>'{eliminar}  ',
							'buttons'=>array(
									'eliminar'=>array(
											'label'=>'<span class="text-error fa fa-times-circle"> Quitar</span>',
											'url'=>'Yii::app()->createUrl("usuarios/desasignarEvento",array(
													"id"=>$data->UsuarioId,
													"evento"=>$data->usrValIdRef,
													"nick"=>"'.$model->UsuariosNick.'",
													"funcion"=>$data->usrValIdRef2))',
											'click'=>'function(event){
													$.get( $(this).attr("href")).done( function(){ $.fn.yiiGridView.update("usrval-grid"); });
													event.preventDefault(); }',

									),
							)

					)


   ),
)); ?>
		</div><!-- asignacion de eventos-->
<div class='span5 white-box'>
		<h3>Reportes permitidos</h3>
<label>Disponibles:</label>
<?php echo CHtml::dropDownList( 'eventos_asignados',0, CHtml::listData( 
		$model->getEventosAsignados(),
				'EventoId','EventoNom'),
				array(
						'class'=>'span3 ' ,
				)); ?>
<br />
<br />
		<div id="tabla-reportes">
			
</div>
</div>
<br />

<?php endif;?>
</div><!-- form -->
<div class='row centrado' >
			<?php echo CHtml::link(' Regresar',$this->createUrl('usuarios/index'),array('class'=>' fa fa-arrow-circle-left btn')) ?>
		 	
<?php
if($model->scenario=='insert')
	echo	CHtml::submitButton('Registrar',array('class'=>'btn btn-primary'));
else{
		echo CHtml::link(' Cambiar contraseña',$this->createUrl('usuarios/index'),array('class'=>'btn fa fa-key fa-1x')) ;
		echo " ";
	echo CHtml::submitButton('Guardar cambios',array('class'=>'btn btn-primary'));
		
}
?>
</div>

<?php $this->endWidget(); ?>
<br />
<br />
<br />


	</div>
</div>

	</div>
<?php 
 if ($model->scenario=='update')
Yii::app()->clientScript->registerScript('asignacion',"
		$('#btn-asignar-evento').on('click',function(){
				$.ajax({
						url:'".$this->createUrl('usuarios/asignarEvento',
								array('id'=>$model->UsuariosId,'nick'=>$model->UsuariosNick))."&eid='+$('#evento_id').val(),
								type:'get',
								dataType:'json',
								success:function(data){
										if(data==false) {alert('Esta asignación no esta permitida');}
										else{
												$('#evento_id option:nth-child(1)').attr('selected', 'selected');
												$.fn.yiiGridView.update('usrval-grid');
												$.get('".$this->createUrl('usuarios/eventosAsignados')."',
										{id:".$model->UsuariosId.",nick:'".$model->UsuariosNick."'},
										function(data){ $('#eventos_asignados').html(data)} );
										}		
								}
				});
});
$('#eventos_asignados').change(function(){ 
		$.get('".$this->createUrl('usuarios/tablaReportes')."',
			{id:'".$model->UsuariosId."',nick:'".$model->UsuariosNick."',
				'evento_id':$('#eventos_asignados option:selected').val() },
		function(data){ $('#tabla-reportes').html(data);}
		);
 });
		");
?>