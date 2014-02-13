<style type='text/css'>
#wrap{
background: #ebebeb;
background-image: url('http://globaloxs.net/taquilla/control/images/sos.png');}
</style>
<div class='controles'>
<h2>Historial de compras</h2>
<div class='col-4 centrado'>
<?php
$this->widget(
    'yiiwheels.widgets.detail.WhDetailView',
    array(
        'data' => array(
            'id' => 1,
            'nombre' => $model->nombreCompleto,
            'email' => $model->email,
            'nick' => $model->username,
        ),
        'attributes' => array(
				array('name' => 'nick', 'label' => 'Usuario'),
				array('name' => 'nombre', 'label' => 'Nombre'),
				array('name' => 'email', 'label' => 'E-mail'),
		),
    ));
?>
</div>
</div>

