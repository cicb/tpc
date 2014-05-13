<?php
/* @var $this PuntosventasController */
/* @var $data Puntosventa */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('PuntosventaId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->PuntosventaId), array('view', 'id'=>$data->PuntosventaId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoid')); ?>:</b>
	<?php echo CHtml::encode($data->tipoid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PuntosventaNom')); ?>:</b>
	<?php echo CHtml::encode($data->PuntosventaNom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('puntosventaTipoId')); ?>:</b>
	<?php echo CHtml::encode($data->puntosventaTipoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PuntosventaInf')); ?>:</b>
	<?php echo CHtml::encode($data->PuntosventaInf); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PuntosventaIdeTra')); ?>:</b>
	<?php echo CHtml::encode($data->PuntosventaIdeTra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PuntosventaSta')); ?>:</b>
	<?php echo CHtml::encode($data->PuntosventaSta); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('PuntosventaSuperId')); ?>:</b>
	<?php echo CHtml::encode($data->PuntosventaSuperId); ?>
	<br />

	*/ ?>

</div>