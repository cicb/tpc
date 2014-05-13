<?php echo CHtml::openTag('div',array('id'=>'zona-'.$model->ZonasId)); ?>
	<div class="row-fluid" style="display:block; margin-bottom:10px" >

<?php echo TbHtml::ajaxButton(' ', $this->createUrl('eliminarZona'),array(
		'type'=>'POST',
		'data'=>array('Zonas'=>array(
				'EventoId'=>$model->EventoId,
				'FuncionesId'=>$model->FuncionesId,
				'ZonasId'=>$model->ZonasId,
				),
		),
		'success'=>'function(resp){ if(resp=="true"){ $("#zona-'.$model->ZonasId.'").remove();}
										else {alert(resp+" \nNo se puede eliminar esta zona.\nVerifique que el Evento no tenga ventas");}}',
		'beforeSend'=>'function(){ return confirm("¿Esta seguro de eliminar esta zona?"); }'
),
	   	array(
			'data-id'=>0,
			'class'=>'btn-quitar-funcion btn btn-danger fa fa-2x fa-minus-circle pull-left',
			'title'=>'Eliminar Zona '.$model->ZonasId
	)); ?>
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
		'class'=>'ZonasTipo', 'data-id'=>$model->ZonasId));
	    	?>
	    </td>
		<td>
			<?php echo TbHtml::textField('ZonasAli',$model->ZonasAli,array('class'=>'input-medium ZonasAli',
				'data-id'=>$model->ZonasId));
			?>
		</td>
	    <td>
	    	<?php echo CHtml::numberField('ZonasCantSubZon',$model->ZonasCantSubZon,array(
					'class'=>'input-small text-center ZonasCantSubZon',
					'data-id'=>$model->ZonasId,
			)); ?>
    	</td>
	    <td>
	    <?php echo TbHtml::numberField('ZonasCanLug',$model->ZonasCanLug,array(
				'class'=>'input-small text-center ZonasCanLug', 'prepend'=>'#',
				'data-id'=>$model->ZonasId,
			   	'append'=>CHtml::link('Generar','',array('class'=>'btn ZonasCanLug','data-id'=>$model->ZonasId)))) ?>	    
	    </td>
	    <td>
	    	<?php echo TbHtml::numberField('ZonasCosBol',$model->ZonasCosBol,array(
	    	'class'=>'input-small text-center ZonasCosBol', 'data-id'=>$model->ZonasId, 'prepend'=>'$')) ?>
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
<div class='arbol-cargos' id="arbol-<?php echo $model->ZonasId; ?>"></div>
	    		<?php 
$raiz=Zonaslevel1::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId,
		'ZonasId'=>$model->ZonasId,
		'PuntosventaId'=>Yii::app()->params['pvRaiz']
));
if (is_object($raiz)) {
	// Si el nodo raiz esta asignado
		$this->renderPartial('_nodoCargo', array('model'=>$raiz));
}	
 ?>
<?php 		echo TbHtml::ajaxButton(' Reparar árbol de cargo por servicio',
				array('generarArbolCargos'),
				array(
						'type'=>'POST',
						'data'=>array('Zonas'=>array(
								'EventoId'=>$model->EventoId,
								'FuncionesId'=>$model->FuncionesId,
								'ZonasId'=>$model->ZonasId,
						),
						'update'=>'#arbol-'.$model->ZonasId,
				)
		),
		array(
				'class'=>'btn btn-small  fa fa-sitemap'
		)
);  ?>
	    </td>
	</tr>
</table>
<?php echo CHtml::closeTag('div'); ?>
