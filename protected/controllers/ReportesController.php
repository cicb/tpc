<?php

class ReportesController extends Controller
{
	//public	$layout="reportes";
	public function actionCortesDiarios()
	{

		$this->render('cortesDiarios');
	}
	public function perfil(){
		if(Yii::app()->user->isGuest OR !Yii::app()->user->getState("Admin")){
			$this->redirect(array("site/logout"));
		}
	}
	public function actionDesgloseVentas()
	{
		$this->perfil();

		$model=new Ventas;
		$flex = new ReportesFlex;

		if(!empty($_POST)){
			$eventoId = $_POST['evento_id'];
			$funcionesId = empty($_POST['funcio_id'])?"TODAS":$_POST['funcio_id'];
			$data = $flex->getDesglose($eventoId,$funcionesId);

			$this->render('desgloseVentas',array('model'=>$model,'data'=>$data));
		}else{
			$this->render('desgloseVentas',array('model'=>$model,'data'=>null));
		}

	}
	public function actionVentasCallCenter()
	{
		$this->perfil();
		$model=new Ventas;
		$flex = new ReportesFlex;
		//if (isset($_GET['grid_mode'],$_GET['evento'],$_GET['funcion']) and $_GET['grid_mode']=='export'){
		if (isset($_POST['grid_mode']) and $_POST['grid_mode']=='export')	{
			$funcion=isset($_POST['funcion_id'])?$_POST['funcion_id']:$_POST['funcion'];
			$this->widget('application.extensions.EExcelView', array(
				'dataProvider'=> $flex->getCallCenter($_POST['evento_id'],$funcion),
				'grid_mode'=>'export',
				'columns'=>array(    
					array(            // display 'create_time' using an expression
						'header'=>'Fecha',
						'value'=>'$data["VentasFecHor"]',
					),
					array(            // display 'create_time' using an expression
						'header'=>'Funcion',
						'value'=>'$data["funcionesTexto"]',
					),
					array(            // display 'create_time' using an expression
						'header'=>'Zona',
						'value'=>'$data["ZonasAli"]',
					),
					array(            // display 'create_time' using an expression
						'header'=>'Fila',
						'value'=>'$data["FilasAli"]',
					),
					array(            // display 'create_time' using an expression
						'header'=>'Asiento',
						'value'=>'$data["LugaresLug"]',
					),
					array(            // display 'create_time' using an expression
						'header'=>'Referencia',
						'value'=>'$data["VentasNumRef"]',
					),
					array(            // display 'create_time' using an expression
						'header'=>'Impresiones',
						'value'=>'$data["vecesImpreso"]',
					)

				)
			));
			Yii::app()->end();   
		}
		if(!empty($_POST)){
			$eventoId = $_POST['evento_id'];
			$funcionesId = empty($_POST['funcion_id'])?"TODAS":$_POST['funcion_id'];
			$this->render('ventasCallCenter',array('model'=>$flex,'eventoId'=>$eventoId,'funcionesId'=>$funcionesId));
		}else{
			$this->render('ventasCallCenter',array('model'=>$flex));
		}

	}

	public function actionIndex()
	{
		//$this->perfil();
		if (Yii::app()->user->getState("TipUsrId")=="2") {
				$this->actionVentasSinCargo();
		}
		else{
				$widgets=array();
				$model=new ReportesVentas;
				$desde=date('Y-m-d',strtotime("-30 days"));
				$hasta=date('Y-m-d');
				$funciones=Funciones::model()->with(array('evento'=>array('condition'=>"EventoSta='ALTA'")))->findAll(array('limit'=>3,'condition'=>'FuncionesFecHor>NOW()','order'=>'FuncionesFecHor','group'=>'t.EventoId','select'=>'t.EventoId'));
				//var_dump($eventos);
				//$eventos=Evento::model()->with('funciones')->findAll(array('limit'=>3,'condition'=>'FuncionesFecHor>NOW()'));
				foreach ($funciones as $funcion) {
					$widgets[]=$this->renderPartial('_resumenVentas',array('model'=>$model,'evento'=>$funcion->evento,'funcionesId'=>"TODAS",'desde'=>$desde,'hasta'=>$hasta),true,true);
				}
				$this->render('index',array('model'=>$model,'widgets'=>$widgets,'desde'=>$desde,'hasta'=>$hasta));
		}	
	}

	public function actionLugares()
	{
		$this->perfil();
		$model=new Lugares;
		$data=null;
		if(isset($_POST['Lugares']))
		{
			$evento = $_POST['evento_id'];
			$funcion = $_POST['funcion_id'];
			$zona = $_POST['zona_id'];
			$fila = $_POST['Lugares']['filas'];
			$asiento = $_POST['Lugares']['lugares'];

			$data = new CActiveDataProvider('Lugares', 
				array('criteria'=>array(
					'select'   =>" 
					templugares.TempLugaresFecHor,
					lugares.LugaresStatus,
					zonas.ZonasAli,
					filas.FilasAli,
					lugares.LugaresLug,
					templugares.DescuentosId,
					descuentos.DescuentosDes,
					templugares.UsuariosId,
					lugares.EventoId,
					lugares.FuncionesId,
					lugares.ZonasId,
					lugares.SubzonaId,
					lugares.FilasId,
					lugares.LugaresId,
					if(templugares.TempLugaresTipUsr = 'usuarios',(SELECT usuarios.UsuariosNom FROM usuarios WHERE UsuariosId = templugares.UsuariosId), if((SELECT clientes.ClientesNom FROM logonline INNER JOIN templugares temp ON temp.TempLugaresClaVis = logonline.IdClaveVisita INNER JOIN clientes ON clientes.ClientesId = logonline.idUsuario where temp.EventoId = templugares.EventoId and temp.FuncionesId = templugares.FuncionesId AND temp.ZonasId = templugares.ZonasId and temp.SubzonaId = templugares.SubzonaId AND temp.FilasId = templugares.FilasId and temp.LugaresId = templugares.LugaresId and templugares.TempLugaresClaVis = temp.TempLugaresClaVis) is null, 'no logeado',(SELECT clientes.ClientesNom FROM logonline INNER JOIN templugares temp ON temp.TempLugaresClaVis = logonline.IdClaveVisita INNER JOIN clientes ON clientes.ClientesId = logonline.idUsuario where temp.EventoId = templugares.EventoId and temp.FuncionesId = templugares.FuncionesId AND temp.ZonasId = templugares.ZonasId and temp.SubzonaId = templugares.SubzonaId AND temp.FilasId = templugares.FilasId and temp.LugaresId = templugares.LugaresId and templugares.TempLugaresClaVis = temp.TempLugaresClaVis))) AS quienvende
						", 
						'alias'=>'lugares',
						'join'=>"LEFT OUTER JOIN templugares ON (lugares.EventoId = templugares.EventoId)
						AND (templugares.FuncionesId = lugares.FuncionesId)
						AND (lugares.ZonasId = templugares.ZonasId)
						AND (templugares.SubzonaId = lugares.SubzonaId)
						AND (lugares.FilasId = templugares.FilasId)
						AND (templugares.LugaresId = lugares.LugaresId)
						LEFT OUTER JOIN descuentos ON (descuentos.DescuentosId = templugares.DescuentosId)
						LEFT OUTER JOIN filas ON (filas.EventoId = lugares.EventoId)
						AND (filas.ZonasId = lugares.ZonasId)
						AND (filas.SubzonaId = lugares.SubzonaId)
						AND (filas.FuncionesId = lugares.FuncionesId)
						AND (filas.FilasId = lugares.FilasId)
						LEFT OUTER JOIN zonas ON (zonas.EventoId = filas.EventoId)
						AND (zonas.FuncionesId = filas.FuncionesId)
						AND (zonas.ZonasId = filas.ZonasId)
						",
						'condition'=>"
						lugares.EventoId = '$evento' AND lugares.ZonasId = '$zona' AND filas.FilasAli LIKE '%$fila%' AND lugares.LugaresLug LIKE '%$asiento%' AND lugares.LugaresStatus != 'OFF'",
						//'order'=>'lugares.FilasId, lugares.LugaresLug, ventas.VentasFecHor',
						'limit'=>'150'),
				'pagination'=>false));    
		}
		else{
			$evento = '******';

		}
		$this->render('lugares',array('model'=>$model, 'dataProvider'=>$data));



		//$this->render('lugares');
	}

