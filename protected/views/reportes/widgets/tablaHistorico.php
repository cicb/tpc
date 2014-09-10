<?php 
						$this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
								'id'=>'cancel-reimp-grid',
								'dataProvider' => $reportes->historial($boleto),
								'template'=>'{items}<div class="col-4 centrado"> {pager}</div>',
								'type'=>'striped hover',
								'mergeColumns'=>array('VentasId','ZonasAli','SubzonaId','FilasAli','LugaresLug','VentasFecHor'),
								'ajaxUpdate'=>false,
								'columns' => array(
										'boleto',
										'ZonasAli',
										'SubzonaId',
										'FilasAli',
										'LugaresLug',
										'VentasId',
										'VentasFecHor',
										'VentasSta',
										'VentasCon',
										'LugaresNumBol',
										'tipo',
										// array(
										// 		'header'=>'Reimpresiones',
										// 		'type'=>'raw',
										// 		'value'=>'is_numeric($data["reimpresiones"])?$data["reimpresiones"]+1:"0"',
										// )
								)
						));
 ?>