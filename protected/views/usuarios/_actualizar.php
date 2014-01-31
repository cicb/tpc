<div class='controles' style="min-height:100%">
<h2>Actualizar datos</h2>
<h4>datos basicos</h4>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'usuarios-form-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php $this->renderPartial('form',array('model'=>$model,'form'=>$form),false,true); ?>
	<div class="row buttons">
			<?php echo CHtml::link(' Regresar',$this->createUrl('usuarios/index'),array('class'=>' fa fa-arrow-circle-left btn')) ?>
			<?php echo CHtml::link(' Cambiar contraseña',$this->createUrl('usuarios/index'),array('class'=>'btn fa fa-key fa-1x')) ?>
		<?php echo CHtml::submitButton('Guardar cambios',array('class'=>'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
