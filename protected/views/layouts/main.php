<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.less"  />
	<?php Yii::app()->bootstrap->register(); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
	<div id="mainmenu">
		<?php
		$accesos = Yii::app()->user->getState("accesos");
		?>   
<?php 
$this->widget('bootstrap.widgets.TbNavbar',array(
		'color'=> 'taquilla',
		'fluid'=>true,
		'brandLabel'=>  "<i class=\"fa fa-th-large\"></i> ".CHtml::encode(Yii::app()->name),
		'collapse'=>true,
		'display'=>TbHtml::NAVBAR_DISPLAY_FIXEDTOP,
		'items' => array(
				array(
						'class' => 'bootstrap.widgets.TbNav',
						'items' => array(
							array('label' => 'Reportes',
								'url' => $this->createUrl('reportes/index'),
								'active' => true,'visible'=>!Yii::app()->user->isGuest,
								'items'=>array(
										array('label' => 'Accesos',
												'url' =>  $this->createUrl('reportes/accesos'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Desglose De Ventas', 
												'url' =>  $this->createUrl('reportes/desgloseVentas'),'visible'
												=> !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Lugares',
												'url' =>  $this->createUrl('reportes/lugares'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Lugares Vendidos',
												'url' =>  $this->createUrl('reportes/lugaresVendidos'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
												//array('label' => 'Cortes diarios', 			'url' =>  $this->createUrl('reportes/cortesDiarios'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ref/Num. Boleto',
												'url' =>  $this->createUrl('reportes/ventasPorRef'),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
										array('label' => 'Ventas y cancelaciones',
												'url' =>  $this->createUrl('reportes/ventasCancelaciones'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas Web Y CallCenter', 
												'url' =>  $this->createUrl('reportes/ventasWeb'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas Con Cargo',
												'url' =>  $this->createUrl('reportes/ventasConCargo'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas Sin Cargo',
												'url' =>  $this->createUrl('reportes/ventasSinCargo'),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin") OR Yii::app()->user->getState("TipUsrId")=="2")?true:false),
										array('label' => 'Ventas De Farmatodo',
												'url' =>  $this->createUrl('reportes/ventasFarmatodo'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas Diarias',
												'url' =>  $this->createUrl('reportes/ventasDiarias'),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
										),
								),
								array('label' => 'Descuentos', 	'url' => $this->createUrl('descuentoslevel1/admin',array('tipo'=>'descuento','query'=>'')),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
								array('label' => 'Eventos', 
								'items'=>array(
										array('label'=>'Configurador de accesos', 'url'=>$this->createUrl('accesos/index')),
								),
								'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
								array('label' => 'Boletos', 	'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
								array('label' => 'Usuarios', 	'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
						),
				),
				array(
						'class' => 'bootstrap.widgets.TbNav',
						'type'=>'right',
						'htmlOptions'=>array('class'=>'pull-right'),
						'items' => array(
								array('label'=>'Iniciar Sesión', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
						)
				),	
		),
)); 
?>

</div><!-- mainmenu -->
<div id='wrap'>
	<div class="container-fluid " id="pagina">	
		<?php echo $content; ?>
		<div class="clear"></div>
	</div><!-- page -->
	<div id='push'></div>
</div>
<div id="footer">
	<div class='container'>
		Copyright &copy; <?php echo date('Y'); ?> por Taquilla Cero.<br/>
		Reservados todos los derechos.<br/>
	</div>
</div><!-- footer -->


<?php //Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/style.less",CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/less.min.js",CClientScript::POS_HEAD); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css"  />
<?php 
		if(Yii::app()->mobileDetect->isMobile())
				Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/mobile.css",CClientScript::POS_BEGIN);
 ?>
</body>
</html>
