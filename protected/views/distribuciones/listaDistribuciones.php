<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    // 'method' => 'post'
)); ?>
<?php Yii::app()->clientScript->registerScriptFile("js/holder.js"); ?>
	<div class="controles">
		<div class="box3">
        <?php echo CHtml::tag('legend',array(), 'Distribuciones'); ?>
        <?php echo $form->textFieldControlGroup($model, 'ForoMapIntNom',
            array('placeholder'=>'Nombre de la distribución')); ?>            <?php
            $eventos = Evento::model()->findAll();
            $list = CHtml::listData($eventos,'EventoId','EventoNom');
            echo $form->dropDownListControlGroup($model, 'EventoId',
                $list, array('empty' => 'Seleccione un evento', 'class'=>'chosen')); 

                ?>
		</div>		
		<?php echo TbHtml::formActions(array(
		    TbHtml::resetButton('Cancelar'),
            TbHtml::submitButton('Buscar', array('class' => 'btn btn-primary fa fa-search')),
		    TbHtml::submitButton('Nueva distribución', array('class' => 'btn btn-success fa fa-plus-circle pull-right')),
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
    'ajaxUpdate'=>true,
    'ajaxType'=>'post',
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
                    "class"=>"img", "style"=>"width:150px"))',
    		),
        array(
               'header'=>'Ultimos Eventos',
               'type'=>'html',
               'value'=>'CHtml::tag("div",array("style"=>"font-size:9px;width:200px"), $data->listaEventos)'         
            ),
        array(
            'header'=>'Numero de Asientos',
            'type'=>'raw',
            'value' =>'number_format($data->asientos)',
            'htmlOptions'=>array('style'=>'text-align:center')
            ),
        array(
                'header'=> 'Configuración',
                'type'=>'html',
                'value' => '$data->getTablaZonas(array(
                    "class"=>"table-bordered",
                    "style"=>"width:100%;font-size:9px!important"
                    ))',

                
            )
    	),
));
 ?>
<script type="text/javascript">
    $('.img').live('hover',function(){
        var path=$(this).attr('src');
        $(this).popover({content:"<img src='"+path+"'/>",html:true})
    })
</script>

