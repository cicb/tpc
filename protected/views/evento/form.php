<script type="text/javascript">
	$("#yw1").blur(function(){
		console.log($(this).val());
	});
	$(".datepicker-days td").on('click',function(){
		console.log('day');
		$("#yw1").focus();
	});
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
		<div class="input-append">
				<?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
						'name' => 'Evento[EventoFecIni]',
						'value'=>$model->EventoFecIni,
						'pluginOptions' => array(
								'lenguage'=>'es-MX',
								'format' => 'yyyy-MM-dd hh:mm:ss'
						)
				));
				?>
		</div>


<div class='control-group'>

		<?php echo $form->labelEx($model,'EventoFecFin',array('class'=>'control-label')); ?>
		<div class="input-append " >
				<?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
						'name' => 'Evento[EventoFecFin]',
						'value'=>$model->EventoFecFin,
						'pluginOptions' => array(
								'lenguage'=>'es-MX',
								'format' => 'yyyy-MM-dd hh:mm:ss'
						)
				));
				?>
		</div>
</div>

<div class='control-group'>
		<?php echo $form->labelEx($model,'EventoTemFecFin',array('class'=>'control-label')); ?>
		<div class="input-append">
				<?php $this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
						'name' => 'Evento[EventoTemFecFin]',
						'value'=>$model->EventoTemFecFin,
						'pluginOptions' => array(
								'lenguage'=>'es-MX',
								'format' => 'yyyy-MM-dd hh:mm:ss'
						)
				));
				?>
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
<?php echo TbHtml::link(' Regresar',array('index'),array('class'=>'fa fa-chevron-circle-left btn ')); ?>
        <?php echo TbHtml::submitButton($model->isNewRecord ? ' Registrar' : ' Guardar',array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
			'size'=>TbHtml::BUTTON_SIZE_LARGE,
			'class'=>'fa fa-check'
        )); ?>
    </div>



    <?php $this->endWidget(); ?>

<?php echo TbHtml::button('Agregar', array('color' => TbHtml::BUTTON_COLOR_PRIMARY,'id'=>'btn-agregar-funcion')); ?>
<!--<button class="btn btn-primary">ok</button>-->
</div><!-- form -->
<?php if(!$model->isNewRecord):?>
<?php $lista_funciones = Funciones::model()->findAll("EventoId=".$_GET['id']);?>
<ul id="lista-funciones">
	<?php foreach ($lista_funciones as $key => $value):?>
		<li><?php echo $value->FuncionesId;?></li>
	<?php endforeach;?>	
</ul>


</div>
<script type="text/javascript">
	$("#btn-agregar-funcion").click(function(){
		
		$.ajax({
			  url:'<?php echo Yii::app()->createUrl('funciones/pruebaajax');?>',
              type:'post',
              error:function(error){
              	alert(error);
              },
              data:{id:<?php echo $_GET['id']; ?>,funcion:$("ul#lista-funciones li").length},
              success:function(datos){
              	console.log(datos);
              	$("ul#lista-funciones").append("<li>"+datos+"</li>");
              }
		});
	});
</script>
<?php endif;?>

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
