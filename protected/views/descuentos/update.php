<?php
/* @var $this DescuentosController */
/* @var $model Descuentos */

$this->breadcrumbs=array(
	'Descuentos'=>array('descuentoslevel1/admin'),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Cupones y Descuentos', 'url'=>array('descuentoslevel1/admin','query'=>"",'tipo'=>'cupon')),
	array('label'=>'Crear Cupon o Descuento', 'url'=>array('descuentos/create')),
);
?>

<div class='controles'>
<h1>Modificar Descuentos: <?php echo $cupon ?> </h1>

<?php echo $this->renderPartial('_form_update', array('model'               => $model,
                                                      'cupon'               => $cupon,
                                                      'EventosRelacionados' => $EventosRelacionados,
                                                      'CuponActual'         => $CuponActual,
                                                      'EventoId'            => $EventoId,
                                                      'DescuentosId'        => $DescuentosId,
                                                      )); ?>
