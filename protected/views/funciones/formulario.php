
<?php $eid=$model->EventoId;$fid=$model->FuncionesId; ?>
<div class=' div-funcion' id='f-<?php echo $model->EventoId."-".$model->FuncionesId ; ?>'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'evento-form',
    'enableAjaxValidation'=>false,
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'action'=>$model->scenario=='update'?array(
			'funciones/actualizar',
			'eid'=>$model->EventoId,
			'fid'=>$model->FuncionesId):'',
)); ?>


<div class="input-append ">
<?php echo $form->label($model,'FuncionesFecHor:'); ?>
<?php
echo $form->textField($model,'FuncionesFecHor',array('class'=>'picker FecHor','data-id'=>"$fid"))
?>
</div>

<div class="input-append ">
<?php echo $form->label($model,'funcionesTexto:'); ?>
<?php echo $form->textField($model, 'funcionesTexto' , array('class'=>'FuncText', 'placeholder'=>'funcionesTexto', 'style'=>'width:320px','id'=>"FuncText-$fid"));?>
</div>

<div class="col-2">
	<?php 
		#Impresion de arbol en primer nivel
		echo CHtml::openTag('ul',array('class'=>"arbol rama-$fid-0"));
				$link="";
				$chk=TbHtml::checkBox("chk-$fid-0");
				$link=TbHtml::link(' ',array('puntosVenta/verRama','id'=>0,'prefix'=>$fid),
					array('class'=>'nodo-toggle fa fa-plus-square','id'=>"link-$fid-0", 'data-estado'=>'inicial')
					);
				echo CHtml::tag('li',array('id'=>"$fid-0", 'class'=>'nodo'),
					$link.' '.$chk.' '.TbHtml::label(" Modulos","chk-$fid-0",array('style'=>'display:inline')));
		echo CHtml::closeTag('ul');

	 ?>

	</div>
 </div>

</div>
	<?php $this->endWidget(); ?>


