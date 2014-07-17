<?php
class ServiciosController extends CController
{

	public function actions()
	{
		return array(
			'venta'=>array(
				'class'=>'CWebServiceAction',
				'classMap'=>array(
                    'Templugares'=>'Templugares',  
                ),
				),
			);
	}

	public function filters()
	{
		return array(
			'validarEntrada + validarReferencia'
			);

	}

    public function validarEntrada($referencia)
    {   
		#Valida que en referencia entrada sea una referencia o un numero de referencia valido
    	if (empty($referencia)) {
    	    throw new Exception("La cadena esta vacía.", 100);
    	}                     
    	if (!is_string($referencia) ){
    		throw new Exception("Entrada no es una cadena", 101);
    	}
    	if (strlen($referencia)!=16){
    		throw new Exception("Numero invalido de caracteres ", 102);
    	} 
    	if (is_numeric(substr($referencia,0,6))){
    		throw new Exception("Formato de cadena inválido", 103);
    	}
    	return $referencia;
    }
    /**
     * @param str/string referencia es una cadena con cualquier serie de simbolos
     * @param int/integer Punto de venta
     * @return array[]      si es la entrada cumple con los requerimientos
     * @soap
     */
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
    	$numeroBd=sizeof($lugares);
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
    		}
    		$lugares=$this->validarEnBD($referencia,$pv);
    		$this->validarNumeroLugares($referencia,sizeof($lugares));
			
    	} catch (Exception $e) {
    		throw new Exception("No se ha validado la integridad de la referencia", 200);
    		return false;
    	}
    	#Validación de formato

    }

    public function actionIndex($valor, $pv)
    {
    	echo CHtml::openTag("pre");
    	print_r($this->validarEnBD($valor,$pv));
    	echo CHtml::closeTag('pre');
    }

    /**
     * @return str/string      si es la entrada cumple con los requerimientos
     * @soap
     */
    public function imprimir()
    {
    	$path= '/home/david/botelos.pdf';
    	$data = file_get_contents($path);
    	// $base64 = 'data:application/pdf;base64,' . base64_encode($data);
    	$base64 = base64_encode($data);
    	return $base64;
    }


    /**
     * @param str/string valor es una cadena con cualquier serie de simbolos
     * @return str/string      si es la entrada cumple con los requerimientos
     * @soap
     */
    public function validarReferencia($ref)
    {
    	try{	
   			return $this->validarEntrada($ref);
    	}
    	catch(Exception $e){
    		return $e;
    	}
    	
    }

  //   public function filterValidarEntrada($filterChain)
  //   {
		// $this->validarEntrada();
  //     	$filterChain->run() //to continue filtering and action execution
  //   }

    // public function reportarError($error)
    // {
    // 	#Esta función se encarga de leer un error y generar un reporte en el log de errores
    // }
}
?>