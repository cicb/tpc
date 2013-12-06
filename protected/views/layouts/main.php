<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->


	<?php Yii::app()->bootstrap->register(); ?>
	<?//php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl+"/css/custom.css",CClientScript::POS_END);?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div id="mainmenu">
<?php $this->widget('bootstrap.widgets.TbNavbar',array(
		'color'=> 'taquilla',
		'fluid'=>true,
		'brandLabel'=>  CHtml::encode(Yii::app()->name),
		'collapse'=>true,
		'display'=>TbHtml::NAVBAR_DISPLAY_FIXEDTOP,
		'items' => array(
				array(
						'class' => 'bootstrap.widgets.TbNav',
						'items' => array(
								array('label' => 'Reportes', 	'url' => '#', 'active' => true),
								array('label' => 'Descuentos', 	'url' => '#'),
								array('label' => 'Eventos', 	'url' => '#'),
								array('label' => 'Boletos', 	'url' => '#'),
								array('label' => 'Usuarios', 	'url' => '#'),
						),
				),
		),
)); ?>

	</div><!-- mainmenu -->
<div class="container-fuid" id="page">
		
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<br />
	<br />
	<br />
<div class='span3'>
<?php $this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_TABS,
    'stacked' => true,
	'items'=>array(
	        array('label' => 'Reporte de ventas', 'url' => '#'),
	        array('label' => 'Ventas por internet', 'url' => '#'),
	), 
)); ?>
</div>
<div class='span8'>
	<?php echo $content; ?>

</div>


	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> por Globaloxs.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css"  />
</body>
</html>
