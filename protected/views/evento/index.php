<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'eventos-form',
    'enableAjaxValidation'=>false,
)); ?>
<div class='controles'>
        <h1>Administración De Eventos</h1>
		<div class='col-2'>
		<?php echo $form->textFieldControlGroup($model,'EventoNom',
				array(
						'append' => TbHtml::submitButton('Buscar',array('class'=>'btn')), 
						'span' => 3,
						'placeholder'=>'Nombre del evento',
						'id'=>'filtro-usuario'
				)); ?>		
<?php $this->endWidget(); ?>
				<?php echo TbHtml::button(' Agregar Evento',array('class'=>'fa fa-plus btn btn-primary')); ?>
		</div>
</div>

<div id='tabla-usuarios'>
		<?php 
             $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'eventos-grid',
            'emptyText'=>'No se encontraron coincidencias',
            'dataProvider'=>$model->search(),
            'summaryText'=>'',
			//'filter'=>$model,
			'type'=>'condensed hover striped',
            'htmlOptions'=>array('class'=>'primario'),
			'columns'=>array(
					array(
							'header'=>'Id',
							'name'=>'EventoId',
					),
					array(
							'header'=>'Nombre',
							'name'=>'EventoNom',
					),
					array(
							'header'=>'Estatus',
							'name'=>'EventoSta',
					),
					array(
							'header'=>'Inicia',
							'name'=>'EventoFecIni',
					),
					array(
							'header'=>'Finaliza',
							'name'=>'EventoFecFin',
					),
					array(
							'class'=>'CButtonColumn',
							'header'=>'Acciones',
							'template'=>'{editar} {alta}{baja}  ',
							'buttons'=>array(
									'alta'=>array(
											'label'=>'<span class="text-success fa fa-arrow-up"> Dar Alta </span>',
											'url'=>'Yii::app()->createUrl("usuarios/conmutarEstatus",array(
													"id"=>$data["EventoId"],
											))',
											'visible'=>'$data["EventoSta"]!="ALTA"',
											'click'=>'function(event)
											{ $.ajax({
													url:$(this).attr("href"),
															success: function(data){
																	$.fn.yiiGridView.update("usuarios-grid");
															}		
												 });
												event.preventDefault(); }',
									),
										'baja'=>array(
											'label'=>'<span class="text-error fa fa-arrow-down"> Dar Baja </span>',
											'url'=>'Yii::app()->createUrl("usuarios/conmutarEstatus",array(
													"id"=>$data["EventoId"],
											))',
											'visible'=>'$data["EventoSta"]=="ALTA"',
											'click'=>'function(event)
											{ $.ajax({
													url:$(this).attr("href"),
															success: function(data){
																	$.fn.yiiGridView.update("usuarios-grid");
															}		
												 });
												event.preventDefault(); }',
									),
									'editar'=>array(
											'label'=>'<span class="text-info fa fa-pencil"> Editar </span>',
											'url'=>'Yii::app()->createUrl("usuarios/actualizar",array(
													"id"=>$data["EventoId"],
											))',
									),
						)

					)
			)
	));
		?>
</div>
