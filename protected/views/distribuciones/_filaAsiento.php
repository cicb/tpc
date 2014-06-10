
<?php 
echo TbHtml::openTag('tr');
foreach ($asientos as $asiento) {
		//Por cada Asiento
	echo TbHtml::tag('td',array(),$asiento->LugaresNum);	
}

echo TbHtml::closeTag('tr');
?>
