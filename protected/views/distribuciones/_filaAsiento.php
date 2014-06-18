
<?php 
echo TbHtml::openTag('tr');
foreach ($asientos as $asiento) {
		//Por cada Asiento
	echo TbHtml::tag('td',array(),$asiento->LugaresLug);	
}

echo TbHtml::closeTag('tr');
?>
