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
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.less"  />


	<?php Yii::app()->bootstrap->register(); ?>
	<?//php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/custom.css",CClientScript::POS_END);?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div id="mainmenu">
<?php
$accesos = Yii::app()->user->getState("accesos");
?>    
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
								array('label' => 'Reportes', 	'url' => $this->createUrl('reportes/index'), 'active' => true,'visible'=>!Yii::app()->user->isGuest,
								'items'=>array(
										array('label' => 'Tipos de reportes', 'active'=>true),
										array('label' => 'Lugares', 				'url' =>  $this->createUrl('reportes/lugares'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Lugares vendidos', 		'url' =>  $this->createUrl('reportes/lugaresVendidos'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Cortes diarios', 			'url' =>  $this->createUrl('reportes/cortesDiarios'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Reservaciones Farmatodo', 'url' =>  $this->createUrl('reportes/reservacionesFarmatodo'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas por Web', 			'url' =>  $this->createUrl('reportes/ventasWeb'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas sin cargo',		'url' =>  $this->createUrl('reportes/ventasSinCargo'),'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin") OR Yii::app()->user->getState("TipUsrId")=="2")?true:false),
										array('label' => 'Ventas con cargo',		'url' =>  $this->createUrl('reportes/ventasConCargo'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas de Farmatodo', 	'url' =>  $this->createUrl('reportes/ventasFarmatodo'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
										array('label' => 'Ventas por Call Center', 	'url' =>  $this->createUrl('reportes/ventasCallCenter'),'visible' => !Yii::app()->user->isGuest AND (Yii::app()->user->getState("Admin"))?true:false), 
										array('label' => 'Desglose de ventas', 	'url' =>  $this->createUrl('reportes/desgloseVentas'),'visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false), 
        ),
						),
						array('label' => 'Descuentos', 	'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
						array('label' => 'Eventos', 	'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
						array('label' => 'Boletos', 	'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
						array('label' => 'Usuarios', 	'url' => '#','visible' => !Yii::app()->user->isGuest AND Yii::app()->user->getState("Admin")?true:false),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
		),
),
)); ?>

	</div><!-- mainmenu -->
<div id='wrap'>
		<div class="container-fluid" id="pagina">
		<br />
		
		<?php echo $content; ?>

		<div class="clear"></div>
<?php
//echo Yii::app()->user->name;
//echo Yii::app()->user->id;
//echo Yii::app()->user->getState("UsuariosStatus");
//echo Yii::app()->user->getState("UsuariosId");


//if(!empty($accesos) AND in_array('Eventos',$accesos) ){
   
//}
//print_r($accesos);
//print_r($accesos);
//echo Yii::app()->user->UsuariosNom;



?>
		</div><!-- page -->
		<div id='push'></div>
</div>
	<div id="footer">
		<div class='container'>
				Copyright &copy; <?php echo date('Y'); ?> por Globaloxs.<br/>
				Reservados todos los derechos.<br/>
		</div>
	</div><!-- footer -->


<?php //Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/style.less",CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/less.min.js",CClientScript::POS_HEAD); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css"  />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css"  />
</body>
</html>
