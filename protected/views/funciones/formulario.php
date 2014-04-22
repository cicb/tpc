
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
	'style'=>'width:265px',
'data-id'=>"$fid",'id'=>"FuncText-$fid"));?>
</div>

<div class="box4">
	<?php 
		#Impresion de arbol en primer nivel
	// $root=1000;//Id del nodo raiz
	$root=Confipvfuncion::model()->with('puntoventa')->findByPk(array(
		'EventoId'=>$model->EventoId,
		'FuncionesId'=>$model->FuncionesId, 
		'PuntosventaId'=> 00//Id del punto de venta  raiz
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
				if (is_object($taquilla)) {
					# Si es valido el id de taquilla del evento
					$this->renderPartial('/funciones/_nodoCPVF',array('model'=>$taquilla));
				}
/*			
		Caso Modulos
*/
			if (is_object($root)) {
				# Si el id de la raiz es correcto
				$this->renderPartial('/funciones/_nodoCPVF',array('model'=>$root));
			}
		echo CHtml::closeTag('ul');

	 ?>

	</div>
 </div>

	<?php $this->endWidget(); ?>


