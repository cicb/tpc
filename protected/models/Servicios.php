<?php 

class Servicios extends CFormModel{

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


        public function validarEnBD($referencia,$pv)
    {
    	# Valida que el referencia de la referencia se encuentre en la base de datos 
    	$criteria=new CDbCriteria;
    	$criteria->compare("tempLugaresNumRef",$referencia);
    	// $criteria->compare("TempLugaresSta",'SELECTED'); //(Desactivado por prueba)
    	$criteria->compare("PuntosventaId",$pv); //Compara que sean mis boletos
    	$criteria->compare("UsuariosId",2);//Compara que los lugares sean de Farmatodo
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
    	$numeroBd=$numeroLugares; 
    	if ($numeroBd==0) {
    		throw new Exception("No hay reservaciones con esos datos", 201);    		
    	}
    	return (int)$numeroBd==(int)$numeroRef;
    }

    public function validacionesVenta($referencia,$pv)
    {
    	# Lleva a cabo todas las validaciones necesarias antes de insertar una venta
    	try {
    		$referencia=$this->validarEntrada($referencia);
    		# Valida que el punto de venta sea un valor válido
    		if (is_numeric($pv) and $pv>0) {
    			throw new Exception("El punto de venta no es válido", 1);
    			return false;
    		}
    		$lugares=$this->validarEnBD($referencia,$pv);
    		#Le envia la referencia y los lugares que encontro.
    		if $this->validarNumeroLugares($referencia,sizeof($lugares)){
    			return $lugares;
    		}
    		else{
    			throw new Exception("Existen inconsistencias entre el numero de boletos encontrados.", 202);
    			return false;
    		}			
    	} catch (Exception $e) {
    		throw new Exception("No se ha podido validar la integridad de la referencia", 200);
    		return false;
    	}
    	#Validación de formato
    }
    
    public function registrarVenta($referencia,$pv)
    {
    	try {
    		$lugares=$this->validacionesVenta($referencia,$pv);
    		$numeroLugares=sizeof($lugares);
    		
    	} catch (Exception $e) {
    		   $this->registrarError($e->getMessage(), $e->getCode()); 
    		   /* 
    		   *	<<<<<<<<<<<<Sale con codigo 2 >>>>>>>>>>>>
    		   */
    		   return 2	;

    	}
    	$venta=new Venta;
    	$venta->PuntosventaId=$pv;
    	$venta->VentasSec="FARMATODO";
    	$venta->TempLugaresTipUsr='usuarios';
    	$venta->UsuariosId=2;
    	$venta->VentasSta='FIN';
    	$venta->VentasMonMetEnt=0;
    	$venta->VentasTip='EFECTIVO';
    	$venta->VentasNumRef=$referencia;
    	$transaction = Yii::app()->db->beginTransaction();
    	try {
    		if ($venta->save()) {
    			# Si la venta se pudo realizar
    			### !!! SE INSERTAN LOS VENTASLEVEL1 !!!
    				$query=" INSERT INTO ventaslevel1 
    					SELECT '%s' AS VentasId, 
							t1.EventoId,  
							t1.FuncionesId,
						    t1.ZonasId, 
						    t1.SubzonaId,
						    t1.FilasId,  
						    t1.LugaresId,
						    t1.DescuentosId,  
						    t2.VentasCosBolDes AS VentasMonDes,
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
	                        '' 					AS CancelFecHor 
                        FROM  templugares as t1 
                        INNER JOIN preciostemplugares t2 
                        			ON (t2.EventoId=t1.EventoId)  
                        			AND (t2.FuncionesId=t1.FuncionesId)
                        			AND (t2.ZonasId=t1.ZonasId) 
                        			AND (t2.SubzonaId=t1.SubzonaId) 
                        			AND (t2.FilasId=t1.FilasId) 
                        			AND (t2.LugaresId=t1.LugaresId) 
                        			AND (t2.PuntosventaId=t1.PuntosventaId) 
                        WHERE  (tempLugaresNumRef = '%s')";
                    	$query=sprintf($query,$venta->VentasId,$pv,$referencia);
                    	$ret=Yii::app()->db->createCommand($query)->queryAll();
                    	if ($ret!=$numeroLugares ) {
                    		throw new Exception("Numero de ventaslevel1 insertados no coincide", 301);
                    		return 2;
                    	}

                    	// Pone todos los templugares en estatus de FALSE (Como vendidos)
                    	$numTemplugares=Templugares::model()->updateAll(array('TempLugaresSta'=>'FALSE'),
                    		array("tempLugaresNumRef = '$referencia'"));
                    	if ($numTemplugares!=$numeroLugares ) {
                    		throw new Exception("Numero de templugares actualizados con status FALSE difiere", 302);
                    		return 2;
                    	}
                    	// Pone todos los lugares en estatus de FALSE (Como vendidos)
                    	$actualizados=0;
                    	foreach ($lugares as $tmplugar) {
                    		$lugar=Lugares::model()->updateByPk(
                    			$tmplugar->getPrimaryKey(),
                    			array('LugaresStatus'=>'FALSE'),
                    			"PuntosventaId= :pv",
                    			array('pv'=>$pv)
                    			);
                    		$actualizados++;
                    	}
                    	if ($actualizados!=$numeroLugares ) {
                    		throw new Exception("Numero de lugares con status FALSE difiere", 303);
                    		return 2;
                    	}
                    	// Si llega a este punto sin problemas entonces compromete la BD
                    	$transaction->commit();

    		}
    	} catch (Exception $e) {
    		//Algo sucedio, no se compromete la base de datos, ningun dato guardado
    		$transaction->rollback();
    		echo $e->getMessage();
    		return 2;
    	}

    }

    public function generarCodigoBarras($codigo=null)
    {
    	# Genera un codigo  de barras aleatorio de EAN 12 
    	if (!is_null($codigo) and is_string($codigo)) {
    		$unico=Ventaslevel1::model()->count("LugaresNumBol = '$codigo' ");
    		if ($unico==0) {
    			# Si no existe ese codigo entonces es UNICO
    			return mt_rand(100000000000,999999999999);
    		}
    		else{
    			return $this->generarCodigoBarras($codigo);
    		}
    		
    	}
    	else{
    		return $this->generarCodigoBarras(mt_rand(100000000000,999999999999));
    	}
    }


   public function registrarError($msg,$codigo)
   {
   		return true;
   }

    
}

?>