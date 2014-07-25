<?php 

class Servicios extends CFormModel{

	public $referencia;
	public $pv;

	public function Servicios($referencia,$pv)
	{
		$this->referencia=$referencia;
		$this->pv=$pv;

	}

    public function validarEntrada($referencia)
    {   
		#Valida que en referencia entrada sea una referencia o un numero de referencia valido
    	if (!$referencia OR empty($referencia)) {
    	    throw new Exception("La cadena esta vacía.", 100);
    	}                     
    	if (!is_string($referencia) ){
    		throw new Exception("Entrada no es una cadena", 101);
    	}
    	if (strlen($referencia)!=16){
    		throw new Exception("Numero invalido de caracteres ", 102);
    	} 
    	if (!is_numeric(substr($referencia,0,6))){
    		throw new Exception("Formato de cadena inválido", 103);
    	}
    	return $referencia;
    }


        public function validarEnBD()
    {
    	$referencia=$this->referencia;
    	$pv=$this->pv;
    	# Valida que el referencia de la referencia se encuentre en la base de datos 
    	$criteria=new CDbCriteria;
    	$criteria->compare("tempLugaresNumRef",$referencia);
    	$criteria->compare("TempLugaresSta",'SELECTED'); //(Desactivado por prueba)
    	$criteria->compare("PuntosventaId",$pv); //Compara que sean mis boletos
    	// $criteria->compare("UsuariosId",2);//Compara que los lugares sean de Farmatodo
    	$tlugares= Templugares::model()->findAll($criteria);
    	$tmps=array();
    	foreach ($tlugares as $lugar) {
    		$tmps[]=$lugar->getAttributes();
    	}
    	return $tmps;
    }

    public function validarNumeroLugares($referencia, $numeroLugares)
    {
    	$numeroRef=substr($referencia,-2);
    	#Toma los dos últimos digitos de la referencia que deberian ser numericos
    	if ($numeroLugares==0) {
    		throw new Exception("No hay reservaciones con esos datos", 201);    		
    	}
    	return (int)$numeroLugares==(int)$numeroRef;
    }

    public function validacionesVenta($referencia,$pv)
    {
    	# Lleva a cabo todas las validaciones necesarias antes de insertar una venta
    	try {
    		$referencia=$this->validarEntrada($referencia);
    		# Valida que el punto de venta sea un valor válido
    		if (!is_numeric($pv) or $pv<0) {
    			throw new Exception("El punto de venta '$pv' no es válido", 104);
    			$this->registrarError($e);

    			return false;
    		}
    		$lugares=$this->validarEnBD($referencia,$pv);
    		#Le envia la referencia y los lugares que encontro.
    		if ($this->validarNumeroLugares($referencia,sizeof($lugares))){
    			return $lugares;
    		}
    		else{
    			throw new Exception("Existen inconsistencias entre el numero de boletos encontrados.", 202);
    			return false;
    		}			
    	} catch (Exception $e) {
    		$this->registrarError($e);
    		throw new Exception("No se ha podido validar la integridad de la referencia", 200);
    		return false;
    	}
    	#Validación de formato
    }
    
