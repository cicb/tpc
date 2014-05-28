
<div class='row-fluid'>
<table border="0" class="table tabla-filas">
	<tr>
		<th>No. Filas</th>
		<?php for ($i=0;$i<($model->ZonasCantSubZon);$i++) {
				echo TbHtml::tag('th',array('colspan'=>2),"Subzona ".($i+1));
				echo TbHtml::tag('th',array(),"Ctd.");
		} ?>
		<th>Total</th>
	</tr>
<?php 
				echo TbHtml::openTag('tr');
				echo TbHtml::tag('td',array(),TbHtml::textField('FilasAli','',array('class'=>'FilasAli input-mini')));
				for ($i=0;$i<($model->ZonasCantSubZon);$i++) {
				$this->renderPartial('_fila',array('fid'=>1,'sid'=>$i));
				} 
				echo TbHtml::tag('td',array(),TbHtml::textField('FilasCanLug','',array('class'=>'FilasCanLug pull-right input-mini')));
				echo TbHtml::closeTag('tr');
?>
</table>
<?php 
		echo TbHtml::ajaxButton(' Agregar fila',array('agregarFila'),array(),array('class'=>'btn btn-success fa fa-plus pull-left'));
?>
		<div class='pull-right'>
<?php echo TbHtml::numberField('ZonasCanLug',$model->ZonasCanLug,array(
		'class'=>'input-small text-center pull-right ZonasCanLug',		
		'prepend'=>'Total de asientos:',
		'data-id'=>$model->ZonasId,
)); ?>
		</div>
</div>
