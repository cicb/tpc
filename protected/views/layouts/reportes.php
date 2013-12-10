<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class='span3 left-bar'>
<?php
$this->widget('bootstrap.widgets.TbNav', array(
		'type' => TbHtml::NAV_TYPE_TABS ,
		'stacked'=>true,
		'htmlOptions'=>array('id'=>'sidebar'),
		'items' => array(
				array('label' => 'Tipos de reportes', 'active'=>true),
				array('label' => 'Lugares', 				'url' =>  $this->createUrl('reportes/lugares')),
				array('label' => 'Lugares vendidos', 		'url' =>  $this->createUrl('reportes/lugares')),
				array('label' => 'Cortes diarios', 			'url' =>  $this->createUrl('reportes/lugares')),
				array('label' => 'Reservaciones Farmatodo', 'url' =>  $this->createUrl('reportes/lugares')),
				array('label' => 'Ventas por Web', 			'url' =>  $this->createUrl('reportes/lugares')),
				array('label' => 'Ventas sin cargo',		'url' =>  $this->createUrl('reportes/ventasSinCargo')),
				array('label' => 'Ventas con cargo',		'url' =>  $this->createUrl('reportes/ventasConCargo')),
				array('label' => 'Ventas de Farmatodo', 	'url' =>  $this->createUrl('reportes/ventasFarmatodo')),
				array('label' => 'Ventas por Call Center', 	'url' =>  $this->createUrl('reportes/ventasCallCenter')), 
				array('label' => 'Desglose de ventas', 	'url' =>  $this->createUrl('reportes/ventasCallCenter')), 
				TbHtml::menuDivider(),

				array('label' => 'Reportes PHP', 'url' => '#'),
				array('label' => 'Reportes PHP', 'url' => '#'),
				array('label' => 'Reportes PHP', 'url' => '#'),
				array('label' => 'Reportes PHP', 'url' => '#'),
				array('label' => 'Reportes PHP', 'url' => '#'),
		)
));
?>
</div>
<div class="span9">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>

<?php $this->endContent(); ?>
