
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
echo $form->textField($model,'FuncionesFecIni',array('class'=>'picker FecIni box2', 'data-id'=>"$fid"))
?>
</div>

<div class="input-append ">
<?php echo $form->label($model,'FuncionesFecHor:'); ?>
<?php
echo $form->textField($model,'FuncionesFecHor',array('class'=>'picker FecHor box2','data-id'=>"$fid"))
?>
</div>

<div class="input-append ">
<?php echo $form->label($model,'funcionesTexto:'); ?>
<?php echo $form->textField($model, 'funcionesTexto' , array(
	'class'=>'FuncText', 'placeholder'=>'funcionesTexto', 'style'=>'width:320px',
'data-id'=>"$fid",'id'=>"FuncText-$fid"));?>
</div>

<div class="box4">
	<?php 
		#Impresion de arbol en primer nivel
	$root=1000;//Id del nodo raiz
		echo CHtml::openTag('ul',array('id'=>"rama-$fid-0", 'class'=>"arbol "));
				/**** ***Caso especial Taquilla propia*** ****/
				// $this->renderPartial('/funciones/_nodoCPVF',compact('fid','pid','model'));

				$link="";
				$chk=TbHtml::checkBox("chk-$fid-$root");
				$link=TbHtml::link(' ',array('puntosVenta/verRama','pid'=>$root,'fid'=>$fid),
					array('class'=>'nodo-toggle fa fa-plus-square','id'=>"link-$fid-$root", 'data-estado'=>'inicial')
					);
				echo CHtml::tag('li',array('id'=>"$fid-$root", 'class'=>'nodo'),
					$link.' '.$chk.' '.TbHtml::label(" Modulos","chk-$fid-$root",array('style'=>'display:inline')));
		echo CHtml::closeTag('ul');

	 ?>

	</div>
 </div>

	<?php $this->endWidget(); ?>


