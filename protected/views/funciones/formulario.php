
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
	'class'=>'FuncText box3', 'placeholder'=>'funcionesTexto',
'data-id'=>"$fid",'id'=>"FuncText-$fid"));?>
</div>

<div class="box3">
	<?php 
		#Impresion de arbol en primer nivel
	// $root=1000;//Id del nodo raiz
	$root=Confipvfuncion::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId, 
		'PuntosventaId'=> 1000//Id del punto de venta  raiz
		));
	$taquilla=Confipvfuncion::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId, 
		'PuntosventaId'=> $model->evento->PuntosventaId, //Id de la taquilla del evento
		));
		echo CHtml::openTag('ul',array('id'=>"rama-$fid", 'class'=>"arbol "));
				/****
				***Caso especial Taquilla propia
				*/
				$this->renderPartial('/funciones/_nodoCPVF',array('model'=>$taquilla));
/*			
		Caso Modulos
*/
			if (is_object($root)) {
				# Si el id de la raiz es correcto
				$this->renderPartial('/funciones/_nodoCPVF',array('model'=>$root));
			}
				// $link="";
				// $chk=TbHtml::checkBox("chk-$fid-$root");
				// $link=TbHtml::link(' ',array('puntosVenta/verRama','id'=>$root,'fid'=>$fid),
				// 	array('class'=>'nodo-toggle fa fa-plus-square','id'=>"link-$fid-$root", 'data-estado'=>'inicial')
				// 	);
				// echo CHtml::tag('li',array('id'=>"$fid-$root", 'class'=>'nodo'),
				// 	$link.' '.$chk.' '.TbHtml::label(" Modulos","chk-$fid-$root",array('style'=>'display:inline')));
		echo CHtml::closeTag('ul');

	 ?>

	</div>
 </div>

	<?php $this->endWidget(); ?>


