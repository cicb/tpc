<?php 
/*
 *EDITOR DE SUBZONA
 */
?>
<div class='controles'>
<h2>Editor de subzona.</h2>
<?php echo TbHtml::dropDownList('SubzonaId',$subzona->SubzonaId,TbHtml::listData($subzona->hermanas,'SubzonaId','nombre'),
array('class'=>'input-medium panel-head')); ?>
<br />
    <?php echo TbHtml::buttonGroup(array(
			array('title'=>'Alinear todo a la izquierda',  'class'=>'fa fa-align-left fa-3x btn btn-large', 
			'url'=>array('alinear',
			'EventoId'=>$subzona->EventoId,
			'FuncionesId'=>$subzona->FuncionesId,
			'ZonasId'=>$subzona->ZonasId,
			'SubzonaId'=>$subzona->SubzonaId,
			'direccion'=>'izquierda'
	)
),
    array('title'=>'Alinear todo al centro',  'class'=>'fa  fa-align-center fa-3x btn btn-large'),
	array('title'=>'Alinear todo a la derecha','class'=>'fa fa-align-right fa-3x btn btn-large',
			'url'=>array('alinearSubzona',
			'EventoId'=>$subzona->EventoId,
			'FuncionesId'=>$subzona->FuncionesId,
			'ZonasId'=>$subzona->ZonasId,
			'SubzonaId'=>$subzona->SubzonaId,
			'direccion'=>'derecha'
	)
),
    ), array('vertical' => false)); ?>
<br />
<br />
</div>

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
				$control=TbHtml::textField('asiento',$asiento->LugaresNum, array(
						'class'=>'input-mini asiento'.$clase,
						'data-fid'=>$asiento->FilasId,
						'data-id'=>$asiento->LugaresId,
				));
				echo TbHtml::tag('td',array('class'=>' '),$control);	

		}

		echo TbHtml::closeTag('tr');

}
echo TbHtml::closeTag('table');
?>

<br />
<style type="text/css" media="screen">
	table{background:#eeD}	
	th,td{margin:5px;padding:5px !important;}
	.input-mini{width:25px;text-align:center}	
</style>
<?php Yii::app()->clientScript->registerScript('efecto',"
$('.asiento').on('change',function(){
		var fila=$(this).data('fid');
		if ($(this).val()=='') {
			// Si se ha eliminado su contenido
				$(this).addClass('off');
				$('.off[data-fid='+fila+']').removeClass('hidden');
		}	
		else{
				$(this).removeClass('off');
				$('.off[data-fid='+fila+']').addClass('hidden');
}
});
"); ?>
