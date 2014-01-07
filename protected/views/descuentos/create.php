<div class='controles'>
<?php
/* @var $this DescuentosController */
/* @var $model Descuentos */

$this->breadcrumbs=array(
	'Descuentos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Cupones y Descuentos', 'url'=>array('descuentoslevel1/admin','query'=>"",'tipo'=>'cupon')),
);
?>

<h1>Cup&oacute;n o Descuento Nuevo</h1>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
