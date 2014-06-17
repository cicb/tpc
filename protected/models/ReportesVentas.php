<?php 
class ReportesVentas extends CFormModel
{
	public function ventasWeb($value='')
	{
		
						$criteria->with[]='venta';
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
				$value['porc']=number_format(($value['boletos']*100)/max($matrix['total']['boletos'],1));
				$value['boletos']=number_format($value['boletos']);
				$value['ventas']=number_format($value['ventas']);
				$value['car serv']=number_format($value['car serv']);
			}	


			return  $matrix;
	}

	public function getReporteZonas($eventoId,$funcionesId='TODAS',$desde='',$hasta='')
	{
			$funcionCond='';

		if (isset($eventoId) and $eventoId>0)
			$evento=Evento::model()->findByPk($eventoId);
		if (isset($funcionesId) and $funcionesId>0){

			$funcionCond=sprintf(" AND FuncionesId = '%s' ",$funcionesId);
			$funcion=Funciones::model()->with('zonas')->findByPk(array('EventoId'=>$eventoId,'FuncionesId'=>$funcionesId));
			if(is_object($funcion))
				//$funciones=$funcion;
				$zonas=$funcion->zonas;
		}
		else{
				//$funciones=$evento->funciones;
				$zonas=Zonas::model()->with('funcion')->findAllByAttributes(array('EventoId'=>$eventoId),array('group'=>'t.EventoId,t.ZonasId'));
		}

		$matrixZonas=array();
		$modelo=new ReportesFlex;
		//foreach ($funciones as $funcion) {
			foreach ($zonas as $zona) {
				$aforo = Lugares::model()->count( sprintf("EventoId= '%s' %s AND ZonasId = '%s'  AND LugaresStatus<>'OFF' ", $eventoId,$funcionCond,$zona->ZonasId));
							//"EventoId = '$eventoId' AND FuncionesId = '".$zona->funcion->FuncionesId."' AND ZonasId =".$zona->ZonasId);
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
				$reporte=$modelo->getDetallesZonasCargo($eventoId,$funcionesId,$zona->ZonasId,$desde,$hasta,$cargo='NO');
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
					$temp['porcentaje']	=number_format(($temp['boletos']*100)/max($matrix['aforo']['boletos'],1));
						
					$matrix['tipos'][]=$temp;

					
				}
				// Ventas con descuento por zona
				$reporte=$modelo->getReporte($eventoId,$zona->funcion->FuncionesId,$desde,$hasta, $cargo, 'NORMAL',' AND t2.VentasMonDes>0 AND t2.ZonasId='.$zona->ZonasId, 'DescuentosDes','DescuentosDes');
				foreach ($reporte->getData() as $fila) {

					$temp=array('titulo'=>'',		'boletos'=>0,	'precio'=>0,	'importe'=>0,	'porcentaje'=>0);
					$temp['titulo']		=$fila['descuento'];
					$temp['boletos']	=$fila['cantidad'];
					$temp['precio']		=$fila['VentasCosBol'];
					$temp['total']		=$fila['total'];
					$matrix['tipos'][]	=$temp;
				}
			$matrix['por vender']['boletos']	=$matrix['aforo']['boletos'] - $matrix['subtotal']['boletos']	;
			$matrix['por vender']['importe']	=$matrix['aforo']['precio'] * $matrix['por vender']['boletos']	;
			 //$matrix['por vender']['porcentaje']	=$matrix['por vender']['boletos'] / max($matrix['aforo']['boletos'],1)	;
			foreach ($matrix as $key=>$fila) {
				if ($key!="tipos") {
						$matrix[$key]['porcentaje']=number_format($fila['boletos']*100/max($matrix['aforo']['boletos'],1),0);					
				}	

			}
			//echo "<pre>";print_r($matrix);echo "</pre>";

			$this->formateoNumerico($matrix,array('boletos','importe','precio'));
			$this->formateoNumerico($matrix['tipos'],array('boletos','importe','precio'));
			$zone['datos']=$matrix;
			$matrixZonas[]=$zone;

			}

		//}
		return array('zonas'=>$matrixZonas);
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

	public function getResumenEvento($eventoId,$funcionId='TODAS',$desde=0,$hasta=0)
	{
			$modelo=new ReportesFlex;
			$funcion="";
			if ($funcionId>0) {
					$funcion=sprintf(" AND FuncionesId = '%s' ",$funcionId);
			}
			$aforo = Lugares::model()->count(sprintf("EventoId = '%s' AND LugaresStatus<>'OFF'  %s",$eventoId,$funcion) );
			$porvender = Lugares::model()->count(sprintf("EventoId = '%s' AND LugaresStatus='TRUE'  %s",$eventoId,$funcion) );
			$vendidas = Lugares::model()->count(sprintf("EventoId = '%s' AND LugaresStatus IN ('RESERVADO','SELECTED','FALSE')  %s",$eventoId,$funcion) );
			//$vendidas = Ventaslevel1::model()->with(
					//array(
							//'venta'=> array('having'=>"VentasSta NOT LIKE 'CANCELADO' ")
					//)
				//)->count(sprintf("EventoId = '%s' %s ",$eventoId,$funcion) );
			//$porvender=$aforo-$vendidas;
			$matrix=array(
			'aforo'       => array('titulo' => 'Aforo','boletos'         => $aforo,'importe'     => 0,'porcentaje' => 100),
			'por vender'  => array('titulo' => 'Por vender','boletos'    => $porvender,'importe' => 0,'porcentaje' => $porvender/max($aforo,1)),
			'cortesia'    => array('titulo' => 'Cortesías','boletos'     => 0,'importe'          => 0,'porcentaje' => 0),
			'boleto duro' => array('titulo' => 'Boletos duros','boletos' => 0,'importe'          => 0,'porcentaje' => 0),
			'normal'      => array('titulo' => 'Ventas','boletos'        => 0,'importe'          => 0,'porcentaje' => 0),
			'total'       => array('titulo' => 'Total','boletos'         => 0,'importe'          => 0,'porcentaje' => 0),
	);
			//$matrix['por vender']['importe'] = Lugares::model()->count(sprintf("EventoId = '%s' AND LugaresStatus='TRUE'  %s",$eventoId,$funcion) );
			$model=new Ventas;
			$matrix['aforo']['importe']=$model->getDbConnection()->createCommand(sprintf("
					SELECT SUM(ZonasCosBol) as ventas FROM lugares as t
					INNER JOIN zonas as t2 
						ON t.EventoId     = t2.EventoId
						AND t.FuncionesId = t2.FuncionesId
						AND t.ZonasId     = t2.ZonasId
					WHERE t.EventoId      = %d and t.LugaresStatus<>'OFF'
					GROUP BY t.EventoId;",$eventoId))->queryScalar();
			$matrix['por vender']['importe']=$model->getDbConnection()->createCommand(sprintf("
					SELECT SUM(ZonasCosBol) as ventas FROM lugares as t
					INNER JOIN zonas as t2 
						ON t.EventoId     = t2.EventoId
						AND t.FuncionesId = t2.FuncionesId
						AND t.ZonasId     = t2.ZonasId
					WHERE t.EventoId      = %d and t.LugaresStatus='TRUE'
					GROUP BY t.EventoId;",$eventoId))->queryScalar();

			//$matrix['por vender']['importe']=$matrix['aforo']['importe']-$model->getDbConnection()->createCommand(sprintf("
					//SELECT sum(VentasCosBol-VentasMonDes) as ventas FROM ventaslevel1 as t
					//INNER JOIN zonas as t2 
						//ON t.EventoId                     = t2.EventoId
						//AND t.FuncionesId                 = t2.FuncionesId
						//AND t.ZonasId                     = t2.ZonasId
					//INNER JOIN ventas as t3 ON t.VentasId = t3.VentasId
					//WHERE t.EventoId                      = %d
					   //AND t3.VentasSta <> 'CANCELADO' AND  t.VentasSta<>'CANCELADO'
					//GROUP BY t.EventoId;",$eventoId))->queryScalar();
			$reporte=$modelo->getReporte($eventoId,$funcionId,$desde,$hasta,false, 'NORMAL,CORTESIA,BOLETO DURO','', 'VentasBolTip');
			if (is_object($reporte)) {
					foreach ($reporte->getData() as $fila) {
							$index=strtolower($fila['VentasBolTip']);
							$matrix[$index]=array('boleto'=>0,'titulo'=>$index, 'importe'=>0,'porcentaje'=>0);
							$matrix['total']['boletos']+=$matrix[$index]['boletos']=$fila['cantidad'];
							$matrix['total']['importe']+=$matrix[$index]['importe']=$fila['total'];
					}
			}	
			foreach ($matrix as &$fila) {
				$fila['porcentaje']=number_format($fila['boletos']*100/max($aforo,1),0);
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

			$matrix['promedio acumulado']['boletos']=number_format($acumulado['boletos'],0);
			$matrix['promedio acumulado']['importe']=number_format($acumulado['importe'],0);
			$matrix['promedio semana']['boletos']=number_format($usemana['boletos'],0);
			$matrix['promedio semana']['importe']=number_format($usemana['importe'],0);
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


	public function getUltimasVentas($eventoId,$funcionesId="TODAS")
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
					WHEN DATE_SUB(curdate(), INTERVAL 2 DAY) THEN 'antier'
					WHEN DATE_SUB(curdate(), INTERVAL 1 DAY) THEN 'ayer'
					WHEN CURDATE() THEN 'hoy'
					END  AS dia " );

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
				$criteria=new CDbCriteria;
				$criteria->with=array(
						'evento'=>array('joinType'=>'INNER JOIN'),
						'funcion'=>array('joinType'=>'INNER JOIN'),
						'zona'=>array('joinType'=>'INNER JOIN'),
						'subzona'=>array('joinType'=>'INNER JOIN'),
						'fila'=>array('joinType'=>'INNER JOIN'),
						'lugar'=>array('joinType'=>'INNER JOIN')
				);
				switch ($tipo) {
					case 'venta':
						// Cuando este buscando 
						$criteria->with[]='acceso';
						$criteria->with[]='venta';
						$criteria->addSearchCondition("VentasNumRef ", $ref);
						break;
					
					case 'reimpresion':
							$criteria->with[]='reimpresion';
							$criteria->with[]='venta';
							$criteria->with[]='acceso';
							$criteria->addSearchCondition("reimpresion.LugaresNumBol", $ref,true,'OR');
							break;
					case 'boleto':
							$criteria->with[]='acceso';
							$criteria->with[]='venta';
							$criteria->addSearchCondition("t.LugaresNumBol", $ref, true,'OR');
							break;	
					case 'reservado':
							$criteria->addCondition("LENGTH(tempLugaresNumRef)>1");
							$criteria->addSearchCondition("tempLugaresNumRef", $ref);
							return new CActiveDataProvider('Templugares',array(
									'criteria'=>$criteria,
									'pagination'=>array('pageSize'=>20),
							));
							break;

				}
				return new CActiveDataProvider('Ventaslevel1',array(
						'criteria'=>$criteria,
						'pagination'=>array('pageSize'=>20),
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
					inner join ventaslevel1 ON ventas.VentasId=ventaslevel1.VentasId
					inner join lugares on lugares.EventoId=ventaslevel1.EventoId and lugares.FuncionesId=ventaslevel1.FuncionesId and lugares.ZonasId=ventaslevel1.ZonasId and lugares.SubzonaId=ventaslevel1.SubzonaId and lugares.FilasId=ventaslevel1.FilasId and lugares.LugaresId=ventaslevel1.LugaresId
					inner join evento on evento.EventoId=ventaslevel1.EventoId
					inner join funciones on funciones.EventoId=ventaslevel1.EventoId and funciones.FuncionesId=ventaslevel1.FuncionesId
					inner join zonas on zonas.EventoId=ventaslevel1.EventoId and zonas.FuncionesId=ventaslevel1.FuncionesId and zonas.ZonasId=ventaslevel1.ZonasId
					inner join subzona on subzona.EventoId=ventaslevel1.EventoId and subzona.FuncionesId=ventaslevel1.FuncionesId and subzona.ZonasId=ventaslevel1.ZonasId and subzona.SubzonaId=ventaslevel1.SubzonaId
					inner join filas on filas.EventoId=ventaslevel1.EventoId and filas.FuncionesId=ventaslevel1.FuncionesId and filas.ZonasId=ventaslevel1.ZonasId and filas.SubzonaId=ventaslevel1.SubzonaId and filas.FilasId=ventaslevel1.FilasId
					inner join puntosventa on puntosventa.PuntosVentaId=ventas.PuntosVentaId
					where tempLugaresNumRef like '%$ref%' GROUP BY Asiento" ;  
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
					where ventas.VentasNumRef like  '%$ref%'
					GROUP BY Asiento";
			}
		return new CSqlDataProvider($query, array(
							'pagination'=>false,
					));

	}
	public function getVentas($desde,$hasta,$criterio=false)
	{
			//if ($desde and $hasta 
			//and preg_match("(\d{4}-\d{2}-\d{2})",$desde)==1 
			//and preg_match("(\d{4}-\d{2}-\d{2})",$hasta)==1){
			if ($criterio){
				   if(is_array($criterio)) {
					$criteria=new CDbCriteria($criterio);
					$criterio=$criteria->toArray();
				   }
				   if(is_object($criterio))
						   $criterio=$criterio->toArray();		
				   if (isset($criterio['select']) and is_array($criterio['select'])) 
						   $criterio['select']=implode(',',$criterio['campos']);
					if (isset($criterio['condition']) and is_array($criterio['condition'])) 
							$criterio['condition']=implode(',',$criterio['condicion']);
					if (isset($criterio['group']) and is_array($criterio['group'])) 
							$criterio['group']=implode(',',$criterio['group']);	
					if (isset($criterio['order']) and is_array($criterio['order'])) 
							$criterio['order']=implode(',',$criterio['order']);
			}else{
					$criterio=array('select'=>'','condition'=>'','order'=>'PuntosventaNom','group'=>'PuntosventaNom');
			}	
			$criterio['select']=strlen($criterio['select'])>1?','.$criterio['select']:'';
			$criterio['condition']=strlen($criterio['condition'])>0?$criterio['condition']:'1';
			$criterio['order']=strlen($criterio['order'])>0?$criterio['order']:'PuntosventaNom';
			$criterio['group']=strlen($criterio['group'])>0?$criterio['group']:'PuntosventaNom';
			$query=sprintf("SELECT t.PuntosventaId as id,
					PuntosventaNom,
					SUM(t1.VentasCosBol+t1.VentasCarSer) as importe,
					COUNT(*) as boletos,
					COUNT(distinct t.VentasId) as ventas,
					MAX(VentasFecHor) as ultimo
					%s
					FROM ventas AS t
					INNER JOIN ventaslevel1 as t1 ON t.VentasId=t1.VentasId 
					INNER JOIN puntosventa  as t2 ON t2.PuntosventaId=t.PuntosVentaId
					WHERE DATE(t.VentasFecHor) BETWEEN '$desde' AND '$hasta'
					AND VentasCosBol>10 
					AND t.VentasSta NOT LIKE 'CANCELADO' AND t1.VentasSta NOT LIKE 'CANCELADO'
					AND  %s 
					GROUP BY %s ORDER BY %s ",$criterio['select'],$criterio['condition'],$criterio['group'],$criterio['order']);
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
	public function getVentasFarmatodo($desde,$hasta,$turno='ambos')
	{
			return	$this->getVentas($desde,$hasta,array('condition'=>"VentasSec like 'FARMATODO'"));
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

	public function getAccesosPorZonas($eventoId,$funcionesId="TODAS")
	{
			$funcion="";
			if ($funcionesId>0) {
					$funcion=sprintf(" AND t.FuncionesId = '%s' ",$funcionesId);
			}
			$query=sprintf("
					SELECT 
					t.ZonasId as id ,t1.ZonasAli,
					COUNT(t.LugaresId)-COUNT(BoletoNum) as Pendientes,
					COUNT(BoletoNum) as Registrados
						FROM
						ventaslevel1 as t
						INNER JOIN
								zonas as t1 ON t.EventoId = t1.EventoId 
								AND t.FuncionesId = t1.FuncionesId 
								AND t.ZonasId = t1.ZonasId
						LEFT JOIN
								acceso as t2 
								ON t2.BoletoNum = t.LugaresNumBol
						WHERE
						t.EventoId = '%d'
						AND t.VentasSta NOT LIKE 'CANCELADO' 					   
						%s
						GROUP BY t.EventoId , t.FuncionesId , t.ZonasId
						",$eventoId,$funcion);
			return new CSqlDataProvider($query, array(
					'pagination'=>false,
					));
	}

	public function getAccesosPorPuertas($eventoId,$funcionesId="TODAS")
	{
			$funcion="";
			if ($funcionesId>0) {
					$funcion=sprintf(" AND t.FuncionesId = '%s' ",$funcionesId);
			}
			$query=sprintf("
					SELECT 
					t1.idCatTerminal as id ,t1.CatTerminalNom,
					COUNT(t.LugaresId)-COUNT(BoletoNum) as Pendientes,
					COUNT(BoletoNum) as Registrados
						FROM
						ventaslevel1 as t
						INNER JOIN	acceso as t2 
								ON t2.BoletoNum = t.LugaresNumBol
						INNER JOIN	catterminal as t1 
								ON t1.idCatTerminal=t2.IdTerminal
						WHERE
						t.EventoId = '%d'
						AND t.VentasSta NOT LIKE 'CANCELADO' 					   
						%s
						GROUP BY t1.idCatTerminal
						",$eventoId,$funcion);
			return new CSqlDataProvider($query, array(
					'pagination'=>false,
					));
	}

		public function getCancelacionesReimpresiones($eventoId,$funcionesId="TODAS", $desde=0,$hasta=0)
		{
				$criteria=new CDbCriteria;
				$criteria->addCondition("t.VentasSta like 'CANCELADO'");
				$criteria->addCondition("t.EventoId=:evento ");
				$funcion="";
				if ($funcionesId>0) {
					$funcion=sprintf("t.FuncionesId = %s ",$funcionesId);
					//$criteria->addCondition($funcion);
				}
				$criteria->params=array(':evento'=>$eventoId);
				return new CActiveDataProvider('Ventaslevel1',array(
						'criteria'=>$criteria,
								//'with'=>array('ventas')
						));

		}
	public function getCancelacionesYReimpresiones($eventoId,$funcionesId, $zonasId,$subzonaId,$filasId,$lugaresId)
	{
			//$rango=$funcion=" AND 1";
			//if ($funcionesId>0) {
						//$funcion=sprintf(" AND t.FuncionesId = %s ",$funcionesId);
				//}
			//if ($desde and $hasta 
			//and preg_match("(\d{4}-\d{2}-\d{2})",$desde)==1 
			//and preg_match("(\d{4}-\d{2}-\d{2})",$hasta)==1){
					//$rango=sprintf(" AND VentasFecHor BETWEEN '%s' and '%s' ",$desde,$hasta);
			//}
			$sql=sprintf("(SELECT  t1.VentasId, t1.VentasSta, t2.UsuariosNom, ReimpresionesFecHor as fecha, 'REIMPRESION' as tipo, 
				t1.LugaresNumBol, t3.PuntosventaId, LogReimpPunVenId as pv,
				CONCAT(t.EventoId,t.FuncionesId,t.ZonasId,t.SubzonaId,t.FilasId,t.LugaresId) as boleto,   
				'' as CancelFecHor,CancelUsuarioId, '' as Cancelo,
				t.LugaresNumBol as NumBol, PuntosventaNom as punto
				FROM reimpresiones as t
					INNER JOIN ventaslevel1 as t1 on t1.EventoId=t.EventoId
						AND t1.FuncionesId=t.FuncionesId
						AND t1.ZonasId=t.ZonasId
						AND t1.SubzonaId=t.SubzonaId
						AND t1.FilasId=t.FilasId
						AND t1.LugaresId=t.LugaresId
					LEFT JOIN logreimp as t5 on t5.EventoId=t.EventoId
						AND t5.FuncionesId=t.FuncionesId
						AND t5.ZonasId=t.ZonasId
						AND t5.SubzonaId=t.SubzonaId
						AND t5.FilasId=t.FilasId
						AND t5.LugaresId=t.LugaresId
				INNER JOIN ventas 		as	t3 on t3.VentasId=t1.VentasId
				LEFT JOIN usuarios 	as	t2 on t2.UsuariosId=t.UsuarioId
				LEFT JOIN puntosventa as t4 ON t4.PuntosventaId=LogReimpPunVenId
				WHERE t.EventoId=%d and  t.FuncionesId=%d and t.ZonasId=%d and t.SubzonaId=%d
				AND t.FilasId=%d AND t.LugaresId=%d
		) UNION(
				SELECT t.VentasId, t.VentasSta, t5.UsuariosNom, t2.VentasFecHor as fecha, 'VENTA' as tipo,
				t.LugaresNumBol, t2.PuntosventaId, t2.PuntosventaId as pv,
				CONCAT(t.EventoId,t.FuncionesId,t.ZonasId,t.SubzonaId,t.FilasId,t.LugaresId) as boleto,   
				CancelFecHor,CancelUsuarioId, t3.UsuariosNom as Cancelo,
				t.LugaresNumBol as NumBol, PuntosventaNom
				FROM ventaslevel1 as  t 
				INNER JOIN ventas as t2	ON t2.VentasId=t.VentasId
				LEFT JOIN usuarios 	as t5 ON t5.UsuariosId=t2.UsuariosId
				LEFT JOIN usuarios 	as	t3 on t3.UsuariosId=t.CancelUsuarioId
				LEFT JOIN puntosventa as t4 ON t4.PuntosventaId=t2.PuntosventaId
				WHERE  t.EventoId=%d and  t.FuncionesId=%d and t.ZonasId=%d and t.SubzonaId=%d
				AND t.FilasId=%d AND t.LugaresId=%d
		)
		ORDER BY  boleto,VentasId,fecha",$eventoId,$funcionesId, $zonasId,$subzonaId,$filasId,$lugaresId,
		$eventoId,$funcionesId, $zonasId,$subzonaId,$filasId,$lugaresId
);
			return new CSqlDataProvider($sql, array(
					'pagination'=>false,
					'keyField'=>'VentasId'));
	}

		public function getHistoricoReimpresiones($eventoId, $funcionesId, $zonasId,$subzonaId, $filasId, $lugaresId)
		{
				$rps=Reimpresiones::model()->with(
						array('usuario','log',))->findAllByAttributes(
								array(
										'EventoId'=>$eventoId,
										'FuncionesId'=>$funcionesId,
										'ZonasId'=>$zonasId,
										'SubzonaId'=>$subzonaId,
										'FilasId'=>$filasId,
										'LugaresId'=>$lugaresId,
				));
				return $rps;
		}
	public function getAnomalos($eventoId,$funcionesId="TODAS", $desde=0,$hasta=0)
	{
			$rango=$funcion=" AND 1";
			if ($funcionesId>0) {
						$funcion=sprintf(" AND t.FuncionesId = %s ",$funcionesId);
				}
			if ($desde and $hasta 
			and preg_match("(\d{4}-\d{2}-\d{2})",$desde)==1 
			and preg_match("(\d{4}-\d{2}-\d{2})",$hasta)==1){
					$rango=sprintf(" AND VentasFecHor BETWEEN '%s' and '%s' ",$desde,$hasta);
			}
			$sql=sprintf("
					SELECT CONCAT_WS('-',t.EventoId,t.FuncionesId,t.ZonasId,t.SubzonaId,t.FilasId,t.LugaresId) as boleto, 
					ZonasAli,t.SubzonaId, FilasAli, LugaresLug, t.VentasId,CancelUsuarioId, t2.VentasFecHor,
					t.VentasSta,SUBSTRING_INDEX(VentasCon,'R',-1) as reimpresiones,
					VentasCon, t.LugaresNumBol	
					FROM ventaslevel1 as  t 
				INNER JOIN zonas as t5 ON 	t5.EventoId=t.EventoId
						AND t5.FuncionesId=t.FuncionesId
						AND t5.ZonasId=t.ZonasId
				INNER JOIN filas as t4 ON 	t4.EventoId=t.EventoId
						AND t4.FuncionesId=t.FuncionesId
						AND t4.ZonasId=t.ZonasId
						AND t4.SubzonaId=t.SubzonaId
						AND t4.FilasId=t.FilasId
				INNER JOIN lugares as t3 ON 	t3.EventoId=t.EventoId
						AND t3.FuncionesId=t.FuncionesId
						AND t3.ZonasId=t.ZonasId
						AND t3.SubzonaId=t.SubzonaId
						AND t3.FilasId=t.FilasId
						AND t3.LugaresId=t.LugaresId
				INNER JOIN ventas 		as	t2	ON	t2.VentasId=t.VentasId
				WHERE   t.EventoId=%d and (t.VentasSta='CANCELADO' OR VentasCon rlike '.*[R][0-9][0-9]*$')
				%s %s 
				ORDER BY boleto
				 ",$eventoId,$funcion,$rango);	
			return new CSqlDataProvider($sql,array('pagination'=>false,	'keyField'=>'VentasId'));
	}

}
 ?>
