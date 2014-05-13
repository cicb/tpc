<?php
/* @var $this EventoController */
/* @var $model Evento */
/* @var $form TbActiveForm */
?>
    <?php 
        $this->widget( 'ext.EChosen.EChosen', array(
            'target' => '.chosen',
      ));
    ?>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'evento-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<div class='controles' style="min-height:100%">

<?php echo sprintf("<h2>%s</h2>",$model->scenario=="insert"?'Nuevo Registro De Evento':'Actualizar Evento'); ?>
	<p class="help-block">Los campos con <span class="required">*</span> con requeridos.</p>
	<?php echo $form->errorSummary($model); ?>
<br />
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo TbHtml::b(Yii::app()->user->getFlash('success'),array('style'=>'font-size:150%')); ?>
    </div>
<?php endif; ?>

		<div class='col-2 white-box box'>
		<h3>Información básica</h3>

			<?php echo $form->textFieldControlGroup($model,'EventoNom',array('span'=>4,'maxlength'=>150)); ?>
            <?php echo $form->textFieldControlGroup($model,'EventoDesBol',array( 'span'=>4,'maxlength'=>75)); ?>
		<div class='alert'>
			<?php echo $form->dropDownListControlGroup($model, 'EventoSta',
					array('1'=>'BAJA', 'ALTA'=>'ALTA'), array('class' => 'span2')); ?>
		</div>
        <?php echo $form->dropDownListControlGroup($model, 'EventoSta2',
					array('1'=>'A la Venta', '2'=>'Proximamente','3'=>'Sinopsis','4'=>'Cancelado'), array('class' => 'span2')); ?>

<div class='control-group'>
		<?php echo $form->labelEx($model,'EventoFecIni',array('class'=>'control-label')); ?>
 <div class="input-append">
		<?php echo $form->textField($model,'EventoFecIni',array('class'=>'picker')) ;?>
 </div>
</div>
<div class='control-group'>
		<?php echo $form->labelEx($model,'EventoFecFin',array('class'=>'control-label')); ?>
 <div class="input-append">
		<?php echo $form->textField($model,'EventoFecFin',array('class'=>'picker')) ;?>
 </div>
</div>

<div class='control-group'>
		<?php echo $form->labelEx($model,'EventoTemFecFin',array('class'=>'control-label')); ?>
 <div class="input-append">
		<?php echo $form->textField($model,'EventoTemFecFin',array('class'=>'picker')) ;?>
 </div>
</div>		

<div class='control-group'>
	<?php echo $form->labelEx($model,'CategoriaId',array('class'=>'control-label')); ?>
	<?php echo $form->dropDownList($model,'CategoriaId',
			 CHtml::listData(
					Categoria::model()->findAll("CategoriaSta='ALTA'"),
					'CategoriaId','CategoriaNom'),
			 array(
					 'empty'=>'Sin categoria','class'=>'span3 chosen',
					 'ajax' => array(
							 'type' => 'POST',  
							 'url' => CController::createUrl('evento/cargarSubcategorias'),
							 'update' => '#Evento_CategoriaSubId',
                             'success' => 'function(data){$("#Evento_CategoriaSubId").html(data);updateChosen(".chosen");}',
					 )
	 )
	) ; ?>
	<?php echo $form->error($model,'CategoriaId'); ?>
</div>
<div class='control-group'>
	<?php echo $form->labelEx($model,'CategoriaSubId',array('class'=>'control-label')); ?>
	<?php echo $form->dropDownList($model,'CategoriaSubId',
			 CHtml::listData(
					Categorialevel1::model()->findAllByAttributes(array('CategoriaId'=>$model->CategoriaId)),
					'CategoriaSubId','CategoriaSubNom'),
			 array('empty'=>'Sin subcategoria','class'=>'span3 chosen',

	 )
	) ; ?>
	<?php echo $form->error($model,'CategoriaSubId'); ?>
</div>

<div class='control-group'>
	<?php echo $form->labelEx($model,'ForoId',array('class'=>'control-label')); ?>
	<?php echo $form->dropDownList($model,'ForoId',
			 CHtml::listData(
					Foro::model()->findAll(),
					'ForoId','ForoNom'),
			array('empty'=>'Sin foro','class'=>'span3 chosen')
	) ; ?>
	<?php echo $form->error($model,'ForoId'); ?>
</div>

<div class='control-group'>
	<?php echo $form->labelEx($model,'PuntosventaId',array('class'=>'control-label')); ?>
	<?php echo $form->dropDownList($model,'PuntosventaId',
			 CHtml::listData(
					Puntosventa::model()->findAll(),
					'PuntosventaId','PuntosventaNom'),
			array('empty'=>'Sin Punto de Venta','class'=>'span3 chosen')
	) ; ?>
	<?php echo $form->error($model,'PuntosventaId'); ?>
