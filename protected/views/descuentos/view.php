<?php
/* @var $this DescuentosController */
/* @var $model Descuentos */

$this->breadcrumbs=array(
	'Descuentoses'=>array('index'),
	$model->DescuentosId,
);

$this->menu=array(
	array('label'=>'List Descuentos', 'url'=>array('index')),
	array('label'=>'Create Descuentos', 'url'=>array('create')),
	array('label'=>'Update Descuentos', 'url'=>array('update', 'id'=>$model->DescuentosId)),
	array('label'=>'Delete Descuentos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->DescuentosId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Descuentos', 'url'=>array('admin')),
);
?>

<h1>View Descuentos #<?php echo $model->DescuentosId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'DescuentosId',
		'DescuentosDes',
		'DescuentosPat',
		'DescuentosCan',
		'DescuentosValRef',
		'DescuentosValIdRef',
		'DescuentosFecIni',
		'DescuentosFecFin',
		'DescuentosExis',
		'DescuentosUso',
		'CuponesCod',
		'DescuentoCargo',
	),
)); ?>