	public function actionLugaresVendidos()
	{
		$this->perfil();
		$model=new Lugares;

		//if(Yii::app()->user->isGuest)
		//$this->redirect(Yii::app()->request->baseUrl);

		$dataProvider = null; 
		if(isset($_POST['Lugares']))
		{
			$evento = $_POST['evento_id'];
			$funcion = $_POST['funcion_id'];
			$zona = $_POST['zona_id'];
			$fila = $_POST['Lugares']['filas'];
			$asiento = $_POST['Lugares']['lugares'];
			$zonaCondicion = '';
			if($zona)
			{
				$zonaCondicion = "lugares.ZonasId = '".$zona."' AND";
			}


			$dataProvider = new CActiveDataProvider('Lugares', 
				array('criteria'=>array('select'   =>"evento.EventoNom,
				funciones.funcionesTexto,
				zonas.ZonasAli as Zona,
				filas.FilasAli as Fila,
				lugares.LugaresLug as Asiento,
				ventaslevel1.LugaresNumBol as Barras,
				ventaslevel1.VentasSta as Estatus,
				ventas.VentasFecHor as FechaVenta,
				ventas.VentasId,
				ventas.VentasNumRef,
				ventas.VentasTip as TipoVenta,
				ventaslevel1.VentasBolTip as TipoBoleto,
				descuentos.DescuentosDes as Descuento,
				puntosventa.PuntosventaId,
				puntosventa.PuntosventaNom as PuntoVenta,
				ventas.UsuariosId,
				IF(ventas.TempLugaresTipUsr = 'usuarios',
				(SELECT usuarios.UsuariosNom FROM usuarios 
				WHERE UsuariosId = ventas.UsuariosId),
				(SELECT clientes.ClientesNom FROM clientes 
				WHERE ClientesId = ventas.UsuariosId)) AS QuienVende,
				ventas.VentasNomDerTar AS NombreTarjeta,
				ventas.VentasNumTar AS NumeroTarjeta,
				IF(ventaslevel1.CancelUsuarioId > 0,
				(SELECT usuarios.UsuariosNom FROM usuarios 
				WHERE UsuariosId = ventaslevel1.CancelUsuarioId), '') AS QuienCancelo,
				ventaslevel1.CancelFecHor AS FechaCancelacion,
				(SELECT COUNT(reimpresiones.ReimpresionesId)
				FROM  reimpresiones
				WHERE reimpresiones.EventoId = ventaslevel1.EventoId AND 
				reimpresiones.FuncionesId = ventaslevel1.FuncionesId AND
				reimpresiones.ZonasId =  ventaslevel1.ZonasId AND
				reimpresiones.SubzonaId = ventaslevel1.SubzonaId AND
				reimpresiones.FilasId = ventaslevel1.FilasId AND
				reimpresiones.LugaresId = ventaslevel1.LugaresId) as VecesImpreso,
				ventaslevel1.EventoId,
				ventaslevel1.FuncionesId,
				ventaslevel1.ZonasId,
				ventaslevel1.SubzonaId,
				ventaslevel1.FilasId,
				ventaslevel1.LugaresId", 
				'alias'=>'lugares',
				'join'=>"INNER JOIN filas ON (filas.EventoId = lugares.EventoId)
				AND (filas.FuncionesId = lugares.FuncionesId)
				AND (filas.ZonasId = lugares.ZonasId)
				AND (filas.SubzonaId = lugares.SubzonaId)
				AND (filas.FilasId = lugares.FilasId)
				INNER JOIN zonas ON (zonas.EventoId = filas.EventoId)
				AND (zonas.FuncionesId = filas.FuncionesId)
				AND (zonas.ZonasId = filas.ZonasId)
				INNER JOIN ventaslevel1 ON (lugares.EventoId = ventaslevel1.EventoId)
				AND (lugares.FuncionesId = ventaslevel1.FuncionesId)
				AND (lugares.ZonasId = ventaslevel1.ZonasId)
				AND (lugares.SubzonaId = ventaslevel1.SubzonaId)
				AND (lugares.FilasId = ventaslevel1.FilasId)
				AND (lugares.LugaresId = ventaslevel1.LugaresId)
				INNER JOIN funciones ON (funciones.FuncionesId = zonas.FuncionesId)
				AND (funciones.EventoId = zonas.EventoId)
				INNER JOIN ventas ON (ventaslevel1.VentasId = ventas.VentasId)
				LEFT JOIN descuentos ON (ventaslevel1.DescuentosId = descuentos.DescuentosId)
				INNER JOIN puntosventa ON (ventas.PuntosventaId = puntosventa.PuntosventaId)
				INNER JOIN evento ON (funciones.EventoId = evento.EventoId)",
					'condition'=>"lugares.EventoId = '$evento' AND 
					lugares.FuncionesId = '$funcion' AND
					".$zonaCondicion." 
					FilasAli LIKE '%$fila%' AND 
					LugaresLug LIKE '%$asiento%'",
					'order'=>'lugares.ZonasId,lugares.FilasId, lugares.LugaresLug, ventas.VentasFecHor',
					'limit'=>'1500'),
				'pagination'=>false));	
		} 
		else{
			$evento = '******';

		}
		$this->render('lugaresVendidos',array('model'=>$model, 'dataProvider'=>$dataProvider));	


	}

	public function actionCancelarVentaFarmatodo()
	{
		$this->perfil();
		$model=new ReportesVentas;
		$ref=null;
		if(!empty($_POST['buscar'])){
			$ref = $_POST['buscar'];
		}
		$this->render('cancelarVentaFarmatodo',array('model'=>$model, 'ref'=>$ref)); 
		//$this->render('reservacionesFarmatodo');
	}




