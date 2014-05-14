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
  .form table td:nth-child(odd){
    width: 50%;
    text-align: left;
    padding-left: 60px;
  }
</style>

<div class="form">
    
    
    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'puntosventa-form',
        //'action'=>Yii::app()->createUrl('evento/AgregarPuntoVentaAjax'),
    	'enableAjaxValidation'=>false,
        //'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
    	'clientOptions'=>array(
    		'validateOnSubmit'=>true,
            ),
       'focus'=>array($model,'PuntosventaNom'),
    )); ?>
    
    	<p class="note">Los campos con <span class="required">*</span> son requeridos. </p>
        <div id="errores" style="font-weight: bold;color: #FF6666;background: #FFCECE;padding: 5px; border: #FF6666 solid 1px; display: none;"></div>
    	<?php //echo $form->errorSummary($model); ?>
        <div class='col-1 white-box box'>
		<h3>Información básica</h3>
            <table  style="width: 100%;">
                <tr>
                	<td><label>Punto de Venta</label></td>
                	<td>
                        <?php echo CHtml::dropDownList('tipo_sucursal',"",array('FF'=>'FARMACIA FARMATODO','T'=>'TAQUILLA','FL'=>'FARMACIA FLEMMING'/*,'MOD'=>'MODULO'*/),array('disabled'=>$model->isNewRecord?false:true)); ?>
                    </td>
                </tr>
                <!--<tr>
                	<td><?php echo $form->labelEx($model,'tipoid'); ?></td>
                	<td>-->
                        <?php echo $form->dropDownList($model,'tipoid',array('1'=>'HIJO','0'=>'PADRE'),array('style'=>'display:none;')); ?>
            		    <?php echo $form->error($model,'tipoid'); ?>
                    <!--</td>
                </tr>-->
                <tr>
                	<td><?php echo $form->labelEx($model,'PuntosventaNom'); ?></td>
                	<td>
                        <?php echo $form->textField($model,'PuntosventaNom',array('size'=>60,'maxlength'=>75)); ?>
            		    <?php echo $form->error($model,'PuntosventaNom'); ?>
                    </td>
                </tr>
                <!--<tr>
                	<td><?php echo $form->labelEx($model,'puntosventaTipoId'); ?></td>
                	<td>
                        <?php echo $form->textField($model,'puntosventaTipoId',array()); ?>
            		    <?php echo $form->error($model,'puntosventaTipoId'); ?>
                    </td>
                </tr>-->
                <tr>
                	<td><?php echo $form->labelEx($model,'PuntosventaInf'); ?></td>
                	<td>
                        <?php echo $form->textField($model,'PuntosventaInf',array('rows'=>6, 'cols'=>50)); ?>
            		    <?php echo $form->error($model,'PuntosventaInf'); ?>
                    </td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model,'PuntosventaSta'); ?></td>
                	<td>
                        <?php echo $form->dropDownList($model,'PuntosventaSta',array('ALTA'=>'ALTA','BAJA'=>'BAJA'),array()); ?>
            		    <?php echo $form->error($model,'PuntosventaSta'); ?>
                    </td>
                </tr>
                <!--<tr>
                	<td><?php echo $form->labelEx($model,'PuntosventaSuperId'); ?></td>
                	<td>
                        <?php $selected_nodo_padre = $model->isNewRecord?"0":"".number_format($model->PuntosventaSuperId,0,"","");?>
                        <?php echo $form->dropDownList($model,'PuntosventaSuperId',CHtml::listData(Puntosventa::model()->findAll(array('condition'=>"PuntosventaNom!=''",'order'=>'PuntosventaNom ASC')),'PuntosventaId','PuntosventaNom'),array('empty'=>array('0'=>'RAIZ'),'options' => array($selected_nodo_padre => array('selected'=>true)))); ?>
            		    <?php echo $form->error($model,'PuntosventaSuperId'); ?>
                    </td>
                </tr>-->
            </table>
        </div> 
            <div class="form-actions">
                    <?php echo CHtml::ajaxSubmitButton("Registrar",Yii::app()->createUrl('evento/AgregarPuntoVentaAjax'),
                    array('success'=>
                                   "function(data){
                                    if(data=='ok'){
                                        location.reload();
                                    }else{
                                        $('#errores').show().html(data);
                                        console.log(data);
                                    }    
                                    
                                    
                                   }"
                         ),
                    array('class'=>'btn btn-primary btn-check fa fa-check')); ?>
            </div>	
    
                <?php $this->endWidget(); ?>
   
</div><!-- form -->