
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
	<div class="accordion" id="<?php echo "acc-modulos-".$fid; ?>">
	  <div class="accordion-group">
	    <div class="accordion-heading">
			<table border="0"> <tr><th>
			<?php echo TbHtml::link(' ',"",array(
							'class'=>'fa fa-times', 'onclick'=>"desactivar($fid)"));
			?>
			</th><th>
			<?php
			echo TbHtml::link('Modulos',"#coll1-$fid",array(
					'class'=>'accordion-toggle', 'data-toggle'=>'collapse', 'data-parent'=>"acc-modulos-$fid")); 
			?>
			</th>
			<th>
				<?php echo TbHtml::textField('FecHor',$model->FuncionesFecHor,array('class'=>'picker')); ?>
			</th>

		  </tr> </table>
	    </div>
	    <div id="<?php echo "coll1-".$fid; ?>" class="accordion-body collapse ">
	      <div class="accordion-inner">
			  <div class="accordion-group">
			    <div class="accordion-heading">
						<table border="0"> <tr><th>
						<?php echo TbHtml::link(' ',"",array( 'class'=>'fa fa-times', 'onclick'=>"desactivar($fid)")); ?>
						</th><th>
						<?php echo TbHtml::link('Farmatodo',"#coll2-$fid",array(
								'class'=>'accordion-toggle', 'data-toggle'=>'collapse', 'data-parent'=>"acc-modulos-$fid")); ?>
						</th> <th>
								<?php echo TbHtml::textField('FecHor',$model->FuncionesFecHor,array('class'=>'picker')); ?>
						</th> </tr> </table>
			    </div>
			    <div id="<?php echo "coll2-".$fid; ?>" class="accordion-body collapse">
			      <div class="accordion-inner">
			        Anim pariatur cliche...
			      </div>
			    </div>
			  </div>
	      </div>
	    </div>
	  </div>

	</div>
 </div>

</div>
	<?php $this->endWidget(); ?>
