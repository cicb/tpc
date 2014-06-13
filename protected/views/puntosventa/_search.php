<?php
/* @var $this PuntosventasController */
/* @var $model Puntosventa */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'tipoid'); ?>
		<?php echo $form->textField($model,'tipoid',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PuntosventaId'); ?>
		<?php echo $form->textField($model,'PuntosventaId',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PuntosventaNom'); ?>
		<?php echo $form->textField($model,'PuntosventaNom',array('size'=>60,'maxlength'=>75)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'puntosventaTipoId'); ?>
		<?php echo $form->textField($model,'puntosventaTipoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PuntosventaInf'); ?>
		<?php echo $form->textArea($model,'PuntosventaInf',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PuntosventaIdeTra'); ?>
		<?php echo $form->textField($model,'PuntosventaIdeTra',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PuntosventaSta'); ?>
		<?php echo $form->textField($model,'PuntosventaSta',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PuntosventaSuperId'); ?>
		<?php echo $form->textField($model,'PuntosventaSuperId',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->