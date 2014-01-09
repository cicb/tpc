<?php 
class ReportesVentas extends CFormModel
{
	public function ventasWeb($value='')
	{
		
	}

	public function getReporte($evento,$funcion="TODAS",$desde="",$hasta="", $cargo=false, $tipoBoleto='NORMAL',$where='', $group_by='puntos')
	{
		$matrix=array(
			'taquilla'				=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'taquilla descuentos'	=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'descuentos'			=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'cupones'				=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'ventas telefonicas'	=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'ventas por internet'	=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'farmatodo'				=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'taquillas secundarias'	=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'subtotal tc'			=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'subtotal ventas'		=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'boleto duro'			=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'cortesia'				=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			'total'					=>array('titulo'=>'','boletos'=>0,'ventas'=>0,'car serv'=>0,'porc'=>0),
			);
		$modelo=new ReportesFlex;

		// Ventas por taquilla
		$reporte=$modelo->getReporteTaquilla($evento,$funcion,$desde,$hasta, $cargo);
		foreach ($reporte->getData() as $fila) {
			$matrix['subtotal ventas']['boletos']	+=$matrix[$fila['puntos']]['boletos']	=$fila['cantidad'];
			$matrix['subtotal ventas']['ventas']	+=$matrix[$fila['puntos']]['ventas']	=$fila['total'];
			$matrix['subtotal ventas']['car serv']	+=$matrix[$fila['puntos']]['car serv']	=$fila['cargo'];
		}
		// Ventas con descuentos
		$reporte=$modelo->getReporte($evento,$funcion,$desde,$hasta, $cargo, 'NORMAL',' AND t2.VentasMonDes>0', 'descuento');
		foreach ($reporte->getData() as $fila) {
			$matrix['subtotal ventas']['boletos']	+=$matrix[$fila['descuento']]['boletos']	=$fila['cantidad'];
			$matrix['subtotal ventas']['ventas']	+=$matrix[$fila['descuento']]['ventas']	=$fila['total'];
			$matrix['subtotal ventas']['car serv']	+=$matrix[$fila['descuento']]['car serv']	=$fila['cargo'];
		}
		//Ventas por puntos de venta
		$reporte=$modelo->getReporte($evento,$funcion,$desde,$hasta ,$cargo=false,'NORMAL','and t3.FuncPuntosventaId<>t.PuntosventaId ');
		foreach ($reporte->getData() as $fila) {
			$matrix['subtotal tc']['boletos']	+=$matrix[$fila['puntos']]['boletos']	=$fila['cantidad'];
			$matrix['subtotal tc']['ventas']	+=$matrix[$fila['puntos']]['ventas']	=$fila['total'];
			$matrix['subtotal tc']['car serv']	+=$matrix[$fila['puntos']]['car serv']	=$fila['cargo'];
		}
		// Sumatoria de subtotales
			$matrix['subtotal ventas']['boletos']	+=$matrix['subtotal tc']['boletos']	;
			$matrix['subtotal ventas']['ventas']	+=$matrix['subtotal tc']['ventas']	;
			$matrix['subtotal ventas']['car serv']	+=$matrix['subtotal tc']['car serv'];

		$reporte=$modelo->getReporte($evento,$funcion,$desde,$hasta,$cargo,
        'CORTESIA,BOLETO DURO','','VentasBolTip');	
		foreach ($reporte->getData() as $fila) {
			$matrix['total']['boletos']		+=$matrix[strtolower($fila['VentasBolTip'])]['boletos']	=$fila['cantidad'];
			$matrix['total']['ventas']		+=$matrix[strtolower($fila['VentasBolTip'])]['ventas']	=$fila['total'];
			$matrix['total']['car serv']	+=$matrix[strtolower($fila['VentasBolTip'])]['car serv']=$fila['cargo'];        
		}
		// Sumatoria de totales
			$matrix['total']['boletos']		+=$matrix['subtotal ventas']['boletos']	;
			$matrix['total']['ventas']		+=$matrix['subtotal ventas']['ventas']	;
			$matrix['total']['car serv']	+=$matrix['subtotal ventas']['car serv'];
		//Primer Ciclo de la matrix
		foreach ($matrix as $key=>&$value) {
				$value['titulo']=ucfirst($key);
				$value['porc']=number_format(($value['boletos']*100)/max($matrix['total']['boletos'],2));
				$value['boletos']=number_format($value['boletos']);
				$value['ventas']=number_format($value['ventas']);
				$value['car serv']=number_format($value['car serv']);
			}	


			return  $matrix;
	}

