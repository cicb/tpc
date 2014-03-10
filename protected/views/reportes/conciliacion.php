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
		<div class='col-2'>
				<div class='col-2'>

<?php echo TbHtml::label('Archivo txt:','archivo'); ?>
		<?php echo TbHtml::fileField('archivo'); ?>
		</div>
		
<br />
<?php 
echo TbHtml::button('Conciliar',array('id'=>'btn-subir', 'class'=>'btn btn-primary','append'=>'<icon class="fa fa-check"></span>'));
$this->endWidget();
?>

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
								//fd.append('CustomField', 'This is some extra data');
								$.ajax({
										url: '".Yii::app()->createUrl('reportes/conciliar',array('fecha'=>date('Y-m-d')))."',
												type: 'POST',
												data: fd,
												processData: false,  // tell jQuery not to process the data
												contentType: false,   // tell jQuery not to set contentType
												//dataType:'json',
												success: function(data){ 
														$('#resultado').html(data);
														 }
								}).fail(function(){alert('Error!')});			  
						}	
				 }
			});

"); ?>