</div>

		</div>
	


		<div class='col-3'>
				<div class='span4 white-box box'>
				<h3><?php echo TbHtml::i('',array('class'=>'fa fa-picture-o')); ?> Imagen en boleto</h3>
					<?php echo TbHtml::imagePolaroid(strlen($model->EventoImaBol)>3?"../imagesbd/".$model->EventoImaBol:'holder.js/239x69','',array('id'=>'img-imabol')); ?>
					<br /><br />
					<?php  echo TbHtml::fileField('imabol','' , array('span'=>2,'maxlength'=>200, 'class'=>'hidden')); ?>

						<?php echo $form->textField($model,'EventoImaBol',array(
								'append'=>TbHtml::button('Seleccionar imagen',
								array('class'=>'btn btn-success','id'=>'btn-subir-imabol')),
								'placeholder'=>'Nombre de la imagen en Boleto')); ?>

				</div>


				<div class='span4 white-box box'>
				<h3><?php echo TbHtml::i('',array('class'=>'fa fa-picture-o')); ?> Imagen para PV</h3>
					<?php echo TbHtml::imagePolaroid(strlen($model->EventoImaMin)>3?"../imagesbd/".$model->EventoImaMin:'holder.js/130x130','',
                     array('id'=>'img-imamin')); ?>
					<br /><br />
					<?php  echo TbHtml::fileField('imamin','' , array('span'=>2,'maxlength'=>200, 'class'=>'hidden')); ?>
					<?php echo $form->textField($model,'EventoImaMin',array(
								'append'=>TbHtml::button('Seleccionar imagen',
								array('class'=>'btn btn-success','id'=>'btn-subir-imamin')),
								'placeholder'=>'Nombre de la imagen miniatura')); ?>
		
				</div>
                <?php if($model->scenario=='update' AND !empty($funciones)): ?>
                <style>
	            .modal-body {
                    max-height: 100%;
                }
                .modal-footer{
                    padding: 2px 15px;
                }
               </style>
                <?php $this->widget('bootstrap.widgets.TbModal', array(
                    'id' => 'ModalMapaChico',
                    'header' => 'Coordenadas Mapa Chico',
                    'content' => $this->renderPartial('_mapaChico',array('eventoId'=>$_GET['id']),true),
                    'footer' => array(
                        //TbHtml::button('Save Changes', array('data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
                        //TbHtml::button('Cerrar', array('data-dismiss' => 'modal')),
                     ),
                     'htmlOptions' => array('style' => 'width: 700px;margin-left: -400px;'), 
                )); ?>
                <?php $this->widget('bootstrap.widgets.TbModal', array(
                    'id' => 'ModalMapaGrande',
                    'header' => 'Coordenadas Mapa Grande',
                    'content' => $this->renderPartial('_mapaGrande',array('eventoId'=>$_GET['id']),true),
                    'footer' => array(
                        //TbHtml::button('Save Changes', array('data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
                        //TbHtml::button('Cerrar', array('data-dismiss' => 'modal')),
                     ),
                     'htmlOptions' => array('style' => 'width: 1100px;margin-left: -550px;top:5px'),
                )); ?>
                <?php endif;?>
		</div>
	

        <div class="form-actions">
<?php echo TbHtml::link(' Regresar',array('index'),array('class'=>' btn btn-primary fa-arrow-left ')); ?>
        <?php echo TbHtml::submitButton($model->isNewRecord ? ' Registrar' : ' Guardar',array(
			'size'=>TbHtml::BUTTON_SIZE_LARGE,
			'class'=>'btn btn-check fa fa-check'
        )); ?>
    </div>



    <?php $this->endWidget(); ?>

<!--<button class="btn btn-primary">ok</button>-->
</div><!-- form -->
<?php if(!$model->isNewRecord):?>
<input type="hidden" id="coor-funcionid" data-funcionId="1" />


<div class=' white-box box text-center' >
	<h3 id="funciones">Funciones</h3>
<div id='listado-funciones'>
	<?php
	foreach($model->funciones as $funcion){
			$this->renderPartial('/funciones/formulario',array('model'=>$funcion));
	};
	?>
</div>
<i id="feedback-funcion" class="fa fa-3x" ></i><br/><br/>
	<?php echo TbHtml::button(' Agregar una función', array(
			'class'=>'btn-agregar-funcion btn btn-success fa fa-2x fa-plus-circle center'
	)); ?>
</div>

<?php endif;?>
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'dlg-confiPvFuncion',
    'header' => 'Selecciona el rango de fechas',
    'content' => "<div is='dlg'></div>",
    'footer' => implode(' ', array(
    	TbHtml::button('Guardar cambios', array(
    		'data-dismiss' => 'modal',
    		'color' => TbHtml::BUTTON_COLOR_PRIMARY)
    	),
    	TbHtml::button('Cerrar', array('data-dismiss' => 'modal')),
    	)),
)); ?>

