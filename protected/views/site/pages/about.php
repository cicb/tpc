<div class="controles" style="height:100%;min-height:400px;">
		<h2><i class="fa fa-th"></i> Acerca del panel de control </h2>			
<br>

<?php 
echo TbHtml::openTag('div', array('class'=>' box box4  text-left'));
$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
try{
		$changelog=readfile("changelog");
}
catch (Exception $e){
		$changelog="### Version 1.0 ";
}
$this->endWidget();

echo TbHtml::closeTag('div');
?>

</div>
