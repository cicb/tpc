<?php 
if (isset($_GET['evento_id'])) {
		$this->widget('bootstrap.widgets.TbGridView', array(
				'id'=>'reportes-grid',
				'dataProvider' => $model->getReportes($_GET['evento_id']),
				'template' => "{items}",
				'type'=>'striped hover',
				'columns' => array(
						array(
								'header'=>'Reporte',
								'name'=>'descripcion'
						),
						array(
								'header'=>'Estado',
								'type'=>'raw',
								'value'=>'$data["estado"]>0?"Autorizado":"Denegado"'
						),
						array(
								'class'=>'CButtonColumn',
								'header'=>'',
								'template'=>'{denegar}{autorizar}  ',
								'buttons'=>array(
										'denegar'=>array(
												'label'=>'<span class="text-error fa fa-minus-square"> Denegar </span>',
												'url'=>'Yii::app()->createUrl("usuarios/denegarReporte",array(
													"id"=>"'.$model->UsuariosId.'",
													"UsrValMulId"=>$data["id"],
													"UsrValPrivId"=>$data["UsrValPrivId"],
													"nick"=>"'.$model->UsuariosNick.'",
											))',
												'click'=>'function(event){
														$.get( $(this).attr("href"), function(){ $.fn.yiiGridView.update("reportes-grid"); });
														event.preventDefault(); }',
												'visible'=>'$data["estado"]>0'				
														),
										'autorizar'=>array(
												'label'=>'<span class="text-success fa fa-check-square"> Autorizar</span>',
												'url'=>'Yii::app()->createUrl("usuarios/autorizarReporte",array(
														"UsrValMulId"=>$data["id"],
														"id"=>"'.$model->UsuariosId.'",
														"eid"=>"'.$_GET['evento_id'].'",
														"nick"=>"'.$model->UsuariosNick.'",
												))',
												'click'=>'function(event){
														$.get( $(this).attr("href"), function(data){$.fn.yiiGridView.update("reportes-grid"); });
														event.preventDefault(); }',
												'visible'=>'!$data["estado"]>0'				
														),
												)

												)
										)
								)
						);
}
?>
