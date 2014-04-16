<script type="text/javascript">
/*	$("#yw1").blur(function(){
		console.log($(this).val());
	});
	$(".datepicker-days td").on('click',function(){
		console.log('day');
		$("#yw1").focus();
	});*/
</script>
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
            <?php echo $form->textFieldControlGroup($model,'EventoDesWeb',array('span'=>4,'maxlength'=>200)); ?>

		<div class='alert'>
			<?php echo $form->dropDownListControlGroup($model, 'EventoSta',
					array('1'=>'BAJA', 'ALTA'=>'ALTA'), array('class' => 'span2')); ?>
		</div>
        <?php echo $form->dropDownListControlGroup($model, 'EventoSta2',
					array('1'=>'A la Venta', '2'=>'Proximamente','3'=>'Sinopsis','4'=>'Cancelado'), array('class' => 'span2')); ?>

		<?php echo $form->labelEx($model,'EventoFecIni',array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'EventoFecIni',array('class'=>'picker')) ;?>


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
<?php
Yii::app()->clientScript->registerScript('remove-chosen',"
$.fn.chosenDestroy = function () {
$(this).show().removeClass('chzn-done').removeAttr('id');
$(this).next().remove()
  return $(this);
}
function updateChosen(obj){
		$(obj).chosenDestroy();
		$(obj).chosen();
}


",CClientScript::POS_BEGIN);
?>
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
                <div class='span4 white-box box'>
				<h3><?php echo TbHtml::i('',array('class'=>'fa fa-picture-o')); ?> Imagen Mapa Chico</h3>
					<?php echo TbHtml::imagePolaroid(strlen($funciones->getForoPequenio())>3?$funciones->getForoPequenio():'holder.js/300x300','',
                    array('id'=>'img-imamapchi','style'=>'width:140px;')); ?>
					<br /><br />
					<?php  echo TbHtml::fileField('imamapchi','' , array('span'=>2,'maxlength'=>200, 'class'=>'hidden')); ?>
					<?php echo TbHtml::textField('MapaChico',$funciones->getUrlForoPequenio(),array(
                                'readonly'=>'readonly',
								'append'=>TbHtml::button('Seleccionar imagen',
								array('class'=>'btn btn-success','id'=>'btn-subir-imamapchi')),
								'placeholder'=>'Nombre de la imagen mapa chico',
                                )); ?>
		
				</div>
                <div class='span4 white-box box'>
				<h3><?php echo TbHtml::i('',array('class'=>'fa fa-picture-o')); ?> Imagen Mapa Grande</h3>
					<?php echo TbHtml::imagePolaroid(strlen($funciones->getForoPequenio())>3?$funciones->getForoGrande():'holder.js/300x300','',
                    array('id'=>'img-imamapgra','style'=>'width:340px;')); ?>
					<br /><br />
					<?php  echo TbHtml::fileField('imamapgra','' , array('span'=>2,'maxlength'=>200, 'class'=>'hidden')); ?>
					<?php echo TbHtml::textField('MapaGrande',$funciones->getUrlForoGrande(),array(
                                'readonly'=>'readonly',
								'append'=>TbHtml::button('Seleccionar imagen',
								array('class'=>'btn btn-success','id'=>'btn-subir-imamapgra')),
								'placeholder'=>'Nombre de la imagen mapa Gde.')); ?>
		
				</div>
                <?php else: ?>
                <?php echo TbHtml::button('Agregar mapas', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
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


<div class=' white-box box' id='listado-funciones'>
<h3>Funciones</h3>
<div class="col-5" >
	<?php echo CHtml::button(' Quitar', array(
			'id'=>'btn-quitar-funcion',
			'class'=>'btn btn-danger fa fa-minus-circle pull-left'
	)); ?>

	<?php echo CHtml::button(' Agregar', array(
			'id'=>'btn-agregar-funcion',
			'class'=>'btn btn-success fa fa-plus-circle pull-right'
	)); ?>
</div>

<?php
foreach($model->funciones() as $funcion){
		$this->renderPartial('/funciones/formulario',array('model'=>$funcion));
};
?>
</div>
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
            $('#btn-subir-imamapchi').on('click',function(){ $('#imamapchi').trigger('click'); });
            $('#imamapchi').on('change',function(){
					 if ($(this).val()!='' && $(this).val()!=null) {
							 if ($.inArray($(this).val().split('.').pop(),ext)==-1) {
									 alert('El archivo no tiene extension valida, (jpg,png,bmp,jpeg), por favor seleccione otro.');
									$(this).val('');	
					         }else{	
								var fd = new FormData();
								var imagen = document.getElementById('imamapchi');
								fd.append('imagen', imagen.files[0]);
								fd.append('prefijo', 'pv_');
                                console.log(fd);
								/*$.ajax({
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
								}).fail(function(){alert('Error!')});	*/	
                            }	
				 }
			});
            $('#btn-subir-imamapgra').on('click',function(){ $('#imamapgra').trigger('click'); });
				


						");

?>
<?php Yii::app()->clientScript->registerScript('agregar-funcion',sprintf("
			$('#btn-agregar-funcion').on('click',function(){
					$.ajax({
							url:'%s',
									type:'get',
							success:function(data){
									$('#listado-funciones').append(data);
									$('.picker:last').datetimepicker(); 
								}
						});
});

$('#btn-quitar-funcion').on('click',function(){
		console.log('click');
		$.ajax({url:'".$this->createUrl('funciones/quitar',array('eid'=>$model->EventoId))."',
				'success': function(){
						$('.div-funcion:last').remove();
				}
		});
});

$( '.nodo-toggle').live('click',function(){
	var id= $(this).data('id');
	var li= $(this).parent().attr('id');
	var link= $(this);
	if (link.data('estado')=='inicial') {
		var href= link.attr('href');
		$.ajax({
			url:href,
			success:function(data){ 
				$('#'+li).append(data);
				link.data('estado','toggle')
				link.toggleClass('fa-minus-square');
				$('.picker').datetimepicker({allowTimes:1});
			}
		});
	}
	else if (link.data('estado')=='toggle'){
		link.toggleClass('fa-minus-square');
		$('#rama-'+li).toggle();
		// link.toggleClass('fa-plus-square');
	}
	return false;
})

$( '.nodo-cal').live('click',function(){
	$('#dlg').load($(this).attr('href'));
});
",$this->createUrl('funciones/insertar',array('eid'=>$model->EventoId))),CClientScript::POS_READY);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl. '/js/jquery.datetimepicker.js',CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl. '/css/jquery.datetimepicker.css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl."/css/jquery.datetimepicker.css" ; ?>" />
 <script type="text/javascript" charset="utf-8">
$('.picker').datetimepicker({
		
		lang:'es'}); 
 </script>

<script type="text/javascript">

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
	$('.FecHor').change(
		function()
		{
			var id=$(this).data('id');
			var meses = new Array ("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC");
			var diasSemana = new Array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			var fechatemp = new Date($(this).val());
			$('#FuncText-'+id).val(diasSemana[fechatemp.getDay()] + " " + fechatemp.getDate() + " - " + 
				meses[fechatemp.getMonth()] + " - " + fechatemp.getFullYear() + " " + fechatemp.getHours() + ":" + 
				(fechatemp.getMinutes()=="0" ? "0"+fechatemp.getMinutes() : fechatemp.getMinutes()) + " HRS");

		});

	$('.FecHor').on('focusout', 
		function()
		{	
			var id=$(this).data('id');
			var datos={Funciones:{FuncionesFecHor:$(this).val(), funcionesTexto:$('#FuncText-'+id).val()} };
			actualizarf(datos,$(this).data('id'));
		});

	$('.FuncText').on('focusout', 
		function()
		{	
			var id=$(this).data('id');
			var datos={Funciones:{funcionesTexto:$(this).val()} };
			actualizarf(datos,$(this).data('id'));
		});

	$('.FuncText').on('keyup',
		function()
		{
			$(this).attr('id','-1');
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
      });>
  
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