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
<div class='controles' style="min-height:100%">
<?php echo sprintf("<h2>%s</h2>",$model->scenario=="insert"?'Nuevo Registro De Usuario':'Actualizar Datos'); ?>
	<div class="panel-head panel-foot" style="padding:9px">Datos Basicos</div>
<div class="form form-inline span12" style="float:none;margin:auto">
	<?php echo $form->errorSummary($model,NULL,NUll,array('class'=>'alert')); ?>
<div class='row'>
        <div class='span5'>
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
		</div><!--Division de columna-->
        <div class='span5'>
	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosNot'); ?>
		<?php echo $form->textArea($model,'UsuariosNot',array('cols'=>7,'rows'=>5,'style'=>'width:300px')); ?>
		<?php echo $form->error($model,'UsuariosNot'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosInf'); ?>
		<?php echo $form->textArea($model,'UsuariosInf',array('cols'=>7,'rows'=>5,'style'=>'width:300px')); ?>
		<?php echo $form->error($model,'UsuariosInf'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosRegion'); ?>
		<?php echo $form->numberField($model,'UsuariosRegion'); ?>
		<?php echo $form->error($model,'UsuariosRegion'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosVigencia'); ?>
		<?php echo $form->dateField($model,'UsuariosVigencia'); ?>
		<?php echo $form->error($model,'UsuariosVigencia'); ?>
	</div>

</div>
</div>
<div class='row'>
		<div class='span5'>
	<div class=' white-box span4' style="float:right;margin:auto;text-align:left">
		<h4 class="panel-head">Permisos en taquilla</h4>
<div class='row'>
	<?php echo $form->labelEx($model,'taquillaPrincipal'); ?>
	<?php echo $form->dropDownList($model,'taquillaPrincipal',
			 CHtml::listData(
					Puntosventa::model()->findAll(),
					'PuntosventaId','PuntosventaNom'),
			array('empty'=>'Sin taquilla')
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

</div>
        <div class='span5'></div>
</div>
</div><!-- form -->
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

<?php $this->endWidget(); ?>
<br />
<br />
	<div class="panel-head panel-foot" style="padding:9px">Permisos y asignaciones</div>
<div id='asignaciones' class="span10" style="float:none;margin:auto">
	<div class='row'>
	<div class='span3 white-box'>
				<h4 class="panel-head">Eventos</h4>
				<?php echo CHtml::dropDownList( 'evento_id','', CHtml::listData( 
				Evento::model()->findAll( "EventoSta='ALTA'"),
				'EventoId','EventoNom'),
				array(
						//'class'=>'chosen' ,
						'ajax' => array(
								'type' => 'POST',
								'data'=>array('evento_id'=>'js:this.value'),
								'url' => CController::createUrl('funciones/cargarFunciones'),
								'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
								'complete'   => 'function() { 
										$("#fspin").removeClass("fa fa-spinner fa-spin");
										$("#funcion_id option:nth-child(2)").attr("selected", "selected");}',
												'update' => '#funcion_id',
										),'prompt' => 'TODOS'
								)); ?>
</div>
	<div class='span3 white-box'>
		<h4 class="panel-head">Funciones</h4>
		<?php echo CHtml::dropDownList( 'funcion_id','', array(),array('empty'=>'TODAS')); ?>
		<span class='fspin'></span>
	</div>

	<div class='span3 white-box'>
		<h4 class="panel-head">Permisos</h4>
		<?php echo CHtml::dropDownList( 'reporte','', CHtml::listData(Usrsubtip::model()->findAll(),'UsrSubTipDes','UsrSubTipDes'),array('empty'=>'TODOS')); ?>
		<span class='fspin'></span>
	</div>
<div class='span3' style="float:none;margin:auto">
		<?php echo CHtml::link(' Asignar','#',array('class'=>'btn btn-large fa fa-chevron-circle-down fa-3x')) ; ?>
</div>

	</div>
<br />
<br />

<?php
										$usrval=new Usrval('search');
										$usrval->UsuarioId=$model->UsuariosId;
										//$usrval->UsrValRef='evento.EventoId';
										//$usrval->UsrValRef2='funciones.FuncionesId';
										$usrval->usrValIdRef2='TODAS';
									   	$this->widget('bootstrap.widgets.TbGridView', array(
   'dataProvider' => $usrval->search(),
   'template' => "{items}",
   'type'=>'striped hover',
   'columns' => array(
		   //array(
				   //'header'=>'Usuario','value'=>
				   //'$data->usuario->UsuariosNom',
		   //),
		   //'UsuarioId',
		   //array(
				   //'header'=>'Tipo','value'=>
				   //'$data->tipusr->tipUsrIdDes',
		   //),
		   array(
				   'header'=>'Permiso','value'=>
				   '$data->usrsubtip->UsrSubTipDes',
		   ),
		   //array(
				   //'header'=>'UsrValRef',
				   //'name'=>'UsrValRef'
		   //),
		   //array(
				   //'header'=>'usrValIdRef',
				   //'name'=>'usrValIdRef'
		   //),
		   array(
				   'header'=>'Evento',
				   'value'=>'coalesce(@$data->evento->EventoNom,$data->usrValIdRef)'
		   ),
		   //array(
				   //'header'=>'UsrValRef2',
				   //'name'=>'UsrValRef2'
		   //),
		   //array(
				   //'name'=>'usrValIdRef2'
		   //),
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
											'label'=>'<span class="text-error fa fa-times"> Eliminar</span>',
											'url'=>'Yii::app()->createUrl("usuarios/actualizar")',
									),
						)

					)


   ),
)); ?>
<?php echo($model->descuentos.'-');@var_dump($model->taquillaPrincipal); ?>
</div>

	</div>
<style type='text/css'>
.form-inline{text-align:right}
.row{ margin:5px; }
</style>
