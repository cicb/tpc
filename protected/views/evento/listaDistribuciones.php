<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'method' => 'GET'
)); ?>
	<div class="controles">
		<div class="box3">
			<?php echo $form->textFieldControlGroup($model, 'ForoMapIntNom'); ?>
		</div>		
		<?php echo TbHtml::formActions(array(
		    TbHtml::resetButton('Cancelar'),
		    TbHtml::submitButton('Buscar', array('class' => 'btn btn-primary fa fa-search')),
		)); ?>
	</div>
<?php $this->endWidget(); ?>

<?php 
$url='../movil/imagesbd';
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'type'=>'striped bordered',
    'dataProvider' => $model->search(),
    'template' => "{pager}{items}{pager}",
    'columns' => array(
    	'ForoId',
    	'ForoMapIntId',
    	'ForoMapIntNom',
    	'ForoMapPat',
    	array(
    		'header'=>'Mapa',
    		'type'=>'raw',
    		'value'=>'CHtml::image("'.$url.'/".$data->ForoMapPat)',
    		),
    	),
));
 ?>