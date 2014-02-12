<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'agregar-usuario-form',
    'enableAjaxValidation'=>false,
)); ?>
<div class='controles'>
		<h2>Usuarios Web</h2>
		<?php echo $form->textFieldControlGroup($model,'nombre',
				array(
						'append' => TbHtml::submitButton('Buscar',array('class'=>'btn')), 
						'span' => 3,
						'placeholder'=>'Nombre del usuario o Nick',
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
            'dataProvider'=>$model->search(),
			//'filter'=>$model,
			'template'=>'{items}<div class="col-2 centrado"> {pager}</div>',
			'type'=>'condensed hover striped',
            'htmlOptions'=>array('class'=>'primario'),
			'columns'=>array(
					array(
							'header'=>'Id',
							'name'=>'iduser',
					),
					'username',
					'nombre',
					'apellido_paterno',
					'apellido_materno',
					'email',
					'state',
					'telefono',
					'sexo',
					'direccion',
					'codigo_postal',
					'colonia',
					'ciudad_municipio',
					'estadoNom',
					'pais',
					'regdate',
					'actdate',
					'logondate',
					'totalsessioncounter',
					'currentsessioncounter',

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
