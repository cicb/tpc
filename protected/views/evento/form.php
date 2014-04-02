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
					array('BAJA'=>'BAJA', 'ALTA'=>'ALTA'), array('class' => 'span2')); ?>
		</div>
			<?php echo $form->textFieldControlGroup($model,'EventoSta2',array('span'=>2,'maxlength'=>20)); ?>

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
					Categorialevel1::model()->findAll(),
					'CategoriaId','CategoriaSubNom'),
			 array(
					 'empty'=>'Sin categoria','class'=>'span3 chosen',
					 'ajax' => array(
							 'type' => 'POST',
							 'url' => CController::createUrl('evento/cargarSubcategorias'),
							 'update' => '#Evento_CategoriaSubId',
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




</div><!-- form -->





</div>


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

	<?php $funciones=new Funciones; ?>

	<div class='col-2 white-box box'>

		<h3>Agregar Funciones</h3>

			<?php $this->widget('bootstrap.widgets.TbGridView', array(
			   'dataProvider' => $funciones->search(),
			   //'filter' => $funciones,
			   'template' => "{items}",
			   
			   'columns' => array( 
			   	"EventoId","funcionesTexto"
			   	/*
			        array(
			            'name' => 'id',
			            'header' => '#',
			            'htmlOptions' => array('color' =>'width: 60px'),
			        ),
			        array(
			            'name' => 'firstName',
			            'header' => 'First name',
			        ),
			        array(
			            'name' => 'lastName',
			            'header' => 'Last name',
			        ),
			        array(
			            'name' => 'username',
			            'header' => 'Username',
			        ),*/
			    ),
			)); ?>

			<div class='span4 white-box box'>

				<!-- Button to trigger modal -->
				<a href="#myModal" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
				 
				<!-- Modal -->
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    <h3 id="myModalLabel">Modal header</h3>
				  </div>
				  <div class="modal-body">
				

					  <?php echo "Hasta: " ?>
					  <?php
					  $this->widget('zii.widgets.jui.CJuiDatePicker',
					    array(          
					       'name'=>'hasta',
					       'attribute'=>'fecha_revision',  
					       'language' => 'es',             
					       'htmlOptions' => array(         
					//                         'readonly'=> $this->usuario->esMesaDeControl,
					        ),
					       'options'=>array(               
					        'autoSize'=>false,              
					        'defaultDate'=>'date("Y-m-d")', 
					        'dateFormat'=>'yy-mm-dd',       
					        'selectOtherMonths'=>true,      
					        'showAnim'=>'fade',            
					        'showButtonPanel'=>false,       
					        'showOn'=>'focus',             
					        'showOtherMonths'=>true,        
					        'changeMonth' => true,          
					        'changeYear' => true,
					                        'minDate'=>'2010-01-01', //fec\ha minima
					                        //'maxDate'=>"+1Y", //fecha maxima
					                        ),
					       )
					    );
					    ?>



				  </div>
				  <div class="modal-footer">
				    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
				    <button class="btn btn-primary">Guardar Función</button>
				  </div>
				</div>



				<?php /*$this->widget('bootstrap.widgets.TbModal', array(
			    'id' => 'myModal',
			    'header' => 'Modal Heading',
			    'content' => '<p>One fine body...</p>',
			    'footer' => array(
			        TbHtml::button('Save Changes', array('data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
			        TbHtml::button('Close', array('data-dismiss' => 'modal')),
			     ),
				)); ?>
			 

				<?php echo TbHtml::button(' Click me to open modal', array(
				    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
				    'size' => TbHtml::BUTTON_SIZE_LARGE,
				    'data-toggle' => 'modal',
				    'data-target' => '#myModal',
				    'class'=>'btn-primary'
				)); */?>
			</div>
</div>