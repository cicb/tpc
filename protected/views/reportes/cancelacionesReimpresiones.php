<div class='controles'>
<h2>Historial De Cancelaciones Y Reimpresiones</h2>
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'controles',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
     'enableAjaxValidation'=>false,
     'clientOptions' => array('validateOnSubmit' => false)
     ));
     ?>
       <div class='col-4' >
          <div class="row">
            <?php
			echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
			if (!Yii::app()->user->isGuest) {
						$eventos = Yii::app()->user->modelo->getEventosAsignados();
						$list = CHtml::listData($eventos,'EventoId','EventoNom');
						echo CHtml::dropDownList('evento_id',@$_POST['evento_id'],$list,
								array(
										'ajax' => array(
												'type' => 'POST',
												'data'=>array('evento_id'=>'js:this.value'),
												'url' => CController::createUrl('funciones/cargarFuncionesFiltradas'),
												'beforeSend' => 'function() { $("#fspin").addClass("fa fa-spinner fa-spin");}',
												'complete'   => 'function() { 
														$("#fspin").removeClass("fa fa-spinner fa-spin");
														$("#funcion_id option:nth-child(2)").attr("selected", "selected");}',
																'update' => '#funcion_id',
														),'prompt' => 'Seleccione un Evento...'
												));
			}	
?>
            </div>
            <div class="row" id="funciones">
                <?php
                echo CHtml::label('Funcion','funcion_id', array('style'=>'width:70px; display:inline-table;'));
                echo CHtml::dropDownList('funcion_id',@$_POST['funcion_id'],array());
                echo CHtml::hiddenField('grid_mode','view');
                echo CHtml::hiddenField('funcion',@$funcionesId);
                ?>
                <span id="fspin" class="fa"></span>
            </div>

        </div>
		<div class='col-4'>
				<div class="input-append">
				<?php echo CHtml::label('Desde: ','desde',array('style'=>'display:inline-block')); ?>
				<?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
						'name' => 'desde',
						'pluginOptions' => array(
						'format' => 'yyyy-mm-dd'
						)
				));
				?>
				<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
				<br />
				<div class="input-append">
				<?php echo CHtml::label('Hasta: ','hasta',array('style'=>'display:inline-block')); ?>
				<?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
						'name' => 'hasta',
						'pluginOptions' => array(
						'format' => 'yyyy-mm-dd'
						)
				));
				?>
				<span class="add-on"><icon class="icon-calendar"></icon></span>
				</div>
		</div>
<br />
    <?php echo CHtml::submitButton('Ver reporte',array('class'=>'btn btn-primary btn-medium centrado')); ?> 
	<?php $this->endWidget(); ?>
