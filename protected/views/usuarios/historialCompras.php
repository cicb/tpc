<style type='text/css'>
#wrap{
background: #ebebeb;
}
</style>
<div class='controles'>
<h2>Historial de compras</h2>
<div class='col-4 centrado'>
<?php
$this->widget(
    'yiiwheels.widgets.detail.WhDetailView',
    array(
        'data' => array(
            'id' => 1,
            'nombre' => $model->nombreCompleto,
            'email' => $model->email,
            'nick' => $model->username,
        ),
        'attributes' => array(
				array('name' => 'nick', 'label' => 'Usuario'),
				array('name' => 'nombre', 'label' => 'Nombre'),
				array('name' => 'email', 'label' => 'E-mail'),
		),
    ));
?>
</div>
</div>
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
			array(
					'header'=>'Evento',
					'type'=>'raw',
					'name'=>'evento',
					'value'=>'$data->evento["EventoNom"]'),
			array(
					'header'=>'Funcion',
					'type'=>'raw',
					'name'=>'funcion',
					'value'=>'$data->funcion->funcionesTexto'),
			array(
					'header'=>'Zona',
					'type'=>'raw',
					'name'=>'zona',
					'value'=>'$data->zona->ZonasAli'),
			array(
					'header'=>'Subzona',
					'type'=>'raw',
					'name'=>'subzona',
					'value'=>'$data->subzona->SubzonaId'),
			array(
					'header'=>'Fila',
					'type'=>'raw',
					'name'=>'fila',
					'value'=>'$data->fila->FilasAli'),
			array(
					'header'=>'Lugar',
					'type'=>'raw',
					'name'=>'lugar',
					'value'=>'$data->lugar->LugaresLug'),

			array(
					'header'=>'Costo',
					'type'=>'raw',
					'name'=>'VentasCosBol',
					),
			'VentasCarSer',
	),
	'mergeColumns' => array('VentasId','VentasNumTar','VentasFecHor','VentasSta','evento','funcion','zona', 'subzona','fila')
));
?>
</div>

