<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    // 'method' => 'post'
)); ?>
    <?php 
        $this->widget( 'ext.EChosen.EChosen', array(
            'target' => '.chosen',
      ));
    ?>
<?php Yii::app()->clientScript->registerScriptFile("js/holder.js"); ?>
	<div class="controles">


		<div class="box3">
        <?php echo CHtml::tag('legend',array(), 'Distribuciones'); ?>
        <?php echo $form->textFieldControlGroup($model, 'ForoMapIntNom',
            array('placeholder'=>'Nombre de la distribución','style'=>'margin:3px')); ?>            
        <?php
            $eventos = Evento::model()->findAll();
            $list = CHtml::listData($eventos,'EventoId','EventoNom');
            echo $form->dropDownListControlGroup($model, 'EventoId',
                $list, array('empty' => 'Seleccione un evento', 'class'=>'chosen')); 
                ?>
		</div>		
		<?php echo TbHtml::formActions(array(
		    TbHtml::link(' Cancelar',$this->createUrl('Evento/actualizar',array('id'=>$eid,'#'=>'funciones')), array('class'=>'btn fa fa-arrow-circle-left')),
            TbHtml::submitButton(' Buscar', array('class' => 'btn btn-primary fa fa-search')),
			TbHtml::ajaxLink(' Nueva distribución',array('Distribuciones/nueva'),
			array(
					'type'=>'post',
					'data'=>array('Funciones'=>array('EventoId'=>$eid,'FuncionesId'=>$fid)),
					'success'=>"function(resp){
							if(resp=='true'){
									window.location='".$this->createUrl('editor',array(
											'EventoId'=>$eid,
											'FuncionesId'=>$fid,
											'scenario'=>'nueva'
									))."';
									return false;
								}else{console.log('No se ha creado la nueva distribución.');}
								}"
			),		
			array(
					'id'=>'btn-nueva',
					'class' => 'btn btn-success fa fa-plus-circle pull-right')),
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
            'header'=>'Acciones',
            'type'  =>'raw',
            'value' =>'
            TbHtml::stackedPills(array(
				array("label" => "&#xf058; Asignar Distribución", 
						"url" => array("distribuciones/asignar"), "active" => true,
						"htmlOptions"=>array(
								"class"=>"fa btn-asignar",
								"style"=>"display:block",
								"data-scenario"=>"asignar",
								"data-foro"=>$data["ForoId"],
								"data-dist"=>$data["ForoMapIntId"]),
				),
				array("label" => "&#xf058; Asignar a todas las funciones",
						"url" => array("distribuciones/asignarATodas"),
						"htmlOptions"=>array(
								"class"=>"fa btn-asignar",
								"style"=>"display:block",
								"data-scenario"=>"todas",
								"data-foro"=>$data["ForoId"],
								"data-dist"=>$data["ForoMapIntId"])
				),

				array("label" => "&#xf058; Asignar como nueva distribución",
						"url" => array("distribuciones/asignarComo"),
						"htmlOptions"=>array(
								"class"=>"fa btn-asignar-como",
								"style"=>"display:block",
								"data-scenario"=>"editar",
								"data-foro"=>$data["ForoId"],
								"data-dist"=>$data["ForoMapIntId"])
				),
			));
         ', 
            ),
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
            'htmlOptions'=>array('style'=>'text-align:center;'),
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
            'header'=>'Asientos',
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

                
            ),
        array(
				'value'=>'CHtml::link(" Modificar", array("modificar"),array(
						"class"=>"btn btn-warning btn-asignar fa fa-warning",
						"data-scenario"=>"edicion",
						"data-foro"=>$data["ForoId"],
						"data-dist"=>$data["ForoMapIntId"])
				)',
                'type'=>'raw',
            ),
    	),
));
 ?>
<script type="text/javascript">
    $('.img').live('hover',function(){
        var path=$(this).attr('src');
        $(this).popover({content:"<img src='"+path+"'/>  ",html:true})
    });


</script>
<style type="text/css">
    .form-horizontal .control-group{margin:5px;}
</style>
<?php Yii::app()->clientScript->registerScript('Asignacion',"
function asignar(obj,nombre){
				var href=obj.children().attr('href');
				var params={
								ForoId:obj.data('foro'), ForoMapIntId:obj.data('dist'),
								EventoId:$eid, FuncionesId:$fid
				};
				if( nombre!= null ){ params[\"ForoMapIntNom\"]=nombre; }
			$.ajax({
                url:href,
                type:'post',
                data:params,
                 success:function(resp){
                    if (resp=='true') {
                        window.location='".$this->createUrl('distribuciones/editor',array(
                            'EventoId'=>$eid,
                            'FuncionesId'=>$fid,
                            ))."&scenario='+obj.data('scenario');
                    }
                    else{
                       alert('No se puede asignar esta distribución.');
                    }
                   }
            });
}

        $('.btn-asignar').live('click',function(){
				asignar($(this),null);
				return false;
    });
        $('.btn-asignar-como').live('click',function(){
				var nombre = prompt('Ingrese el nombre para la nueva distribución','Distribución ...');
				if(nombre != null){
						asignar($(this),nombre);
				}
		return false;
	});

    "); ?>
