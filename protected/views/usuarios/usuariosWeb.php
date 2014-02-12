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
					'iduser',
					'username',
					'nombre',
					'apellido_paterno',
					'apellido_materno',
					'email',
					'state',
					'telefono',
					'sexo',
					//'direccion',
					'codigo_postal',
					'colonia',
					'ciudad_municipio',
					//'estadoNom',
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
Yii::app()->clientScript->registerScript('ddown','
$currentId=-1;
$(function() {
		var $contextMenu = $("#contextMenu");
		$("body").on("contextmenu", "table tr", function(e) {
				var id=	$(this).children(":first").text();
				if ($.isNumeric(id)){
						currentId=parseInt(id);
						//console.log(currentId);
						$contextMenu.css({
								display: "block",
										left: e.pageX,
										top: e.pageY
	});
	}	  
	return false;
  });

	$("body").on("click", "table tr", function(e) {
				$contextMenu.hide();
		});

  $contextMenu.on("click", "a", function() {
		  $contextMenu.hide();
  });
	$("#contextual li a").on("click",function(){

		return true;
   }); 
});	 
		');
//Yii::app()->clientScript->registerCss('tablas','
		//TD{padding:5px !important;}
		//FORM {margin:5px;}
		//',CClientScript::POS_END)
?>
<style type='text/css'>
#contextMenu {
  position: absolute;
  display:none;

}
table{cursor:default;}
</style>
  <div id="contextMenu" class="dropdown clearfix">
    <ul class="dropdown-menu" id="contextual" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
	  <li><a tabindex="-1" href='<?php echo $this->createUrl('usuarios/historialCompras') ; ?>' class="fa fa-dollar">
 Historial de compras</a></li>
	  <li><a tabindex="-1" href="#" class="fa fa-credit-card"> Tarjetas de credito.
			</a></li>
	  <li class="divider"></li>
	  <li><a tabindex="-1" href="#" class="fa fa-arrow-down"> Dar de baja</a></li>
    </ul>
  </div>
