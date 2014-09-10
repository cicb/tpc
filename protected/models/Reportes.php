<?php 

class Reportes extends CFormModel{

		public static function findAll($criteria=null)
		{
				//$criteria=is_null($criteria)?new CDbCriteria:$criteria;
				$query="";

		}


		public function conciliarFarmatodo($rutaArchivo,$desde=0,$hasta=0)
		{
				$data=array();
				if (($gestor = fopen($rutaArchivo, "r")) !== FALSE) {
						while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
								if ($datos[0]==1) {
										// Si se trata de un registro se incluye en la matriz de data
										$data[]=array(
												'sucursal'=>$datos[1],
												'fecha'=>strtotime($datos[2]." ".$datos[3]),
												'clave'=>substr($datos[4],0,16),
												'monto'=>(int)$datos[6],
												'total'=>0,
												'farmatodo'=>true,
												'taquillacero'=>false,
										);

								}	
						}
						fclose($gestor);
				}
				$rango='1';
				$matrix=array();
				if ($desde and $hasta 
						and preg_match("(\d{4}-\d{2}-\d{2})",$desde)==1 
						and preg_match("(\d{4}-\d{2}-\d{2})",$hasta)==1){
								$rango=sprintf(" VentasFecHor BETWEEN '%s' and '%s' ",$desde,$hasta);
						}
				$criteria=new CDbCriteria;
				$criteria->addCondition($rango);
				$criteria->addCondition("VentasSta<>'CANCELADO'");
				$criteria->addCondition("UsuariosId=2");
				$criteria->order="t.VentasId";
				$ventas=Ventas::model()->with(
						'total','puntoventa')->findAll($criteria);
				foreach ($ventas as $venta) {
						$matrix[$venta->VentasId]=array(
								'id'=>$venta->VentasId,
								'sucursal'=>$venta->puntoventa->PuntosventaNom,
								'fecha'=>strtotime($venta->VentasFecHor),
								'clave'=>$venta->VentasNumRef,
								'monto'=>0,
								'total'=>$venta->total,
								'farmatodo'=>false,
								'taquillacero'=>true,
						);
				}				

				foreach ($data	as $i=>$fila) {
						$venta=Ventas::model()->with('total')->findByAttributes(array('VentasNumRef'=>$fila['clave']));
						if (is_object($venta)) {
								$data[$i]['total']=$venta->total;
								$data[$i]['taquillacero']=true;
								$data[$i]['id']=$venta->VentasId;
								$matrix[$venta->VentasId]=$data[$i];
						}	
						else{
								$$data[$i]['id']=mktime();
								$matrix[]=$data[$i];
						}
				}
				return new CArrayDataProvider(array_values($matrix),array('pagination'=>false));
		}

		public function historial($numeroBoleto)
		{
			// $criteria=new CDbCriteria;
			// $criteria->addCondition('');
			// $BoletosValidos=null;
			// $matrix=Ventaslevel1::model()
			return  new CSqlDataProvider("
					SELECT * FROM impresiones where NumBol='$numeroBoleto' or LugaresNumBol='$numeroBoleto' 
				", array(
					'pagination'=>false,
					'keyField'=>'VentasId'));
		}
			public function historicoPorBoleto($numerosBoleto)
	{
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
				WHERE t.LugaresNumBol='%s'
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
				WHERE  t.LugaresNumBol='%s'
		)
		ORDER BY  boleto,VentasId,fecha",$numerosBoleto,$numerosBoleto
);
			return new CSqlDataProvider($sql, array(
					'pagination'=>false,
					'keyField'=>'VentasId'));
	}
}
?>
