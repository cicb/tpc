<?php 
	if (isset($eventoId) and $eventoId>0) {
			$this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
					'id'=>'cancel-reimp-grid',
					'dataProvider' => $model->getCancelacionesYReimpresiones($eventoId,$funcionesId, $zonasId,$subzonaId,$filasId,$lugaresId),
					'template'=>'{items}<div class="col-4 centrado"> {pager}</div>',
					'type'=>'striped hover',
					'mergeColumns'=>array('VentasId','VentasSta'),
					'ajaxUpdate'=>false,
					'columns' => array(

							array(
									'header'=>'Venta',
									'name'=>'VentasId'
							),
							//array(
									//'header'=>'NumBol Ventaslevel1 ',
									//'name'=>'LugaresNumBol'
							//),

							array(
									'header'=>'Usuario',
									'name'=>'UsuariosNom'
							),
							array(
									'header'=>'PV',
									'type'=>'raw',
									'value'=>'$data["pv"]." ".$data["punto"]'
							),
							array(
									'header'=>'Reimp./Venta',
									'type'=>'html',
									'value'=>'"<span class=\'\'>".$data["tipo"]."</span>"',
							),
							array(
									'header'=>'NumBol Reimpresion',
									'name'=>'NumBol'
							),
							array(
									'header'=>'Fecha/Hora',
									'name'=>'fecha'
							),
							array(
									'header'=>'Fec/Hor Cancelacion',
									'value'=>'$data["CancelFecHor"]!="0000-00-00 00:00:00"?$data["CancelFecHor"]:""',
							),
							array(
									'header'=>'Cancelo',
									'value'=>'$data["CancelUsuarioId"]>0?$data["CancelUsuarioId"]." ".$data["Cancelo"]:""',
							),

							array(
									'header'=>'Estatus Ventaslevel1',
									'name'=>'VentasSta'
							),

					),
			));
	}

?>
