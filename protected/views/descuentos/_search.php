<?php
/* @var $this DescuentosController */
/* @var $model Descuentos */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'DescuentosId'); ?>
		<?php echo $form->textField($model,'DescuentosId',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosDes'); ?>
		<?php echo $form->textField($model,'DescuentosDes',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosPat'); ?>
		<?php echo $form->textField($model,'DescuentosPat',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosCan'); ?>
		<?php echo $form->textField($model,'DescuentosCan',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosValRef'); ?>
		<?php echo $form->textField($model,'DescuentosValRef',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosValIdRef'); ?>
		<?php echo $form->textField($model,'DescuentosValIdRef',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosFecIni'); ?>
		<?php echo $form->textField($model,'DescuentosFecIni'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosFecFin'); ?>
		<?php echo $form->textField($model,'DescuentosFecFin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosExis'); ?>
		<?php echo $form->textField($model,'DescuentosExis'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentosUso'); ?>
		<?php echo $form->textField($model,'DescuentosUso'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CuponesCod'); ?>
		<?php echo $form->textField($model,'CuponesCod',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DescuentoCargo'); ?>
		<?php echo $form->textField($model,'DescuentoCargo',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->