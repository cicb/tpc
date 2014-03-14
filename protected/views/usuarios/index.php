<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'agregar-usuario-form',
    'enableAjaxValidation'=>false,
)); ?>
<div class='controles'>
		<h2>Control de usuarios</h2>
		<?php echo $form->textFieldControlGroup($model,'UsuariosNom',
				array(
						'append' => TbHtml::submitButton('Buscar',array('class'=>'btn')), 
						'span' => 3,
						'placeholder'=>'Nombre del usuario o Nick',
						'label'=>'',
						'id'=>'filtro-usuario'
				)); ?>		
<?php $this->endWidget(); ?>
<?php echo TbHtml::link('<span class="fa fa-plus-circle"> Registrar nuevo</span>',$this->createUrl('usuarios/registro'),array('class'=>'btn btn-primary')); ?>
<br />
<br />
</div>
<div id='tabla-usuarios'>
		<?php 
             $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'usuarios-grid',
            'emptyText'=>'No se encontraron coincidencias',
            'dataProvider'=>$model->buscar(),
            'summaryText'=>'',
			//'filter'=>$model,
			'type'=>'condensed hover striped',
            'htmlOptions'=>array('class'=>'primario'),
			'columns'=>array(
					array(
							'header'=>'Id',
							'name'=>'UsuariosId',
					),
					array(
							'header'=>'Nick',
							'name'=>'UsuariosNick',
					),
					array(
							'header'=>'Nombre de Usuario',
							'name'=>'UsuariosNom',
					),
					array(
							'header'=>'Estatus',
							'name'=>'UsuariosStatus',
					),
					'TipUsrId',
					array(
							'header'=>'Tipo de usuario',
							'name'=>'tipo',
					),
					array(
							'class'=>'CButtonColumn',
							'header'=>'Acciones',
							'template'=>'{editar} {alta}{baja}  ',
							'buttons'=>array(
									'alta'=>array(
											'label'=>'<span class="text-success fa fa-arrow-up"> Dar Alta </span>',
											'url'=>'Yii::app()->createUrl("usuarios/conmutarEstatus",array(
													"id"=>$data["UsuariosId"],
													"nick"=>$data["UsuariosNick"],
											))',
											'visible'=>'$data["UsuariosStatus"]!="ALTA"',
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
													"id"=>$data["UsuariosId"],
													"nick"=>$data["UsuariosNick"],
											))',
											'visible'=>'$data["UsuariosStatus"]=="ALTA"',
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
													"id"=>$data["UsuariosId"],
													"nick"=>$data["UsuariosNick"],
											))',
									),
						)

					)
			)
	));
		?>
</div>
<?php 
Yii::app()->clientScript->registerCss('tablas','
		TD{padding:5px !important;}
		FORM {margin:5px;}
		',CClientScript::POS_END)
?>
