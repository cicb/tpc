<div class='controles' style="min-height:100%">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'usuarios-form-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php $this->renderPartial('form',array('model'=>$model,'form'=>$form),false,true); ?>
	<div class="row buttons">
			<?php echo CHtml::link('Regresar',$this->createUrl('usuarios/index'),array('class'=>'btn')) ?>
		<?php
echo $model->scenario=='insert'?
		CHtml::submitButton('Registrar',array('class'=>'btn btn-primary')):
		CHtml::submitButton('Guardar cambios',array('class'=>'btn btn-success'));
?>
	</div>
<?php $this->endWidget(); ?>
</div>
