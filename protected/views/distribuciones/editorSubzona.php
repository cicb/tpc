<?php 
/*
 *EDITOR DE SUBZONA
 */
?>
<div class='controles'>
<h2>Editor de subzona.</h2>
<?php echo TbHtml::tag('legend',array(),"Subzona ".$subzona->SubzonaNum); ?>
</div>

<?php 
echo TbHtml::openTag('table',array('width'=>'80%','class'=>'table table-stripped'));
foreach ($subzona->filas as $fila) {
		// Por filas
		//$this->renderPartial('_filaAsiento',array('asientos'=>$fila->asientos));
		echo TbHtml::openTag('tr');
		foreach ($fila->lugares as $asiento) {
				//Por cada Asiento
				if ($asiento->LugaresStatus=='TRUE') {
						// code...
						echo TbHtml::tag('td',array(
								'class'=>'asiento'
						),$asiento->LugaresNum);	
				}	
				else 
						echo TbHtml::tag('td');
		}

		echo TbHtml::closeTag('tr');

}
echo TbHtml::closeTag('table');
?>

<style type="text/css" media="screen">
	td{margin:5px;padding:5px;}
</style>
