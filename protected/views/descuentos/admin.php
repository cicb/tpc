<?php
/* @var $this DescuentosController */
/* @var $model Descuentos */

$this->breadcrumbs=array(
	'Descuentoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Generar Cupones', 'url'=>array('create')),
    array('label'=>'Ayuda', 'url'=>array('Ayuda')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#descuentos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
print_r($model->descuentoslevel1s);
?>
<h1>Descuentos</h1>

<div class="span-16" >
<a id="abrir_cupon"  class="btn btn-success" style="margin-right: 10px;"><i class="icon-folder-open icon-white"></i>&nbsp;Abrir cup&oacute;n seleccinado</a>
<a id="desactivar_seleccion"  class="btn btn-success" style="margin-right: 17px;"><i class="icon-check icon-white"></i>&nbsp;Desactivar seleccionados</a>
</div>
<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button'));
 ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'descuentos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'CuponesCod',
		'DescuentosDes',
		'DescuentosPat',
		'DescuentosExis',
        array(
           
           'value'=>'$data->CuponesCod',
           'class'=>'CCheckBoxColumn',
           'selectableRows' => '2',
           'header'=>'Selecciona', 
           'visible'=>!empty($model->CuponesCod)?"1":"0",
           'htmlOptions'=>array('data'=>"algo".$model->CuponesCod,'class'=>'checkbox-column'),
           ),
         array(
            'class'=>'CLinkColumn',
            'label'=>'<i class="icon icon-eye-open"><i>',
            'url'=>array('view','id'=>$model->CuponesCod),
            'header'=>'',
            'visible'=>!empty($model->CuponesCod)?"1":"0"
         ),
         array(
            'class'=>'CLinkColumn',
            'label'=>'<i class="icon icon-pencil"><i>',
            'url'=>array('update','id'=>$model->CuponesCod),
            'header'=>'',
            'visible'=>!empty($model->CuponesCod)?"1":"0"
         ),
         array(
            'class'=>'CLinkColumn',
            'label'=>'<i class="icon icon-trash"><i>',
            'url'=>array('delete','id'=>$model->CuponesCod),
            'header'=>'',
            'visible'=>!empty($model->CuponesCod)?"1":"0",
            'linkHtmlOptions'=>array('onclick'=>'return confirm("Estas segura que quieres eliminar el cupon:'.$model->CuponesCod.'")')
         ),
		/*'DescuentosValRef',
		'DescuentosValIdRef',
		/*
		'DescuentosFecIni',
		'DescuentosFecFin',
		'DescuentosExis',
		'DescuentosUso',
		'CuponesCod',
		'DescuentoCargo',
		*/
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
)); ?>
<script>
$("#abrir_cupon").click(function(){
    var cupon = $(".grid-view table.items tr.selected td:first").html();
    console.log(cupon);
});
$("#desactivar_seleccion").click(function(){
    var data= new Array();
    $("td.checkbox-column input[type=checkbox]:checked").each(function(index){
        //$("td",this).each(function(index2){
            data[index] = this.value;
            console.log(this.value);
        //});
        
    });
    
});
</script>
<style>
.grid-view table.items tr.selected td { background: #EA635B; }
</style>