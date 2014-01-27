<?php

class FarmatodoController extends Controller
{
	public function actionIndex()
	{
		
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
	
	}
    public function actionDelete(){
         //if(Yii::app()->user->isGuest)
			//$this->redirect(Yii::app()->request->baseUrl);
        $error_boleto_duplicado = "";
        $error   = "";
        $success = "";
        $data    = "";    
        if(!empty($_POST['delete'])):
            foreach($_POST['delete'] as $key => $del):
                //$data .=  $del."<br/>";
                
                $ref        = explode("_",$del);
                $referencia = $ref[0];
                $lugares    = $ref[1];
                $sucursal   = $ref[2];
                $evento     = $ref[3];
                $funcion    = $ref[4];
                $boleto_duplicado = Yii::app()->db->createCommand("SELECT * FROM ventaslevel1 WHERE ventaslevel1.VentasSta='CANCELADO' AND ventaslevel1.LugaresId = $lugares AND VentasId in (select VentasId from ventas where ventas.VentasNumRef='$referencia')")->execute();
                if($boleto_duplicado >= 2 && !empty($referencia)):
                    $error_boleto_duplicado .= "Este boleto est&aacute; duplicado:<br/>Referencia: ".$referencia. "Asiento: ".$lugares;
                    $data .= $boleto_duplicado;
                else:
                   $cancelacion = Yii::app()->db->createCommand("update ventaslevel1 set VentasSta='CANCELADO',CancelUsuarioId ='".Yii::app()->user->id."',CancelFecHor = '".date("Y-m-d H:i:s")."' where ventaslevel1.LugaresId = $lugares AND VentasId in (select VentasId from ventas where ventas.VentasNumRef='$referencia')")->execute();
                    if($cancelacion > 0):
                        $success .= "Zona: ".$ref[5]." Fila: ".$ref[6]." Asiento: ".$ref[7]."<br/>";
                        $data .= "cancelado";
                        $query = "select * from ventaslevel1 where VentasId in (select VentasId from ventas where ventas.VentasNumRef='$referencia')";
                            $ventaslevel1 = new CSqlDataProvider($query); 
                               foreach($ventaslevel1->getData() as $key => $vl1):
                               //Se cambia el LugaresStatus a TRUE en la Tabla lugares
                                    $status = Yii::app()->db->createCommand("UPDATE lugares l SET LugaresStatus='TRUE' WHERE l.EventoId = ".$vl1['EventoId']." AND l.FuncionesId = ".$vl1['FuncionesId']." AND l.ZonasId = ".$vl1['ZonasId']." AND l.SubzonaId = ".$vl1['SubzonaId']." AND l.FilasId = ".$vl1['FilasId']." AND l.LugaresId = ".$vl1['LugaresId'])->execute();
                                    if($status > 0):
                               //Se eliminan las reservaciones de la tabla templugares     
                                            Yii::app()->db->createCommand("DELETE FROM templugares  WHERE EventoId = ".$vl1['EventoId']." AND FuncionesId = ".$vl1['FuncionesId']." AND ZonasId = ".$vl1['ZonasId']." AND SubzonaId = ".$vl1['SubzonaId']." AND FilasId = ".$vl1['FilasId']." AND LugaresId = ".$vl1['LugaresId'])->execute();
                                    endif;    
                               endforeach;
                    else:
                        $error .=  "El boleto con referencia ".$referencia." y numero de asiento ".$lugares." no fue cancelado";
                    endif; 
                endif;
                
                //$cancelacion = Yii::app()->db->createCommand("update ventaslevel1 set VentasSta='CANCELADO',CancelUsuarioId ='".Yii::app()->user->id."',CancelFecHor = '".date("Y-m-d H:i:s")."' where ventaslevel1.LugaresId = $lugares AND VentasId in (select VentasId from ventas where ventas.VentasNumRef='$referencia')")->execute();
                //echo $cancelacion;
                //print_r(preg_split("_",$del));
            endforeach;
            if(!empty($error_boleto_duplicado) or !empty($error)):
                 Yii::app()->user->setFlash('error',$error_boleto_duplicado.'<br/>'.$error);
            endif;
            if(!empty($success)):
                 Yii::app()->user->setFlash('success',"<b>Boletos Cancelados con &eacute;xito:</b><br/><br/>Referencia: ".$referencia.'<br/>Sucursal: '.$sucursal.'<br/>Evento: '.$evento.'<br/> Funci&oacute;n: '.$funcion."<br/><br/>".$success.'<br/><button class="btn btn-success" onClick="document.location.reload(true)">Ok</button>');
            endif;
                        
            //Yii::app()->user->setFlash('success2',$data.'<br/>'.$sucursal.'<br/>'.$evento.'<br/>'.$funcion.'<br/>'.$zona.'<br/>'.$fila.'<br/>'.$asiento.'<br/><br/><input type="button" value="OK" onClick="document.location.reload(true)">');
            $this->redirect(array("reportes/ventasCancelaciones"));
        else:
        Yii::app()->user->setFlash('error', 'No se mand&oacute; informaci&oacute;n para procesar <br/><br/><input type="button" value="OK" onClick="document.location.reload(true)">');    
        endif;
        //$this->render("index");
        $this->redirect(array("reportes/ventasCancelaciones"));
    }
   /* public function actionDelete($id){
        if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
     //Cambia el estatus a cancelado con respecto al numero de referencia 
     $cancelacion = Yii::app()->db->createCommand("update ventaslevel1 set VentasSta='CANCELADO',CancelUsuarioId ='".Yii::app()->user->id."',CancelFecHor = '".date("Y-m-d H:i:s")."' where VentasId in (select VentasId from ventas where ventas.VentasNumRef='$id')")->execute();
     
     //Se obtiene el dato que se va a cambiar, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId
     if($cancelacion > 0):
        $query = "select * from ventaslevel1 where VentasId in (select VentasId from ventas where ventas.VentasNumRef='$id')";
        $ventaslevel1 = new CSqlDataProvider($query); 
           foreach($ventaslevel1->getData() as $key => $vl1):
           //Se cambia el LugaresStatus a TRUE en la Tabla lugares
                $status = Yii::app()->db->createCommand("UPDATE lugares l SET LugaresStatus='TRUE' WHERE l.EventoId = ".$vl1['EventoId']." AND l.FuncionesId = ".$vl1['FuncionesId']." AND l.ZonasId = ".$vl1['ZonasId']." AND l.SubzonaId = ".$vl1['SubzonaId']." AND l.FilasId = ".$vl1['FilasId']." AND l.LugaresId = ".$vl1['LugaresId'])->execute();
                if($status > 0):
           //Se eliminan las reservaciones de la tabla templugares     
                        Yii::app()->db->createCommand("DELETE FROM templugares  WHERE EventoId = ".$vl1['EventoId']." AND FuncionesId = ".$vl1['FuncionesId']." AND ZonasId = ".$vl1['ZonasId']." AND SubzonaId = ".$vl1['SubzonaId']." AND FilasId = ".$vl1['FilasId']." AND LugaresId = ".$vl1['LugaresId'])->execute();
                endif;    
           endforeach;
      endif;
    }*/
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
