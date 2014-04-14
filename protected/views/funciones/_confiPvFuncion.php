<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'dlg-confiPvFuncion',
    'header' => 'Selecciona el rango de fechas',
    'content' => "WOW!",
    'footer' => implode(' ', array(
    	TbHtml::button('Guardar cambios', array(
    		'data-dismiss' => 'modal',
    		'color' => TbHtml::BUTTON_COLOR_PRIMARY)
    	),
    	TbHtml::button('Cerrar', array('data-dismiss' => 'modal')),
    	)),
)); ?>
