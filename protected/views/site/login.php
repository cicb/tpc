<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<style type="text/css">
	.row{margin: 3px}
</style>
<div class="row-fluid">
	<div class="span6" style="margin:15px">
		<?php echo CHtml::image('images/t0-logo.jpg'); ?>
	</div>
<div class="span4" style="margin:auto;float:right">
	
<h1>Login</h1>

<p>Por favor llene el formulario con sus datos de usuario:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son
requeridos.</p>
	<p class="note">Lo campos con <span class="required">*</span> son
requeridos.</p>


	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>

</div>
