<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'eventos-form',
    'enableAjaxValidation'=>false,
)); ?>
<div class='controles'>
        <h1>Administración de Puntos de Venta</h1>
        <?php if(Yii::app()->user->hasFlash('success')):?>
            <div class="alert alert-success">
                <?php echo TbHtml::b(Yii::app()->user->getFlash('success'),array('style'=>'font-size:150%')); ?>
            </div>
        <?php endif; ?>
		<div class='col-2'>
		<?php echo $form->textFieldControlGroup($model,'PuntosventaNom',
				array(
						'append' => TbHtml::submitButton('Buscar',array('class'=>'btn')), 
						'span' => 3,
						'placeholder'=>'Nombre del Punto de Venta',
						'id'=>'filtro-punto-venta'
				)); ?>		
<?php $this->endWidget(); ?>
				<?php echo TbHtml::link(' Agregar Punto de Venta', array('puntosventa/create') ,array('class'=>'fa fa-plus btn btn-primary')); ?>
		</div>
</div>

<div id='tabla-puntos-venta'>
		<?php 
             $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'puntos-venta-grid',
            'emptyText'=>'No se encontraron coincidencias',
            'dataProvider'=>$model->search(),
            'summaryText'=>'',
			//'filter'=>$model,
			'type'=>'condensed hover striped',
            'htmlOptions'=>array('class'=>'primario'),
            'columns'=>array(
                'tipoid',
                'PuntosventaId',
                'PuntosventaNom',
                'PuntosventaSuperId',
                'PuntosventaInf',
                'PuntosventaIdeTra',
                'PuntosventaSta',
                array(
							'class'=>'CButtonColumn',
							'header'=>'Acciones',
							'template'=>'{editar} {alta}{baja}  ',
							'buttons'=>array(
									'alta'=>array(
											'label'=>'<span class="text-success fa fa-arrow-up"> Dar Alta </span>',
											'url'=>'Yii::app()->createUrl("puntosventa/conmutarEstatus",array(
													"id"=>$data["PuntosventaId"],
											))',
											'visible'=>'$data["PuntosventaSta"]!="ALTA"',
											'click'=>'function(event)
											{ $.ajax({
													url:$(this).attr("href"),
															success: function(data){
																	$.fn.yiiGridView.update("puntos-venta-grid");
															}		
												 });
												event.preventDefault(); }',
									),
										'baja'=>array(
											'label'=>'<span class="text-error fa fa-arrow-down"> Dar Baja </span>',
											'url'=>'Yii::app()->createUrl("puntosventa/conmutarEstatus",array(
													"id"=>$data["PuntosventaId"],
											))',
											'visible'=>'$data["PuntosventaSta"]=="ALTA"',
											'click'=>'function(event)
											{ $.ajax({
													url:$(this).attr("href"),
															success: function(data){
																	$.fn.yiiGridView.update("puntos-venta-grid");
															}		
												 });
												event.preventDefault(); }',
									),
									'editar'=>array(
											'label'=>'<span class="text-info fa fa-pencil"> Editar </span>',
											'url'=>'Yii::app()->createUrl("puntosventa/update",array(
													"id"=>$data["PuntosventaId"],
											))',
									),
						)

					)
            ),
			/*'columns'=>array(
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
											'url'=>'Yii::app()->createUrl("evento/conmutarEstatus",array(
													"id"=>$data["EventoId"],
											))',
											'visible'=>'$data["EventoSta"]!="ALTA"',
											'click'=>'function(event)
											{ $.ajax({
													url:$(this).attr("href"),
															success: function(data){
																	$.fn.yiiGridView.update("eventos-grid");
															}		
												 });
												event.preventDefault(); }',
									),
										'baja'=>array(
											'label'=>'<span class="text-error fa fa-arrow-down"> Dar Baja </span>',
											'url'=>'Yii::app()->createUrl("evento/conmutarEstatus",array(
													"id"=>$data["EventoId"],
											))',
											'visible'=>'$data["EventoSta"]=="ALTA"',
											'click'=>'function(event)
											{ $.ajax({
													url:$(this).attr("href"),
															success: function(data){
																	$.fn.yiiGridView.update("eventos-grid");
															}		
												 });
												event.preventDefault(); }',
									),
									'editar'=>array(
											'label'=>'<span class="text-info fa fa-pencil"> Editar </span>',
											'url'=>'Yii::app()->createUrl("evento/actualizar",array(
													"id"=>$data["EventoId"],
											))',
									),
						)

					)
			)*/
	));
		?>
</div>
