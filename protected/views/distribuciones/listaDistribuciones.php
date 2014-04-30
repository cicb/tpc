<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'method' => 'GET'
)); ?>
<?php Yii::app()->clientScript->registerScriptFile("js/holder.js"); ?>
	<div class="controles">
		<div class="box3">
        <?php echo CHtml::tag('legend',array(), 'Distribuciones'); ?>
        <?php echo $form->textFieldControlGroup($model, 'ForoMapIntNom',
            array('placeholder'=>'Nombre de la distribución')); ?>            <?php
            $eventos = Evento::model()->findAll();
            $list = CHtml::listData($eventos,'EventoId','EventoNom');
            echo $form->dropDownListControlGroup($model, 'EventoNom',
                $list, array('empty' => 'Seleccione un evento', 'class'=>'chosen')); 

                ?>
		</div>		
		<?php echo TbHtml::formActions(array(
		    TbHtml::resetButton('Cancelar'),
		    TbHtml::submitButton('Buscar', array('class' => 'btn btn-primary fa fa-search')),
		)); ?>
	</div>
<?php $this->endWidget(); ?>

<?php 
$url='../imagesbd/';
$data=$model->search();
// if(is_object($data))$data=$data->getData();

// foreach ($data as $i=>$fila) {
//     # Elimina los que su imagen no sea valida
//     if (strlen($fila->ForoMapPat)<3 or !file_exists($url.$fila->ForoMapPat)) {
//         unset($data[$i]);
//     }
// }
// $data=new CArrayDataProvider($data,array('keyField'=>False));
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'type'=>'striped bordered',
    'dataProvider' => $data,
    'template' => "{pager}{items}{pager}",
    'columns' => array(
    	// 'ForoId',
    	// 'ForoMapIntId',
        array(
            'header'=>'Distribución',
            'name'=> 'ForoMapIntNom',
            ),
        array(
            'header'=>'Foro',
            'name'=> 'ForoId',
            'value'=>'$data->foro->ForoNom'
            ),
    	// 'ForoMapPat',
    	array(
    		'header'=>'Mapa',
    		'type'=>'raw',
    		'value'=>'CHtml::image(file_exists("'.$url.'".$data["ForoMapPat"])?
                "'.$url.'".$data["ForoMapPat"]:"holder.js/150x150",
                $data["ForoMapPat"],
                array(
                    "data-foroid"=>$data->ForoId,
                    "data-fmiid"=>$data->ForoMapIntId,
                    "class"=>"img-polaroid", "width"=>"150px"))',
    		),
    	),
));
 ?>