<div id='formulario' class="span5" style="float:none;margin:auto;">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'usuarios-form-form',
		'enableAjaxValidation'=>false,
		'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,

)); ?>
<?php echo TbHtml::passwordFieldControlGroup('up','',
		array('label' => 'Nueva contraseña', 'placeholder' => 'Escriba la nueva contraseña')); ?>
<?php echo TbHtml::passwordFieldControlGroup('upc', '',
		array('label' => 'Confirme la nueva contraseña', 'placeholder' => 'Repita la contraseña')); ?>

		</div>
<?php $this->endWidget(); ?>