</div>
<div id='reporte'>
<?php 
				if (isset($eventoId) and $eventoId>0) {
						//$this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
								//'id'=>'cancel-reimp-grid',
								//'dataProvider' => $model->getCancelacionesYReimpresiones($eventoId,$funcionesId,$desde,$hasta),
								//'template'=>'{items}<div class="col-4 centrado"> {pager}</div>',
								//'type'=>'striped hover',
								//'mergeColumns'=>array('VentasId','boleto','FilasId','LugaresId'),
								//'ajaxUpdate'=>false,
								//'columns' => array(
										//'boleto',
										//array(
												//'header'=>'Fila',
												//'name'=>'FilasId',
										//),
										//array(
												//'header'=>'Lugar',
												//'name'=>'LugaresId',
										//),
										//array(
												//'header'=>'Venta',
												//'name'=>'VentasId'
										//),
										//array(
												//'header'=>'NumBol Ventaslevel1 ',
												//'name'=>'LugaresNumBol'
										//),
										//array(
												//'header'=>'Estatus Ventaslevel1',
												//'name'=>'VentasSta'
										//),
										//array(
												//'header'=>'Usuario',
												//'name'=>'UsuariosNom'
										//),
										//array(
												//'header'=>'Reimpresion',
												//'type'=>'html',
												//'value'=>'"<span class=\'\'>".$data["tipo"]."</span>"',
										//),
										//array(
												//'header'=>'NumBol Anterior',
												//'name'=>'NumBol'
										//),
										//array(
												//'header'=>'Fecha/Hora',
												//'name'=>'fecha'
										//),
										//array(
												//'header'=>'Fec/Hor Cancelacion',
												//'name'=>'CancelFecHor'
										//),
										//array(
												//'header'=>'Cancelo',
												//'name'=>'CancelUsuarioId'
										//),
										//array(
												//'header'=>'PV. Ventaslevel1',
												//'name'=>'PuntosventaId'
										//),
										//array(
												//'header'=>'PV. Ventaslevel1',
												//'name'=>'PuntosventaId'
										//),
										////array(
												////'header'=>'C',
												////'name'=>'fecha'
										////),
										////array(
										////'class'=>'CButtonColumn',
										////'header'=>'',
										////'template'=>'{eliminar}  ',
										////'buttons'=>array(
										////'eliminar'=>array(
										////'label'=>'<span class="text-error fa fa-times-circle"> Quitar</span>',
										////'url'=>'Yii::app()->createUrl("usuarios/desasignarEvento",array(
										////"id"=>$data->UsuarioId,
										////"evento"=>$data->usrValIdRef,
										////"nick"=>"'.$model->UsuariosNick.'",
										////"funcion"=>$data->usrValIdRef2))',
										////'click'=>'function(event){
										////$.get( $(this).attr("href")).done( function(){ $.fn.yiiGridView.update("usrval-grid"); });
										////event.preventDefault(); }',

										////),
										////)

										////)


								//),
						//));
						$this->widget('yiiwheels.widgets.grid.WhGroupGridView', array(
								'id'=>'cancel-reimp-grid',
								'dataProvider' => $model->getAnomalos($eventoId,$funcionesId,$desde,$hasta),
								'template'=>'{items}<div class="col-4 centrado"> {pager}</div>',
								'type'=>'striped hover',
								'mergeColumns'=>array('VentasId','ZonasAli','SubzonaId','FilasAli','LugaresLug','VentasFecHor'),
								'ajaxUpdate'=>false,
								'columns' => array(
										'boleto',
										'ZonasAli',
										'SubzonaId',
										'FilasAli',
										'LugaresLug',
										'VentasId',
										'VentasFecHor',
										'VentasSta',
										'VentasCon',
										'LugaresNumBol',
										array(
												'header'=>'Reimpresiones',
												'type'=>'raw',
												'value'=>'is_numeric($data["reimpresiones"])?$data["reimpresiones"]+1:"0"',
										)
								)
						));
				}
				
?>
</div>
<?php 
Yii::app()->clientScript->registerScript('ddown','
$currentId=-1;
$(function() {
		var $contextMenu = $("#contextMenu");
		$("body").on("contextmenu", "table tr", function(e) {
				var id=	$(this).children(":first").text();
						currentId=id;
						//console.log(currentId);
						$contextMenu.css({
								display: "block",
										left: e.pageX,
										top: e.pageY
	});
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

?>
<style type='text/css'>
#contextMenu {
  position: absolute;
  display:none;

}
table{cursor:default;}
</style>
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modal',
    'header' => 'Historial del boleto',
    'content' => '<div id="tablaModal">'.TbHtml::animatedProgressBar(50).'</div>',
    'htmlOptions' => array('style'=>'width:60%;left:38%'),
    'footer' => implode(' ', array(
        TbHtml::button('Cerrar', array('data-dismiss' => 'modal')),
     )),
)); ?>
 

  <div id="contextMenu" class="dropdown clearfix">
    <ul class="dropdown-menu" id="contextual" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
	  <li>
<?php echo TbHtml::link(' Historial del boleto','#', array(
    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
	'class'=> 'fa fa-calendar-o',	
    'size' => TbHtml::BUTTON_SIZE_LARGE,
	'onclick'=>"$.ajax({
			url:'".$this->createUrl('ventas/historialBoleto')."&id='+currentId,
			success:function(data){ $('#tablaModal').html(data);},
	})",
	'data-toggle' => 'modal',
    'data-target' => '#modal',
)); ?>
			</li>
	  <li class="divider"></li>
	 <!-- <li><a tabindex="-1" href="#" class="fa fa-arrow-down"> Dar de baja</a></li>-->
    </ul>
  </div>
