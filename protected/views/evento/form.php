<?php
/* @var $this EventoController */
/* @var $model Evento */
/* @var $form TbActiveForm */
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
		<div class='box4 white-box'>
		<h3>Información básica</h3>

			<?php echo $form->textFieldControlGroup($model,'EventoNom',array('span'=>3,'maxlength'=>150)); ?>
		<div class='alert'>
			<?php echo $form->dropDownListControlGroup($model, 'EventoSta',
					array('ALTA', 'BAJA'), array('class' => 'chosen span2')); ?>
		</div>

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
		<div class="input-append">
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
			array('empty'=>'Sin categoria','class'=>'span3')
	) ; ?>
	<?php echo $form->error($model,'CategoriaId'); ?>
</div>

<div class='control-group'>
	<?php echo $form->labelEx($model,'CategoriaSubId',array('class'=>'control-label')); ?>
	<?php echo $form->dropDownList($model,'CategoriaSubId',
			 CHtml::listData(
					Categorialevel1::model()->findAllByAttributes(array('CategoriaId'=>$model->CategoriaId)),
					'CategoriaSubId','CategoriaSubNom'),
			array('empty'=>'Sin subcategoria','class'=>'span3')
	) ; ?>
	<?php echo $form->error($model,'CategoriaSubId'); ?>
</div>

<div class='control-group'>
	<?php echo $form->labelEx($model,'ForoId',array('class'=>'control-label')); ?>
	<?php echo $form->dropDownList($model,'ForoId',
			 CHtml::listData(
					Foro::model()->findAll(),
					'ForoId','ForoNom'),
			array('empty'=>'Sin foro','class'=>'span3')
	) ; ?>
	<?php echo $form->error($model,'ForoId'); ?>
</div>

<div class='control-group'>
	<?php echo $form->labelEx($model,'PuntosventaId',array('class'=>'control-label')); ?>
	<?php echo $form->dropDownList($model,'PuntosventaId',
			 CHtml::listData(
					Puntosventa::model()->findAll(),
					'PuntosventaId','PuntosventaNom'),
			array('empty'=>'Sin Punto de Venta','class'=>'span3')
	) ; ?>
	<?php echo $form->error($model,'PuntosventaId'); ?>
</div>


		</div>

		<div class='col-2 white-box'>

		<h3>Información adicional</h3>
            <?php echo $form->textFieldControlGroup($model,'EventoDesBol',array( 'span'=>4,'maxlength'=>75)); ?>


			<?php echo $form->fileFieldControlGroup($model,'EventoImaMin',array('append'=>TbHtml::imagePolaroid($model->EventoImaBol),
 'span'=>4,'maxlength'=>200)); ?>
			<?php echo TbHtml::imagePolaroid($model->EventoImaBol); ?>

            <?php echo $form->textFieldControlGroup($model,'EventoDesWeb',array('span'=>4,'maxlength'=>200)); ?>

            <?php echo $form->textFieldControlGroup($model,'EventoSta2',array('span'=>4,'maxlength'=>20)); ?>

		</div>
		<div class='col-3 white-box '>
		<h3>Imagen en boleto</h3>
			<?php echo TbHtml::imagePolaroid(strlen($model->EventoImaBol)>3?$model->EventoImaBol:'holder.js/239x69'); ?>
			<br /><br />
			<?php echo $form->fileField($model,'imaBol',array('span'=>2,'maxlength'=>200)); ?>

		</div>
		<div class='col-3 white-box '>
		<h3>Imagen en miniatura</h3>
			<?php echo TbHtml::imagePolaroid(strlen($model->EventoImaMin)>3?$model->EventoImaMin:'holder.js/239x69'); ?>
			<br /><br />
			<?php echo $form->fileField($model,'imaMin',array('span'=>2,'maxlength'=>200)); ?>

		</div>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'size'=>TbHtml::BUTTON_SIZE_LARGE,
        )); ?>
    </div>



    <?php $this->endWidget(); ?>

</div><!-- form -->

</div>
<?php 
				Yii::app()->clientScript->registerScriptFile("js/holder.js");
				Yii::app()->clientScript->registerScript("subir-boleto","
						var ext= ['jpg','png','bmp','jpeg'];
			 $('#Evento_imaBol').on('change',function(){
					 if ($(this).val()!='' && $(this).val()!=null) {
							 if ($.inArray($(this).val().split('.').pop(),ext)==-1) {
									 alert('El archivo no tiene extension xls, por favor seleccione otro.');
						}else{	 
								var fd = new FormData(document.getElementById('form-importacion'));
								//fd.append('CustomField', 'This is some extra data');
								$.ajax({
										url: '".Yii::app()->createUrl('/admin/subirListaMaestra')."',
												type: 'POST',
												data: fd,
												processData: false,  // tell jQuery not to process the data
												contentType: false,   // tell jQuery not to set contentType
												//dataType:'json',
												success: function(data){ 
														$('#page-wrapper').html(data);
														$('#btn-validar').addClass('btn-primary');
														$('#btn-subir').removeClass('btn-primary');
														$('#btn-importar').addClass('btn-primary');
														$('#btn-importar').attr('disabled',false);
														 }
								}).fail(function(){alert('Error!')});			  
						}	
				 }
			});
						");

?>
