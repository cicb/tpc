<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- blueprint CSS framework -->
<!--	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />-->
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
								array('label' => 'Reportes', 	'url' => $this->createUrl('reportes/index'), 'active' => true),
								array('label' => 'Descuentos', 	'url' => '#'),
								array('label' => 'Eventos', 	'url' => '#'),
								array('label' => 'Boletos', 	'url' => '#'),
								array('label' => 'Usuarios', 	'url' => '#'),
						),
				),
		),
)); ?>

	</div><!-- mainmenu -->
<div id='wrap'>
		<div class="container-fluid" id="pagina">
		<br />
		<br />
		<?php echo $content; ?>

		<div class="clear"></div>

		</div><!-- page -->
		<div id='push'></div>
</div>
	<div id="footer">
		<div class='container'>
				Copyright &copy; <?php echo date('Y'); ?> por Globaloxs.<br/>
				Reservados todos los derechos.<br/>
		</div>
	</div><!-- footer -->


<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/style.css",CClientScript::POS_END); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css"  />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"  />
</body>
</html>
