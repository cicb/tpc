<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */
/* @var $form CActiveForm */
?>

<div class="form form-inline">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuarios-form-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>
<div class='row'>
        <div class='span5'>
	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

    <div class="row">
		<?php echo $form->labelEx($model,'TipUsrId'); ?>
        <?php echo $form->dropDownList($model, 'TipUsrId',
            CHtml::listData(Tipusr::model()->findAll(), 'tipUsrId', 'tipUsrIdDes'),
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
		<?php echo $form->labelEx($model,'UsuariosNot'); ?>
		<?php echo $form->textField($model,'UsuariosNot'); ?>
		<?php echo $form->error($model,'UsuariosNot'); ?>
	</div>
</div>
        <div class='span5'>
	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosNick'); ?>
		<?php echo $form->textField($model,'UsuariosNick'); ?>
		<?php echo $form->error($model,'UsuariosNick'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosPass'); ?>
		<?php echo $form->textField($model,'UsuariosPass'); ?>
		<?php echo $form->error($model,'UsuariosPass'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosPasCon'); ?>
		<?php echo $form->textField($model,'UsuariosPasCon'); ?>
		<?php echo $form->error($model,'UsuariosPasCon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosGruId'); ?>
		<?php echo $form->textField($model,'UsuariosGruId'); ?>
		<?php echo $form->error($model,'UsuariosGruId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosIma'); ?>
		<?php echo $form->textField($model,'UsuariosIma'); ?>
		<?php echo $form->error($model,'UsuariosIma'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosInf'); ?>
		<?php echo $form->textField($model,'UsuariosInf'); ?>
		<?php echo $form->error($model,'UsuariosInf'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosEmail'); ?>
		<?php echo $form->textField($model,'UsuariosEmail'); ?>
		<?php echo $form->error($model,'UsuariosEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosRegion'); ?>
		<?php echo $form->textField($model,'UsuariosRegion'); ?>
		<?php echo $form->error($model,'UsuariosRegion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosStatus'); ?>
		<?php echo $form->textField($model,'UsuariosStatus'); ?>
		<?php echo $form->error($model,'UsuariosStatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UsuariosVigencia'); ?>
		<?php echo $form->textField($model,'UsuariosVigencia'); ?>
		<?php echo $form->error($model,'UsuariosVigencia'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Confirmar',array('class'=>'btn btn-primary')); ?>
	</div>
</div>
</div>



<?php $this->endWidget(); ?>

</div><!-- form -->

<style type='text/css'>
.form-inline{text-align:right}
.row{ margin:5px; }
</style>
