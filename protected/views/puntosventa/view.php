<?php
/* @var $this PuntosventasController */
/* @var $model Puntosventa */

$this->breadcrumbs=array(
	'Puntosventas'=>array('index'),
	$model->PuntosventaId,
);

$this->menu=array(
	array('label'=>'List Puntosventa', 'url'=>array('index')),
	array('label'=>'Create Puntosventa', 'url'=>array('create')),
	array('label'=>'Update Puntosventa', 'url'=>array('update', 'id'=>$model->PuntosventaId)),
	array('label'=>'Delete Puntosventa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->PuntosventaId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Puntosventa', 'url'=>array('admin')),
);
?>

<h1>View Puntosventa #<?php echo $model->PuntosventaId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'tipoid',
		'PuntosventaId',
		'PuntosventaNom',
		'puntosventaTipoId',
		'PuntosventaInf',
		'PuntosventaIdeTra',
		'PuntosventaSta',
		'PuntosventaSuperId',
	),
)); ?>
