<?php 
echo CHtml::openTag('h3',array('style'=>'text-align:center'));
echo $evento->EventoNom;
echo CHtml::closeTag('h3');
$resumenEvento=$model->getResumenEvento($evento->EventoId,'TODAS');
	$data=array();
	foreach (array_slice($resumenEvento,1,4) as $key=>$fila) {
			$label=strcasecmp($key,'NORMAL')==0?'Ventas':@ucwords($resumenEvento[$key]['titulo']);		
			$data[]=array('label'=>$label,'value'=>(int)str_replace(',','',$fila['boletos']));
	}
					$this->widget('application.extensions.morris.MorrisChartWidget', array(
							'id'      => 'grafica-resumen-'.$evento->EventoId,
							'htmlOptions'=>array('style'=>'width:250;height:200px'),
							'options' => array(
									'chartType' => 'Donut',
									'data'      => $data,
									'colors'    => array('#f1c40f','#2980b9','#8e44ad','#27ae60','#f1c40f')
							),
					));
					Yii::app()->mustache->render('tablaResumenEvento', $resumenEvento);
?>