    public function registrarVenta()
    {
    	$referencia=$this->referencia;
    	$pv=$this->pv;
    	try {
    		$lugares=$this->validacionesVenta($referencia,$pv);
    		$numeroLugares=sizeof($lugares);
    		
    	} catch (Exception $e) {
    		   $this->registrarError($e); 
    		   return $e->getCode()	;
    	}
    	$venta=new Ventas;
    	$venta->PuntosventaId=$pv;
    	$venta->VentasSec="FARMATODO";
    	$venta->TempLugaresTipUsr='usuarios';
    	$venta->UsuariosId=2;
    	$venta->VentasSta='FIN';
    	$venta->VentasMonMetEnt=0;
    	$venta->VentasTip='EFECTIVO';
    	$venta->VentasNumRef=$referencia;
    	/*  
    	* COMIENZA LA TRANSACCION
    	*/
    	$transaction = Yii::app()->db->beginTransaction();
    	try {
    		if ($venta->save(false)) {
    			# Si la venta se pudo realizar
    			### !!! SE INSERTAN LOS VENTASLEVEL1 !!!
    				$query=" INSERT INTO ventaslevel1 (
    					SELECT '%s' AS VentasId, 
							t1.EventoId,  
							t1.FuncionesId,
						    t1.ZonasId, 
						    t1.SubzonaId,
						    t1.FilasId,  
						    t1.LugaresId,
						    t1.DescuentosId,  
						    IFNULL(t2.VentasCosBolDes,0)
						    					AS VentasMonDes,
	    					'NORMAL' 			AS VentasBolTip,
	                        t2.VentasCosBol 	AS VentasCosBol,  
	                        t2.VentasCarSer-IFNULL(t2.VentasCarSerDes,0) 
												AS VentasCarSer,
	                        'VENDIDO' 			AS VentasSta,
	                        FLOOR(100000000000 + RAND() * (999999999999 - 100000000000)) 
    											AS LugaresNumBol,  
	                        '' 					AS VentasBolPara,
	                        CONCAT_WS('-',
	                        	CONCAT_WS('.',
	                        		t1.EventoId,t1.FuncionesId,t1.ZonasId,
	                        		t1.SubzonaId,t1.FilasId, t1.LugaresId
	                        		),
	                        	CONCAT_WS('.',MONTH(CURDATE()),DAY(CURDATE()) ),
	                        	'F%s'
	                        	) 				AS VentasCon,
	                        '0' 				AS CancelUsuarioId,
	                        '0000-00-00' 				AS CancelFecHor 
                        FROM  templugares as t1 
                        INNER JOIN preciostemplugares t2 
                        			ON (t2.EventoId=t1.EventoId)  
                        			AND (t2.FuncionesId=t1.FuncionesId)
                        			AND (t2.ZonasId=t1.ZonasId) 
                        			AND (t2.SubzonaId=t1.SubzonaId) 
                        			AND (t2.FilasId=t1.FilasId) 
                        			AND (t2.LugaresId=t1.LugaresId) 
                        			AND (t2.PuntosventaId=t1.PuntosventaId) 
                        WHERE  (tempLugaresNumRef = '%s'))";
                    	$query=sprintf($query,$venta->VentasId,$pv,$referencia);
                    	try {
                    		$ret=Yii::app()->db->createCommand($query)->execute();
                    	} catch (Exception $e) {
                    		$this->registrarError($e);
                    		throw $e;
                    		return 300;
                    	}
                    	if ($ret!=$numeroLugares ) {
                    		throw new Exception("Numero de ventaslevel1 insertados no coincide", 301);
                    		return 301;
                    	}

                    	// Pone todos los templugares en estatus de FALSE (Como vendidos)
                    	$numTemplugares=Templugares::model()->updateAll(array('TempLugaresSta'=>'FALSE'),
                    		"tempLugaresNumRef = '$referencia'");

                    	if ($numTemplugares!=$numeroLugares ) {
                    		throw new Exception("Numero de templugares actualizados con status FALSE difiere", 302);
                    		return 302;
                    	}
                    	// Pone todos los lugares en estatus de FALSE (Como vendidos)
                    	$actualizados=0;
                    	foreach ($lugares as $tmplugar) {
                    		if (is_array($tmplugar)) {

		                		Lugares::model()->updateByPk(
                    			array_slice($tmplugar,0,6),
                    			array('LugaresStatus'=>'FALSE')
                    			// "PuntosventaId= :pv",
                    			// array('pv'=>$pv)
                    			);
                    		$actualizados++;
                    		}
    
                    	}
                    	if ($actualizados!=$numeroLugares ) {
                    		throw new Exception("Numero de lugares con status FALSE difiere", 303);
                    		return 303;
                    	}
                    	// Si llega a este punto sin problemas entonces compromete la BD

    		}
    		else{
    			throw new Exception("No fue posible guardar la venta con los datos actuales", 304);

    		}
    	} catch (Exception $e) {
    		//Algo sucedio, no se compromete la base de datos, ningun dato guardado
    		$transaction->rollback();
    		$this->registrarError($e);
    		return $e->getCode();
    	}
    	$ventaslevel1=Ventaslevel1::model()->findAllByAttributes(
    		array('VentasId'=>$venta->VentasId,'VentasSta'=>'VENDIDO' ));
    	if (sizeof($ventaslevel1)!=sizeof($lugares)) {
    		#Si el numero de ventaslevel1 es distinto que el numero de templugares seleccionados en primer lugar
    		#Entonces hubo un error 
    		$transaction->rollback();
    		$this->registrarError(new Exception("No se paso la prueba de integridad en el registro de ventas", 305));
    		return 305;
    	}
    	else{
    	/*Verifica que los numero de boletos generados sean unicos
    	*/
    		// foreach ($ventaslevel1 as $vl1 ) {
    		// 	if (is_object($vl1)) {
    		// 		# code...
    		// 		$vt1->LugaresNumBol=$this->generarCodigoBarras();
    		// 		$vl1->save(false);
    		// 	}
    		// }
    		$transaction->commit();
    		return array('venta'=>$venta,'ventaslevel1'=>$ventaslevel1);
    		return 1000;
    	}
    }

    // public function generarCodigoBarras($codigo=0,$intentos=0)
    // {
    // 	# Genera un codigo  de barras aleatorio de EAN 12 
    // 	// if (!is_null($codigo)) {
    // 		$unico=Ventaslevel1::model()->count("LugaresNumBol = '$codigo' ");
    // 		if ($unico==0) {
    // 			# Si no existe ese codigo entonces es UNICO
    // 			return $codigo;
    // 		}    			
    // 	// }
    // 		return $this->generarCodigoBarras(mt_rand(100000000000,999999999999),$intentos+1);    		
    // 	}


   public function registrarError($error)
   {
   	$errorpath="/tmp/error.log";
   	if (file_exists($errorpath) and filesize($errorpath)>(1024*100)) {
   		$fp = fopen($errorpath, "r+");
// clear content to 0 bits
   		ftruncate($fp, 0);
//close file
   		fclose($fp);
   	}   	
   	error_log(
   		sprintf("(%s)| R:%s | E%s : %s \n",date("d.M.y H:i:s"),
   			$this->referencia,$error->getCode(),$error->getMessage()),
   		3, $errorpath);
   	return true;
   }

    
}

?>