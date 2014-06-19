<?php 
echo TbHtml::openTag('table',array('width'=>'auto','class'=>'table-bordered centrado box'));
		foreach ($subzona->filas as $fila) {
				// Por filas
				//$this->renderPartial('_filaAsiento',array('asientos'=>$fila->asientos));
				echo TbHtml::openTag('tr');
				echo TbHtml::tag('th',array(),$fila->FilasAli);	
				foreach ($fila->lugares as $asiento) {
						//Por cada Asiento
						$clase="";
						if ($asiento->LugaresStatus=='OFF') {
								$clase.=" off hidden";
						}
						$control=TbHtml::textField('asiento',$asiento->LugaresLug, array(
								'class'=>'input-mini asiento'.$clase,
								'data-fid'=>$asiento->FilasId,
								'data-id'=>$asiento->LugaresId,
						));
						echo TbHtml::tag('td',array('class'=>' '),$control);	

				}

				echo TbHtml::tag('td',array(),
						TbHtml::buttonGroup(
								array( 
										array(
												'data-id'=>$fila->FilasId,
												'title'=>'Alinear todo a la izquierda',  
												'class'=>'fa fa-angle-double-left btn btn-info btn-alinear', 
												'url'=>array_merge(
														(array)'alinearFila',$fila->getPrimaryKey(),
														array('direccion'=>'izquierda'))
												),
												array(
														'data-id'=>$fila->FilasId,
														'title'=>'Recorrer a la izquierda',  
														'class'=>'fa fa-angle-left btn btn-info btn-alinear',  
														'url'=>array_merge(
																(array)'moverFila',$fila->getPrimaryKey(),
																array('direccion'=>'izquierda'))
														),

												array(
														'data-id'=>$fila->FilasId,
														'title'=>'Alinear todo al centro',  
														'class'=>'fa fa-angle-double-up btn-alinear btn btn-info', 
														'url'=>array_merge(
																(array)'alinearFila',$fila->getPrimaryKey(),
																array('direccion'=>'centro'))
												),
												array(
														'data-id'=>$fila->FilasId,
														'title'=>'Recorrer a la derecha', 
														'class'=>'fa fa-angle-right  btn-alinear btn btn-info', 
														'url'=>array_merge(
																(array)'moverFila',$fila->getPrimaryKey(),
																array('direccion'=>'derecha'))
												),
												array(
														'data-id'=>$fila->FilasId,
														'title'=>'Alinear todo a la derecha', 
														'class'=>'fa fa-angle-double-right  btn-alinear btn btn-info', 
														'url'=>array_merge(
																(array)'alinearFila',$fila->getPrimaryKey(),
																array('direccion'=>'derecha'))
												),
										))
								);	

				echo TbHtml::tag('td',array(),TbHtml::button('',array(
						'onclick'=>'activarOff('.$fila->FilasId.')',
						'class'=>'btn fa fa-adjust',
				)));	
				echo TbHtml::tag('td',array(),TbHtml::textField('FilasCanLug-'.$fila->FilasId,$fila->ntrue,array(
						'class'=>'input-mini',
						'data-lugares'=>$fila->ntrue,
						'append'=>'Lugares',
						'readonly'=>true)));	
				echo TbHtml::closeTag('tr');

		}
		echo TbHtml::closeTag('table');

?>
