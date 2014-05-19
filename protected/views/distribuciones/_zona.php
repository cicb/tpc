<?php echo CHtml::openTag('div',array('id'=>'zona-'.$model->ZonasId)); ?>
	<div class="row-fluid" style="display:block; margin-bottom:10px" >

<?php echo $editar?TbHtml::link(' ', $this->createUrl('eliminarZona'),
	   	array(
			'data-zid'=>$model->ZonasId,
			'class'=>'btn-eliminar-zona btn btn-danger fa fa-2x fa-minus-circle pull-left',
			'title'=>'Eliminar Zona '.$model->ZonasId
	)):""; ?>
<?php echo TbHtml::tag('span',array('class'=>'panel-head '),"Zona ".$model->ZonasNum.":".$model->ZonasId) ?>
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
echo CHtml::dropDownList('ZonasTipo', $model->ZonasTipo,array(1=>'General',2=>'Numerada'),array(
		'class'=>'ZonasTipo', 
		'disabled'=>!$editar,
		'data-id'=>$model->ZonasId));
	    	?>
	    </td>
		<td>
<?php echo TbHtml::textField('ZonasAli',$model->ZonasAli,array(
		'class'=>'input-medium ZonasAli',
		'data-id'=>$model->ZonasId));
			?>
		</td>
	    <td>
	    	<?php echo CHtml::numberField('ZonasCantSubZon',$model->ZonasCantSubZon,array(
					'class'=>'input-small text-center ZonasCantSubZon',		
					'disabled'=>!$editar,
					'data-id'=>$model->ZonasId,
			)); ?>
    	</td>
	    <td>
	    <?php echo TbHtml::numberField('ZonasCanLug',$model->ZonasCanLug,array(
				'class'=>'input-small text-center ZonasCanLug', 'prepend'=>'#',
				'disabled'=>!$editar,
				'data-id'=>$model->ZonasId,
				'append'=>CHtml::link('Generar','',array(
						'class'=>'btn ZonasCanLug',
						'disabled'=>!$editar,
						'data-id'=>$model->ZonasId)))) ?>	    
	    </td>
	    <td>
	    	<?php echo TbHtml::numberField('ZonasCosBol',$model->ZonasCosBol,array(
	    	'class'=>'input-small text-center ZonasCosBol', 'data-id'=>$model->ZonasId, 'prepend'=>'$')) ?>
	    </td>
	    <td>
<?php
			if ($editar) {
					echo TbHtml::buttonGroup(array(
							//array('label' => ' ','class'=>'fa fa-building-o btn-primary'),
							array('label' => ' ','class'=>'fa fa-bars btn',	'title'=>'Configurar Filas'),
							array('label' => ' ','class'=>'fa fa-th-large',	'title'=>'Configurar Asientos'),
					)); 
			}	
	    	?>
	    </td>
		<td>
				<div class='arbol-cargos' id="arbol-<?php echo $model->ZonasId; ?>">
				<?php $this->renderPartial('_arbolCargos',compact('model')); ?>
				</div>
	    </td>
	</tr>
</table>
<?php echo CHtml::closeTag('div'); ?>

