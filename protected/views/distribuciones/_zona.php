
	<div class="row-fluid" style="display:block; margin-bottom:10px" >

	<?php echo TbHtml::button(' ', array(
			'data-id'=>0,
			'class'=>'btn-quitar-funcion btn btn-danger fa fa-2x fa-minus-circle pull-left',
			'title'=>'Eliminar esta función'
	)); ?>
	</div>
<table class="table table-condensed ">
	<tr class="gris-head">
		<th>Tipo de acceso</th>
		<th>Nombre de zona</th>
		<th>Subzonas</th>
		<th>Num. Asientos</th>
		<th>Precio</th>
		<th>Acciones</th>
		<th>Cargo por servicio</th>
	</tr>
	<tr>
	    <td>
	    	<?php
	    	echo CHtml::dropDownList('Acceso', 'General',array('General','Numerada'));
	    	?>
	    </td>
	    <td><?php 
	    	echo TbHtml::textField('ZonasAli',$model->ZonasAli,array('class'=>'input-medium'));
			?>
		</td>
	    <td>
	    	<?php echo CHtml::numberField('Subzonas',$model->ZonasCantSubZon,array(
	    	'class'=>'input-small text-center')) ?>
    	</td>
	    <td>
	    <?php echo TbHtml::numberField('Lugares',$model->ZonasCanLug,array(
	    	'class'=>'input-small text-center', 'prepend'=>'#', 'append'=>CHtml::link('Generar','',array('class'=>'btn')))) ?>	    
	    </td>
	    <td>
	    	<?php echo TbHtml::numberField('Precio',$model->ZonasCosBol,array(
	    	'class'=>'input-small text-center', 'prepend'=>'$')) ?>
	    </td>
	    <td>
	    <?php
	    echo TbHtml::buttonGroup(array(
	    	array('label' => ' ','class'=>'fa fa-building-o btn-primary'),
	    	array('label' => ' ','class'=>'fa fa-bars btn', 		'title'=>'Configurar Filas'),
	    	array('label' => ' ','class'=>'fa fa-th-large', 	'title'=>'Configurar Asientos'),
	    	)); 
	    	?>
	    </td>
	    <td>
	    		<?php 

	    		 ?>
	    </td>
	</tr>
</table>
<script type="text/javascript">
function cambiarValores(control){
	var key=control.attr('name');
	var value=control.val();
	$.ajax({
		url:"<?php echo $this->createUrl('AsignarValorZona'); ?>",
		type:'POST',
		data:{''}
		success:function(){}
	});
}
$('.ZonasAli').live('focusout',function(){

});
</script>
