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
</div>
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
