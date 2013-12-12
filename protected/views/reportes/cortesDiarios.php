<div class="controles">
<h1>Ventas Call Center</h1>
<div id="cargador"  style="position:absolute; width:40px; height:40px;left:30%; top:150px; border:0px; margin-left:-40px; margin-top:-40px;" >
</div>
<div class="form">

<?php 
$form=$this->beginWidget('CActiveForm', array(
   'id'=>'usuarios-form',
   //'action'=>$this->createUrl('/asiento/main'),
   //'htmlOptions'=>array('target'=>'gridFrame'),
   'enableAjaxValidation'=>false,
   'clientOptions' => array('validateOnSubmit' => false)
));

?>
<div class='row' style="margin-left:30px">
		<div class='span4'>
	<div class="row">
        <?php
        echo CHtml::label('Puntos de Venta','pv_id', array('style'=>'width:70px; display:inline-table;'));
        $modeloPuntoVenta = Puntosventa::model()->findAll(array('condition' => "(PuntosventaId BETWEEN '103' AND '200') ",'order'=>'PuntosventaNom'));
        $list = CHtml::listData($modeloPuntoVenta,'PuntosventaId','PuntosventaNom');
        echo CHtml::dropDownList('pv_id','',$list);
        ?>
	</div>
    <div class="row">
        <?php
        echo CHtml::label('Usuarios','usuario_id', array('style'=>'width:70px; display:inline-table;'));
        $modeloUsuarios = Usuarios::model()->findAll(array('condition' => "(TipUsrId = '3')",'order'=>'	UsuariosNom'));
        $listusr = CHtml::listData($modeloUsuarios,'UsuariosId','UsuariosNom');
        echo CHtml::dropDownList('usuario_id','',$listusr);
        ?>
	</div>
	<div class="row">
       <div class=" buttons">
        <?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
    </div>
    
 </div>   
</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
table.items{
    min-width: 900px !important;
}
</style>
 
  <style>
.CANCELADO{
        background-color:#FFCECE;}
</style>
</div>