	public function getReporteZonas($eventoId,$funcionId='TODAS',$desde='',$hasta='')
	{

		if (isset($eventoId) and $eventoId>0)
			$evento=Evento::model()->findByPk($eventoId);
		if (isset($funcionesId) and $funcionesId>0){
			$funcion=Funciones::model()->findByPk(array('EventoId'=>$eventoId,'FuncionesId'=>$funcionesId));
			if(is_object($funcion))
				$funciones=$funcion;
		}
		else
			$funciones=$evento->funciones;

		$zonas=array();
		$modelo=new ReportesFlex;
		foreach ($funciones as $funcion) {
			foreach ($funcion->zonas as $zona) {
				$aforo = Lugares::model()->count("EventoId = '$eventoId' AND FuncionesId = '".$funcion->FuncionesId."' AND ZonasId =".$zona->ZonasId);
				$zone=array();
				$zone['aforo']=$aforo;
				$zone['zona']=$zona->ZonasAli;
				$matrix=array(
					'aforo'			=>array('titulo'=>'Aforo',			'boletos'=>$aforo,	'precio'=>$zona->ZonasCosBol,	'importe'=>$zona->ZonasCosBol*$aforo,	'porcentaje'=>100),
					'por vender'	=>array('titulo'=>'Por Vender',		'boletos'=>0,	'precio'=>0,	'importe'=>0,	'porcentaje'=>0),
					'descuentos'	=>array('titulo'=>'Descuentos',		'boletos'=>0,	'precio'=>0,	'importe'=>0,	'porcentaje'=>0),
					'cupones'		=>array('titulo'=>'Cupones',		'boletos'=>0,	'precio'=>0,	'importe'=>0,	'porcentaje'=>0),
					'subtotal'		=>array('titulo'=>'Sub-Total',		'boletos'=>0,	'precio'=>0,	'importe'=>0,	'porcentaje'=>0),
					);
				$reporte=$modelo->getDetallesZonasCargo($eventoId,$funcionId,$zona->ZonasId,$desde,$hasta,$cargo='NO');
				//$tipos=array();
				$matrix['tipos']=array();
				foreach ($reporte->getData() as $fila) {
					//$index=$fila['VentasBolTip'].$fila['VentasCosBol'];

					$temp=array('titulo'=>'',		'boletos'=>0,	'precio'=>0,	'importe'=>0,	'porcentaje'=>0);
					$temp['precio']	=$fila['VentasCosBol'];
					$temp['titulo']	=ucfirst(strtolower($fila['VentasBolTip']));
					if (strcasecmp($temp['titulo'],'Normal')==1) {
						$temp['titulo']	='Ventas';
					}	
					$matrix['subtotal']['boletos']	+=$temp['boletos']	=$fila['cantidad'];
					$matrix['subtotal']['importe']	+=$temp['importe']	=$fila['total'];
					$temp['porcentaje']	=number_format(($temp['boletos']*100)/max($matrix['aforo']['boletos'],2));
						
					$matrix['tipos'][]=$temp;

					
				}
				// Ventas con descuento por zona
				$reporte=$modelo->getReporte($eventoId,$funcion->FuncionesId,$desde,$hasta, $cargo, 'NORMAL',' AND t2.VentasMonDes>0 AND t2.ZonasId='.$zona->ZonasId, 'DescuentosDes','DescuentosDes');
				foreach ($reporte->getData() as $fila) {

					$temp=array('titulo'=>'',		'boletos'=>0,	'precio'=>0,	'importe'=>0,	'porcentaje'=>0);
					$temp['titulo']		=$fila['descuento'];
					$temp['boletos']	=$fila['cantidad'];
					$temp['precio']		=$fila['VentasCosBol'];
					$temp['total']		=$fila['total'];
					$matrix['tipos'][]	=$temp;
				}
			$matrix['por vender']['boletos']	=$matrix['aforo']['boletos'] - $matrix['subtotal']['boletos']	;
			$matrix['por vender']['importe']	=$matrix['aforo']['importe'] - $matrix['subtotal']['importe']	;
			 //$matrix['por vender']['porcentaje']	=$matrix['por vender']['boletos'] / max($matrix['aforo']['boletos'],1)	;
			foreach ($matrix as $key=>$fila) {
				if ($key!="tipos") {
						$matrix[$key]['porcentaje']=number_format($fila['boletos']*100/max($matrix['aforo']['boletos'],1),2);					
				}	

			}
			//echo "<pre>";print_r($matrix);echo "</pre>";

			$this->formateoNumerico($matrix,array('boletos','importe','precio'));
			$this->formateoNumerico($matrix['tipos'],array('boletos','importe','precio'));
			$zone['datos']=$matrix;
			$zonas[]=$zone;

			}

		}
		return array('zonas'=>$zonas);
	}

