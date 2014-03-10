<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/font-awesome.min.css"); ?>
	<?php Yii::app()->bootstrap->register(); ?>
	<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/style.css"); ?>
<!--	<link rel="stylesheet/less" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/style.less"  />-->
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
								//Estos son los elementos del menu que dirigen hacia modulos especificos del panel de control
								 //!!! Si se desea cambiar el nombre de un reporte o de cualquier otro modulo en particular 
								 //es necesario que se cambie tambien en el encabezado de la vista asi también es recomendado
								 //que se cambie el nombre de la cccion del controller para que la direccion URL sea semanticamente correcta
							array('label' => 'Reportes',
								'url' => $this->createUrl('reportes/index'),
								'active' => Yii::app()->controller->id=='reportes',
								'visible'=>!Yii::app()->user->isGuest,
								'items'=>array(
										array('label' => 'Accesos',
												'url' =>  $this->createUrl('reportes/accesos'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array(
												'label' => 'Buscar Boleto Y Referencias',
												'url' =>  $this->createUrl('reportes/buscarBoleto'),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
										array('label' => 'Cancelar Venta Farmatodo',
												'url' =>  $this->createUrl('reportes/cancelarVentaFarmatodo'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Desglose De Ventas', 
												'url' =>  $this->createUrl('reportes/desgloseVentas'),'visible'
												=> !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Historial De Cancelaciones Y Reimpresiones',
												'url' =>  $this->createUrl('reportes/cancelacionesReimpresiones'),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
										array('label' => 'Lugares',
												'url' =>  $this->createUrl('reportes/lugares'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Lugares Vendidos',
												'url' =>  $this->createUrl('reportes/lugaresVendidos'),
												'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
												//array('label' => 'Cortes diarios', 			'url' =>  $this->createUrl('reportes/cortesDiarios'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),

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

										array('label' => 'Conciliación Farmatodo',
												'url' =>  $this->createUrl('reportes/conciliacionFarmatodo'),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false),
								),
						),

								array(
										'label' => 'Cupones Y Descuentos', 
										//'url' => $this->createUrl('descuentoslevel1/admin',array('tipo'=>'descuento','query'=>'')),
										'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false,
										'active' => in_array(Yii::app()->controller->id,array('descuentos','descuentoslevel1')),
										'items'=>array(
												array('label' => 'Lista De Descuentos',
												'url' => $this->createUrl('descuentoslevel1/admin',array('tipo'=>'descuento','query'=>'')),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
												array('label' => 'Lista De Cupones',
												'url' => $this->createUrl('descuentoslevel1/admin',array('tipo'=>'cupon','query'=>'')),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
												array('label' => 'Crear Cupón/Descuento',
												'url' => $this->createUrl('descuentos/create'),
												'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
										)
										),
								array('label' => 'Eventos', 
								'items'=>array(
										array('label'=>'Configurador de accesos', 'url'=>$this->createUrl('evento/index')),
								),
								'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
								array('label'=>'Usuarios','items'=>array(
										array('label' => 'Usuarios del Sistema',
										'url' => $this->createUrl('usuarios/index'),
										'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Usuarios Web',
										'url' => $this->createUrl('usuarios/usuariosWeb'),
										'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),

								)
								),
										array('label' => 'Boletos', 	'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
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


<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/less.min.js",CClientScript::POS_HEAD); ?>
<?php //Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/style.less",CClientScript::POS_END); ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css"  />
<?php 
		if(Yii::app()->mobileDetect->isMobile())
				Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/mobile.css",CClientScript::POS_BEGIN);
 ?>
</body>
</html>