	public function actionVentasDiarias()
	{
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);	
		$model=new ReportesFlex;
		$desde=isset($_POST['desde'])?$_POST['desde']:0;
		$hasta=isset($_POST['hasta'])?$_POST['hasta']:0;
		$por=isset($_POST['por'])?$_POST['por']:'usuario';
		$this->render('ventasDiarias',array(
			'model'=>$model,
			'desde'=>$desde,'hasta'=>$hasta,
			'por'=>$por));
	}

	public function actionVentasFarmatodo()
	{
			$model=new ReportesVentas;
			$desde=0;$hasta=0;		
			if (isset($_POST['desde'],$_POST['hasta'])  
					and preg_match("(\d{4}-\d{2}-\d{2})",$_POST['desde'])==1 
					and preg_match("(\d{4}-\d{2}-\d{2})",$_POST['hasta'])==1
			) {
					$desde=$_POST['desde'];
					$hasta=$_POST['hasta'];
			}	
			$this->render('ventasFarmatodo',array('model'=>$model,'desde'=>$desde,'hasta'=>$hasta));
	}

	public function actionVentasFarmatodo2()
	{
		$this->perfil();
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
		$totalventa         = '';
		$totaltransacciones = '';
		$totalboleto        = '';
		$order              = '';
		if (isset($_POST) and sizeof($_POST)>0) {
			if(isset($_POST['totalventa'] ) and $_POST['totalventa'] !='todo')
				$order = $totalventa = $_POST['totalventa'];

			if(isset($_POST['totaltransacciones'] ) and $_POST['totaltransacciones'] != 'todo')
			{
				if($order !='')
					$order.= ",".$totaltransacciones = $_POST['totaltransacciones'];    
				else
					$order = $totaltransacciones = $_POST['totaltransacciones'];

			}

			if(isset($_POST['totalboleto'] ) and $_POST['totalboleto'] != 'todo')
			{
				if($order!= '')
					$order.=",".$totalboleto = $_POST['totalboleto'];
				else
					$order = $totalboleto = $_POST['totalboleto'];
			}

			$dia[]=31;
			$dia[]=28;
			$dia[]=31;
			$dia[]=30;
			$dia[]=31;
			$dia[]=30;
			$dia[]=31;
			$dia[]=31;
			$dia[]=30;
			$dia[]=31;
			$dia[]=30;
			$dia[]=31;

			$model = new Ventaslevel1;
			$hora = '';
			if(isset($_POST['mes']) && ($_POST['mes']!= 'todo') && ($_POST['turno'] != 'todo') && isset($_POST['turno']))
			{
				$turno = explode("-",$_POST['turno']); 
				$mesInicio = $_POST['mes']." ".$turno[0];
				$fecha =  explode('-',$mesInicio);

				if($fecha[1] == 12)
				{
					$mes =$fecha[1];
					$dias = $dia[$fecha[1]-1];     
				}
				else
				{
					$mes =$fecha[1];   
					$dias = $dia[$fecha[1]-1];
				}

				$mesFin = date("Y-$mes-$dias");

				$hora = " AND TIME(ventas.VentasFecHor) BETWEEN '".$turno[0]."' AND '".$turno[1]."'";

			}
			if(($_POST['mes'] != 'todo') && ($_POST['turno'] == 'todo'))
			{
				$mesInicio  = $_POST['mes'];
				$fecha =  explode('-',$mesInicio);

				if($fecha[1] == 12)
				{
					$mes =$fecha[1];
					$dias = $dia[$fecha[1]-1];     
				}
				else
				{
					$mes =$fecha[1];   
					$dias = $dia[$fecha[1]-1];
				}

				$mesFin = date("Y-$mes-$dias");   

			}

			if(($_POST['mes'] == 'todo') && $_POST['turno'] != 'todo')
			{

				$turno = explode("-",$_POST['turno']);
				$mesInicio  = "2011-01-01";
				$fecha =  explode('-',$mesInicio);

				if($fecha[1] == 12)
				{
					$mes =$fecha[1];
					$dias = $dia[$fecha[1]-1];     
				}
				else
				{
					$mes =$fecha[1];   
					$dias = $dia[$fecha[1]-1];
				}

				$mesFin = date("Y-12-$dias");

				$hora = " AND TIME(ventas.VentasFecHor) BETWEEN '".$turno[0]."' AND '".$turno[1]."'";
			}

			if(isset($_POST['mes']) && ($_POST['mes']!= 'todo') || ($_POST['turno'] != 'todo') && isset($_POST['turno']))
			{
					$query="SELECT 
							puntosventa.PuntosventaNom,
							SUM(ventaslevel1.VentasCosBol) + SUM(ventaslevel1.VentasCarSer) AS total_de_venta_en_pesos, 
							(SELECT COUNT(VentasId)
									FROM ventas WHERE PuntosventaId = puntosventa.PuntosventaId AND DATE(VentasFecHor) BETWEEN '$mesInicio' AND  '$mesFin'  AND VentasFecHor != '0000-00-00 00:00:00' $hora) AS total_transacciones,
						puntosventa.PuntosventaId,
						ventas.VentasFecHor,
						COUNT(ventaslevel1.VentasCosBol) AS total_de_boletos
						INNER JOIN ventas ON (ventas.VentasId = ventaslevel1.VentasId)
						INNER JOIN puntosventa ON (ventas.PuntosventaId = puntosventa.PuntosventaId)
						";


				$dataproviderReporte = new CActiveDataProvider('Ventaslevel1',array(
					'criteria'=>array(
						'select'=>"puntosventa.PuntosventaNom,
						SUM(ventaslevel1.VentasCosBol) + SUM(ventaslevel1.VentasCarSer) AS total_de_venta_en_pesos, 
						(SELECT COUNT(VentasId) FROM ventas WHERE PuntosventaId = puntosventa.PuntosventaId AND DATE(VentasFecHor) BETWEEN '$mesInicio' AND  '$mesFin'  AND VentasFecHor != '0000-00-00 00:00:00' $hora)AS total_transacciones,
						puntosventa.PuntosventaId,
						ventas.VentasFecHor,
						COUNT(ventaslevel1.VentasCosBol) AS total_de_boletos",
						'join'=>"INNER JOIN ventas ON (ventas.VentasId = ventaslevel1.VentasId)
						INNER JOIN puntosventa ON (ventas.PuntosventaId = puntosventa.PuntosventaId)",
							'alias'=>'ventaslevel1',                                                                                                                                
							'condition'=>"ventas.VentasSec = 'FARMATODO' AND DATE(ventas.VentasFecHor) BETWEEN '$mesInicio' AND '$mesFin' AND VentasFecHor != '0000-00-00 00:00:00' $hora",
							'order'=>$order,
							'group'=>"puntosventa.PuntosventaNom",
						),
						'pagination'=>array(
							'pageSize'=>40,
						),
					));    
			}
			else
			{
				$dataproviderReporte = new CActiveDataProvider('Ventaslevel1',array(
					'criteria'=>array(
						'select'=>"puntosventa.PuntosventaNom,
						SUM(ventaslevel1.VentasCosBol) + SUM(ventaslevel1.VentasCarSer) AS total_de_venta_en_pesos, 
						(SELECT COUNT(VentasId) FROM ventas WHERE PuntosventaId = puntosventa.PuntosventaId AND VentasFecHor != '0000-00-00 00:00:00')AS total_transacciones,
						puntosventa.PuntosventaId,
						ventas.VentasFecHor,
						COUNT(ventaslevel1.VentasCosBol) AS total_de_boletos",
						'join'=>"INNER JOIN ventas ON (ventas.VentasId = ventaslevel1.VentasId)
						INNER JOIN puntosventa ON (ventas.PuntosventaId = puntosventa.PuntosventaId)",
							'alias'=>'ventaslevel1',
							'condition'=>"ventas.VentasSec = 'FARMATODO' AND VentasFecHor != '0000-00-00 00:00:00'",
							'order'=>$order,
							'group'=>"puntosventa.PuntosventaNom",
						),
						'pagination'=>array(
							'pageSize'=>40,
						),
					));
			}
			$this->render('ventasFarmatodo',array('dataproviderReporte'=>$dataproviderReporte,
				'indice'=>$_POST['mes'],
				'indiceTurno'=>$_POST['turno'],
				'indiceventa'=>$_POST['totalventa'],
				'indicetransaccion'=>$_POST['totaltransacciones'],
				'indiceboleto'=>$_POST['totalboleto']));
		}
		else 
			$this->render('ventasFarmatodo',array('dataproviderReporte'=>null,
				'indice'=>0,
				'indiceTurno'=>0,
				'indiceventa'=>0,
				'indicetransaccion'=>0,
				'indiceboleto'=>0));
	}


	public function actionVentasSinCargo()
	{

		if(Yii::app()->user->isGuest){
			$this->redirect(array("site/logout"));
		}

		$model=new ReportesVentas;
		$eventoId=isset($_POST['evento_id'])?$_POST['evento_id']:0;
		$funcionesId=isset($_POST['funcion_id'])?$_POST['funcion_id']:0;
		$desde=isset($_POST['desde'])?$_POST['desde']:0;
		$hasta=isset($_POST['hasta'])?$_POST['hasta']:0;
		$this->render('ventasSinCargo',array(
			'model'=>$model,
			'eventoId'=>$eventoId,'funcionesId'=>$funcionesId,
			'desde'=>$desde,'hasta'=>$hasta));
	}
	public function actionVentasConCargo()
	{

		$model=new ReportesVentas;
		$eventoId=isset($_POST['evento_id'])?$_POST['evento_id']:0;
		$funcionesId=isset($_POST['funcion_id'])?$_POST['funcion_id']:0;
		$desde=isset($_POST['desde'])?$_POST['desde']:0;
		$hasta=isset($_POST['hasta'])?$_POST['hasta']:0;
		$this->render('ventasConCargo',array(
			'model'=>$model,
			'eventoId'=>$eventoId,'funcionesId'=>$funcionesId,
			'desde'=>$desde,'hasta'=>$hasta));
	}

	public function actionVentasWeb()
	{
		$this->perfil();
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
		$user = Usuarios::model()->findByAttributes(array('UsuariosId'=>Yii::app()->user->id));
		$region = $user->UsuariosRegion;
		$model=new ReportesFlex;
		$grid_mode='show';
		$funcionesId=0;
		$eventoId=0;

		if(!empty($_POST['Ventaslevel1']) and isset($_POST['evento_id']) )
		{
			// Si recibe parametros del post
			// Si recibe un parametro de exportacion 
			$grid_mode=isset($_POST['grid_mode'])?$_POST['grid_mode']:'show';
			$eventoId=$_POST['evento_id']>0?$_POST['evento_id']:0;
			if (isset($_POST['Ventaslevel1']['funcion'])
				and !is_null($_POST['Ventaslevel1']['funcion'])
				and $_POST['Ventaslevel1']['funcion']>0 )
				$funcionesId=$_POST['Ventaslevel1']['funcion'];

			else if (isset($_POST['funcion_id'])
				and !is_null($_POST['funcion_id'])
				and $_POST['funcion_id']>0 )
				$funcionesId=$_POST['funcion_id'];
		}

		$this->render('ventasWeb',
			array('model'=>$model,
			'eventoId'=>$eventoId,
			'funcionesId'=>$funcionesId,
			'grid_mode'=>$grid_mode,
			'region'=>$region));
	}	
	public function actionVentasInternet()
	{

			$download ="";
			$this->perfil();
			$user = Usuarios::model()->findByAttributes(array('UsuariosId'=>Yii::app()->user->id));
			$region = $user->UsuariosRegion;
			$download ="";
			//if(Yii::app()->user->isGuest)
			//$this->redirect(Yii::app()->request->baseUrl);
			$venta = "";
			$model=new Ventaslevel1;
			$count = 0;
			if(!empty($_POST['Ventaslevel1'])){
					if(!empty($_POST['Ventaslevel1']['funcion']) && $_POST['Ventaslevel1']['funcion']!=0 )
							$funcion = " lugares.FuncionesId=".$_POST['Ventaslevel1']['funcion']." AND ";
					else
							$funcion = " lugares.FuncionesId in(1,2,3,4,5,6,7,8,9,10) AND ";
					$venta = $_POST['evento_id'];
					$query = "SELECT '' as id, '' as VentasId , '' as PuntosventaId, '' as PuntosventaNom, '' as VentasFecHor, '' ZonasAli,
							''  as FilasAli, '' as LugaresLug, '' as LugaresNumBol, 
							'' as VentasCon, '' as VentasNumRef";
					if ($venta>0){

							$query ="(SELECT  ventas.VentasId as id, ventas.PuntosventaId, funciones.funcionesTexto as fnc,
									puntosventa.PuntosventaNom, ventas.VentasFecHor, zonas.ZonasAli,
									filas.FilasAli, lugares.LugaresLug,  subzona.SubzonaAcc,
									ventaslevel1.LugaresNumBol, ventaslevel1.VentasCon,cruge_user.email,
									ventas.VentasNumRef
									FROM
									lugares
									INNER JOIN funciones ON funciones.FuncionesId = lugares.FuncionesId AND funciones.EventoId = lugares.EventoId
									INNER JOIN ventaslevel1 ON (lugares.EventoId=ventaslevel1.EventoId)
									AND (lugares.FuncionesId=ventaslevel1.FuncionesId)
									AND (lugares.ZonasId=ventaslevel1.ZonasId)
									AND (lugares.SubzonaId=ventaslevel1.SubzonaId)
									AND (lugares.FilasId=ventaslevel1.FilasId)
									AND (lugares.LugaresId=ventaslevel1.LugaresId)
									INNER JOIN filas ON (filas.EventoId=lugares.EventoId)
									AND (filas.FuncionesId=lugares.FuncionesId)
									AND (filas.ZonasId=lugares.ZonasId)
									AND (filas.SubzonaId=lugares.SubzonaId)
									AND (filas.FilasId=lugares.FilasId)
									INNER JOIN zonas ON (zonas.EventoId=filas.EventoId)
									AND (zonas.FuncionesId=filas.FuncionesId)
									AND (zonas.ZonasId=filas.ZonasId)
									INNER JOIN ventas ON (ventas.VentasId=ventaslevel1.VentasId)
									INNER JOIN puntosventa ON (puntosventa.PuntosventaId=ventas.PuntosventaId)
									INNER JOIN subzona ON (subzona.EventoId=filas.EventoId)
									AND (subzona.FuncionesId=filas.FuncionesId)
									AND (subzona.ZonasId=filas.ZonasId)
									AND (subzona.SubzonaId=filas.SubzonaId)
									AND (zonas.EventoId=subzona.EventoId)
									AND (zonas.FuncionesId=subzona.FuncionesId)
									AND (zonas.ZonasId=subzona.ZonasId)
									WHERE
									(lugares.EventoId = $venta) AND
									$funcion
									((puntosventa.PuntosventaId = '101')) AND
									NOT (ventas.VentasNumRef = ''))
									ORDER BY  fnc ,ZonasAli,filasAli,LugaresLug;";
					}

					$dataProvider = new CSqlDataProvider($query, array(
							'totalItemCount'=>count($query),	
							'pagination'=>false,
					));
					if(isset($_POST['grid_mode']) and $_POST['grid_mode']=='export'){  
							$EventoNombre = Evento::model()->findAll("EventoId=".$_POST['evento_id']);
							$dir_file = Yii::app()->request->scriptFile."doctos/";
							$delete_file = @scandir(str_replace('index.php','',$dir_file));
							if(!empty($delete_file[2])){
									@unlink(str_replace('index.php','',$dir_file).$delete_file[2]);
							}
							$phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
							spl_autoload_unregister(array('YiiBase','autoload'));
							include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
							$objPHPExcel = new PHPExcel();
							$objPHPExcel->setActiveSheetIndex(0);
							$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Función');
							$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Punto de Venta');
							$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Ventas Fecha y Hora');
							$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Zona');
							$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Fila');
							$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Lugar');
							$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Referencia');
							$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Clientes Email');
							$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Reimpresiones');
							spl_autoload_register(array('YiiBase','autoload'));
							foreach($dataProvider->getData() as $key => $datos):
									$fila = $key+2;
							$objPHPExcel->getActiveSheet()->setCellValue("A$fila", $datos['fnc']);
							$objPHPExcel->getActiveSheet()->setCellValue("B$fila", $datos['PuntosventaNom']);
							$objPHPExcel->getActiveSheet()->setCellValue("C$fila", $datos['VentasFecHor']);
							$objPHPExcel->getActiveSheet()->setCellValue("D$fila", $datos['ZonasAli']);
							$objPHPExcel->getActiveSheet()->setCellValue("E$fila", $datos['FilasAli']);
							$objPHPExcel->getActiveSheet()->setCellValue("F$fila", $datos['LugaresLug']);
							$objPHPExcel->getActiveSheet()->setCellValue("G$fila", $datos['VentasNumRef']);
							$objPHPExcel->getActiveSheet()->setCellValue("H$fila", $datos['ClientesEma']);
							$string = $datos['VentasCon'];
							if(!empty($string)):
									$len = strlen($string);
							$num = substr($string ,$len -2);
							if(is_numeric($num)):
									$reimp = $num + 1;
							else:
									$num = substr($string ,$len -1);
							$reimp = $num + 1;
endif;
else:
		$reimp = "0";
endif;
$objPHPExcel->getActiveSheet()->setCellValue("I$fila", $reimp);
endforeach;
$objPHPExcel->getActiveSheet()->setTitle('Concentrados');
$objPHPExcel->setActiveSheetIndex(0);
$name =  date('d_m_Y');
//$file=str_replace('index.php','',$dir_file)."reporte_web_".str_replace(array('Á','á','É','é','Í','í','Ó','ó','Ú','ú','Ñ','ñ',' '),array('A','a','E','e','I','i','O','o','U','u','N','n','_'),$EventoNombre[0]->EventoNom)."_$name.xls";

$file=Yii::app()->request->baseUrl."/doctos/reporte_web_".str_replace(array('Á','á','É','é','Í','í','Ó','ó','Ú','ú','Ñ','ñ',' '),array('A','a','E','e','I','i','O','o','U','u','N','n','_'),$EventoNombre[0]->EventoNom)."_$name.xls";
$download =$file;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
header('Content-Disposition: attachment; filename="reporte_web_'.str_replace(array('Á','á','É','é','Í','í','Ó','ó','Ú','ú','Ñ','ñ',' '),array('A','a','E','e','I','i','O','o','U','u','N','n','_'),$EventoNombre[0]->EventoNom).'_'.$name.'.xls"');
// Write file to the browser
$objWriter->save('php://output');
//$objWriter->save('..'.$file); 

					}      

					$this->render('ventasWeb',
							array('model'=>$model,'itemselected' => $venta, 'dataProvider'=>$dataProvider,'download'=>$download,'region'=>$region));

			} 
			else
					$this->render('ventasWeb',array('model'=>$model,'itemselected' => $venta,'region'=>$region));
	}

	public function actionExportarReporte(){
			$esMovil=Yii::app()->mobileDetect->isMobile();
			if (isset($_GET['movil']) ) {
					$esMovil=$_GET['movil'];
			}
			$model=new ReportesVentas;

			$matrix=array(
					'evento'=>array('nombre','funcion','desde','diaspara'),
					'tablas'=>array('resumen'=>'','vhoy'=>'','promedios'=>'',
					'zonas'=>'','ventas'=>'','ultimas'=>''),
			);	
			$eventoId=isset($_GET['evento_id'])?$_GET['evento_id']:0;
			$funcionesId=isset($_GET['funcion_id'])?$_GET['funcion_id']:"TODAS";
			$desde=isset($_GET['desde'])?$_GET['desde']:0;
			$hasta=isset($_GET['hasta'])?$_GET['hasta']:0;
			$cargo=isset($_GET['cargo'])?$_GET['cargo']:false;
			$matrix['tablas']['resumen']	=$model->getResumenEvento($eventoId,$funcionesId,$desde,$hasta);
					if (!$esMovil) {
							$matrix['tablas']['ventas']		=$model->getReporte($eventoId,$funcionesId,$desde,$hasta);
							$matrix['tablas']['vhoy']		=$model->getReporte($eventoId,$funcionesId,'curdate()','curdate()');
							$matrix['tablas']['promedios']	=$model->getPromedios($eventoId,$funcionesId);
							$matrix['tablas']['zonas']		=$model->getReporteZonas($eventoId,$funcionesId,$desde,$hasta);
					}
					else{
							$matrix['tablas']['ultimas']	=$model->getUltimasVentas($eventoId,$funcionesId);
					}	
	
			//Primer renderizado en html ------>

					$matrix['tablas']['resumen']	=Yii::app()->mustache->render('tablaResumenEvento', $matrix['tablas']['resumen'],null,null,false);
					if (!$esMovil) {
							if ($cargo) {
									$matrix['tablas']['ventas']		=Yii::app()->mustache->render('tablaVentasConCargo', $matrix['tablas']['ventas'],null,null,false);
							}
							else
									$matrix['tablas']['ventas']		=Yii::app()->mustache->render('tablaVentasSinCargo', $matrix['tablas']['ventas'],null,null,false);
							$matrix['tablas']['vhoy']		=Yii::app()->mustache->render('tablaVentasHoySin', $matrix['tablas']['vhoy'],null,null,false);
							$matrix['tablas']['promedios']	=Yii::app()->mustache->render('tablaPromediosDiarios', $matrix['tablas']['promedios'],null,null,false);
							$matrix['tablas']['zonas']		=Yii::app()->mustache->render('tablasVentasZonas', $matrix['tablas']['zonas'],null,null,false);
					}
					else{
							$matrix['tablas']['ultimas']	=Yii::app()->mustache->render('tablaUltimasVentas', $matrix['tablas']['ultimas'],null,null,false);
					}
				//foreach ($matrix['tablas'] as $key=>&$tabla) {
					//$tabla=htmlspecialchars_decode($tabla); 
				//}
			
		
			if (isset($eventoId) and $eventoId>0){ 
					$evento=Evento::model()->findByPk($eventoId);
					$funciones="TODAS";
					if (isset($funcionesId) and $funcionesId>0){
							$funcion=Funciones::model()->findByPk(array('EventoId'=>$eventoId,'FuncionesId'=>$funcionesId));
							if(is_object($funcion)){
									$funciones=$funcion->funcionesTexto;
							}

					}
					else{
							$funcion=$evento->funciones[0];
					}
					$ventasDesde=date_create($funcion->FuncionesFecIni)->format("d-F-Y");                   
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
							"Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					$months = array( 'January', 'February', 'March', 'April', 'May',
						   	'June', 'July ', 'August', 'September', 'October', 'November',  'December',);
					$diaFuncion = new DateTime($funcion->FuncionesFecHor);
					$hoy = new DateTime("now");
					$diaspara=round(($diaFuncion->format('U') - $hoy->format('U')) / (60*60*24));
					$matrix['evento']['nombre']=$evento->EventoNom;
					$matrix['evento']['funcion']=$funciones;
					$matrix['evento']['desde']=str_replace($months,$meses,$ventasDesde);
					$matrix['evento']['diaspara']=$diaspara>-1?$diaspara:"El evento ya ha finalizado.";

					header('Content-type: application/ms-excel');
					header('Content-Disposition: attachment; filename=VentasSinCargo.xls');
					Yii::app()->mustache->render('ReporteSinCargoExportacion',$matrix);


			}
	}//actionExcel method end

 
    public function actionImpresionBoletosAjax()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        if(!empty($_POST['formatoId'])){
            $pv = $_POST['pv'];
            $EventoId = $_POST['EventoId'];
            $FuncionId = $_POST['FuncionId'];
            $todos = "";
            if($_POST['tipo_impresion']=="no_impresos"){
                $todos = "  ventaslevel1.VentasCon='' AND ";
            }
            $data=array();
            $query ="(SELECT  ventas.VentasId as id, 
                                    funciones.funcionesTexto as fnc, 
                                    lugares.LugaresLug,
                                    filas.FilasAli,
                                    zonas.ZonasAli,
                                    subzona.SubzonaAcc,
                                    evento.EventoDesBol,
                                    evento.EventoNom,
                                    evento.EventoImaBol,
                                    foro.ForoNom,
                                    ventaslevel1.EventoId,
                                    ventaslevel1.FuncionesId,
                                    ventaslevel1.ZonasId,
                                    ventaslevel1.SubzonaId,
                                    ventaslevel1.FilasId,
                                    ventaslevel1.LugaresId,
                                    ventaslevel1.VentasBolTip,
                                    ventaslevel1.VentasCon,
                                    ventaslevel1.VentasCarSer,
                                    ventaslevel1.LugaresNumBol,
                                    (ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes) as cosBol,
                                    (ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes + ventaslevel1.VentasCarSer) as cosBolCargo,
                                    ventas.UsuariosId,
                                    ventas.VentasNumRef,
                                    ventas.PuntosventaId,
                                    ventas.VentasFecHor,
                                    ventas.VentasNumTar,
                                    ventas.VentasNomDerTar
									FROM
									lugares
									INNER JOIN funciones ON funciones.FuncionesId = lugares.FuncionesId AND funciones.EventoId = lugares.EventoId
									INNER JOIN ventaslevel1 ON (lugares.EventoId=ventaslevel1.EventoId)
									AND (lugares.FuncionesId=ventaslevel1.FuncionesId)
									AND (lugares.ZonasId=ventaslevel1.ZonasId)
									AND (lugares.SubzonaId=ventaslevel1.SubzonaId)
									AND (lugares.FilasId=ventaslevel1.FilasId)
									AND (lugares.LugaresId=ventaslevel1.LugaresId)
                                    INNER JOIN evento ON evento.EventoId = ventaslevel1.EventoId
                                    INNER JOIN foro ON foro.ForoId = evento.ForoId
									INNER JOIN filas ON (filas.EventoId=lugares.EventoId)
									AND (filas.FuncionesId=lugares.FuncionesId)
									AND (filas.ZonasId=lugares.ZonasId)
									AND (filas.SubzonaId=lugares.SubzonaId)
									AND (filas.FilasId=lugares.FilasId)
									INNER JOIN zonas ON (zonas.EventoId=filas.EventoId)
									AND (zonas.FuncionesId=filas.FuncionesId)
									AND (zonas.ZonasId=filas.ZonasId)
									INNER JOIN ventas ON (ventas.VentasId=ventaslevel1.VentasId)
									INNER JOIN subzona ON (subzona.EventoId=filas.EventoId)
									AND (subzona.FuncionesId=filas.FuncionesId)
									AND (subzona.ZonasId=filas.ZonasId)
									AND (subzona.SubzonaId=filas.SubzonaId)
									AND (zonas.EventoId=subzona.EventoId)
									AND (zonas.FuncionesId=subzona.FuncionesId)
									AND (zonas.ZonasId=subzona.ZonasId)
									WHERE
                                    $todos 
                                    ventaslevel1.VentasSta not like '%CANCELADO%' AND 
									(lugares.EventoId = $EventoId ) AND 
									(lugares.FuncionesId = $FuncionId ) AND
									((ventas.PuntosventaId = '$pv')) AND 
									NOT (ventas.VentasNumRef = ''))
									ORDER BY  fnc ,ZonasAli,filasAli,LugaresLug;";
                $dataCodigo = new CSqlDataProvider($query, array(
							//'totalItemCount'=>$count,//$count,	
							'pagination'=>false,
					)); 
                $data =   $dataCodigo->getData(); 
                $newdata = array();
                foreach($data as $key => $boletoreimpresion):
                    $codigo = $this->verificaCodigos();
                    if(empty($boletoreimpresion['LugaresNumBol'])){
                        //$this->imprimeBoleto($codigo,$boletoreimpresion['id'],$boletoreimpresion['EventoId'],$boletoreimpresion['FuncionesId'],$boletoreimpresion['ZonasId'],$boletoreimpresion['SubzonaId'],$boletoreimpresion['FilasId'],$boletoreimpresion['LugaresId'],$boletoreimpresion['UsuariosId']);
                        
                        $contra = $boletoreimpresion['EventoId'].".".$boletoreimpresion['FuncionesId'].".".$boletoreimpresion['ZonasId'].".".$boletoreimpresion['SubzonaId'];
                	    $contra .= ".".$boletoreimpresion['FilasId'].".".$boletoreimpresion['LugaresId']."-".date("m").".".date("d")."-".$boletoreimpresion['UsuariosId'];
                	    $contra .= "R";
                        /*$ventaslevel1 = Ventaslevel1::model()->findByAttributes(array('VentasId'=>$boletoreimpresion['id'],'EventoId'=>$boletoreimpresion['EventoId'],'FuncionesId'=>$boletoreimpresion['FuncionesId'],'ZonasId'=>$boletoreimpresion['ZonasId'],'SubzonaId'=>$boletoreimpresion['SubzonaId'],'FilasId'=>$boletoreimpresion['FilasId'],'LugaresId'=>$boletoreimpresion['LugaresId']));
                   	    $ventaslevel1->LugaresNumBol = $codigo;
                        $ventaslevel1->VentasCon = $contra;
                        $ventaslevel1->update();*/
                        
                        $newdata[$key]['LugaresNumBol'] = $codigo;
                        $newdata[$key]['VentasCon'] = $contra;
                        $newdata[$key]['cosBolCargo'] = $boletoreimpresion['cosBolCargo'];
                        $newdata[$key]['FilasAli']   = $boletoreimpresion['FilasAli'];
                        $newdata[$key]['LugaresLug'] = $boletoreimpresion['LugaresLug'];
                        $newdata[$key]['ZonasAli'] = $boletoreimpresion['ZonasAli'];
                        $newdata[$key]['VentasNumRef'] = $boletoreimpresion['VentasNumRef'];
                        $newdata[$key]['EventoNom'] = $boletoreimpresion['EventoNom'];
                        $newdata[$key]['ForoNom'] = $boletoreimpresion['ForoNom'];
                        $newdata[$key]['SubzonaAcc'] = $boletoreimpresion['SubzonaAcc'];
                        $newdata[$key]['EventoDesBol'] = $boletoreimpresion['EventoDesBol'];
                        $newdata[$key]['fnc'] = $boletoreimpresion['fnc'];
                        $newdata[$key]['VentasBolTip'] = $boletoreimpresion['VentasBolTip'];
                        $newdata[$key]['cosBol'] = $boletoreimpresion['cosBol'];
                        $newdata[$key]['VentasCarSer'] = $boletoreimpresion['VentasCarSer'];
                        $newdata[$key]['EventoImaBol'] = $boletoreimpresion['EventoImaBol'];
                        $newdata[$key]['id'] = $boletoreimpresion['id'];
                        $newdata[$key]['PuntosventaId'] = $boletoreimpresion['PuntosventaId'];
                        $newdata[$key]['VentasFecHor'] = $boletoreimpresion['VentasFecHor'];
                        $newdata[$key]['VentasNumTar'] = $boletoreimpresion['VentasNumTar'];
                        $newdata[$key]['VentasNomDerTar'] = $boletoreimpresion['VentasNomDerTar'];
                    }else{
                        //$this->reimprimeBoleto($codigo,$boletoreimpresion['id'],$boletoreimpresion['EventoId'],$boletoreimpresion['FuncionesId'],$boletoreimpresion['ZonasId'],$boletoreimpresion['SubzonaId'],$boletoreimpresion['FilasId'],$boletoreimpresion['LugaresId'],$boletoreimpresion['UsuariosId'],$boletoreimpresion['LugaresNumBol'],$boletoreimpresion['VentasBolTip'],$boletoreimpresion['cosBol']);
                        
                        $reimpresiones = Reimpresiones::model()->count(array('condition'=>"EventoId=".$boletoreimpresion['EventoId']." AND FuncionesId=".$boletoreimpresion['FuncionesId']." AND ZonasId=".$boletoreimpresion['ZonasId']." AND SubzonaId=".$boletoreimpresion['SubzonaId']." AND FilasId=".$boletoreimpresion['FilasId']." AND LugaresId=".$boletoreimpresion['LugaresId']));
                        $contra = $boletoreimpresion['EventoId'].".".$boletoreimpresion['FuncionesId'].".".$boletoreimpresion['ZonasId'].".".$boletoreimpresion['SubzonaId'];
                	    $contra .= ".".$boletoreimpresion['FilasId'].".".$boletoreimpresion['LugaresId']."-".date("m").".".date("d")."-".$boletoreimpresion['UsuariosId'];
                	    $contra .= "PR$reimpresiones";
                        /*$ventaslevel1 = Ventaslevel1::model()->findByAttributes(array('VentasId'=>$boletoreimpresion['id'],'EventoId'=>$boletoreimpresion['EventoId'],'FuncionesId'=>$boletoreimpresion['FuncionesId'],'ZonasId'=>$boletoreimpresion['ZonasId'],'SubzonaId'=>$boletoreimpresion['SubzonaId'],'FilasId'=>$boletoreimpresion['FilasId'],'LugaresId'=>$boletoreimpresion['LugaresId']));
                   	    $ventaslevel1->LugaresNumBol = $codigo;
                        $ventaslevel1->VentasCon = $contra;
                        $ventaslevel1->update();
                        $ultimo = Reimpresiones::model()->findAll(array('limit'=>1,'order'=>'t.ReimpresionesId DESC'));
                        $ultimo = $ultimo[0]->ReimpresionesId + 1;
                        $hoy    = date("Y-m-d G:i:s"); 
                        $user_id = Yii::app()->user->id;
                        Yii::app()->db->createCommand("INSERT INTO reimpresiones VALUES($ultimo,".$boletoreimpresion['EventoId'].",".$boletoreimpresion['FuncionesId'].",".$boletoreimpresion['ZonasId'].",".$boletoreimpresion['SubzonaId'].",".$boletoreimpresion['FilasId'].",".$boletoreimpresion['LugaresId'].",'PANEL ADMINISTRATIVO','',$user_id,'$hoy','".$boletoreimpresion['LugaresNumBol']."')")->execute();
                        
                        $ultimologreimp = Logreimp::model()->findAll(array('limit'=>1,'order'=>'t.LogReimpId DESC'));
                        $ultimologreimp = $ultimologreimp[0]->LogReimpId + 1;
                        
                        Yii::app()->db->createCommand("INSERT INTO logreimp VALUES($ultimologreimp,'$hoy','".$boletoreimpresion['VentasBolTip']."',".$boletoreimpresion['cosBol'].",'".$boletoreimpresion['VentasBolTip']."',$user_id,0,".$boletoreimpresion['EventoId'].",".$boletoreimpresion['FuncionesId'].",".$boletoreimpresion['ZonasId'].",".$boletoreimpresion['SubzonaId'].",".$boletoreimpresion['FilasId'].",".$boletoreimpresion['LugaresId'].")")->execute();
                        */
                        $newdata[$key]['LugaresNumBol'] = $codigo;
                        $newdata[$key]['VentasCon'] = $contra;
                        $newdata[$key]['cosBolCargo'] = $boletoreimpresion['cosBolCargo'];
                        $newdata[$key]['FilasAli']   = $boletoreimpresion['FilasAli'];
                        $newdata[$key]['LugaresLug'] = $boletoreimpresion['LugaresLug'];
                        $newdata[$key]['ZonasAli'] = $boletoreimpresion['ZonasAli'];
                        $newdata[$key]['VentasNumRef'] = $boletoreimpresion['VentasNumRef'];
                        $newdata[$key]['EventoNom'] = $boletoreimpresion['EventoNom'];
                        $newdata[$key]['ForoNom'] = $boletoreimpresion['ForoNom'];
                        $newdata[$key]['SubzonaAcc'] = $boletoreimpresion['SubzonaAcc'];
                        $newdata[$key]['EventoDesBol'] = $boletoreimpresion['EventoDesBol'];
                        $newdata[$key]['fnc'] = $boletoreimpresion['fnc'];
                        $newdata[$key]['VentasBolTip'] = $boletoreimpresion['VentasBolTip'];
                        $newdata[$key]['cosBol'] = $boletoreimpresion['cosBol'];
                        $newdata[$key]['VentasCarSer'] = $boletoreimpresion['VentasCarSer'];
                        $newdata[$key]['EventoImaBol'] = $boletoreimpresion['EventoImaBol'];
                        $newdata[$key]['id'] = $boletoreimpresion['id'];
                        $newdata[$key]['PuntosventaId'] = $boletoreimpresion['PuntosventaId'];
                        $newdata[$key]['VentasFecHor'] = $boletoreimpresion['VentasFecHor'];
                        $newdata[$key]['VentasNumTar'] = $boletoreimpresion['VentasNumTar'];
                        $newdata[$key]['VentasNomDerTar'] = $boletoreimpresion['VentasNomDerTar'];
                    
                    }
                endforeach;         
            if(empty($newdata)){
                $ok = array('ok'=>'no');
                echo json_encode($ok);
            }else{
                $ok = array('ok'=>'si');
                echo json_encode($ok);
            }                                                
            $formato = Formatosimpresionlevel1::model()->findAll(array('condition'=>'FormatoId='.$_POST['formatoId']));
            $imagen = Evento::model()->findByAttributes(array('EventoId'=>$_POST['EventoId']));//$data->getData();
            
                if($imagen->EventoImaBol==""){
                    if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/blanco.jpg')){
                        copy('https://taquillacero.com/imagesbd/blanco.jpg',$_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/blanco.jpg' );
                    }
                }else{
                    if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/'.$imagen[0]['EventoImaBol'])){
                        copy('https://taquillacero.com/imagesbd/'.$imagen[0]['EventoImaBol'],$_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/'.$imagen->EventoImaBol );
                    }
                }
            $documento = $this->renderPartial('_impresionBoletosAjax', array('formato'=>$formato,'data'=>$newdata,'FormatoId'=>$_POST['formatoId']), true, false);
            $pdf = Yii::createComponent ( 'application.extensions.html2pdf.html2pdf' );
            $html2pdf = new HTML2PDF ( 'P', array(75,180), 'es', true, 'UTF-8', array (
                			0,
                			0,
                			0,
                			0
                	) );
         
         $html2pdf->writeHTML ($documento, false );
         $path=$_SERVER["DOCUMENT_ROOT"].'/'. Yii::app()->request->baseUrl . '/doctos';
    	 $html2pdf->Output ($path.'/boletos.pdf', 'F' );
        }
        
    }
     public function actionImpresionBoletosAjax2()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        if(!empty($_POST['formatoId'])){
            $pv = $_POST['pv'];
            $EventoId = $_POST['EventoId'];
            $FuncionId = $_POST['FuncionId'];
            $todos = "";
            if($_POST['tipo_impresion']=="no_impresos"){
                $todos = "  ventaslevel1.VentasCon='' AND ";
            }
            $data=array();
            $query ="(SELECT  ventas.VentasId as id, 
                                    funciones.funcionesTexto as fnc, 
                                    lugares.LugaresLug,
                                    filas.FilasAli,
                                    zonas.ZonasAli,
                                    subzona.SubzonaAcc,
                                    evento.EventoDesBol,
                                    evento.EventoNom,
                                    evento.EventoImaBol,
                                    foro.ForoNom,
                                    ventaslevel1.EventoId,
                                    ventaslevel1.FuncionesId,
                                    ventaslevel1.ZonasId,
                                    ventaslevel1.SubzonaId,
                                    ventaslevel1.FilasId,
                                    ventaslevel1.LugaresId,
                                    ventaslevel1.VentasBolTip,
                                    ventaslevel1.VentasCon,
                                    ventaslevel1.VentasCarSer,
                                    ventaslevel1.LugaresNumBol,
                                    (ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes) as cosBol,
                                    (ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes + ventaslevel1.VentasCarSer) as cosBolCargo,
                                    ventas.UsuariosId,
                                    ventas.VentasNumRef,
                                    ventas.PuntosventaId,
                                    ventas.VentasFecHor,
                                    ventas.VentasNumTar,
                                    ventas.VentasNomDerTar
									FROM
									lugares
									INNER JOIN funciones ON funciones.FuncionesId = lugares.FuncionesId AND funciones.EventoId = lugares.EventoId
									INNER JOIN ventaslevel1 ON (lugares.EventoId=ventaslevel1.EventoId)
									AND (lugares.FuncionesId=ventaslevel1.FuncionesId)
									AND (lugares.ZonasId=ventaslevel1.ZonasId)
									AND (lugares.SubzonaId=ventaslevel1.SubzonaId)
									AND (lugares.FilasId=ventaslevel1.FilasId)
									AND (lugares.LugaresId=ventaslevel1.LugaresId)
                                    INNER JOIN evento ON evento.EventoId = ventaslevel1.EventoId
                                    INNER JOIN foro ON foro.ForoId = evento.ForoId
									INNER JOIN filas ON (filas.EventoId=lugares.EventoId)
									AND (filas.FuncionesId=lugares.FuncionesId)
									AND (filas.ZonasId=lugares.ZonasId)
									AND (filas.SubzonaId=lugares.SubzonaId)
									AND (filas.FilasId=lugares.FilasId)
									INNER JOIN zonas ON (zonas.EventoId=filas.EventoId)
									AND (zonas.FuncionesId=filas.FuncionesId)
									AND (zonas.ZonasId=filas.ZonasId)
									INNER JOIN ventas ON (ventas.VentasId=ventaslevel1.VentasId)
									INNER JOIN subzona ON (subzona.EventoId=filas.EventoId)
									AND (subzona.FuncionesId=filas.FuncionesId)
									AND (subzona.ZonasId=filas.ZonasId)
									AND (subzona.SubzonaId=filas.SubzonaId)
									AND (zonas.EventoId=subzona.EventoId)
									AND (zonas.FuncionesId=subzona.FuncionesId)
									AND (zonas.ZonasId=subzona.ZonasId)
									WHERE
                                    $todos 
                                    ventaslevel1.VentasSta not like '%CANCELADO%' AND 
									(lugares.EventoId = $EventoId ) AND 
									(lugares.FuncionesId = $FuncionId ) AND
									((ventas.PuntosventaId = '$pv')) AND 
									NOT (ventas.VentasNumRef = ''))
									ORDER BY  fnc ,ZonasAli,filasAli,LugaresLug;";
                $dataCodigo = new CSqlDataProvider($query, array(
							//'totalItemCount'=>$count,//$count,	
							'pagination'=>false,
					)); 
                $data =   $dataCodigo->getData(); 
                $newdata = array();
                foreach($data as $key => $boletoreimpresion):
                    $codigo = $this->verificaCodigos();
                    if(empty($boletoreimpresion['LugaresNumBol'])){
                        //$this->imprimeBoleto($codigo,$boletoreimpresion['id'],$boletoreimpresion['EventoId'],$boletoreimpresion['FuncionesId'],$boletoreimpresion['ZonasId'],$boletoreimpresion['SubzonaId'],$boletoreimpresion['FilasId'],$boletoreimpresion['LugaresId'],$boletoreimpresion['UsuariosId']);
                        
                        $contra = $boletoreimpresion['EventoId'].".".$boletoreimpresion['FuncionesId'].".".$boletoreimpresion['ZonasId'].".".$boletoreimpresion['SubzonaId'];
                	    $contra .= ".".$boletoreimpresion['FilasId'].".".$boletoreimpresion['LugaresId']."-".date("m").".".date("d")."-".$boletoreimpresion['UsuariosId'];
                	    $contra .= "R";
                        $ventaslevel1 = Ventaslevel1::model()->findByAttributes(array('VentasId'=>$boletoreimpresion['id'],'EventoId'=>$boletoreimpresion['EventoId'],'FuncionesId'=>$boletoreimpresion['FuncionesId'],'ZonasId'=>$boletoreimpresion['ZonasId'],'SubzonaId'=>$boletoreimpresion['SubzonaId'],'FilasId'=>$boletoreimpresion['FilasId'],'LugaresId'=>$boletoreimpresion['LugaresId']));
                   	    $ventaslevel1->LugaresNumBol = $codigo;
                        $ventaslevel1->VentasCon = $contra;
                        $ventaslevel1->update();
                        
                        $newdata[$key]['LugaresNumBol'] = $codigo;
                        $newdata[$key]['VentasCon'] = $contra;
                        $newdata[$key]['cosBolCargo'] = $boletoreimpresion['cosBolCargo'];
                        $newdata[$key]['FilasAli']   = $boletoreimpresion['FilasAli'];
                        $newdata[$key]['LugaresLug'] = $boletoreimpresion['LugaresLug'];
                        $newdata[$key]['ZonasAli'] = $boletoreimpresion['ZonasAli'];
                        $newdata[$key]['VentasNumRef'] = $boletoreimpresion['VentasNumRef'];
                        $newdata[$key]['EventoNom'] = $boletoreimpresion['EventoNom'];
                        $newdata[$key]['ForoNom'] = $boletoreimpresion['ForoNom'];
                        $newdata[$key]['SubzonaAcc'] = $boletoreimpresion['SubzonaAcc'];
                        $newdata[$key]['EventoDesBol'] = $boletoreimpresion['EventoDesBol'];
                        $newdata[$key]['fnc'] = $boletoreimpresion['fnc'];
                        $newdata[$key]['VentasBolTip'] = $boletoreimpresion['VentasBolTip'];
                        $newdata[$key]['cosBol'] = $boletoreimpresion['cosBol'];
                        $newdata[$key]['VentasCarSer'] = $boletoreimpresion['VentasCarSer'];
                        $newdata[$key]['EventoImaBol'] = $boletoreimpresion['EventoImaBol'];
                        $newdata[$key]['id'] = $boletoreimpresion['id'];
                        $newdata[$key]['PuntosventaId'] = $boletoreimpresion['PuntosventaId'];
                        $newdata[$key]['VentasFecHor'] = $boletoreimpresion['VentasFecHor'];
                        $newdata[$key]['VentasNumTar'] = $boletoreimpresion['VentasNumTar'];
                        $newdata[$key]['VentasNomDerTar'] = $boletoreimpresion['VentasNomDerTar'];
                    }else{
                        //$this->reimprimeBoleto($codigo,$boletoreimpresion['id'],$boletoreimpresion['EventoId'],$boletoreimpresion['FuncionesId'],$boletoreimpresion['ZonasId'],$boletoreimpresion['SubzonaId'],$boletoreimpresion['FilasId'],$boletoreimpresion['LugaresId'],$boletoreimpresion['UsuariosId'],$boletoreimpresion['LugaresNumBol'],$boletoreimpresion['VentasBolTip'],$boletoreimpresion['cosBol']);
                        
                        $reimpresiones = Reimpresiones::model()->count(array('condition'=>"EventoId=".$boletoreimpresion['EventoId']." AND FuncionesId=".$boletoreimpresion['FuncionesId']." AND ZonasId=".$boletoreimpresion['ZonasId']." AND SubzonaId=".$boletoreimpresion['SubzonaId']." AND FilasId=".$boletoreimpresion['FilasId']." AND LugaresId=".$boletoreimpresion['LugaresId']));
                        $contra = $boletoreimpresion['EventoId'].".".$boletoreimpresion['FuncionesId'].".".$boletoreimpresion['ZonasId'].".".$boletoreimpresion['SubzonaId'];
                	    $contra .= ".".$boletoreimpresion['FilasId'].".".$boletoreimpresion['LugaresId']."-".date("m").".".date("d")."-".$boletoreimpresion['UsuariosId'];
                	    $contra .= "PR$reimpresiones";
                        $ventaslevel1 = Ventaslevel1::model()->findByAttributes(array('VentasId'=>$boletoreimpresion['id'],'EventoId'=>$boletoreimpresion['EventoId'],'FuncionesId'=>$boletoreimpresion['FuncionesId'],'ZonasId'=>$boletoreimpresion['ZonasId'],'SubzonaId'=>$boletoreimpresion['SubzonaId'],'FilasId'=>$boletoreimpresion['FilasId'],'LugaresId'=>$boletoreimpresion['LugaresId']));
                   	    $ventaslevel1->LugaresNumBol = $codigo;
                        $ventaslevel1->VentasCon = $contra;
                        $ventaslevel1->update();
                        $ultimo = Reimpresiones::model()->findAll(array('limit'=>1,'order'=>'t.ReimpresionesId DESC'));
                        $ultimo = $ultimo[0]->ReimpresionesId + 1;
                        $hoy    = date("Y-m-d G:i:s"); 
                        $user_id = Yii::app()->user->id;
                        Yii::app()->db->createCommand("INSERT INTO reimpresiones VALUES($ultimo,".$boletoreimpresion['EventoId'].",".$boletoreimpresion['FuncionesId'].",".$boletoreimpresion['ZonasId'].",".$boletoreimpresion['SubzonaId'].",".$boletoreimpresion['FilasId'].",".$boletoreimpresion['LugaresId'].",'PANEL ADMINISTRATIVO','',$user_id,'$hoy','".$boletoreimpresion['LugaresNumBol']."')")->execute();
                        
                        $ultimologreimp = Logreimp::model()->findAll(array('limit'=>1,'order'=>'t.LogReimpId DESC'));
                        $ultimologreimp = $ultimologreimp[0]->LogReimpId + 1;
                        
                        Yii::app()->db->createCommand("INSERT INTO logreimp VALUES($ultimologreimp,'$hoy','".$boletoreimpresion['VentasBolTip']."',".$boletoreimpresion['cosBol'].",'".$boletoreimpresion['VentasBolTip']."',$user_id,0,".$boletoreimpresion['EventoId'].",".$boletoreimpresion['FuncionesId'].",".$boletoreimpresion['ZonasId'].",".$boletoreimpresion['SubzonaId'].",".$boletoreimpresion['FilasId'].",".$boletoreimpresion['LugaresId'].")")->execute();
                        $newdata[$key]['LugaresNumBol'] = $codigo;
                        $newdata[$key]['VentasCon'] = $contra;
                        $newdata[$key]['cosBolCargo'] = $boletoreimpresion['cosBolCargo'];
                        $newdata[$key]['FilasAli']   = $boletoreimpresion['FilasAli'];
                        $newdata[$key]['LugaresLug'] = $boletoreimpresion['LugaresLug'];
                        $newdata[$key]['ZonasAli'] = $boletoreimpresion['ZonasAli'];
                        $newdata[$key]['VentasNumRef'] = $boletoreimpresion['VentasNumRef'];
                        $newdata[$key]['EventoNom'] = $boletoreimpresion['EventoNom'];
                        $newdata[$key]['ForoNom'] = $boletoreimpresion['ForoNom'];
                        $newdata[$key]['SubzonaAcc'] = $boletoreimpresion['SubzonaAcc'];
                        $newdata[$key]['EventoDesBol'] = $boletoreimpresion['EventoDesBol'];
                        $newdata[$key]['fnc'] = $boletoreimpresion['fnc'];
                        $newdata[$key]['VentasBolTip'] = $boletoreimpresion['VentasBolTip'];
                        $newdata[$key]['cosBol'] = $boletoreimpresion['cosBol'];
                        $newdata[$key]['VentasCarSer'] = $boletoreimpresion['VentasCarSer'];
                        $newdata[$key]['EventoImaBol'] = $boletoreimpresion['EventoImaBol'];
                        $newdata[$key]['id'] = $boletoreimpresion['id'];
                        $newdata[$key]['PuntosventaId'] = $boletoreimpresion['PuntosventaId'];
                        $newdata[$key]['VentasFecHor'] = $boletoreimpresion['VentasFecHor'];
                        $newdata[$key]['VentasNumTar'] = $boletoreimpresion['VentasNumTar'];
                        $newdata[$key]['VentasNomDerTar'] = $boletoreimpresion['VentasNomDerTar'];
                    
                    }
                endforeach;                                                
            $formato = Formatosimpresionlevel1::model()->findAll(array('condition'=>'FormatoId='.$_POST['formatoId']));
            $imagen = Evento::model()->findByAttributes(array('EventoId'=>$_POST['EventoId']));//$data->getData();
            
                if($imagen->EventoImaBol==""){
                    if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/blanco.jpg')){
                        copy('https://taquillacero.com/imagesbd/blanco.jpg',$_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/blanco.jpg' );
                    }
                }else{
                    if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/'.$imagen->EventoImaBol)){
                        copy('https://taquillacero.com/imagesbd/'.$imagen->EventoImaBol,$_SERVER["DOCUMENT_ROOT"].'/'. Yii::app ()->baseUrl . '/imagesbd/'.$imagen->EventoImaBol );
                    }
                }
            $this->renderPartial('_impresionBoletosAjax', array('formato'=>$formato,'data'=>$newdata,'FormatoId'=>$_POST['formatoId']));
        }
        
    }
    public function actionActualizarRegion(){
        if(!empty($_POST['region_id'])){
            $user = Usuarios::model()->findByAttributes(array('UsuariosId'=>Yii::app()->user->id));
            $user->UsuariosRegion = $_POST['region_id'];
            $user->update();
            //echo "ok".$user->UsuariosId.$_POST['region_id']; 
        }
    }
   	public function imprimeBoleto($codigo,$ventasId,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId,$usuariosId){
           //$reimpresiones = Reimpresiones::model()->count(array('condition'=>"EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=$lugaresId"));
        $contra = $eventoId.".".$funcionesId.".".$zonasId.".".$subzonaId;
	    $contra .= ".".$filasId.".".$lugaresId."-".date("m").".".date("d")."-".$usuariosId;
	    $contra .= "R";
        $ventaslevel1 = Ventaslevel1::model()->findByAttributes(array('VentasId'=>$ventasId,'EventoId'=>$eventoId,'FuncionesId'=>$funcionesId,'ZonasId'=>$zonasId,'SubzonaId'=>$subzonaId,'FilasId'=>$filasId,'LugaresId'=>$lugaresId));
   	    $ventaslevel1->LugaresNumBol = $codigo;
        $ventaslevel1->VentasCon = $contra;
        $ventaslevel1->update();
        /*
        $ultimo = Reimpresiones::model()->findAll(array('limit'=>1,'order'=>'t.ReimpresionesId DESC'));
        $ultimo = $ultimo[0]->ReimpresionesId + 1;
        $hoy    = date("Y-m-d G:i:s"); 
        
        Yii::app()->db->createCommand("INSERT INTO reimpresiones VALUES($ultimo,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId,'PANEL ADMINISTRATIVO','', $usuariosId,'$hoy','$codigo')")->execute();*/
    }
    public function reimprimeBoleto($codigo,$ventasId,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId,$usuariosId,$ultimocodigo="26",$tip="NORMAL",$cosBol=0){
        
        $reimpresiones = Reimpresiones::model()->count(array('condition'=>"EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=$lugaresId"));
        $contra = $eventoId.".".$funcionesId.".".$zonasId.".".$subzonaId;
	    $contra .= ".".$filasId.".".$lugaresId."-".date("m").".".date("d")."-".$usuariosId;
	    $contra .= "PR$reimpresiones";
        $ventaslevel1 = Ventaslevel1::model()->findByAttributes(array('VentasId'=>$ventasId,'EventoId'=>$eventoId,'FuncionesId'=>$funcionesId,'ZonasId'=>$zonasId,'SubzonaId'=>$subzonaId,'FilasId'=>$filasId,'LugaresId'=>$lugaresId));
   	    $ventaslevel1->LugaresNumBol = $codigo;
        $ventaslevel1->VentasCon = $contra;
        $ventaslevel1->update();
        $ultimo = Reimpresiones::model()->findAll(array('limit'=>1,'order'=>'t.ReimpresionesId DESC'));
        $ultimo = $ultimo[0]->ReimpresionesId + 1;
        $hoy    = date("Y-m-d G:i:s"); 
        $user_id = Yii::app()->user->id;
        Yii::app()->db->createCommand("INSERT INTO reimpresiones VALUES($ultimo,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId,'PANEL ADMINISTRATIVO','',$user_id,'$hoy','$ultimocodigo')")->execute();
        
        $ultimologreimp = Logreimp::model()->findAll(array('limit'=>1,'order'=>'t.LogReimpId DESC'));
        $ultimologreimp = $ultimologreimp[0]->LogReimpId + 1;
        
        Yii::app()->db->createCommand("INSERT INTO logreimp VALUES($ultimologreimp,'$hoy','$tip',$cosBol,'$tip',$user_id,0,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId)")->execute();
       
    }
    public function verificaCodigos(){
        
        do{
            
            $codigo = $this->generarCodigo(12);
            $model = Ventaslevel1::model()->count(array('condition'=>"LugaresNumBol='$codigo'",'limit'=>1));
            if($model<=0){
                $i=0;
            }    
        }while($i != 0);
        return $codigo;
    }
    public function generarCodigo($longitud) {
         $key = '';
         $pattern = '0123456789';
         $max = strlen($pattern)-1;
         for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
         return strtoupper($key);
    }

	public function actionBuscarBoleto()
	{
		$model=new ReportesVentas;	
		$ref=null;	
		$tipo="venta";
		if(!empty($_GET['buscar'])){
			$ref = $_GET['buscar'];
			if(isset($_GET['tipo']) ){
				$tipo=$_GET['tipo'];
			}
		}

			$this->render('buscarBoleto',array('model'=>$model,'ref'=>$ref,'tipo'=>$tipo));
	}
	public function actionAccesos()
	{
		//Este es un reporte de los boletos accesados y por accesar en en evento especifico
		$model=new ReportesVentas;
		$eventoId=isset($_POST['evento_id'])?$_POST['evento_id']:0;
		$funcionesId=isset($_POST['funcion_id'])?$_POST['funcion_id']:"TODAS";
		$this->render('Accesos',array('model'=>$model,'eventoId'=>$eventoId,'funcionesId'=>$funcionesId));
		
	}
	public function actionVentasPorPunto(){
			//if(Yii::app()->request->isAjaxRquest()){
		$eventoId=isset($_POST['eventoId'])?$_POST['eventoId']:0;
		$funcionesId=isset($_POST['funcionesId'])?$_POST['funcionesId']:0;
		$puntoVenta=isset($_POST['puntoVenta'])?$_POST['puntoVenta']:0;
				$model=new ReportesFlex();
		$this->render('ventasPorPunto',array('model'=>$model,'eventoId'=>$eventoId,'funcionesId'=>$funcionesId,'puntoVenta'=>$puntoVenta));
			//}

	}
	public function actionCancelacionesReimpresiones()
	{

		$this->perfil();
		$model=new ReportesVentas;
		$eventoId=isset($_POST['evento_id'])?$_POST['evento_id']:0;
		$funcionesId=isset($_POST['funcion_id'])?$_POST['funcion_id']:"TODAS";
		$desde=isset($_POST['desde'])?$_POST['desde']:0;
		$hasta=isset($_POST['hasta'])?$_POST['hasta']:0;
		$this->render('cancelacionesReimpresiones',array('model'=>$model,'eventoId'=>$eventoId,'funcionesId'=>$funcionesId,
		'desde'=>$desde,'hasta'=>$hasta));
	}

	public function actionConciliacionFarmatodo()
	{
			//$model= new ReportesVentas;
			$fecha=isset($_GET['fecha'])?$_GET['fecha']:0;
			$this->render('conciliacion',compact('fecha'));
			
	}
	public function actionConciliar()
	{
		
		$this->perfil();
		if (isset($_POST['desde']) and strlen($_POST['desde'])==10) {
			$model=new Reportes;
			$data=$model->conciliarFarmatodo($_FILES['archivo']['tmp_name'],$_POST['desde'],$_POST['hasta']);		
			$this->widget('bootstrap.widgets.TbGridView', array(
					'id'=>'evento-grid',
					'dataProvider'=>$data,
					'summaryText'=>'',
					'type'=>array('condensed table-hover table-striped'),
					'emptyText'=>'No se encontraron resultados',
					'columns'=>array(
							array('name'=>'id','header'=>'VentasId'),
							array('name'=>'sucursal','header'=>'Sucursal'),
							array('name'=>'monto','header'=>'Monto en archivo','htmlOptions'=>array('style'=>'text-align:right')),
							array('name'=>'total','header'=>'Total en TC','htmlOptions'=>array('style'=>'text-align:right')),
							array('value'=>'$data["total"]-$data["monto"]','header'=>'Diferencia','htmlOptions'=>array('style'=>'text-align:right')),

							array('value'=>'date("d/M/Y H:i",$data["fecha"])','header'=>'Fecha','htmlOptions'=>array('style'=>'text-align:center')),

							array(
									'value'=>'TbHtml::i("",array("class"=>$data["farmatodo"]?"fa fa-check":"fa fa-times text-error"))',
									'type'=>'raw', 'header'=>'Frmtd.'),
							array(
									'value'=>'TbHtml::i("",array("class"=>$data["taquillacero"]?"fa fa-check":"fa fa-times text-error"))',
									'type'=>'raw', 'header'=>'Tqllcr.'),
							),
			));

		//	echo "<pre>";print_r($data);echo "</pre>";
		}	

	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	 */
}
