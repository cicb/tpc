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
}
?>