	public function formateoNumerico(&$matrix,$cols,$decimal=0)
	{
			foreach($matrix as $index=>$fila){
					foreach ($fila as $key => $value) {
							if (in_array($key,$cols) and !is_array($value)) {
									$matrix[$index][$key]=number_format($value,$decimal);
							}
					}
		}
	}

	public function getResumenEvento($eventoId,$funcionId='TODAS',$desde,$hasta)
	{
			$modelo=new ReportesFlex;
			$funcion="";
			if ($funcionId>0) {
					$funcion=sprintf(" AND FuncionesId = '%s' ",$funcionId);
			}
			$aforo = Lugares::model()->count(sprintf("EventoId = '%s' %s",$eventoId,$funcion) );
			$vendidas = Ventaslevel1::model()->with(
					array(
							'venta'=> array('having'=>"VentasSta NOT LIKE 'CANCELADO' ")
					)
				)->count(sprintf("EventoId = '%s' %s ",$eventoId,$funcion) );
			$porvender=$aforo-$vendidas;
			$matrix=array(
			'aforo'       => array('titulo' => 'Aforo','boletos'         => $aforo,'importe'     => 0,'porcentaje' => 100),
			'por vender'  => array('titulo' => 'Por vender','boletos'    => $porvender,'importe' => 0,'porcentaje' => $porvender/max($aforo,1)),
			'cortesia'    => array('titulo' => 'Cortesias','boletos'     => 0,'importe'          => 0,'porcentaje' => 0),
			'boleto duro' => array('titulo' => 'Boletos duros','boletos' => 0,'importe'          => 0,'porcentaje' => 0),
			'normal'      => array('titulo' => 'Ventas','boletos'        => 0,'importe'          => 0,'porcentaje' => 0),
			'total'       => array('titulo' => 'Total','boletos'         => 0,'importe'          => 0,'porcentaje' => 0),
	);
			$model=new Ventas;
			$matrix['aforo']['importe']=$model->getDbConnection()->createCommand(sprintf("
					SELECT count(t.LugaresId)*ZonasCosBol as ventas FROM lugares as t
					INNER JOIN zonas as t2 
						ON t.EventoId     = t2.EventoId
						AND t.FuncionesId = t2.FuncionesId
						AND t.ZonasId     = t2.ZonasId
					WHERE t.EventoId      = %d
					GROUP BY t.EventoId;",$eventoId))->queryScalar();

			$matrix['por vender']['importe']=$matrix['aforo']['importe']-$model->getDbConnection()->createCommand(sprintf("
					SELECT sum(VentasCosBol-VentasMonDes) as ventas FROM ventaslevel1 as t
					INNER JOIN zonas as t2 
						ON t.EventoId                     = t2.EventoId
						AND t.FuncionesId                 = t2.FuncionesId
						AND t.ZonasId                     = t2.ZonasId
				    INNER JOIN ventas as t3 ON t.VentasId = t3.VentasId
					WHERE t.EventoId                      = %d AND t3.VentasSta <> 'CANCELADO' AND  t.VentasSta<>'CANCELADO'
					GROUP BY t.EventoId;",$eventoId))->queryScalar();
			$reporte=$modelo->getReporte($eventoId,$funcionId,$desde,$hasta,false, 'NORMAL,CORTESIA,BOLETO DURO','', 'VentasBolTip');
			foreach ($reporte->getData() as $fila) {
					$index=strtolower($fila['VentasBolTip']);
					$matrix[$index]=array('boleto'=>0,'importe'=>0,'porcentaje'=>0);
					$matrix['total']['boletos']+=$matrix[$index]['boletos']=$fila['cantidad'];
					$matrix['total']['importe']+=$matrix[$index]['importe']=$fila['total'];
			}
			foreach ($matrix as &$fila) {
				$fila['porcentaje']=number_format($fila['boletos']*100/max($aforo,1));
				$fila['boletos']=number_format( $fila['boletos'],0);
				$fila['importe']=number_format( $fila['importe'],0);
			}
		return $matrix;
	}

	public function getPromedios($eventoId,$funcionId="TODAS")
	{

			$matrix=array(
					'promedio acumulado' => array('titulo'=>'Promedio acumulado','boletos' => 0,'importe' => 0),
					'promedio semana'    => array('titulo'=>'Prom. Ultima semana','boletos' => 0,'importe' => 0),
			);

			$acumulado=$this->getPromedioDiario($eventoId,$funcionId);
			$usemana=$this->getPromedioDiario($eventoId,$funcionId,
					$desde=date('Y-m-d',strtotime("-1 week")),
					$hasta=date("Y-m-d"));

			$matrix['promedio acumulado']['boletos']=number_format($acumulado['boletos'],3);
			$matrix['promedio acumulado']['importe']=number_format($acumulado['importe'],3);
			$matrix['promedio semana']['boletos']=number_format($usemana['boletos'],3);
			$matrix['promedio semana']['importe']=number_format($usemana['importe'],3);
			return $matrix;	
	}

	public function getPromedioDiario($eventoId,$funcionId="TODAS",$desde=false,$hasta=false)
	{
			$funcion="";
			if ($funcionId>0) {
					$funcion=sprintf(" AND FuncionesId = '%s' ",$funcionId);
			}
			$fechas='';
			$dias="ABS(DATEDIFF(FuncionesFecIni,LEAST(DATE(FuncionesFecHor),CURDATE())))";
			if ($desde and $hasta 
					and preg_match("(\d{4}-\d{2}-\d{2})",$desde)==1 
					and preg_match("(\d{4}-\d{2}-\d{2})",$hasta)==1) {
							$fechas="AND DATE(VentasFecHor) BETWEEN '$desde' AND  '$hasta' ";
							$dias="ABS(DATEDIFF('$desde',LEAST('$hasta',CURDATE())  ))";
					}

			$promedio=Yii::app()->db->createCommand(sprintf("
					SELECT COUNT( LugaresId)/GREATEST(
									$dias,1) AS boletos,
							SUM(t2.VentasCosBol-t2.VentasMonDes)/GREATEST(
									$dias,1) AS importe
						FROM ventas AS t
						INNER JOIN ventaslevel1 AS t2 ON
							t.VentasId=t2.VentasId AND t2.EventoId='%d' %s
						INNER JOIN funciones as t3 ON 
							t2.EventoId=t3.EventoId AND t2.FuncionesId=t3.FuncionesId	
						WHERE t.VentasSta<>'CANCELADO' and  t2.VentasSta<>'CANCELADO' %s;
			",$eventoId,$funcion,$fechas))->queryRow();
			return $promedio;	
	}

	public function getDatosGraficaPorDia($eventoId, $funcionesId, $desde, $hasta){
			$model=new ReportesFlex;
			$datos=$model->graficaFechas($eventoId, $funcionesId, $desde, $hasta);
			$dias=array();
			foreach ($datos->getData() as $value) {
				$dias[]=array('dia'=>date_format(date_create($value['fecha']),'d/M'),'v'=>$value['ventas']);
			}
			return $dias;

		}


	public function getUltimasVentas($eventoId,$funcionesId="TODAS",$desde=0,$hasta=0)
	{
			$modelo=new ReportesFlex;
			$desde=date("Y-m-d",strtotime("-2 day"));
			$hasta=date("Y-m-d");
			$funcion="";
			if ($funcionesId>0) {
					$funcion=sprintf(" AND FuncionesId = '%s' ",$funcionesId);
			}

			$reporte=$modelo->getReporte($eventoId,$funcion,$desde,$hasta,$cargo=false, 
					$tipoBoleto='NORMAL,BOLETO DURO',$where='', 
					$group_by='DAYOFYEAR(VentasFecHor)',$campos=", 	CASE DATE(VentasFecHor) 
					WHEN DATE(VentasFecHor)=DATE_SUB(DATE(VentasFecHor), INTERVAL 2 DAY) THEN 'antier'
					WHEN DATE(VentasFecHor)=DATE_SUB(DATE(VentasFecHor), INTERVAL 1 DAY) THEN 'ayer'
					WHEN DATE(VentasFecHor)=CURDATE() THEN 'hoy'
					END  AS dia" );

			$matrix=array(
					'hoy' 		=> array('titulo' =>'Venta hoy','boletos'=>0,'importe'=>0 ),
					'ayer' 		=> array('titulo' =>'Venta ayer','boletos'=>0,'importe'=>0 ),
					'antier' 	=> array('titulo' =>'Venta antier','boletos'=>0,'importe'=>0 ),
			);
			foreach ($reporte->getData() as $fila) {
				$matrix[$fila['dia']]['boletos']=number_format($fila['cantidad']);
				$matrix[$fila['dia']]['importe']=number_format($fila['total']);
			}
			return $matrix;
	}

		public function  getVentasPorRef($ref,$tipo='venta' )
		{
				$filtro="	(ventaslevel1.LugaresNumBol LIKE '%$ref%')";
				if(strcasecmp($tipo,'venta')==0){
					$filtro= "(ventas.VentasNumRef LIKE '%$ref%')";
				}		
				$query = "SELECT
							'' as id,		
							  zonas.ZonasAli,
							  filas.FilasAli,
							  lugares.LugaresLug as Asiento,
							  ventaslevel1.VentasSta,
							  ventaslevel1.VentasBolTip,
							  evento.EventoNom,
							  funciones.FuncionesFecHor,
							  ventas.VentasNumRef,  ventaslevel1.LugaresNumBol as NumBol
							FROM
							 filas
							 INNER JOIN lugares ON (filas.EventoId=lugares.EventoId)
							  AND (filas.FuncionesId=lugares.FuncionesId)
							  AND (filas.ZonasId=lugares.ZonasId)
							  AND (filas.SubzonaId=lugares.SubzonaId)
							  AND (filas.FilasId=lugares.FilasId)
							 INNER JOIN zonas ON (zonas.EventoId=filas.EventoId)
							  AND (zonas.FuncionesId=filas.FuncionesId)
							  AND (zonas.ZonasId=filas.ZonasId)
							 INNER JOIN ventaslevel1 ON (lugares.EventoId=ventaslevel1.EventoId)
							  AND (lugares.FuncionesId=ventaslevel1.FuncionesId)
							  AND (lugares.ZonasId=ventaslevel1.ZonasId)
							  AND (lugares.SubzonaId=ventaslevel1.SubzonaId)
							  AND (lugares.FilasId=ventaslevel1.FilasId)
							  AND (lugares.LugaresId=ventaslevel1.LugaresId)
							 INNER JOIN evento ON (evento.EventoId=zonas.EventoId)
							 INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
							  AND (funciones.FuncionesId=zonas.FuncionesId)
							 INNER JOIN ventas ON (ventas.VentasId=ventaslevel1.VentasId)
							 WHERE   $filtro ";
				return new CSqlDataProvider($query, array(
							'pagination'=>false,
					));
		}

	public function getReservacionesFarmatodo($ref)
	{
			$count=Templugares::model()->countByAttributes(array('tempLugaresNumRef'=>$ref));
			if ($count>0) {
				$query = "select 
					ventas.ventasId as id,
					ventas.VentasNumRef,
					ventas.VentasFecHor Fecha, 
					ventas.VentasNumRef Referencia, 
					puntosventa.PuntosventaId, 
					puntosventa.PuntosventaNom Venta, 
					evento.EventoNom Evento, 
					funciones.funcionesTexto Funcion, 
					zonas.ZonasAli Zona,
					filas.FilasAli Fila, 
					lugares.LugaresLug Asiento,
					ventaslevel1.VentasSta Estatus,
					ventaslevel1.LugaresId Lug
					from templugares
					LEFT JOIN ventas ON ventas.VentasNumRef = templugares.tempLugaresNumRef
					inner join ventaslevel1 on ventas.VentasId=ventaslevel1.VentasId
					inner join lugares on lugares.EventoId=ventaslevel1.EventoId and lugares.FuncionesId=ventaslevel1.FuncionesId and lugares.ZonasId=ventaslevel1.ZonasId and lugares.SubzonaId=ventaslevel1.SubzonaId and lugares.FilasId=ventaslevel1.FilasId and lugares.LugaresId=ventaslevel1.LugaresId
					inner join evento on evento.EventoId=ventaslevel1.EventoId
					inner join funciones on funciones.EventoId=ventaslevel1.EventoId and funciones.FuncionesId=ventaslevel1.FuncionesId
					inner join zonas on zonas.EventoId=ventaslevel1.EventoId and zonas.FuncionesId=ventaslevel1.FuncionesId and zonas.ZonasId=ventaslevel1.ZonasId
					inner join subzona on subzona.EventoId=ventaslevel1.EventoId and subzona.FuncionesId=ventaslevel1.FuncionesId and subzona.ZonasId=ventaslevel1.ZonasId and subzona.SubzonaId=ventaslevel1.SubzonaId
					inner join filas on filas.EventoId=ventaslevel1.EventoId and filas.FuncionesId=ventaslevel1.FuncionesId and filas.ZonasId=ventaslevel1.ZonasId and filas.SubzonaId=ventaslevel1.SubzonaId and filas.FilasId=ventaslevel1.FilasId
					inner join puntosventa on puntosventa.PuntosVentaId=ventas.PuntosVentaId
					where tempLugaresNumRef='$ref' GROUP BY Asiento" ;  
			}
			else{
				$query ="select 
					ventas.ventasId as id,
					ventas.VentasNumRef,
					ventas.VentasFecHor Fecha, 
					ventas.VentasNumRef Referencia, 
					puntosventa.PuntosventaId, 
					puntosventa.PuntosventaNom Venta, 
					evento.EventoNom Evento, 
					funciones.funcionesTexto Funcion, 
					zonas.ZonasAli Zona,
					filas.FilasAli Fila, 
					lugares.LugaresLug Asiento,
					ventaslevel1.VentasSta Estatus,
					ventaslevel1.LugaresId Lug
					from ventas
					inner join ventaslevel1 on ventas.VentasId=ventaslevel1.VentasId
					inner join lugares on lugares.EventoId=ventaslevel1.EventoId and lugares.FuncionesId=ventaslevel1.FuncionesId and lugares.ZonasId=ventaslevel1.ZonasId and lugares.SubzonaId=ventaslevel1.SubzonaId and lugares.FilasId=ventaslevel1.FilasId and lugares.LugaresId=ventaslevel1.LugaresId
					inner join evento on evento.EventoId=ventaslevel1.EventoId
					inner join funciones on funciones.EventoId=ventaslevel1.EventoId and funciones.FuncionesId=ventaslevel1.FuncionesId
					inner join zonas on zonas.EventoId=ventaslevel1.EventoId and zonas.FuncionesId=ventaslevel1.FuncionesId and zonas.ZonasId=ventaslevel1.ZonasId
					inner join subzona on subzona.EventoId=ventaslevel1.EventoId and subzona.FuncionesId=ventaslevel1.FuncionesId and subzona.ZonasId=ventaslevel1.ZonasId and subzona.SubzonaId=ventaslevel1.SubzonaId
					inner join filas on filas.EventoId=ventaslevel1.EventoId and filas.FuncionesId=ventaslevel1.FuncionesId and filas.ZonasId=ventaslevel1.ZonasId and filas.SubzonaId=ventaslevel1.SubzonaId and filas.FilasId=ventaslevel1.FilasId
					inner join puntosventa on puntosventa.PuntosVentaId=ventas.PuntosVentaId
					where ventas.VentasNumRef = '$ref'
					GROUP BY Asiento";
			}
		return new CSqlDataProvider($query, array(
							'pagination'=>false,
					));

	}

	public function getVentasFarmatodo($desde,$hasta,$turno='ambos')
	{
		//if ($desde and $hasta 
					//and preg_match("(\d{4}-\d{2}-\d{2})",$desde)==1 
					//and preg_match("(\d{4}-\d{2}-\d{2})",$hasta)==1){
				$query="SELECT t.PuntosventaId as id,
					PuntosventaNom,
					SUM(t1.VentasCosBol+t1.VentasCarSer) as importe,
					COUNT(*) as boletos,
					COUNT(distinct t.VentasId) as ventas,
					MAX(VentasFecHor) as ultimo
				FROM ventas AS t
				INNER JOIN ventaslevel1 as t1 ON t.VentasId=t1.VentasId 
				INNER JOIN puntosventa  as t2 ON t2.PuntosventaId=t.PuntosVentaId
				WHERE t.VentasFecHor BETWEEN '$desde' AND '$hasta'
						AND VentasSec like 'FARMATODO'
				GROUP BY PuntosventaNom";
				return new CSqlDataProvider($query, array(
							'pagination'=>false,
							//'sort'=>array(
									//'puntos_venta'=>array(
											//'asc'=>'"puntosventa"."PuntosventaNom"',
											//'desc'=>'"importe" DESC'
									//)
							//)
					));
		

	}
		public function getDetalleVenta($ventaId)
		{
			 return new CActiveDataProvider('Lugares', 
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
                      INNER JOIN descuentos ON (ventaslevel1.DescuentosId = descuentos.DescuentosId)
                      INNER JOIN puntosventa ON (ventas.PuntosventaId = puntosventa.PuntosventaId)
                      INNER JOIN evento ON (funciones.EventoId = evento.EventoId)",
                  'condition'=>"ventas.VentasId = '$ventaId'",
                    'limit'=>'150'),
                    'pagination'=>false));


		}
    public function getEventosAsignados(){
        $usuarioId = Yii::app()->user->id;
        $hoy = date("Y-m-d G:i:s");
        $usrval = Usrval::model()->findAll(array('condition'=>"UsuarioId=$usuarioId AND UsrTipId=2 AND UsrSubTipId=4  AND  ((FecHorIni < '$hoy' AND FecHorFin > '$hoy ') OR FecHorIni = '0000-00-00 00:00:00' AND FecHorIni = '0000-00-00 00:00:00')"));
        $condiciones = "";
        if($usrval[0]->usrValIdRef=="TODAS"){
            
        }else{
            $condicion ="";
            foreach($usrval as $key => $evento){
                $condicion .= $evento->usrValIdRef.",";
            }
            $condiciones = " AND EventoId IN(".substr($condicion,0,-1).")";
        }
        $eventos = Evento::model()->findAll(array('condition'=>" EventoSta='ALTA'".$condiciones,'order'=>"t.EventoNom ASC"));
        return $eventos;
    }
    public function getFuncionesAsignadas($EventoId){
        $usuarioId = Yii::app()->user->id;
        $hoy = date("Y-m-d G:i:s");
        $usrval = Usrval::model()->findAll(array('condition'=>"UsuarioId=$usuarioId AND UsrTipId=2 AND UsrSubTipId=4  AND  ((FecHorIni < '$hoy ' AND FecHorFin > '$hoy ') OR FecHorIni = '0000-00-00 00:00:00' AND FecHorIni = '0000-00-00 00:00:00')"));
        $condiciones = "";
        if($usrval[0]->usrValIdRef2=="TODAS"){
            
        }else{
            $condicion ="";
            foreach($usrval as $key => $funcion){
                $condicion .= $funcion->usrValIdRef2.",";
            }
            $condiciones = " AND FuncionesId IN(".substr($condicion,0,-1).")";
        }
        $funciones = Funciones::model()->findAll(array('condition'=>" EventoId=$EventoId".$condiciones,'order'=>"t.FuncionesId ASC"));
        return $funciones;
    }
}
 ?>