<?php 
				Yii::app()->clientScript->registerScriptFile("js/holder.js");
				Yii::app()->clientScript->registerScript("subir-boleto","
						var ext= ['jpg','png','bmp','jpeg'];
				$('#btn-subir-imabol').on('click',function(){ $('#imabol').trigger('click'); });
			 $('#imabol').on('change',function(){
					 if ($(this).val()!='' && $(this).val()!=null) {
							 if ($.inArray($(this).val().split('.').pop(),ext)==-1) {
									 alert('El archivo no tiene extension xls, por favor seleccione otro.');
									$(this).val('');	
						}else{	 
								var fd = new FormData();
								var imagen = document.getElementById('imabol');
								fd.append('imagen', imagen.files[0]);
								fd.append('prefijo', 'boleto_');
								$.ajax({
										url: '".Yii::app()->createUrl('evento/subirImagen')."',
												type: 'POST',
												data: fd,
												processData: false,  // tell jQuery not to process the data
												contentType: false,   // tell jQuery not to set contentType
												success: function(data){ 
														if (data) {
																$('#Evento_EventoImaBol').val(data);
																$('#img-imabol').attr('src','../imagesbd/'+data);

														}	
												 }
								}).fail(function(){alert('Error!')});		
						}	
				 }
			});
			$('#btn-subir-imamin').on('click',function(){ $('#imamin').trigger('click'); });
			 $('#imamin').on('change',function(){
					 if ($(this).val()!='' && $(this).val()!=null) {
							 if ($.inArray($(this).val().split('.').pop(),ext)==-1) {
									 alert('El archivo no tiene extension xls, por favor seleccione otro.');
									$(this).val('');	
						}else{	 
								var fd = new FormData();
								var imagen = document.getElementById('imamin');
								fd.append('imagen', imagen.files[0]);
								fd.append('prefijo', 'pv_');
								$.ajax({
										url: '".Yii::app()->createUrl('evento/subirImagen')."',
												type: 'POST',
												data: fd,
												processData: false,  // tell jQuery not to process the data
												contentType: false,   // tell jQuery not to set contentType
												success: function(data){ 
														if (data) {
																$('#Evento_EventoImaMin').val(data);
																$('#img-imamin').attr('src','../imagesbd/'+data);

														}	
												 }
								}).fail(function(){alert('Error!')});		
						}	
				 }
			});
   ");

?>

<?php 
if (isset($model) and is_object($model) and $model->EventoId) {
Yii::app()->clientScript->registerScript('agregar-funcion',sprintf("


$('.btn-quitar-funcion').live('click',function(){
		if(confirm('¿Esta usted seguro de querer eliminar esta función? Esta operación es irreversible')){			
			var ff=$(this).data('id');
			$.ajax({
				url:'".$this->createUrl('funciones/quitar')."',
				type:'post',
				data:{eid:".$model->EventoId.",fid:ff},
				success: function(){
					$('#f-".$model->EventoId."-'+ff).remove();
				}
			});
		}
});


",$this->createUrl('funciones/insertar',array('eid'=>$model->EventoId))),CClientScript::POS_READY);
}
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl. '/js/jquery.datetimepicker.js',CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl. '/js/evento.js'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl. '/css/jquery.datetimepicker.css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl."/css/jquery.datetimepicker.css" ; ?>" />
 <script type="text/javascript" charset="utf-8">
 $("#btn-coordenadas-mapchi").live('click',function(){
     var funcionId = $(this).data('funcionid');
     var eventoId  = '<?php echo @$_GET['id']?>';
     $.ajax({
            url      : '<?php echo $this->createUrl('evento/getUrlImagenMapaChico') ?>',
            type     : 'post',
            dataType : 'json',
            data     : {eventoId:eventoId,funcionId:funcionId},
            success  : function(data){
                            $('#area-imagen-chica img').attr('src',data.url);
                       }
     });
     $.ajax({
            url        : '<?php echo $this->createUrl('evento/getSubzonas') ?>',
            type       : 'post',
            beforeSend : function(){
                            $('#select-sub-zona').html("");
                         },
            data       : {eventoId:eventoId,funcionId:funcionId},
            success    : function(data){
                            $('#select-sub-zona').html(data);
                         }
     });
 });
 $("#btn-coordenadas-mapgra").live('click',function(){
     var funcionId = $(this).data('funcionid');
     var eventoId  = '<?php echo @$_GET['id']?>';
     $.ajax({
            url      : '<?php echo $this->createUrl('evento/getUrlImagenMapaGrande') ?>',
            type     : 'post',
            dataType : 'json',
            data     : {eventoId:eventoId,funcionId:funcionId},
            success  : function(data){
                            $('#area-imagen-grande img').attr('src',data.url);
                       }
     });
     $.ajax({
            url        : '<?php echo $this->createUrl('evento/getSubzonas') ?>',
            type       : 'post',
            beforeSend : function(){
                            $('#select-sub-zona-mapa-grande').html("");
                         },
            data       : {eventoId:eventoId,funcionId:funcionId},
            success    : function(data){
                            $('#select-sub-zona-mapa-grande').html(data);
                         }
     });
 });
$('.picker').datetimepicker({
		
		lang:'es'}); 

function actualizarf(datos, funcionid) 
{
	$.ajax(
		{url: "<?php echo CController::createUrl('Funciones/update',array('EventoId'=>$model->EventoId)); ?>&FuncionesId="+funcionid,
		data:datos,
		type:'POST',
		dataType:'JSON',
		success:function(data)
		{
			if (data.respuesta)
			{
				console.log('La actualización se realizo con exito');
			}
		}
	})

}
$('.CPVFSta').live('click', 
	function()
	{
		var pvid=$(this).data('pid');
		var funcid=$(this).data('fid');
		$.ajax(
			{url: "<?php echo CController::createUrl('Funciones/ActualizarPv'); ?>",
			data:{EventoId:'<?php echo $model->EventoId?>',FuncionesId:funcid,PuntosventaId:pvid,atributo:'ConfiPVFuncionSta',valor:($(this).prop('checked')==true ? 'ALTA' : 'BAJA')},
			type:'GET',
			success:function(data)
			{
				console.log(data);
			}
		});
	});

$('.CPVFFecIni').live('change', 
	function()
	{
		var pvid=$(this).data('pid');
		var funcid=$(this).data('fid');
		$.ajax(
			{url: "<?php echo CController::createUrl('Funciones/ActualizarPv'); ?>",
			data:{EventoId:'<?php echo $model->EventoId?>',FuncionesId:funcid,PuntosventaId:pvid,atributo:'ConfiPVFuncionFecIni',valor:$(this).val()},
			type:'GET',
			success:function(data)
			{
				console.log(data);
			}
		});
	});
$('.CPVFFecFin').live('change', 
	function()
	{
		var pvid=$(this).data('pid');
		var funcid=$(this).data('fid');
		$.ajax(
			{url: "<?php echo CController::createUrl('Funciones/ActualizarPv'); ?>",
			data:{EventoId:'<?php echo $model->EventoId?>',FuncionesId:funcid,PuntosventaId:pvid,atributo:'ConfiPVFuncionFecFin',valor:$(this).val()},
			type:'GET',
			success:function(data)
			{
				console.log(data);
			}
		});
	});

$('.btn-agregar-funcion').live('click',function(){
	var btn=$('#feedback-funcion');
	btn.toggleClass('fa-spinner fa-spin','hidden');
	$.ajax({
		url:'<?php echo CController::createUrl("funciones/insertar",array("eid"=>$model->EventoId));?>',
		type:'get',
		complete:function(){
			btn.toggleClass('fa-spinner fa-spin','hidden');
		},
		success:function(data){
			$('#listado-funciones').append(data);
			$('.picker').datetimepicker({allowTimes:1});

		}
	});
});

	$('.CPVFFecFin').live('change', 
		function()
		{
			var pvid=$(this).data('pid');
			var funcid=$(this).data('fid');
			$.ajax(
				{url: "<?php echo CController::createUrl('Funciones/ActualizarPv'); ?>",
				data:{EventoId:'<?php echo $model->EventoId?>',FuncionesId:funcid,PuntosventaId:pvid,atributo:'ConfiPVFuncionFecFin',valor:$(this).val()},
				type:'GET',
				success:function(data)
				{
					console.log(data);
				}
			});
		});
</script>	


<script>
  	$(function() {
  	  // Apparently click is better chan change? Cuz IE?
      $('input[type="checkbox"]').change(function(e) {
      var checked = $(this).prop("checked"),
          container = $(this).parent(),
          siblings = container.siblings();
  
      container.find('input[type="checkbox"]').prop({
          indeterminate: false,
          checked: checked
      });
  
      function checkSiblings(el) {
          var parent = el.parent().parent(),
              all = true;
  
          el.siblings().each(function() {
              return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
          });
  
          if (all && checked) {
              parent.children('input[type="checkbox"]').prop({
                  indeterminate: false,
                  checked: checked
              });
              checkSiblings(parent);
          } else if (all && !checked) {
              parent.children('input[type="checkbox"]').prop("checked", checked);
              parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
              checkSiblings(parent);
          } else {
              el.parents("li").children('input[type="checkbox"]').prop({
                  indeterminate: true,
                  checked: false
              });
          }
        }
    
        checkSiblings(container);
      });
    });
    </script>

