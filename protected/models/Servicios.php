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
    		
    	} catch (Exception $e) {
    		   $this->registrarError($e->getMessage(), $e->getCode()); 
    		   /* 
    		   *<<<<<<<<<<<<Sale con codigo 2 >>>>>>>>>>>>
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
							templugares.EventoId,  
							templugares.FuncionesId,
						    templugares.ZonasId, 
						    templugares.SubzonaId,
						    templugares.FilasId,  
						    templugares.LugaresId,
						    '0' AS DescuentosId,  
						    '0' AS VentasMonDes,
	    					'NORMAL' as VentasBolTip,
	                        zonas.ZonasCosBol AS VentasCosBol,  
	                        zonaslevel1.ZonasFacCarSer AS VentasCarSer,
	                        VENDIDO' AS VentasSta,
	                        'codigoBarras' AS LugaresNumBol,  
	                        '' AS VentasBolPara,
	                        'contrasena' AS VentasCon,
	                        '0' AS CancelUsuarioId,
	                        '' AS CancelFecHor 
                        FROM  zonas 
                        INNER JOIN templugares 
                        			ON (zonas.EventoId=templugares.EventoId)  
                        			AND (zonas.FuncionesId=templugares.FuncionesId)
                        			AND (zonas.ZonasId=templugares.ZonasId) 
            			INNER JOIN zonaslevel1 
            						ON (templugares.EventoId=zonaslevel1.EventoId)  
            						AND (templugares.FuncionesId=zonaslevel1.FuncionesId)
                                    AND (templugares.ZonasId=zonaslevel1.ZonasId)  
                                    AND (templugares.PuntosventaId=zonaslevel1.PuntosventaId) 
                        WHERE  (tempLugaresNumRef = '%s')";
    		}
    	} catch (Exception $e) {
    		
    	}

    }



   public function registrarError($msg,$codigo)
   {
   		return true;
   }

    
}

?>