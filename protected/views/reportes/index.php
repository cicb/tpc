
<div class='controles'>
		<h2>Tablero</h2>
<?php 
//$this->widget('application.extensions.cbarras.CBarras',array(
		//'code_type'=> 'ean13',
		//'code_string'=>'1234567890123',
		//'size'=>4,
		//'htmlOptions'=>array('width'=>'30px')
//));
?>
</div>
<div class='span9' style="margin:auto;float:none">
<div class='row-fluid'>
<?php 
		if (isset($widgets,$model) and is_array($widgets)) :
			foreach ($widgets as $widget): 
?>
<div class='span4'>
				<?php echo $widget ; ?>
</div>
<?php endforeach; ?>			

</div>
<div id="grafica-barras" class="row-fluid" >
	
<?php 
					$data=$model->getVentas($desde,$hasta,array(
							'select'=>"DATE_FORMAT(VentasFecHor,'%d %M') as dia",
							'group'=>'DATE(VentasFecHor)',
							'order'=>'DATE(VentasFecHor)',
					))->getData();
	$i=0;
foreach ($data as $key=>$fila) {
		$data[$key]['i']=$i;
		$i++;
}
		$this->widget('application.extensions.morris.MorrisChartWidget', array(
				'id'      => 'grafica-ventas',
				//'htmlOptions'=>array('style'=>'width:900;height:300px;'),
				'options' => array(
						'chartType' => 'Bar',
						'data'      => $data,
						'xkey'      => 'dia',
						'ykeys'     => array('ventas','boletos'),
						'labels'    => array('Transacciones','Boletos'),
						'barColors'    => array('#e67e22','#3498db')
				),
		));
        ?>
<?php endif;?>

</div>
</div>
<style type="text/css" media="screen">
	td{text-align: right !important;}
</style>
<?php 
		//Yii::app()->clientScript->registerScript('overlap',
		//"$('#mainmenu').html($(this).html);",CClientScript::POS_END
		//);
?>
