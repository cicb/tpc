<?php
/* @var $this DescuentosController */
/* @var $data Descuentos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->DescuentosId), array('view', 'id'=>$data->DescuentosId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosDes')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosDes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosPat')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosPat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosCan')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosCan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosValRef')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosValRef); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosValIdRef')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosValIdRef); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosFecIni')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosFecIni); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosFecFin')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosFecFin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosExis')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosExis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentosUso')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentosUso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CuponesCod')); ?>:</b>
	<?php echo CHtml::encode($data->CuponesCod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DescuentoCargo')); ?>:</b>
	<?php echo CHtml::encode($data->DescuentoCargo); ?>
	<br />

	*/ ?>

</div>