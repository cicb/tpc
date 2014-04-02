<?php
/* @var $this DescuentosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Descuentoses',
);

$this->menu=array(
	array('label'=>'Create Descuentos', 'url'=>array('create')),
	array('label'=>'Manage Descuentos', 'url'=>array('admin')),
);
?>

<h1>Descuentoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
