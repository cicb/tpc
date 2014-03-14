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
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
		<div class='box4'>


			<?php echo $form->textFieldControlGroup($model,'EventoNom',array('span'=>4,'maxlength'=>150)); ?>

			<?php echo $form->dropDownListControlGroup($model, 'EventoSta',
					array('ALTA', 'BAJA'), array('class' => 'chosen')); ?>

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


	

		</div>
		<div class='col-2'>


            <?php echo $form->textFieldControlGroup($model,'EventoDesBol',array('span'=>5,'maxlength'=>75)); ?>

            <?php echo $form->textFieldControlGroup($model,'EventoImaBol',array('span'=>5,'maxlength'=>200)); ?>

            <?php echo $form->textFieldControlGroup($model,'EventoImaMin',array('span'=>5,'maxlength'=>200)); ?>

            <?php echo $form->textFieldControlGroup($model,'EventoDesWeb',array('span'=>5,'maxlength'=>200)); ?>

            <?php echo $form->textFieldControlGroup($model,'ForoId',array('span'=>5,'maxlength'=>20)); ?>

            <?php echo $form->textFieldControlGroup($model,'PuntosventaId',array('span'=>5,'maxlength'=>20)); ?>

            <?php echo $form->textFieldControlGroup($model,'EventoSta2',array('span'=>5,'maxlength'=>20)); ?>
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
