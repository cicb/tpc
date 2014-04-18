
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
<?php echo $form->label($model,'FuncionesFecIni:'); ?>
<?php
echo $form->textField($model,'FuncionesFecIni',array('class'=>'picker FecIni', 'data-id'=>"$fid"))
?>
</div>

<div class="input-append ">
<?php echo $form->label($model,'FuncionesFecHor:'); ?>
<?php
echo $form->textField($model,'FuncionesFecHor',array('class'=>'picker FecHor','data-id'=>"$fid"))
?>
</div>

<div class="input-append ">
<?php echo $form->label($model,'funcionesTexto:'); ?>
<?php echo $form->textField($model, 'funcionesTexto' , array('class'=>'FuncText', 'placeholder'=>'funcionesTexto', 'style'=>'width:320px',
'data-id'=>"$fid",'id'=>"FuncText-$fid"));?>
</div>

<div class="col-2">
	<?php 
		#Impresion de arbol en primer nivel
	$root=1000;//Id del nodo raiz
		echo CHtml::openTag('ul',array('class'=>"arbol rama-$fid-$root"));
				$link="";
				$chk=TbHtml::checkBox("chk-$fid-$root");
				$link=TbHtml::link(' ',array('puntosVenta/verRama','id'=>$root,'prefix'=>$fid),
					array('class'=>'nodo-toggle fa fa-plus-square','id'=>"link-$fid-$root", 'data-estado'=>'inicial')
					);
				echo CHtml::tag('li',array('id'=>"$fid-$root", 'class'=>'nodo'),
					$link.' '.$chk.' '.TbHtml::label(" Modulos","chk-$fid-$root",array('style'=>'display:inline')));
		echo CHtml::closeTag('ul');

	 ?>

	</div>
 </div>

	<?php $this->endWidget(); ?>


