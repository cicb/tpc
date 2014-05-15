
<?php $eid=$model->EventoId;$fid=$model->FuncionesId; ?>
<div class=' div-funcion box' id='f-<?php echo $model->EventoId."-".$model->FuncionesId ; ?>'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'evento-form',
    'enableAjaxValidation'=>false,
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'action'=>$model->scenario=='update'?array(
			'funciones/actualizar',
			'eid'=>$model->EventoId,
			'fid'=>$model->FuncionesId):'',
)); ?>
<div class="row-fluid" style="display:block; margin-bottom:10px" >
	<?php echo TbHtml::button(' ', array(
			'data-id'=>$model->FuncionesId,
			'class'=>'btn-quitar-funcion btn btn-danger fa fa-2x fa-minus-circle pull-left',
			'title'=>'Eliminar esta función'
	)); ?>
	<?php if (isset($this->forolevel1)) {
		echo "$this->forolevel1->ForoMapPat";
	} ?>
<?php
		if (isset($model->zonas) and sizeof($model->zonas)>0) {
				echo TbHtml::link(' Modificar distribución',array(
						'distribuciones/editor',
						'EventoId'=>$model->EventoId,
						'FuncionesId'=>$model->FuncionesId,
						'scenario'=>'asignacion'),
				array('class'=>'btn btn-warning fa fa-warning pull-left')
				); 	
		}	 else  
			echo TbHtml::link(' Asignar distribucion',$this->createUrl('distribuciones/index',array(
		'eid'=>$model->EventoId,
		'fid'=>$model->FuncionesId,
		'foroid'=>$model->evento->ForoId,
		)), array(
			'data-id'=>$model->FuncionesId,
			'class'=>'btn-asignar-dist btn btn-primary fa fa-2x fa-trello pull-left',
			'title'=>'Asignar distribución.'
	)); 
?>



</div>



<div class="input-append ">
<?php
echo  CHtml::label('Inicio de ventas','Funciones[FuncionesFecIni]');
echo $form->textField($model,'FuncionesFecIni',array('class'=>'picker FecIni box2', 'data-id'=>"$fid"))
?>
</div>

<div class="input-append ">
<?php
echo  CHtml::label('Función','Funciones[FuncionesFecHor]');
echo $form->textField($model,'FuncionesFecHor',array('class'=>'picker FecHor box2','data-id'=>"$fid"))
?>
</div>

<div class="input-append ">
<?php echo  CHtml::label('Texto de la función','Funciones[funcionesTexto]'); ?>
<?php echo $form->textField($model, 'funcionesTexto' , array(
	'class'=>'FuncText box3', 'placeholder'=>'Texto de la función',
	'style'=>'width:265px',
'data-id'=>"$fid",'id'=>"FuncText-$fid"));?>
</div>

<div class="box4">
<?php $this->renderPartial('/funciones/_arbolCPVF',compact('model')); ?>
	</div>
 </div>

	<?php $this->endWidget(); ?>


