<div class='controles'>
<h2>Conciliación De Ventas Farmatodo</h2>
<?php 
$form = $this->beginWidget(
		'bootstrap.widgets.TbActiveForm',
		array(
				'id' => 'upload-form',
				'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
				'enableAjaxValidation' => false,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),

		)
);
?>
		<div class='row'>
				<div class='box3 text-right'>
<div class="input-append">

<?php //echo TbHtml::label('Rango de fechas:','archivo', array('style'=>'display:inline-table;')); ?>
<?php $this->widget(
    'yiiwheels.widgets.daterangepicker.WhDateRangePicker',
    array(
        'name' => 'fechas',
		'pluginOptions'=>array('format'=>'YYYY-MM-DD'),
        'htmlOptions' => array(
				'id'=>'fechas',
            'placeholder' => 'Seleccione el rango de fechas'
        )
    )
);
?>
 <span class="add-on"><icon class="icon-calendar"></icon></span>
</div>
<br />
<br />
<?php //echo TbHtml::label('Archivo txt:','archivo', array('style'=>'display:inline-table;')); ?>
		<?php echo TbHtml::fileField('archivo'); ?>
		</div>
		
<br />
<?php 
echo TbHtml::button(' Conciliar',array('id'=>'btn-subir', 'class'=>'btn btn-primary fa fa-compress'));
$this->endWidget();
?>

		</div>
				<div id='pbar' style="display:none">
				<?php echo TbHtml::animatedProgressBar(100); ?>
				</div>
</div>
<div id='resultado'>
</div>
<?php Yii::app()->clientScript->registerScript("subir-conciliacion","
			 $('#btn-subir').on('click',function(){
					 if ($('#archivo').val()!='' && $('#archivo').val()!=null) {
							 if ($('#archivo').val().split('.').pop()!='txt') {
									 alert('El archivo no tiene extension txt, por favor seleccione otro.');
						}else{	 
								console.log('subiendo ..');
								var fd = new FormData(document.getElementById('upload-form'));
								fd.append('desde', $('#fechas').val().substr(0,10));
								fd.append('hasta', $('#fechas').val().substr(13,10));
								$.ajax({
										url: '".Yii::app()->createUrl('reportes/conciliar')."',
												type: 'POST',
												data: fd,
												processData: false,  // tell jQuery not to process the data
												contentType: false,   // tell jQuery not to set contentType
												//dataType:'json',
												beforeSend:function(){ $('#pbar').toggle(500);},
												success: function(data){ 
														$('#pbar').toggle();
														$('#resultado').html(data);
														 }
								}).fail(function(){alert('Error!')});			  
						}	
				 }
			});

"); ?>
