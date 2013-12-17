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
				array('label' => 'Lugares', 				'url' =>  $this->createUrl('reportes/lugares'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Lugares vendidos', 		'url' =>  $this->createUrl('reportes/lugaresVendidos'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Cortes diarios', 			'url' =>  $this->createUrl('reportes/cortesDiarios'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Reservaciones Farmatodo', 'url' =>  $this->createUrl('reportes/reservacionesFarmatodo'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Ventas por Web', 			'url' =>  $this->createUrl('reportes/ventasWeb'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Ventas sin cargo',		'url' =>  $this->createUrl('reportes/ventasSinCargo'),'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin") OR Yii::app()->user->getState("TipUsrId")=="2")?true:false),
				array('label' => 'Ventas con cargo',		'url' =>  $this->createUrl('reportes/ventasConCargo'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Ventas de Farmatodo', 	'url' =>  $this->createUrl('reportes/ventasFarmatodo'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Ventas por Call Center', 	'url' =>  $this->createUrl('reportes/ventasCallCenter'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false), 
				array('label' => 'Desglose de ventas', 	'url' =>  $this->createUrl('reportes/desgloseVentas'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false), 
				TbHtml::menuDivider(),

				array('label' => 'Reportes PHP', 'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Reportes PHP', 'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Reportes PHP', 'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Reportes PHP', 'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
				array('label' => 'Reportes PHP', 'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
		)
));
?>
</div>
<div class="span10 area">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>

<?php $this->endContent(); ?>
