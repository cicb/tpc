<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'agregar-usuario-form',
    'enableAjaxValidation'=>false,
)); ?>
<div class='controles'>
		<h2>Control de usuarios</h2>
		<?php echo $form->textFieldControlGroup($model,'UsuariosNom',
				array(
						'append' => TbHtml::submitButton('Buscar',array('class'=>'btn-primary')), 
						'span' => 3,
						'placeholder'=>'Nombre del usuario',
						'id'=>'filtro-usuario'
				)); ?>		
</div>
<div id='tabla-usuarios'>
		<?php 
             $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'taquilla-grid',
            'emptyText'=>'No se encontraron coincidencias',
            'dataProvider'=>$model->search(),
            'summaryText'=>'',
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
							'header'=>'Correo electrónico',
							'name'=>'UsuariosEmail',
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
											'url'=>'Yii::app()->createUrl("usuarios/registro")',
											'visible'=>'$data["UsuariosStatus"]!="ALTA"'
									),
										'baja'=>array(
											'label'=>'<span class="text-error fa fa-arrow-down"> Dar Baja </span>',
											'url'=>'Yii::app()->createUrl("usuarios/registro")',
											'visible'=>'$data["UsuariosStatus"]=="ALTA"'
									),
									'editar'=>array(
											'label'=>'<span class="text-info fa fa-pencil"> Editar </span>',
											'url'=>'Yii::app()->createUrl("usuarios/registro")',
									),
						)

					)
			)
	));
		?>
</div>
<?php $this->endWidget(); ?>
<?php 
Yii::app()->clientScript->registerCss('tablas','
		TD{padding:5px !important;}

		',CClientScript::POS_END)
?>
