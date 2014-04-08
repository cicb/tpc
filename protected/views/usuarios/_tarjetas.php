
<div id='reporte'>
<?php 
 $this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
	'type' => 'striped bordered',
	'dataProvider' => $model->getHistorico(),
	'template' => "{items}",
	'columns' => array(
			'VentasId',
			array(
					'header'=>'Num. Tarjeta',
					'type'=>'raw',
					'name'=>'VentasNumTar',
					'value'=>'$data->venta->tarjeta'),
			'VentasSta',
			array(
					'header'=>'Fecha/Hora',
					'type'=>'raw',
					'name'=>'VentasFecHor',
					'value'=>'$data->venta->VentasFecHor'),
				),
	'mergeColumns' => array('VentasId','VentasNumTar','VentasFecHor')
));
?>
</div>
