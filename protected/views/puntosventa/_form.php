<?php
/* @var $this PuntosventasController */
/* @var $model Puntosventa */
/* @var $form CActiveForm */
?>
<style>
  .form .errorMessage{
        color: red;
  }
  .form input[type=text],
  .form select{
    margin-bottom: 1px;
  }
  .form  label{
    text-align: left;
    text-indent: 10%;
    padding-left: 10%;
  }
</style>
<div class="form">
    <div class='controles' style="min-height:100%">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'puntosventa-form',
    	'enableAjaxValidation'=>false,
        /*'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
    	'clientOptions'=>array(
    		'validateOnSubmit'=>true,
            ),*/
    )); ?>
    
    	<p class="note">Los campos con <span class="required">*</span> son requeridos. </p>
    
    	<?php //echo $form->errorSummary($model); ?>
        <div class='col-2 white-box box'>
		<h3>Información básica</h3>
            
                <?php if(!$model->isNewRecord):?>
                
                	<?php echo $form->labelEx($model,'PuntosventaId',array('class'=>'span3')); ?></td>
                	
                        <?php echo $form->textField($model,'PuntosventaId',array('size'=>20,'maxlength'=>20,'readonly'=>'readonly','class'=>'span3')); ?>
            		    <?php echo $form->error($model,'PuntosventaId'); ?>
                    
                
                
                	<?php echo $form->labelEx($model,'PuntosventaIdeTra',array('class'=>'span3')); ?>
                	
                        <?php echo $form->textField($model,'PuntosventaIdeTra',array('size'=>20,'maxlength'=>20,'readonly'=>'readonly','class'=>'span3')); ?>
            		    <?php echo $form->error($model,'PuntosventaIdeTra'); ?>
                    
                
                <?php endif;?>
                
                	<label class="span3">Punto de Venta</label>
                	
                        <?php
	                           $selected_tipo_sucursal = "0";
                               if(!$model->isNewRecord){
                                    if($model->PuntosventaId >=1 AND $model->PuntosventaId<=99)
                                        $selected_tipo_sucursal ="FF";
                                    elseif($model->PuntosventaId >=103 AND $model->PuntosventaId<=299)
                                        $selected_tipo_sucursal ="T"; 
                                    elseif($model->PuntosventaId >=300 AND $model->PuntosventaId<=999)
                                        $selected_tipo_sucursal ="FL";    
                                    elseif($model->PuntosventaId >=1000)
                                        $selected_tipo_sucursal ="MOD";       
                               }
                        ?>
                        <?php echo CHtml::dropDownList('tipo_sucursal',$selected_tipo_sucursal,array('FF'=>'FARMACIA FARMATODO','T'=>'TAQUILLA','FL'=>'FARMACIA FLEMMING'/*,'MOD'=>'MODULO'*/),array('disabled'=>$model->isNewRecord?false:true,'class'=>'span3')); ?>
                    
                
                <!--
                	<?php echo $form->labelEx($model,'tipoid',array('class'=>'span3')); ?>
                	
                        <?php echo $form->dropDownList($model,'tipoid',array('1'=>'HIJO','0'=>'PADRE'),array('style'=>'display:none;','class'=>'span3')); ?>
            		    <?php echo $form->error($model,'tipoid'); ?>
                    
                -->
                
                	<?php echo $form->labelEx($model,'PuntosventaNom',array('class'=>'span3')); ?>
                	
                        <?php echo $form->textField($model,'PuntosventaNom',array('size'=>60,'maxlength'=>75,'class'=>'span3')); ?>
            		    <?php echo $form->error($model,'PuntosventaNom'); ?>
                    
                
                <!--
                	<?php echo $form->labelEx($model,'puntosventaTipoId',array('class'=>'span3')); ?>
                	
                        <?php echo $form->textField($model,'puntosventaTipoId',array('class'=>'span3')); ?>
            		    <?php echo $form->error($model,'puntosventaTipoId'); ?>
                   
                -->
                
                	<?php echo $form->labelEx($model,'PuntosventaInf',array('class'=>'span3')); ?>
                	
                        <?php echo $form->textField($model,'PuntosventaInf',array('rows'=>6, 'cols'=>50,'class'=>'span3')); ?>
            		    <?php echo $form->error($model,'PuntosventaInf'); ?>
                    
                
                
                	<?php echo $form->labelEx($model,'PuntosventaSta',array('class'=>'span3')); ?>
                	
                        <?php echo $form->dropDownList($model,'PuntosventaSta',array('ALTA'=>'ALTA','BAJA'=>'BAJA'),array('class'=>'span3')); ?>
            		    <?php echo $form->error($model,'PuntosventaSta'); ?>
                    
                
                <!--
                	<?php echo $form->labelEx($model,'PuntosventaSuperId',array('class'=>'span3')); ?>
                	
                        <?php $selected_nodo_padre = $model->isNewRecord?"0":"".number_format($model->PuntosventaSuperId,0,"","");?>
                        <?php echo $form->dropDownList($model,'PuntosventaSuperId',CHtml::listData(Puntosventa::model()->findAll(array('condition'=>"PuntosventaNom!=''",'order'=>'PuntosventaNom ASC')),'PuntosventaId','PuntosventaNom'),array('empty'=>array('0'=>'RAIZ'),'options' => array($selected_nodo_padre => array('selected'=>true)),'class'=>'span3')); ?>
            		    <?php echo $form->error($model,'PuntosventaSuperId'); ?>
                    
                -->
        </div> 
            <div class="form-actions">
            <?php echo TbHtml::link(' Regresar',array('index'),array('class'=>' btn  fa-arrow-left ')); ?>
                    <?php echo TbHtml::submitButton($model->isNewRecord ? ' Registrar' : ' Guardar',array(
            			'size'=>TbHtml::BUTTON_SIZE_LARGE,
            			'class'=>'btn btn-primary btn-check fa fa-check'
                    )); ?>
            </div>	
    
                <?php $this->endWidget(); ?>
               
    </div>
</div><!-- form -->