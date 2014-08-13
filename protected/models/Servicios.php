<?php 

class Servicios extends CFormModel{

	public $referencia;
	public $pv;

	public function Servicios($referencia,$pv=0)
	{
		$this->referencia=$referencia;
		$this->pv=$pv;
	}

    public function validarEntrada($referencia,$tipo='referencia')
    {   
		#Valida que en referencia entrada sea una referencia o un numero de referencia valido
    	if (!$referencia OR empty($referencia)) {
    	    throw new Exception("La cadena '$referencia' esta vacía.", 100);
    	}                     
    	if (!is_string($referencia) ){
    		throw new Exception("Entrada no es una cadena", 101);
    	}
    	if (strlen($referencia)!=16){
    		throw new Exception("Numero invalido de caracteres ", 102);
    	} 
    	switch ($tipo) {
    		case 'referencia':
				# Referencia de farmatodo
	    		if (!is_numeric(substr($referencia,0,6)))
	    			throw new Exception("Formato de cadena inválido", 103);
    			break;

			case 'reimpresion':
    			# En el caso que se valida una Referencia de Impresion
	    		if (!is_numeric(substr($referencia,1,6)))
	    			throw new Exception("Formato de cadena inválido", 107);				
				break;
    		
    		default:
	    		throw new Exception("Tipo invalido de referencia", 105);				
    			break;
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
    		if ($lugar->PuntosventaId!=$this->pv) {
    			throw new Exception("El punto de venta de al menos uno de los lugares no corresponde a este punto de venta", 203);
    			
    		}
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

    public function validacionesVenta()
    {
    	$referencia=$this->referencia;
    	$pv=$this->pv;
    	# Lleva a cabo todas las validaciones necesarias antes de insertar una venta
    	// try {
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
    	// } catch (Exception $e) {
    	// 	$this->registrarError($e);
    	// 	throw new Exception("No se ha podido validar la integridad de la referencia", 200);
    	// 	return false;
    	// }
    	#Validación de formato
    }

    public function validarPV($pv)
    {
    	if (!is_numeric($pv) or $pv<0) {
    		throw new Exception("El punto de venta '$pv' no es válido", 104);
    		$this->registrarError($e);

    		return false;
    	}
    	else
    		if (is_null(Puntosventa::model()->findByPk($pv))){
				throw new Exception("No existe el punto de venta", 151);
    		}
    }
    
    public function registrarVenta()
    {
    	$referencia=$this->referencia;
    	$pv=$this->pv;
    	try {
    		$lugares=$this->validacionesVenta();
    		$numeroLugares=sizeof($lugares);
    		
    	} catch (Exception $e) {
    		   $this->registrarError($e); 
    		   throw $e;
    		   // return $e->getCode()	;
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

    public function generarCodigoBarras($codigo=123456789012,$intentos=0)
    {
      # Genera un codigo  de barras aleatorio de EAN 12 
      if (strlen($codigo)==12) {
        $unico=Ventaslevel1::model()->count("LugaresNumBol = '$codigo' ");
        if ($unico==0) {
          # Si no existe ese codigo entonces es UNICO
          return $codigo;
        }         
      }
        $rnd=mt_rand(100000,999999)."".mt_rand(100000,999999);
        return $this->generarCodigoBarras($rnd,$intentos+1);        
      }


   public function registrarError($error)
   {
//    	$errorpath="/tmp/error.log";
//    	if (file_exists($errorpath) and filesize($errorpath)>(1024*100)) {
//    		$fp = fopen($errorpath, "r+");
// // clear content to 0 bits
//    		ftruncate($fp, 0);
// //close file
//    		fclose($fp);
//    	}   	
//    	error_log(
//    		sprintf("(%s)| R:%s | E%s : %s \n",date("d.M.y H:i:s"),
//    			$this->referencia,$error->getCode(),$error->getMessage()),
//    		3, $errorpath);
   	return true;
   }

   public function buscarBoletos($referencia=false,$numerosBoletos=false)
   {
   	if (!($referencia or $numerosBoletos)) {
   		# Si ambos filtros estan desactivados regresa vacio
   		return array();
   	}
   	else{
   		$criteria=new CDbCriteria;
   		$criteria->limit=10;
   		if ($numerosBoletos and is_array($numerosBoletos)) {
   		# Si pasan un arr1eglo de numeros de boletos
              #Valida que todos los numero de referencia sean validos
        foreach ($numerosBoletos as $LugaresNumBol) {
        # Si al menos uno no es valido se detiene la operacion
          if (empty($LugaresNumBol) or !is_numeric($LugaresNumBol)
            or strlen($LugaresNumBol)!=12) {
            return array();
        }
      }
      $criteria->addInCondition('t.LugaresNumBol',$numerosBoletos);
    }
    if ($referencia and is_string($referencia)) {
   		# Si le pasan una referencia
      $criteria->compare('venta.VentasNumRef',$referencia);
    }
   	# Busca los boletos de la venta y los devuelve en el formato de impresion de boletos
   		// $criteria=new CDbCriteria;
   		// $criteria->limit=10;
   		// $criteria->select='subzona.SubzonaAcc , zona.ZonasAli, fila.FilasAli, lugar.LugaresLug, VentasBolTip, precios.VentasCosBol, VentasCarSer, EventoDesBol, EventoNom, ForoNom, funcionesTexto, VentasCon, LugaresNumBol';
    $boletos=Ventaslevel1::model()
    ->with(array('venta','evento','funcion', 'zona','subzona','fila','lugar','precios', 'foro'))
    ->findAll($criteria);
    return $boletos;
  }

}

   // REIMPRESION---------------------------REIMPRESION--------------------REIMPRESION

   public function reimprimir(){
   	try {
   		$this->validarEntrada($this->referencia,'reimpresion');
   		if ($this->pv!=0) {
   			$this->validarPv($this->pv);
   		}
   		$refreimps=$this->buscarReimpresion($this->referencia);
   		if (empty($refreimps)) {
   			# Si no se encontraron registros
   			return false;
   		}
   		else{
   			$numerosBoletos=array();
   			$transaction = Yii::app()->db->beginTransaction();
   			foreach ($refreimps as $refreimp ) {
   				# Por cada refreimp
				##-------------------------------------------[ Actualiza Logreimp ] 
   				$logreimp=new Logreimp;
   				$logreimp->LogReimpTip=$refreimp->ventalevel1->VentasBolTip;
   				$logreimp->LogCosAnt=$refreimp->ventalevel1->VentasCosBol;
   				$logreimp->LogReimpTipAnt=$refreimp->ventalevel1->VentasBolTip;
   				$logreimp->LogReimpUsuId=2;
   				if ($this->pv==0) {
   					# Cuando sea 0 toma el punto de venta que vendio y no el que esta reimprimiendo
   					$logreimp->LogReimpPunVenId=$refreimp->venta->PuntosventaId;
   				}
   				else{
   					$logreimp->LogReimpPunVenId=$this->pv;
   					
   				}
   				$logreimp->EventoId=$refreimp->ventalevel1->EventoId;
   				$logreimp->FuncionesId=$refreimp->ventalevel1->FuncionesId;
   				$logreimp->ZonasId=$refreimp->ventalevel1->ZonasId;
   				$logreimp->SubzonaId=$refreimp->ventalevel1->SubzonaId;
   				$logreimp->FilasId=$refreimp->ventalevel1->FilasId;
   				$logreimp->LugaresId=$refreimp->ventalevel1->LugaresId;
   				$logreimp->save();
   				#---------------------------------------------------[ Actualiza la contraseña]
   				$contra=$refreimp->ventalevel1->VentasCon;
   				$contrav=explode('R',$contra);
   				if (sizeof($contrav)>1) {
   					# Significa que la contraseña ya tenia reimpresiones previas
   					$contrav[1]=(int)$contrav[1]+1;
   					$contra=implode('R', $contrav);
   				}
   				else{
					$contra.="R1";   					
   				}
   					$refreimp->ventalevel1->VentasCon=$contra;
   					#------------------------------------------------[ Actualizar numero de boleto]
   					$reimp=new Reimpresiones;
   					$reimp->attributes=$refreimp->ventalevel1->getAttributes();
   					$reimp->ReimpresionesMod="FARMATODO";
   					$reimp->UsuarioId=2;
   					$reimp->save(false);
   					$refreimp->ventalevel1->LugaresNumBol=$this->generarCodigoBarras($refreimp->ventalevel1->LugaresNumBol);
   					$refreimp->ventalevel1->save(false);
   					$numerosBoletos[]=$refreimp->ventalevel1->LugaresNumBol;
   				#----------------------------[ Actualiza el estatus de reimpresion]
   				$refreimp->RefReimpSta=0;
   				$refreimp->save(false);

   			}
   			##-----------------------------------------------[ Escribe cambios en BD*]
   			$transaction->commit();
   			return $numerosBoletos;

   		}

   		
   	} catch (Exception $e) {
   		$this->registrarError($e);
   		throw $e;
   	}
   }

    public function buscarReimpresion($referencia)
    {
    	# Busca en refreimp los boletos que se les genero reimpresion que coincidan con la referencia de reimpresion y que aun no se hayan reimpreso
    	$refreimps=Refreimp::model()->with(
    		array(
    			'venta'=>array('joinType'=>'INNER JOIN'),
    			'ventalevel1'=>array('joinType'=>'INNER JOIN')
    			))->findAllByAttributes(
    		array(
    			'RefReimpNumRes'=>$referencia,
    			'RefReimpSta'=>1 #Aun no se reimprime
    			)
    		);
    	return $refreimps;
    }

    public function foo()
    {
    	$this->validarEntrada($this->referencia,'reimpresion');
    	return '00002005ZYQUZD02';
    }
}

?>
