<?php
/* @var $this PuntosventasController */
/* @var $model Puntosventa */

$this->breadcrumbs=array(
	'Puntosventas'=>array('index'),
	$model->PuntosventaId=>array('view','id'=>$model->PuntosventaId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Puntosventa', 'url'=>array('index')),
	array('label'=>'Create Puntosventa', 'url'=>array('create')),
	array('label'=>'View Puntosventa', 'url'=>array('view', 'id'=>$model->PuntosventaId)),
	array('label'=>'Manage Puntosventa', 'url'=>array('admin')),
);
?>

<h2 style="text-align: center;">Actualizar Punto de Venta</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>