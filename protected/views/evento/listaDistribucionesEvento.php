<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'method' => 'GET'
)); ?>
	<div class="controles">
		<div class="box3">
            <?php
			echo CHtml::label('Evento','evento_id', array('style'=>'width:70px; display:inline-table;'));
			$eventos = Evento::model()->findAll();
			$list = CHtml::listData($eventos,'EventoId','EventoNom');
			echo $form->dropDownListControlGroup($model, 'EventoNom',
				$list, array('empty' => 'Seleccione un evento', 'class'=>'chosen')); 

                ?>		</div>		
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