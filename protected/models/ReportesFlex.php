<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ReportesFlex extends CFormModel
{
	/*public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;*/

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(/*
			// name, email, subject and body are required
			array('name, email, subject, body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		*/);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
		/*	'verifyCode'=>'Verification Code',*/
		);
	}
    public function getDetallesZonasCargo($EventoId, $FuncionesId, $ZonasId, $fecha1, $fecha2, $cargo){
        if($cargo == 'SI')
			$extra = " + ventaslevel1.VentasCarSer ";
		else
			$extra = "";
		
		if($fecha1 != "" && $fecha2 != "")
			$rango = " AND ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:00:00' ";
		else
			$rango = "";
      $aforo = Lugares::model()->count("EventoId = '$EventoId' AND FuncionesId = '$FuncionesId' AND ZonasId = '$ZonasId'");
      $criteria = new CDbCriteria;
      if($FuncionesId == 'TODAS'){
            $count = Yii::app()->db->createCommand("SELECT  '$aforo' as aforo, zonas.ZonasAli,  CONCAT(ventaslevel1.VentasBolTip, ' ', if(descuentos.DescuentosDes = 'Ninguno', '',  CONCAT('- ',descuentos.DescuentosDes))) AS VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
				(ventaslevel1.VentasCosBol -	ventaslevel1.VentasMonDes) as ZonasCosBol,	SUM(ventaslevel1.VentasCosBol -	ventaslevel1.VentasMonDes $extra) as total, (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as  VentasCosBol
					FROM ventas
					INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
					INNER JOIN descuentos ON (descuentos.DescuentosId = ventaslevel1.DescuentosId)
					INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
					AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
					AND (ventaslevel1.ZonasId=zonas.ZonasId)
					WHERE ventaslevel1.EventoId = '$EventoId'
					AND NOT (ventaslevel1.VentasSta = 'CANCELADO')
					AND ventaslevel1.ZonasId = '$ZonasId'
					$rango
					GROUP BY  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  zonas.ZonasCosBol,
					ventaslevel1.VentasCosBol,  ventaslevel1.VentasMonDes")->execute();
                    
        	$query = "SELECT ventas.VentasId as id, '$aforo' as aforo, zonas.ZonasAli,  CONCAT(ventaslevel1.VentasBolTip, ' ', if(descuentos.DescuentosDes = 'Ninguno', '',  CONCAT('- ',descuentos.DescuentosDes))) AS VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
				(ventaslevel1.VentasCosBol -	ventaslevel1.VentasMonDes) as ZonasCosBol,	SUM(ventaslevel1.VentasCosBol -	ventaslevel1.VentasMonDes $extra) as total, (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as  VentasCosBol
					FROM ventas
					INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
					INNER JOIN descuentos ON (descuentos.DescuentosId = ventaslevel1.DescuentosId)
					INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
					AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
					AND (ventaslevel1.ZonasId=zonas.ZonasId)
					WHERE ventaslevel1.EventoId = '$EventoId'
					AND NOT (ventaslevel1.VentasSta = 'CANCELADO')
					AND ventaslevel1.ZonasId = '$ZonasId'
					$rango
					GROUP BY  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  zonas.ZonasCosBol,
					ventaslevel1.VentasCosBol,  ventaslevel1.VentasMonDes";
		
		}else{
		   $count = Yii::app()->db->createCommand("SELECT '$aforo' as aforo,	zonas.ZonasAli,   CONCAT(ventaslevel1.VentasBolTip, ' ', if(descuentos.DescuentosDes = 'Ninguno', '',  CONCAT('- ',descuentos.DescuentosDes))) AS VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
					(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as  ZonasCosBol,	SUM(ventaslevel1.VentasCosBol -	ventaslevel1.VentasMonDes $extra) as total, (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as  VentasCosBol
					FROM ventas
					INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
					INNER JOIN descuentos ON (descuentos.DescuentosId = ventaslevel1.DescuentosId)
					INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
					AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
					AND (ventaslevel1.ZonasId=zonas.ZonasId)
					WHERE ventaslevel1.EventoId = '$EventoId'
					AND ventaslevel1.FuncionesId = '$FuncionesId'
					AND NOT (ventaslevel1.VentasSta = 'CANCELADO')
					AND ventaslevel1.ZonasId = '$ZonasId'
					$rango
					GROUP BY  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  zonas.ZonasCosBol,
					ventaslevel1.VentasCosBol,  ventaslevel1.VentasMonDes")->execute();
			$query = "SELECT ventas.VentasId as id, '$aforo' as aforo,	zonas.ZonasAli,   CONCAT(ventaslevel1.VentasBolTip, ' ', if(descuentos.DescuentosDes = 'Ninguno', '',  CONCAT('- ',descuentos.DescuentosDes))) AS VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
					(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as  ZonasCosBol,	SUM(ventaslevel1.VentasCosBol -	ventaslevel1.VentasMonDes $extra) as total, (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as  VentasCosBol
					FROM ventas
					INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
					INNER JOIN descuentos ON (descuentos.DescuentosId = ventaslevel1.DescuentosId)
					INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
					AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
					AND (ventaslevel1.ZonasId=zonas.ZonasId)
					WHERE ventaslevel1.EventoId = '$EventoId'
					AND ventaslevel1.FuncionesId = '$FuncionesId'
					AND NOT (ventaslevel1.VentasSta = 'CANCELADO')
					AND ventaslevel1.ZonasId = '$ZonasId'
					$rango
					GROUP BY  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  zonas.ZonasCosBol,
					ventaslevel1.VentasCosBol,  ventaslevel1.VentasMonDes";
					
			}
            return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
					));
    }
    public function getCallCenter($EventoId, $FuncionesId){
        if($FuncionesId == 'TODAS')
			$cadenaFuncion = "";
		else
			$cadenaFuncion = " AND lugares.FuncionesId = '$FuncionesId'";
            
		    $count = Yii::app()->db->createCommand("SELECT 
					  evento.EventoNom,
					  funciones.funcionesTexto,
					  zonas.ZonasAli,
					  filas.FilasAli,
					  lugares.LugaresLug,
					  ventas.VentasNumRef,
					  ventas.VentasFecHor,
					  (SELECT (COUNT(reimpresiones.ReimpresionesId)) AS vecesImpreso 
					  FROM reimpresiones
					   WHERE (reimpresiones.EventoId = ventaslevel1.EventoId) AND 
					   (reimpresiones.FuncionesId = ventaslevel1.FuncionesId) AND 
					   (reimpresiones.ZonasId = ventaslevel1.ZonasId) AND 
					   (reimpresiones.SubzonaId = ventaslevel1.SubzonaId) AND 
					   (reimpresiones.FilasId = ventaslevel1.FilasId) AND 
					   (reimpresiones.LugaresId = ventaslevel1.LugaresId) 
					   GROUP BY reimpresiones.EventoId, reimpresiones.FuncionesId, 
					   reimpresiones.ZonasId, reimpresiones.SubzonaId, 
					   reimpresiones.FilasId, reimpresiones.LugaresId) AS vecesImpreso
					FROM
					  ventaslevel1
					  INNER JOIN lugares ON (ventaslevel1.EventoId = lugares.EventoId)
					  AND (ventaslevel1.FuncionesId = lugares.FuncionesId)
					  AND (ventaslevel1.ZonasId = lugares.ZonasId)
					  AND (ventaslevel1.SubzonaId = lugares.SubzonaId)
					  AND (ventaslevel1.FilasId = lugares.FilasId)
					  AND (ventaslevel1.LugaresId = lugares.LugaresId)
					  INNER JOIN filas ON (lugares.EventoId = filas.EventoId)
					  AND (lugares.FuncionesId = filas.FuncionesId)
					  AND (lugares.ZonasId = filas.ZonasId)
					  AND (lugares.SubzonaId = filas.SubzonaId)
					  AND (lugares.FilasId = filas.FilasId)
					  INNER JOIN zonas ON (filas.ZonasId = zonas.ZonasId)
					  AND (filas.FuncionesId = zonas.FuncionesId)
					  AND (filas.EventoId = zonas.EventoId)
					  INNER JOIN funciones ON (zonas.EventoId = funciones.EventoId)
					  AND (zonas.FuncionesId = funciones.FuncionesId)
					  INNER JOIN evento ON (funciones.EventoId = evento.EventoId)
					  INNER JOIN ventas ON (ventaslevel1.VentasId = ventas.VentasId)
					WHERE
					  (lugares.EventoId = '$EventoId') AND 
					  (NOT (ventaslevel1.VentasSta = 'CANCELADO')) AND 
					  (ventas.PuntosventaId = '102' $cadenaFuncion) 
					  ORDER BY ZonasAli, FilasAli, LugaresLug")->execute();
			
			$query = "SELECT 
					  evento.EventoNom,
					  funciones.funcionesTexto,
					  zonas.ZonasAli,
					  filas.FilasAli,
					  lugares.LugaresLug,
					  ventas.VentasNumRef,
					  ventas.VentasFecHor,
					  (SELECT (COUNT(reimpresiones.ReimpresionesId)) AS vecesImpreso 
					  FROM reimpresiones
					   WHERE (reimpresiones.EventoId = ventaslevel1.EventoId) AND 
					   (reimpresiones.FuncionesId = ventaslevel1.FuncionesId) AND 
					   (reimpresiones.ZonasId = ventaslevel1.ZonasId) AND 
					   (reimpresiones.SubzonaId = ventaslevel1.SubzonaId) AND 
					   (reimpresiones.FilasId = ventaslevel1.FilasId) AND 
					   (reimpresiones.LugaresId = ventaslevel1.LugaresId) 
					   GROUP BY reimpresiones.EventoId, reimpresiones.FuncionesId, 
					   reimpresiones.ZonasId, reimpresiones.SubzonaId, 
					   reimpresiones.FilasId, reimpresiones.LugaresId) AS vecesImpreso
					FROM
					  ventaslevel1
					  INNER JOIN lugares ON (ventaslevel1.EventoId = lugares.EventoId)
					  AND (ventaslevel1.FuncionesId = lugares.FuncionesId)
					  AND (ventaslevel1.ZonasId = lugares.ZonasId)
					  AND (ventaslevel1.SubzonaId = lugares.SubzonaId)
					  AND (ventaslevel1.FilasId = lugares.FilasId)
					  AND (ventaslevel1.LugaresId = lugares.LugaresId)
					  INNER JOIN filas ON (lugares.EventoId = filas.EventoId)
					  AND (lugares.FuncionesId = filas.FuncionesId)
					  AND (lugares.ZonasId = filas.ZonasId)
					  AND (lugares.SubzonaId = filas.SubzonaId)
					  AND (lugares.FilasId = filas.FilasId)
					  INNER JOIN zonas ON (filas.ZonasId = zonas.ZonasId)
					  AND (filas.FuncionesId = zonas.FuncionesId)
					  AND (filas.EventoId = zonas.EventoId)
					  INNER JOIN funciones ON (zonas.EventoId = funciones.EventoId)
					  AND (zonas.FuncionesId = funciones.FuncionesId)
					  INNER JOIN evento ON (funciones.EventoId = evento.EventoId)
					  INNER JOIN ventas ON (ventaslevel1.VentasId = ventas.VentasId)
					WHERE
					  (lugares.EventoId = '$EventoId') AND 
					  (NOT (ventaslevel1.VentasSta = 'CANCELADO')) AND 
					  (ventas.PuntosventaId = '102' $cadenaFuncion) 
					  ORDER BY ZonasAli, FilasAli, LugaresLug";
                    return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
					));
    }
    public function getDesglose($EventoId, $FuncionesId){
         if($FuncionesId == 'TODAS')
			$cadenaFuncion = "";
		else
			$cadenaFuncion = " AND lugares.FuncionesId = '$FuncionesId'";
		
        $count = Yii::app()->db->createCommand("SELECT   ventas.UsuariosId,  ventas.VentasId,  ventas.VentasNumRef,  zonas.ZonasAli,
					filas.FilasAli,  lugares.LugaresLug,  
					(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as VentasCosBol, 
					if (ventaslevel1.DescuentosId = 0, ventaslevel1.VentasBolTip, 
						descuentos.DescuentosDes) AS VentasBolTip ,
					ventaslevel1.VentasSta,  ventaslevel1.LugaresNumBol,  ventas.VentasFecHor, usuarios.UsuariosNom
					FROM lugares
					 INNER JOIN ventaslevel1 ON (lugares.EventoId=ventaslevel1.EventoId)
					  AND (lugares.FuncionesId=ventaslevel1.FuncionesId)
					  AND (lugares.ZonasId=ventaslevel1.ZonasId)
					  AND (lugares.SubzonaId=ventaslevel1.SubzonaId)
					  AND (lugares.FilasId=ventaslevel1.FilasId)
					  AND (lugares.LugaresId=ventaslevel1.LugaresId)
					 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
					 INNER JOIN templugares ON (lugares.EventoId=templugares.EventoId)
					  AND (lugares.FuncionesId=templugares.FuncionesId)
					  AND (lugares.ZonasId=templugares.ZonasId)
					  AND (lugares.SubzonaId=templugares.SubzonaId)
					  AND (lugares.FilasId=templugares.FilasId)
					  AND (lugares.LugaresId=templugares.LugaresId)
					 INNER JOIN funciones ON (funciones.EventoId=templugares.EventoId)
					  AND (funciones.FuncionesId=templugares.FuncionesId)
					 INNER JOIN evento ON (evento.EventoId=lugares.EventoId)
					  AND (evento.EventoId=funciones.EventoId)
					 INNER JOIN zonas ON (funciones.EventoId=zonas.EventoId)
					  AND (funciones.FuncionesId=zonas.FuncionesId)
					 INNER JOIN filas ON (zonas.EventoId=filas.EventoId)
					  AND (zonas.FuncionesId=filas.FuncionesId)
					  AND (zonas.ZonasId=filas.ZonasId)
					  AND (filas.EventoId=templugares.EventoId)
					  AND (filas.FuncionesId=templugares.FuncionesId)
					  AND (filas.ZonasId=templugares.ZonasId)
					  AND (filas.SubzonaId=templugares.SubzonaId)
					  AND (filas.FilasId=templugares.FilasId)
					  INNER JOIN usuarios ON (usuarios.UsuariosId=templugares.UsuariosId)
					  INNER JOIN descuentos ON (descuentos.DescuentosId=ventaslevel1.DescuentosId)
					  WHERE  (lugares.EventoId = '$EventoId') AND NOT (ventaslevel1.VentasSta = 'CANCELADO') $cadenaFuncion")->execute();
        
			
			$query = "SELECT  '' as id, ventas.UsuariosId,  ventas.VentasId,  ventas.VentasNumRef,  zonas.ZonasAli,
					filas.FilasAli,  lugares.LugaresLug,  
					(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as VentasCosBol, 
					if (ventaslevel1.DescuentosId = 0, ventaslevel1.VentasBolTip, 
						descuentos.DescuentosDes) AS VentasBolTip ,
					ventaslevel1.VentasSta,  ventaslevel1.LugaresNumBol,  ventas.VentasFecHor, usuarios.UsuariosNom
					FROM lugares
					 INNER JOIN ventaslevel1 ON (lugares.EventoId=ventaslevel1.EventoId)
					  AND (lugares.FuncionesId=ventaslevel1.FuncionesId)
					  AND (lugares.ZonasId=ventaslevel1.ZonasId)
					  AND (lugares.SubzonaId=ventaslevel1.SubzonaId)
					  AND (lugares.FilasId=ventaslevel1.FilasId)
					  AND (lugares.LugaresId=ventaslevel1.LugaresId)
					 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
					 INNER JOIN templugares ON (lugares.EventoId=templugares.EventoId)
					  AND (lugares.FuncionesId=templugares.FuncionesId)
					  AND (lugares.ZonasId=templugares.ZonasId)
					  AND (lugares.SubzonaId=templugares.SubzonaId)
					  AND (lugares.FilasId=templugares.FilasId)
					  AND (lugares.LugaresId=templugares.LugaresId)
					 INNER JOIN funciones ON (funciones.EventoId=templugares.EventoId)
					  AND (funciones.FuncionesId=templugares.FuncionesId)
					 INNER JOIN evento ON (evento.EventoId=lugares.EventoId)
					  AND (evento.EventoId=funciones.EventoId)
					 INNER JOIN zonas ON (funciones.EventoId=zonas.EventoId)
					  AND (funciones.FuncionesId=zonas.FuncionesId)
					 INNER JOIN filas ON (zonas.EventoId=filas.EventoId)
					  AND (zonas.FuncionesId=filas.FuncionesId)
					  AND (zonas.ZonasId=filas.ZonasId)
					  AND (filas.EventoId=templugares.EventoId)
					  AND (filas.FuncionesId=templugares.FuncionesId)
					  AND (filas.ZonasId=templugares.ZonasId)
					  AND (filas.SubzonaId=templugares.SubzonaId)
					  AND (filas.FilasId=templugares.FilasId)
					  INNER JOIN usuarios ON (usuarios.UsuariosId=templugares.UsuariosId)
					  INNER JOIN descuentos ON (descuentos.DescuentosId=ventaslevel1.DescuentosId)
					  WHERE  (lugares.EventoId = '$EventoId') AND NOT (ventaslevel1.VentasSta = 'CANCELADO') $cadenaFuncion";
         return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
					));             
    }
    public function getInternet($EventoId, $FuncionesId, $pv){
		
		if($FuncionesId == 'TODAS')
			$cadenaFuncion = "";
		else
			$cadenaFuncion = " AND lugares.FuncionesId = '$FuncionesId'";
		
		$count = Yii::app()->db->createCommand("SELECT 
					  evento.EventoNom,
					  funciones.funcionesTexto,
					  zonas.ZonasAli,
					  filas.FilasAli,
					  lugares.LugaresLug,
					  ventas.VentasNumRef,
					  ventas.VentasFecHor,
					  (SELECT (COUNT(reimpresiones.ReimpresionesId)) AS vecesImpreso 
					  FROM reimpresiones
					   WHERE (reimpresiones.EventoId = ventaslevel1.EventoId) AND 
					   (reimpresiones.FuncionesId = ventaslevel1.FuncionesId) AND 
					   (reimpresiones.ZonasId = ventaslevel1.ZonasId) AND 
					   (reimpresiones.SubzonaId = ventaslevel1.SubzonaId) AND 
					   (reimpresiones.FilasId = ventaslevel1.FilasId) AND 
					   (reimpresiones.LugaresId = ventaslevel1.LugaresId) 
					   GROUP BY reimpresiones.EventoId, reimpresiones.FuncionesId, 
					   reimpresiones.ZonasId, reimpresiones.SubzonaId, 
					   reimpresiones.FilasId, reimpresiones.LugaresId) AS vecesImpreso,
					  clientes.ClientesEma
					FROM
					  ventaslevel1
					  INNER JOIN lugares ON (ventaslevel1.EventoId = lugares.EventoId)
					  AND (ventaslevel1.FuncionesId = lugares.FuncionesId)
					  AND (ventaslevel1.ZonasId = lugares.ZonasId)
					  AND (ventaslevel1.SubzonaId = lugares.SubzonaId)
					  AND (ventaslevel1.FilasId = lugares.FilasId)
					  AND (ventaslevel1.LugaresId = lugares.LugaresId)
					  INNER JOIN filas ON (lugares.EventoId = filas.EventoId)
					  AND (lugares.FuncionesId = filas.FuncionesId)
					  AND (lugares.ZonasId = filas.ZonasId)
					  AND (lugares.SubzonaId = filas.SubzonaId)
					  AND (lugares.FilasId = filas.FilasId)
					  INNER JOIN zonas ON (filas.ZonasId = zonas.ZonasId)
					  AND (filas.FuncionesId = zonas.FuncionesId)
					  AND (filas.EventoId = zonas.EventoId)
					  INNER JOIN funciones ON (zonas.EventoId = funciones.EventoId)
					  AND (zonas.FuncionesId = funciones.FuncionesId)
					  INNER JOIN evento ON (funciones.EventoId = evento.EventoId)
					  INNER JOIN ventas ON (ventaslevel1.VentasId = ventas.VentasId)
					  INNER JOIN clientes ON (ventas.UsuariosId = clientes.ClientesId)
					WHERE
					  (lugares.EventoId = '$EventoId') AND 
					  (NOT (ventaslevel1.VentasSta = 'CANCELADO')) AND 
					  (ventas.PuntosventaId = '$pv' $cadenaFuncion)
					  ORDER BY ZonasAli, FilasAli, LugaresLug")->execute();	
			
            $query = "SELECT '' as id,
					  evento.EventoNom,
					  funciones.funcionesTexto,
					  zonas.ZonasAli,
					  filas.FilasAli,
					  lugares.LugaresLug,
					  ventas.VentasNumRef,
					  ventas.VentasFecHor,
					  (SELECT (COUNT(reimpresiones.ReimpresionesId)) AS vecesImpreso 
					  FROM reimpresiones
					   WHERE (reimpresiones.EventoId = ventaslevel1.EventoId) AND 
					   (reimpresiones.FuncionesId = ventaslevel1.FuncionesId) AND 
					   (reimpresiones.ZonasId = ventaslevel1.ZonasId) AND 
					   (reimpresiones.SubzonaId = ventaslevel1.SubzonaId) AND 
					   (reimpresiones.FilasId = ventaslevel1.FilasId) AND 
					   (reimpresiones.LugaresId = ventaslevel1.LugaresId) 
					   GROUP BY reimpresiones.EventoId, reimpresiones.FuncionesId, 
					   reimpresiones.ZonasId, reimpresiones.SubzonaId, 
					   reimpresiones.FilasId, reimpresiones.LugaresId) AS vecesImpreso,
					  clientes.ClientesEma
					FROM
					  ventaslevel1
					  INNER JOIN lugares ON (ventaslevel1.EventoId = lugares.EventoId)
					  AND (ventaslevel1.FuncionesId = lugares.FuncionesId)
					  AND (ventaslevel1.ZonasId = lugares.ZonasId)
					  AND (ventaslevel1.SubzonaId = lugares.SubzonaId)
					  AND (ventaslevel1.FilasId = lugares.FilasId)
					  AND (ventaslevel1.LugaresId = lugares.LugaresId)
					  INNER JOIN filas ON (lugares.EventoId = filas.EventoId)
					  AND (lugares.FuncionesId = filas.FuncionesId)
					  AND (lugares.ZonasId = filas.ZonasId)
					  AND (lugares.SubzonaId = filas.SubzonaId)
					  AND (lugares.FilasId = filas.FilasId)
					  INNER JOIN zonas ON (filas.ZonasId = zonas.ZonasId)
					  AND (filas.FuncionesId = zonas.FuncionesId)
					  AND (filas.EventoId = zonas.EventoId)
					  INNER JOIN funciones ON (zonas.EventoId = funciones.EventoId)
					  AND (zonas.FuncionesId = funciones.FuncionesId)
					  INNER JOIN evento ON (funciones.EventoId = evento.EventoId)
					  INNER JOIN ventas ON (ventaslevel1.VentasId = ventas.VentasId)
					  INNER JOIN clientes ON (ventas.UsuariosId = clientes.ClientesId)
					WHERE
					  (lugares.EventoId = '$EventoId') AND 
					  (NOT (ventaslevel1.VentasSta = 'CANCELADO')) AND 
					  (ventas.PuntosventaId = '$pv' $cadenaFuncion)
					  ORDER BY ZonasAli, FilasAli, LugaresLug";
		
		  return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
					)); 
		}
	
	public function getReporteSinCargo($EventoId, $FuncionesId, $fecha1, $fecha2, $cargo) {
				
		if($cargo == 'SI')
			$extra = " + ventaslevel1.VentasCarSer ";
		else
			$extra = "";
		
		if($fecha1 != "" && $fecha2 != "")
			$rango = " AND ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' ";
		else
			$rango = "";
		
		if($FuncionesId == 'TODAS'){
			    $count = Yii::app()->db->createCommand("SELECT   zonas.ZonasAli,  ventaslevel1.VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
				zonas.ZonasCosBol,  SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes $extra) AS total,
				evento.EventoNom,  ventas.PuntosventaId,  funciones.funcionesTexto,  evento.EventoFecIni, evento.PuntosventaId AS PuntosventaIdEvento
				FROM ventas
				INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
				INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
				AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
				AND (ventaslevel1.ZonasId=zonas.ZonasId)
				INNER JOIN evento ON (evento.EventoId=zonas.EventoId)
				INNER JOIN funciones ON (funciones.FuncionesId=zonas.FuncionesId)
				AND (funciones.EventoId=evento.EventoId)
				AND (funciones.EventoId=zonas.EventoId)
				WHERE  (ventaslevel1.EventoId = '$EventoId') AND NOT (ventaslevel1.VentasSta = 'CANCELADO') $rango
				GROUP BY  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  zonas.ZonasCosBol,  evento.EventoNom,  ventas.PuntosventaId,
				funciones.funcionesTexto,  evento.EventoFecIni")->execute();	
			
				$query = "SELECT  '' as id, zonas.ZonasAli,  ventaslevel1.VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
				zonas.ZonasCosBol,  SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes $extra) AS total,
				evento.EventoNom,  ventas.PuntosventaId,  funciones.funcionesTexto,  evento.EventoFecIni, evento.PuntosventaId AS PuntosventaIdEvento
				FROM ventas
				INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
				INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
				AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
				AND (ventaslevel1.ZonasId=zonas.ZonasId)
				INNER JOIN evento ON (evento.EventoId=zonas.EventoId)
				INNER JOIN funciones ON (funciones.FuncionesId=zonas.FuncionesId)
				AND (funciones.EventoId=evento.EventoId)
				AND (funciones.EventoId=zonas.EventoId)
				WHERE  (ventaslevel1.EventoId = '$EventoId') AND NOT (ventaslevel1.VentasSta = 'CANCELADO') $rango
				GROUP BY  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  zonas.ZonasCosBol,  evento.EventoNom,  ventas.PuntosventaId,
				funciones.funcionesTexto,  evento.EventoFecIni";
			
			}else{
		        $count = Yii::app()->db->createCommand("SELECT   zonas.ZonasAli,  ventaslevel1.VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
				zonas.ZonasCosBol,  SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes $extra) AS total,
				evento.EventoNom,  ventas.PuntosventaId,  funciones.funcionesTexto,  evento.EventoFecIni, evento.PuntosventaId AS PuntosventaIdEvento
					FROM ventas
					 INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
					 INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
					  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
					  AND (ventaslevel1.ZonasId=zonas.ZonasId)
					 INNER JOIN evento ON (evento.EventoId=zonas.EventoId)
					 INNER JOIN funciones ON (funciones.FuncionesId=zonas.FuncionesId)
					  AND (funciones.EventoId=zonas.EventoId)
					  AND (evento.EventoId=funciones.EventoId)
					WHERE
					  (ventaslevel1.EventoId = '$EventoId') AND 
					  (ventaslevel1.FuncionesId = '$FuncionesId') AND
					   NOT (ventaslevel1.VentasSta = 'CANCELADO') $rango
					GROUP BY
					  zonas.ZonasAli,
					  ventaslevel1.VentasBolTip,
					  zonas.ZonasCosBol,
					  evento.EventoNom,
					  ventas.PuntosventaId,
					  funciones.funcionesTexto,
					  evento.EventoFecIni")->execute();
                      
				$query = "SELECT  '' as id,  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  COUNT(ventaslevel1.LugaresId) AS cantidad,
				zonas.ZonasCosBol,  SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes $extra) AS total,
				evento.EventoNom,  ventas.PuntosventaId,  funciones.funcionesTexto,  evento.EventoFecIni, evento.PuntosventaId AS PuntosventaIdEvento
					FROM ventas
					 INNER JOIN ventaslevel1 ON (ventas.VentasId=ventaslevel1.VentasId)
					 INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
					  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
					  AND (ventaslevel1.ZonasId=zonas.ZonasId)
					 INNER JOIN evento ON (evento.EventoId=zonas.EventoId)
					 INNER JOIN funciones ON (funciones.FuncionesId=zonas.FuncionesId)
					  AND (funciones.EventoId=zonas.EventoId)
					  AND (evento.EventoId=funciones.EventoId)
					WHERE
					  (ventaslevel1.EventoId = '$EventoId') AND 
					  (ventaslevel1.FuncionesId = '$FuncionesId') AND
					   NOT (ventaslevel1.VentasSta = 'CANCELADO') $rango
					GROUP BY
					  zonas.ZonasAli,
					  ventaslevel1.VentasBolTip,
					  zonas.ZonasCosBol,
					  evento.EventoNom,
					  ventas.PuntosventaId,
					  funciones.funcionesTexto,
					  evento.EventoFecIni";
			}	
            return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
					));
		
	}
    public function getReporteSinCargoDescuentos($EventoId, $fecha1, $fecha2) {
		
		if($fecha1 != "" && $fecha2 != "")
			$rango = " AND ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' ";
		else
			$rango = "";
		$count = Yii::app()->db->createCommand("SELECT descuentos.DescuentosDes, descuentos.DescuentosPat,
				 COUNT(ventaslevel1.VentasId) AS descuentos,  SUM((ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) - ventaslevel1.VentasMonDes) AS total
				 FROM ventaslevel1
				  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
				  INNER JOIN descuentos ON (ventaslevel1.DescuentosId=descuentos.DescuentosId)
				  WHERE descuentos.DescuentosId != '0' AND
				    ventaslevel1.VentasSta = 'VENDIDO' AND
					ventaslevel1.EventoId = '$EventoId' $rango
					GROUP BY descuentos.DescuentosDes,  descuentos.DescuentosPat")->execute();
		
		$query = "SELECT '' as id, descuentos.DescuentosDes, descuentos.DescuentosPat,
				 COUNT(ventaslevel1.VentasId) AS descuentos,  SUM((ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) - ventaslevel1.VentasMonDes) AS total
				 FROM ventaslevel1
				  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
				  INNER JOIN descuentos ON (ventaslevel1.DescuentosId=descuentos.DescuentosId)
				  WHERE descuentos.DescuentosId != '0' AND
				    ventaslevel1.VentasSta = 'VENDIDO' AND
					ventaslevel1.EventoId = '$EventoId' $rango
					GROUP BY descuentos.DescuentosDes,  descuentos.DescuentosPat";
		return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
					));
		
		
	}
    public function getTotales($usuario, $puntoVenta, $fecha1, $fecha2){
			
		 $hoy = date("Y-m-d");
			
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventas.VentasFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
			$count = Yii::app()->db->createCommand("SELECT   ventas.VentasTip,  SUM(ventaslevel1.VentasCosBol) AS VentasCosBol,
									SUM(ventaslevel1.VentasCarSer) AS VentasCarSer
									FROM
									ventaslevel1
									INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
									INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
									INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
									AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
									WHERE
									(ventas.UsuariosId = '$usuario') AND 
									(ventas.PuntosventaId = '$puntoVenta') AND 
									(ventaslevel1.VentasSta = 'VENDIDO') AND 
									(ventaslevel1.VentasBolTip = 'NORMAL') AND
									$rango
									GROUP BY ventas.VentasTip")->execute();
			$query = "SELECT '' as id,  ventas.VentasTip,  SUM(ventaslevel1.VentasCosBol) AS VentasCosBol,
									SUM(ventaslevel1.VentasCarSer) AS VentasCarSer
									FROM
									ventaslevel1
									INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
									INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
									INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
									AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
									WHERE
									(ventas.UsuariosId = '$usuario') AND 
									(ventas.PuntosventaId = '$puntoVenta') AND 
									(ventaslevel1.VentasSta = 'VENDIDO') AND 
									(ventaslevel1.VentasBolTip = 'NORMAL') AND
									$rango
									GROUP BY ventas.VentasTip";
                                    
			return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));
		}
 	public function getVentasDetalle($usuario, $puntoVenta, $EventoId, $FuncionesId, $tipo, $fecha1, $fecha2){

		  $hoy = date("Y-m-d");
			
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventas.VentasFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";

		
		if($tipo != 'CANCELADOS'){
		   $count = Yii::app()->db->createCommand("SELECT '' as id, ventaslevel1.EventoId, ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,
								  zonas.ZonasAli,  count(ventaslevel1.LugaresId) AS cantidad, 
								  SUM(ventaslevel1.VentasMonDes) AS descuento, ventas.VentasTip,  ventaslevel1.VentasBolTip,
								  ventaslevel1.VentasCosBol,  ventaslevel1.VentasCarSer,
								  SUM(ventaslevel1.VentasCosBol) AS VentasCosBolT,
								  SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT  
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
								  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
								  AND (ventaslevel1.ZonasId=zonas.ZonasId)
								  WHERE  (ventaslevel1.EventoId = '$EventoId') AND 
								  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
								  (ventas.VentasSta = 'FIN') AND 
								  (ventas.UsuariosId = '$usuario') AND 
								  (ventas.PuntosventaId = '$puntoVenta') AND  
								  (ventaslevel1.VentasSta = 'VENDIDO') AND
								  (ventaslevel1.VentasBolTip = '$tipo') AND
								  $rango
								  GROUP BY
								  ventaslevel1.EventoId,  ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,  zonas.ZonasAli")->execute();
			
            $query = "SELECT '' as id, ventaslevel1.EventoId, ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,
								  zonas.ZonasAli,  count(ventaslevel1.LugaresId) AS cantidad, 
								  SUM(ventaslevel1.VentasMonDes) AS descuento, ventas.VentasTip,  ventaslevel1.VentasBolTip,
								  ventaslevel1.VentasCosBol,  ventaslevel1.VentasCarSer,
								  SUM(ventaslevel1.VentasCosBol) AS VentasCosBolT,
								  SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT  
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
								  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
								  AND (ventaslevel1.ZonasId=zonas.ZonasId)
								  WHERE  (ventaslevel1.EventoId = '$EventoId') AND 
								  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
								  (ventas.VentasSta = 'FIN') AND 
								  (ventas.UsuariosId = '$usuario') AND 
								  (ventas.PuntosventaId = '$puntoVenta') AND  
								  (ventaslevel1.VentasSta = 'VENDIDO') AND
								  (ventaslevel1.VentasBolTip = '$tipo') AND
								  $rango
								  GROUP BY
								  ventaslevel1.EventoId,  ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,  zonas.ZonasAli";
		}else{
				
				
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventaslevel1.CancelFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventaslevel1.CancelFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventaslevel1.CancelFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				$count = Yii::app()->db->createCommand("SELECT '' as id, ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
									  zonas.ZonasAli,  ventaslevel1.LugaresId,  ventas.VentasTip,
									  ventaslevel1.VentasBolTip,  ventaslevel1.CancelUsuarioId,
									  ventaslevel1.CancelFecHor
									  FROM ventaslevel1
									  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
									  INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
									  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
									  AND (ventaslevel1.ZonasId=zonas.ZonasId)
									  WHERE
									  (ventaslevel1.EventoId = '$EventoId') AND 
									  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
									  (ventaslevel1.CancelUsuarioId = '$usuario') AND 
									  (ventaslevel1.VentasSta = 'CANCELADO') AND
									  $rango")->execute();
                                      
				$query = "SELECT '' as id, ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
									  zonas.ZonasAli,  ventaslevel1.LugaresId,  ventas.VentasTip,
									  ventaslevel1.VentasBolTip,  ventaslevel1.CancelUsuarioId,
									  ventaslevel1.CancelFecHor
									  FROM ventaslevel1
									  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
									  INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
									  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
									  AND (ventaslevel1.ZonasId=zonas.ZonasId)
									  WHERE
									  (ventaslevel1.EventoId = '$EventoId') AND 
									  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
									  (ventaslevel1.CancelUsuarioId = '$usuario') AND 
									  (ventaslevel1.VentasSta = 'CANCELADO') AND
									  $rango";
			}
			
	       return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));
			
		}
        public function getVentasMasDetalle($usuario, $puntoVenta, $EventoId, $FuncionesId, $tipo, $fecha1, $fecha2){
		  $hoy = date("Y-m-d");
			
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventas.VentasFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
			
			
			if($tipo != 'CANCELADOS'){
			        $count = Yii::app()->db->createCommand("SELECT  ventaslevel1.EventoId,  ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,
									  zonas.ZonasAli,  count(ventaslevel1.LugaresId) AS cantidad, ventas.VentasTip,
									  SUM(ventaslevel1.VentasMonDes) AS descuento,  ventaslevel1.VentasBolTip,
									  ventaslevel1.VentasCosBol,  ventaslevel1.VentasCarSer,  
									  SUM(ventaslevel1.VentasCosBol) AS VentasCosBolT,
									  SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT,
									  ventas.VentasTipTar,  ventas.VentasNumAut
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
									  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
									  AND (ventaslevel1.ZonasId=zonas.ZonasId)
								  WHERE
									  (ventaslevel1.EventoId = '$EventoId') AND 
									  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
									  (ventas.VentasSta = 'FIN') AND 
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = '$tipo') AND
									  $rango
								  GROUP BY  ventaslevel1.EventoId,  ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,
									  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  ventaslevel1.VentasCosBol, ventas.VentasTip,
									  ventaslevel1.VentasCarSer,  ventas.VentasTipTar,  ventas.VentasNumAut")->execute();
                                      
					$query = "SELECT  '' as id, ventaslevel1.EventoId,  ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,
									  zonas.ZonasAli,  count(ventaslevel1.LugaresId) AS cantidad, ventas.VentasTip,
									  SUM(ventaslevel1.VentasMonDes) AS descuento,  ventaslevel1.VentasBolTip,
									  ventaslevel1.VentasCosBol,  ventaslevel1.VentasCarSer,  
									  SUM(ventaslevel1.VentasCosBol) AS VentasCosBolT,
									  SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT,
									  ventas.VentasTipTar,  ventas.VentasNumAut
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
									  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
									  AND (ventaslevel1.ZonasId=zonas.ZonasId)
								  WHERE
									  (ventaslevel1.EventoId = '$EventoId') AND 
									  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
									  (ventas.VentasSta = 'FIN') AND 
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = '$tipo') AND
									  $rango
								  GROUP BY  ventaslevel1.EventoId,  ventaslevel1.FuncionesId,  ventaslevel1.ZonasId,
									  zonas.ZonasAli,  ventaslevel1.VentasBolTip,  ventaslevel1.VentasCosBol, ventas.VentasTip,
									  ventaslevel1.VentasCarSer,  ventas.VentasTipTar,  ventas.VentasNumAut";
			
			
				}else{
				
				
							
				if($fecha1 == '' || $fecha2 == '')
					$rango = "(ventaslevel1.CancelFecHor LIKE '%$hoy%')";
				else
					$rango = "(ventaslevel1.CancelFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
					
				if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
				  $rango = "(ventaslevel1.CancelFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
                  
				$count = Yii::app()->db->createCommand("SELECT  ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
									  zonas.ZonasAli,  ventaslevel1.LugaresId,  ventas.VentasTip,
									  ventaslevel1.VentasBolTip,  ventaslevel1.CancelUsuarioId,
									  ventaslevel1.CancelFecHor, lugares.LugaresLug, filas.FilasAli,
									  ventas.VentasFecHor
									  FROM ventaslevel1
									 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
									 INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
									  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
									  AND (ventaslevel1.ZonasId=zonas.ZonasId)
									 INNER JOIN lugares ON (ventaslevel1.EventoId=lugares.EventoId)
									  AND (ventaslevel1.FuncionesId=lugares.FuncionesId)
									  AND (ventaslevel1.ZonasId=lugares.ZonasId)
									  AND (ventaslevel1.SubzonaId=lugares.SubzonaId)
									  AND (ventaslevel1.FilasId=lugares.FilasId)
									  AND (ventaslevel1.LugaresId=lugares.LugaresId)
									 INNER JOIN filas ON (lugares.EventoId=filas.EventoId)
									  AND (lugares.FuncionesId=filas.FuncionesId)
									  AND (lugares.ZonasId=filas.ZonasId)
									  AND (lugares.SubzonaId=filas.SubzonaId)
									  AND (lugares.FilasId=filas.FilasId)
									  WHERE
									  (ventaslevel1.EventoId = '$EventoId') AND 
									  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
									  (ventaslevel1.CancelUsuarioId = '$usuario') AND 
									  (ventaslevel1.VentasSta = 'CANCELADO') AND
									  $rango")->execute();
                                      
				$query = "SELECT '' as id, ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
									  zonas.ZonasAli,  ventaslevel1.LugaresId,  ventas.VentasTip,
									  ventaslevel1.VentasBolTip,  ventaslevel1.CancelUsuarioId,
									  ventaslevel1.CancelFecHor, lugares.LugaresLug, filas.FilasAli,
									  ventas.VentasFecHor
									  FROM ventaslevel1
									 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
									 INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
									  AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
									  AND (ventaslevel1.ZonasId=zonas.ZonasId)
									 INNER JOIN lugares ON (ventaslevel1.EventoId=lugares.EventoId)
									  AND (ventaslevel1.FuncionesId=lugares.FuncionesId)
									  AND (ventaslevel1.ZonasId=lugares.ZonasId)
									  AND (ventaslevel1.SubzonaId=lugares.SubzonaId)
									  AND (ventaslevel1.FilasId=lugares.FilasId)
									  AND (ventaslevel1.LugaresId=lugares.LugaresId)
									 INNER JOIN filas ON (lugares.EventoId=filas.EventoId)
									  AND (lugares.FuncionesId=filas.FuncionesId)
									  AND (lugares.ZonasId=filas.ZonasId)
									  AND (lugares.SubzonaId=filas.SubzonaId)
									  AND (lugares.FilasId=filas.FilasId)
									  WHERE
									  (ventaslevel1.EventoId = '$EventoId') AND 
									  (ventaslevel1.FuncionesId = '$FuncionesId') AND 
									  (ventaslevel1.CancelUsuarioId = '$usuario') AND 
									  (ventaslevel1.VentasSta = 'CANCELADO') AND
									  $rango";
				}
                return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));
		}
        public function getVentasMiasCancelados($usuario, $puntoVenta, $fecha1, $fecha2){
			$hoy = date("Y-m-d");
			
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventaslevel1.CancelFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventaslevel1.CancelFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventaslevel1.CancelFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
              
            $count = Yii::app()->db->createCommand("SELECT  ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventaslevel1.CancelUsuarioId = '$usuario') AND 
									  (ventaslevel1.VentasSta = 'CANCELADO') AND 
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId")->execute();
                                  
			$query = "SELECT '' as id, ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventaslevel1.CancelUsuarioId = '$usuario') AND 
									  (ventaslevel1.VentasSta = 'CANCELADO') AND 
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId";
			return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));
		}
        public function getVentasMiasCortesia($usuario, $puntoVenta, $fecha1, $fecha2){
			$hoy = date("Y-m-d");
			
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventas.VentasFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
            $count = Yii::app()->db->createCommand("SELECT  ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = 'CORTESIA') AND
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId")->execute();
                                  
			$query = "SELECT '' as id, ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = 'CORTESIA') AND
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId";
            return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));
		}
 	
     public function getVentasMiasDuro($usuario, $puntoVenta, $fecha1, $fecha2){
			$hoy = date("Y-m-d");
			
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventas.VentasFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
			$count = Yii::app()->db->createCommand("SELECT  ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = 'BOLETO DURO') AND
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId")->execute();
                                     
			$query = "SELECT '' as id, ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = 'BOLETO DURO') AND
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId";
            return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));                       
		}
        public function getVentasMiasNormal($usuario, $puntoVenta, $fecha1, $fecha2){
			$hoy = date("Y-m-d");
			
			if($fecha1 == '' || $fecha2 == '')
			    $rango = "(ventas.VentasFecHor LIKE '%$hoy%')";
			else
			    $rango = "(ventas.VentasFecHor BETWEEN '$fecha1' AND '$fecha2')";
				
			if(($fecha1 != '' && $fecha2 != '') && ($fecha1 == $fecha2))
			  $rango = "(ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59')";
			
            $count = Yii::app()->db->createCommand("SELECT  ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = 'NORMAL') AND
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId")->execute();

			$query = "SELECT  '' as id, ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
								 	 funciones.FuncionesId,  funciones.funcionesTexto,  
									 COUNT(ventaslevel1.LugaresId) as cantidad,
								 	 SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
								  FROM ventaslevel1
								  INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
								  INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
								  INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
								 	 AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
								  WHERE
									  (ventas.UsuariosId = '$usuario') AND 
									  (ventas.PuntosventaId = '$puntoVenta') AND 
									  (ventaslevel1.VentasSta = 'VENDIDO') AND 
									  (ventaslevel1.VentasBolTip = 'NORMAL') AND
									  $rango									  
								  GROUP BY ventaslevel1.EventoId, funciones.FuncionesId";
			return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));   
		}
        
        public function graficaFechas($EventoId, $FuncionesId, $fecha1, $fecha2){		
		
		if($fecha1 != "" && $fecha2 != "")
			$rango = " AND ventas.VentasFecHor BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' ";
		else
			$rango = "";
		
		if($FuncionesId == 'TODAS'){
			$count = Yii::app()->db->createCommand("SELECT   COUNT(ventaslevel1.LugaresId) as ventas,   DATE(ventas.VentasFecHor) AS fecha
						FROM ventaslevel1 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
						WHERE ventaslevel1.EventoId = '$EventoId'  AND ventaslevel1.VentasSta = 'VENDIDO' 
						AND ventaslevel1.VentasBolTip = 'NORMAL'
						$rango
						GROUP BY DATE(ventas.VentasFecHor) ")->execute();
                                  
			$query = "SELECT   COUNT(ventaslevel1.LugaresId) as ventas,   DATE(ventas.VentasFecHor) AS fecha
						FROM ventaslevel1 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
						WHERE ventaslevel1.EventoId = '$EventoId'  AND ventaslevel1.VentasSta = 'VENDIDO' 
						AND ventaslevel1.VentasBolTip = 'NORMAL'
						$rango
						GROUP BY DATE(ventas.VentasFecHor) ";
		}else{
			$count = Yii::app()->db->createCommand("SELECT   COUNT(ventaslevel1.LugaresId) as ventas,   DATE(ventas.VentasFecHor) AS fecha
						FROM ventaslevel1 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
						WHERE ventaslevel1.EventoId = '$EventoId' AND ventaslevel1.FuncionesId = '$FuncionesId'
						AND ventaslevel1.VentasSta = 'VENDIDO' AND ventaslevel1.VentasBolTip = 'NORMAL'
						$rango
						GROUP BY DATE(ventas.VentasFecHor) ")->execute();
                        
			$query = "SELECT   COUNT(ventaslevel1.LugaresId) as ventas,   DATE(ventas.VentasFecHor) AS fecha
						FROM ventaslevel1 INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
						WHERE ventaslevel1.EventoId = '$EventoId' AND ventaslevel1.FuncionesId = '$FuncionesId'
						AND ventaslevel1.VentasSta = 'VENDIDO' AND ventaslevel1.VentasBolTip = 'NORMAL'
						$rango
						GROUP BY DATE(ventas.VentasFecHor) ";
			}	
		
		      return new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
			));   
		}	
}