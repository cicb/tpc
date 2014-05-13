<?php
/* @var $this PuntosventasController */
/* @var $model Puntosventa */

$this->breadcrumbs=array(
	'Puntosventas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Puntosventa', 'url'=>array('index')),
	array('label'=>'Manage Puntosventa', 'url'=>array('admin')),
);
?>
<h2 style="text-align: center;">Nuevo Punto de Venta</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>