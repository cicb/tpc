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
    		// $servicio->registrarError(new Exception('Error general al llamar a la funcion de registrar venta',500));
    		echo $e->getMessage();
    	}
    	
    	echo CHtml::closeTag("pre");
    	
    }
    /**
     * @param str/string valor es una cadena con cualquier serie de simbolos
     * @param int/integer valor es una cadena con cualquier serie de simbolos
     * @return str/string      si es la entrada cumple con los requerimientos
     * @soap
     */
    public function insertarVenta($referencia,$pv){
    	$servicio=new Servicios($referencia,$pv);
    	$error=array('codigo'=>-1,'popsae'=>1,'msg'=>"No se encontro el error.","visible"=>1);
    	try {
    		$venta=$servicio->registrarVenta();
    	} catch (Exception $e) {
    		$servicio->registrarError($e);
            // "Error al insertar la venta"
    		$error=array('codigo'=>$e->getCode(),'popsae'=>1,
    			'msg'=>sprintf("Error %s: %s",$e->getCode(),$e->getMessage()),"visible"=>1);
    	    	return CJSON::encode(array("error"=>$error,"venta"=>array()));
    	}
    	return $this->verBoletos($referencia,$pv);
    }  

      /**
     * @param str/string valor es una cadena con cualquier serie de simbolos
     * @param int/integer valor es una cadena con cualquier serie de simbolos
     * @return str/string      si es la entrada cumple con los requerimientos
     * @soap
     */
    public function foo($referencia,$pv){
    	$cad="";
    	try {
			$servicio=new Servicios($referencia,$pv);
			$referencia=$servicio->foo();

			$error=array('codigo'=>5,'popsae'=>1,
    			'msg'=>$referencia,"visible"=>1);
    	} catch (Exception $e) {
    		$error=array('codigo'=>$e->getCode(),'popsae'=>1,
    			'msg'=>sprintf("Error %s: %s",$e->getCode(),$e->getMessage()),"visible"=>1);

    			    	}
    		return CJSON::encode(array("error"=>$error,"venta"=>array()));


    }
      /**
     * @param str/string valor es una cadena con cualquier serie de simbolos
     * @param int/integer valor es una cadena con cualquier serie de simbolos
     * @return str/string      si es la entrada cumple con los requerimientos
     * @soap
     */
    public function reimprimir($refreimp,$pv){
    	$error=array('codigo'=>-1,'popsae'=>1,'msg'=>"No se encontro el error.","visible"=>1);
    	try {
    		$servicio=new Servicios($refreimp,$pv);
    		$numeroBoletos=$servicio->reimprimir();
    		if (is_array($numeroBoletos)){
                //Validar que el numero de boletos que se vendieron sea igual al de la referencia xxxxxxxxxxNN
    			return $this->verBoletos(false,$numeroBoletos);
    		}
    		else 
    			$error= array('codigo'=>1,'popsae'=>1,'msg'=>"No hay boletos por reimprimir.","visible"=>1);
    	} catch (Exception $e) {
    		$error=array(
    			'codigo'=>$e->getCode(),
    			'popsae'=>1,
    			'msg'=>sprintf("Error %s: %s",$e->getCode(),
    				$e->getMessage()),
    			"visible"=>1);
    	}
    	return CJSON::encode(array("error"=>$error,"venta"=>array()));
    	
    }

    /**
     * @param str/string valor es una cadena con cualquier serie de simbolos
     * @param int/integer valor es una cadena con cualquier serie de simbolos
     * @return str/string      si es la entrada cumple con los requerimientos
     * @soap
     */
    public function verBoletos($referencia=false,$numeroBoletos=false)
    {
    	$error=array('codigo'=>-1,'popsae'=>1,'msg'=>"No se encontro el error.","visible"=>1);
        $formatoInterno='BoletoFormatoSimple';
        $eventos=array(539, 558);
    	$servicios=new Servicios($referencia);
    	// echo CHtml::openTag("pre");
        //Validar que el numero de boletos que se vendieron sea igual al de la referencia xxxxxxxxxxNN

    	$lugares=$servicios->buscarBoletos($referencia,$numeroBoletos);
    	$tickets=array();
    	$coords=Formatosimpresionlevel1::model()->findAllByAttributes(array('FormatoId'=>3));
    	$matrizCoord=array();
    	require_once( dirname(__FILE__) . '/../extensions/cbarras/ean.php');

    	foreach ($coords as $coord ) {
    		$matrizCoord[$coord->FormatoObj]=array($coord->FormatoX,$coord->FormatoY);
    	}
    	foreach ($lugares as $lugar) {
    		// print_r($lugar);
    		$encoder = new EAN13($lugar->LugaresNumBol, 2);
    		$fila=explode(',', str_replace('  ', ' ', $lugar->fila->FilasAli));
    		$fali=array_pop($fila);
    		$imaBol="";
    		try {
                if (in_array($lugar->EventoId,$eventos)){
                    $formatoInterno='BoletoFormatoUdlap';
                }
                if (strlen($lugar->evento->EventoImaBol)>0) {
                 $imaBol=base64_encode(
                    @file_get_contents(
                       'http://taquillacero.com/imagesbd/'.$lugar->evento->EventoImaBol
                       ));
                    
                }
    		} catch (Exception $e) {
    			// $error['codigo']=601;
    			// $error['msg']="No se encontro la imagen del boleto.";
    			// $error['popsae']=2;
    		}
    		$tickets[]=	array(
    			// 'subzona.SubzonaAcc , zona.ZonasAli, fila.FilasAli,
    			// lugar.LugaresLug, VentasBolTip, precios.VentasCosBol, 
    			//VentasCarSer, EventoDesBol, EventoNom, ForoNom, funcionesTexto, 
    			//VentasCon, LugaresNumBol';
	    			'SubzonaAcc'=>$lugar->subzona->SubzonaAcc,
					'ZonasAli'=>$lugar->zona->ZonasAli." ".array_pop($fila),
					'FilasAli'=>$fali,
					'LugaresLug'=>$lugar->lugar->LugaresLug,
					'VentasBolTip'=>$lugar->VentasBolTip,
					'VentasCosBol'=>$lugar->precios->VentasCosBol,
					'VentasCarSer'=>$lugar->precios->VentasCarSer,
					'EventoDesBol'=>$lugar->evento->EventoDesBol,
					'EventoNom'=>$lugar->evento->EventoNom,
					'ForoNom'=>$lugar->foro->ForoNom,
					'funcionesTexto'=>$lugar->funcion->funcionesTexto,
					'VentasCon'=>$lugar->VentasCon,
					'LugaresNumBol'=>$lugar->LugaresNumBol,
					'codigo'=>base64_encode($encoder->display()),
					'contenedor1'=> $imaBol
					);
    	}
    	$boletos=array('boletos'=>$tickets);
    	// echo "<pre>";
    	$e=Yii::app()->mustache->render($formatoInterno, $boletos, null,null,false);
    	$jes=CJSON::decode($e);
    	$ret=array();
    	array_pop($jes);
    	// var_export($jes);
    	foreach ($jes as $boleto) {
    		foreach ($boleto as $key=>$item ) {
    			try {
    				if (array_key_exists($key, $matrizCoord)) {
    					$boleto[$key][0]+=$matrizCoord[$key][0];
    					$boleto[$key][1]+=$matrizCoord[$key][1];
    				}
    			} catch (Exception $e) {

    			}
    		}
    		$ret[]=array_values($boleto);
    	}
    	// print_r($ret);
    	// echo "</pre>";
    	// echo CHtml::closeTag('pre');

    	return CJSON::encode(array("error"=>$error,"venta"=>$ret));
    }

    public function imprimir($value='')
    {
    	# code...
    }


    public function actionReimprimir($refreimp,$pv)
    {
    	echo $this->reimprimir($refreimp,$pv);
    }

    public function actionVerBoletos($referencia,$pv)
    {
    	$boletos=CJSON::decode(($this->verBoletos($referencia,$pv)));
    	if ($boletos['error']['codigo']>0) {
    		echo "Error: ",$boletos['error']['codigo'];
    		return false;
    	}
    	else{
    		$boletos=$boletos['venta'];

    		require_once( dirname(__FILE__) . '/../extensions/cbarras/ean.php');
    		foreach ($boletos as $boleto) {
    			echo CHtml::openTag('svg',array('width'=>400,'height'=>700));
    			echo CHtml::tag('image',array('width'=>300,'height'=>689,
    				'x'=>-5,'y'=>-55,
    				'xlink:href'=>"http://localhost/taquilla/control/images/boleto3.png"
    				)); 
    			echo CHtml::tag('rect',array('width'=>289,'height'=>670,
    				'style'=>"stroke:#999;stroke-width:1;fill:rgba(0,0,0,0)"
    				));
    			foreach ($boleto as $campo) {

    				if ($campo[3]=="Imagen" or $campo[3]=="Codigo") {
    					echo CHtml::tag('image',array('width'=>$campo[6],'height'=>$campo[7],
    						'x'=>$campo[0],'y'=>$campo[1],
    						'xlink:href'=>"data:image/png;base64,".$campo[2]
    						)); 
    				}
    				else
    					echo CHtml::tag('text',array('x'=>$campo[0],'y'=>$campo[1],
    						'style'=>sprintf("font-family:'%s';font-size:%s;font-weight:%s",
    							$campo[3],$campo[4],$campo[5])),
    				$campo[2]);
    			}
    		# code...
    			echo CHtml::closeTag('svg');
    		}
    	}

    }
}
?>
