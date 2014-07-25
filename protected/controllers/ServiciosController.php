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


    public function actionInsertarVenta($referencia,$pv)
    {
    	$servicio=new Servicios($referencia,$pv);
    	echo CHtml::openTag("pre");
    	try {
    		print_r($servicio->registrarVenta());
    	} catch (Exception $e) {
    		$servicio->registrarError(new Exception('Error general al llamar a la funcion de registrar venta',500));
    	}
    	
    	echo CHtml::closeTag("pre");
    	
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

    	// $pdf = Yii::createComponent ( 'application.extensions.html2pdf.html2pdf' );
    	// $html2pdf = new HTML2PDF ( 
    	// 	'P', array(75,180), 'es', true, 'UTF-8', 
    	// 	array (0, 0, 0, 0 ) );
    	$documento=$this->renderPartial("/ventas/formatoBoleto",array(),true,false);
    	// $html2pdf->writeHTML ($documento, false );
    	// $pdf=$html2pdf->Output ('', 'S' );

    	// $path= '/home/david/botelos.pdf';
    	// $data = file_get_contents($path);
    	// //$base64 = 'data:application/pdf;base64,' . base64_encode($data);
    	$base64 = base64_encode($documento);
    	return $base64;
    	// return $documento;
    }
    /**
     * @return str/string     si es la entrada cumple con los requerimientos
     * @soap
     */
    public function imprimirCoord()
    {

		$boleto=array(
				#campo=>array(DX,DY,Valor,Fuente,Tamano, Estilo)
				'acceso'=>array(0,5,"3-4","Arial","9","Bold"),
				'zonasAli'=>array(0,5,"VIP Central","Arial","9","Bold"),
				'FilasAli'=>array(0,5,"R","Arial","9","Bold"),
				'lugaresLug'=>array(0,5,"39","Arial","9","Bold"),
				'tipo'=>array(0,8,"NORMAL","Arial","9","Bold"),
				'cosBol'=>array(35,8,"$1,600","Arial","9","Bold"),
				'carSer'=>array(35,8,"20","Arial","9","Bold"),
				'desBol'=>array(0,5,"Descripcion del Boleto","Arial","9","Bold"),
				'evento'=>array(0,5,"Prueba PV 2014","Arial","12","Bold"),
				'foro'=>array(0,5,"Auditorio Siglo XXI","Arial","10","Bold"),
				'funcion'=>array(0,5,"Miercoles 14 - 01 - 2015 10:40 Hrs","Arial","9","Bold"),
				'contenedor1'=>array(0,5," ","Arial","9","Bold"),
				'zonasAli2'=>array(0,50,"VIP Central","Arial","8","Bold"),
				'clave2'=>array(-20,50,"509.1.1.2.2.18-03.24.184T","Arial","5","Normal"),
				'filasAli2'=>array(0,50,"R","Arial","8","Bold"),
				'lugaresLug2'=>array(0,50,"39","Arial","8","Bold"),
				'tipo2'=>array(7,50,"NORMAL","Arial","8","Bold"),
				'cosBol2'=>array(0,50,"$1,600","Arial","8","Bold"),
				'carser2'=>array(0,50,"$20","Arial","8","Bold"),
				'zonasAli3'=>array(0,50,"VIP Central","Arial","8","Bold"),
				'clave'=>array(-20,50,"509.1.1.2.2.18-03.24.184T","Arial","5","Normal"),
				'FilasAli3'=>array(0,50,"R","Arial","8","Bold"),
				'lugaresLug3'=>array(0,50,"39","Arial","8","Bold"),
				'tipo3'=>array(7,50,"NORMAL","Arial","8","Bold"),
				'cosBol3'=>array(0,50,"$1,600","Arial","8","Bold"),
				'carser3'=>array(0,50,"$20","Arial","8","Bold"),
				'codigo'=>array(50,265,"*5121115886985*","CCode39", 15,"Normal"),
				'codigo2'=>array(50,265,"5121115886985","Arial", 15,"Normal")
			);

    	$coords=Formatosimpresionlevel1::model()->findAllByAttributes(array('FormatoId'=>3));
    	$matrix=array();
    	foreach ($coords as $coord ) {
    		$matrix[$coord->FormatoObj]=array($coord->FormatoX,$coord->FormatoY);
    	}
    	$salida=array();
    	foreach ($boleto as $campo=>$datos) {
    		if (array_key_exists($campo,$matrix)) {
    			$datos[0]+=$matrix[$campo][0];
    			$datos[1]+=$matrix[$campo][1];
    		}
    		$salida[]=$datos;
    	}
    	return CJSON::encode($salida);
    	// return CJSON::encode(array(
    	// 	array("3050","1345","{{fila}}"),
    	// 	array("3700","1345","{{asiento}}"),
    	// 	array("500","1870","{{cliente}}"),
    	// 	array("1900","1870","{{precio}}"),
    	// 	));

    }

    public function actionImprimir()
    {
    	echo $this->imprimir();
    }

    /**
     * @param str/string valor es una cadena con cualquier serie de simbolos
     * @return str/string      si es la entrada cumple con los requerimientos
     * @soap
     */
    public function validarReferencia($ref)
    {
    	try{	
   			return $this->validarEnBD();
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