<?php

class DistribucionesController extends Controller
{
	public function actionAsignar()
	{
		extract($_POST);	
		$distribucion=Forolevel1::model()->with('funcion')->findByPk(compact('ForoId','ForoMapIntId'));
		echo $distribucion->asignar($EventoId,$FuncionesId)?"true":"false";
	}

	public function actionAsignarATodas()
	{
		extract($_POST);	
		$distribucion=Forolevel1::model()->with('funcion')->findByPk(compact('ForoId','ForoMapIntId'));
		$funciones=Funciones::model()->findAllByAttributes(compact('EventoId'),"FuncionesId<>".$FuncionesId);
		$retorno=true;
		foreach ($funciones as $funcion) {
				if (is_object($funcion)) {
						$retorno=$retorno and $distribucion->asignar($EventoId,$funcion->FuncionesId);
				}	
		}
		echo $retorno?'true '.$funcion->FuncionesId:'false';
	}

	public function actionGuardar()
	{
		$this->render('guardar');
	}


	public function actionNueva()
	{
		$this->render('nueva');
	}

	public function actionIndex($eid,$fid,$foroid)
	{
		#Despliega una lista de distribuciones actuales
		$model=new Forolevel1('search');
		if (isset($_POST['Forolevel1'])) {
			# code...
			$model->attributes=$_POST['Forolevel1'];
			// $model->EventoId=$_POST['Forolevel1'];
		}
		else{
			$model->ForoId=$foroid;
		}
		$this->render('listaDistribuciones',compact('model','eid','fid'));
	}


	// Uncomment the following methods and override them if needed
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'postOnly + asignar asignarATodas ',
			'accessControl'
			// array(
			// 	'class'=>'path.to.FilterClass',
			// 	'propertyName'=>'propertyValue',
			// ),
		);
	}
	public function accessRules()
	{
		return array(

			);
	}

	// public function actions()
	// {
	// 	// return external action classes, e.g.:
	// 	return array(
	// 		'action1'=>'path.to.ActionClass',
	// 		'action2'=>array(
	// 			'class'=>'path.to.AnotherActionClass',
	// 			'propertyName'=>'propertyValue',
	// 		),
	// 	);
	// }
	public function actionActualizar($escenario=""){
	     $eventoId = $_GET['eventoId']; 
         $funcionId = $_GET['funcionId']; 
	     $model = Funciones::model()->find("EventoId=$eventoId AND FuncionesId=$funcionId");  
	     $this->render('actualizar',compact('model'));  
	}
    /****************************************************************************************
 *Manipulacion de coordenadas mapa Chico
 ****************************************************************************************/    
    public function actionGetCoordenadaMapaChico(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $zonaId = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $subzona = Subzona::model()->find("eventoId=$eventoId AND FuncionesId=$funcionId AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
                $data['x1'] = $subzona->SubzonaX1;
                $data['y1'] = $subzona->SubzonaY1;
                $data['x2'] = $subzona->SubzonaX2;
                $data['y2'] = $subzona->SubzonaY2;
                $data['x3'] = $subzona->SubzonaX3;
                $data['y3'] = $subzona->SubzonaY3;
                $data['x4'] = $subzona->SubzonaX4;
                $data['y4'] = $subzona->SubzonaY4;
                $data['x5'] = $subzona->SubzonaX5;
                $data['y5'] = $subzona->SubzonaY5;
                echo json_encode($data);
            }
        }
    }
    public function actionGetCoordenadasMapaChico(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $subzonas = Subzona::model()->findAll("eventoId=$eventoId AND FuncionesId=$funcionId");
                $data = array();
                foreach($subzonas as $key => $subzona):
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['x1'] = $subzona->SubzonaX1;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['y1'] = $subzona->SubzonaY1;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['x2'] = $subzona->SubzonaX2;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['y2'] = $subzona->SubzonaY2;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['x3'] = $subzona->SubzonaX3;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['y3'] = $subzona->SubzonaY3;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['x4'] = $subzona->SubzonaX4;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['y4'] = $subzona->SubzonaY4;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['x5'] = $subzona->SubzonaX5;
                    $data[$subzona->ZonasId][$subzona->SubzonaId]['y5'] = $subzona->SubzonaY5;
                endforeach;
                
                echo json_encode($data);
            }
        }
    }
    public function actionDeleteCoordenadaMapaChico(){
         if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $zonaId    = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId  = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $escenario = $_POST['escenario'];
                $query = "eventoId=$eventoId AND FuncionesId=$funcionId AND ZonasId=$zonaId AND SubzonaId=$subzonaId";
                if($escenario=="todas")
                    $query = "eventoId=$eventoId AND ZonasId=$zonaId AND SubzonaId=$subzonaId";
                $updated = Subzona::model()->updateAll(
                    					array(
                                                'SubzonaX1'=>0,
                                                'SubzonaX2'=>0,
                                                'SubzonaX3'=>0,
                                                'SubzonaX4'=>0,
                                                'SubzonaX5'=>0,
                                                'SubzonaY1'=>0,
                                                'SubzonaY2'=>0,
                                                'SubzonaY3'=>0,
                                                'SubzonaY4'=>0,
                                                'SubzonaY5'=>0,
                                              ),
                                               $query,
                                               array()
                                              );
                if($updated>0)
                    echo json_encode(array('update'=>true));
                else    
                    echo json_encode(array('update'=>false));
                
            }
         }
    } 
    public function actionGuardarCoordenadasMapaChico(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $zonaId    = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId  = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $escenario = $_POST['escenario'];
                $query = "eventoId=$eventoId AND FuncionesId=$funcionId AND ZonasId=$zonaId AND SubzonaId=$subzonaId";
                if($escenario=="todas")
                    $query = "eventoId=$eventoId AND ZonasId=$zonaId AND SubzonaId=$subzonaId";
                $updated = Subzona::model()->updateAll(
                    					array(
                                                'SubzonaX1'=>$_POST['x1'],
                                                'SubzonaX2'=>$_POST['x2'],
                                                'SubzonaX3'=>$_POST['x3'],
                                                'SubzonaX4'=>$_POST['x4'],
                                                'SubzonaX5'=>$_POST['x5'],
                                                'SubzonaY1'=>$_POST['y1'],
                                                'SubzonaY2'=>$_POST['y2'],
                                                'SubzonaY3'=>$_POST['y3'],
                                                'SubzonaY4'=>$_POST['y4'],
                                                'SubzonaY5'=>$_POST['y5'],
                                              ),
                                               $query,
                                               array()
                                              );
                if($updated>0)
                    echo json_encode(array('update'=>true));
                else    
                    echo json_encode(array('update'=>false));
            }
        }    
    }
/****************************************************************************************
 *Manipulacion de coordenadas mapa Grande
 ****************************************************************************************/  
    public function actionGetCoordenadaMapaGrande(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $zonaId = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $mapa_grande = MapaGrande::model()->find("eventoId=$eventoId AND FuncionId=$funcionId");
                $coordenada = Yii::app()->db->createCommand("SELECT * FROM configurl_mapa_grande_coordenadas WHERE configurl_funcion_mapa_grande_id=$mapa_grande->id AND ZonasId=$zonaId AND SubzonaId=$subzonaId")->queryRow();
                
                //$subzona = Subzona::model()->find("eventoId=$eventoId AND FuncionesId=$funcionId AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
                $data['x1'] = $coordenada['x1'];
                $data['y1'] = $coordenada['y1'];
                $data['x2'] = $coordenada['x2'];
                $data['y2'] = $coordenada['y2'];
                $data['x3'] = $coordenada['x3'];
                $data['y3'] = $coordenada['y3'];
                $data['x4'] = $coordenada['x4'];
                $data['y4'] = $coordenada['y4'];
                $data['x5'] = $coordenada['x5'];
                $data['y5'] = $coordenada['y5'];
                $data['x6'] = $coordenada['x6'];
                $data['y6'] = $coordenada['y6'];
                $data['x7'] = $coordenada['x7'];
                $data['y7'] = $coordenada['y7'];
                $data['x8'] = $coordenada['x8'];
                $data['y8'] = $coordenada['y8'];
                $data['x9'] = $coordenada['x9'];
                $data['y9'] = $coordenada['y9'];
                $data['x10'] = $coordenada['x10'];
                $data['y10'] = $coordenada['y10'];
                $data['x11'] = $coordenada['x11'];
                $data['y11'] = $coordenada['y11'];
                $data['x12'] = $coordenada['x12'];
                $data['y12'] = $coordenada['y12'];
                $data['x13'] = $coordenada['x13'];
                $data['y13'] = $coordenada['y13'];
                $data['x14'] = $coordenada['x14'];
                $data['y14'] = $coordenada['y14'];
                echo json_encode($data);
            }
        }
    } 
    public function actionGuardarCoordenadasMapaGrande(){
         if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $zonaId = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $escenario = $_POST['escenario'];
                $query = "eventoId=$eventoId AND FuncionId=$funcionId";
                if($escenario=="todas")
                    $query = "eventoId=$eventoId";
                    
                $mapa_grande = MapaGrande::model()->findAll($query);
                foreach($mapa_grande as $key =>$mapa):
                    $coordenada = Yii::app()->db->createCommand()->update('configurl_mapa_grande_coordenadas',
                                                                      array(
                                                                            'x1'=>(empty($_POST['x1'])?null:$_POST['x1']),
                                                                            'x2'=>(empty($_POST['x2'])?null:$_POST['x2']),
                                                                            'x3'=>(empty($_POST['x3'])?null:$_POST['x3']),
                                                                            'x4'=>(empty($_POST['x4'])?null:$_POST['x4']),
                                                                            'x5'=>(empty($_POST['x5'])?null:$_POST['x5']),
                                                                            'x6'=>(empty($_POST['x6'])?null:$_POST['x6']),
                                                                            'x7'=>(empty($_POST['x7'])?null:$_POST['x7']),
                                                                            'x8'=>(empty($_POST['x8'])?null:$_POST['x8']),
                                                                            'x9'=>(empty($_POST['x9'])?null:$_POST['x9']),
                                                                            'x10'=>(empty($_POST['x10'])?null:$_POST['x10']),
                                                                            'x11'=>(empty($_POST['x11'])?null:$_POST['x11']),
                                                                            'x12'=>(empty($_POST['x12'])?null:$_POST['x12']),
                                                                            'x13'=>(empty($_POST['x13'])?null:$_POST['x13']),
                                                                            'x14'=>(empty($_POST['x14'])?null:$_POST['x14']),
                                                                            'y1'=>(empty($_POST['y1'])?null:$_POST['y1']),
                                                                            'y2'=>(empty($_POST['y2'])?null:$_POST['y2']),
                                                                            'y3'=>(empty($_POST['y3'])?null:$_POST['y3']),
                                                                            'y4'=>(empty($_POST['y4'])?null:$_POST['y4']),
                                                                            'y5'=>(empty($_POST['y5'])?null:$_POST['y5']),
                                                                            'y6'=>(empty($_POST['y6'])?null:$_POST['y6']),
                                                                            'y7'=>(empty($_POST['y7'])?null:$_POST['y7']),
                                                                            'y8'=>(empty($_POST['y8'])?null:$_POST['y8']),
                                                                            'y9'=>(empty($_POST['y9'])?null:$_POST['y9']),
                                                                            'y10'=>(empty($_POST['y10'])?null:$_POST['y10']),
                                                                            'y11'=>(empty($_POST['y11'])?null:$_POST['y11']),
                                                                            'y12'=>(empty($_POST['y12'])?null:$_POST['y12']),
                                                                            'y13'=>(empty($_POST['y13'])?null:$_POST['y13']),
                                                                            'y14'=>(empty($_POST['y14'])?null:$_POST['y14']),
                                                                            ),
                                                                      'configurl_funcion_mapa_grande_id= :id AND ZonasId=:ZonasId AND SubzonaId=:SubzonaId',
                                                                      array(':id'=>$mapa->id,':ZonasId'=>$zonaId,'SubzonaId'=>$subzonaId)
                                                                      );
                endforeach;
                /*$mapa_grande = MapaGrande::model()->find("eventoId=$eventoId AND FuncionId=$funcionId");
                $coordenada = Yii::app()->db->createCommand()->update('configurl_mapa_grande_coordenadas',
                                                                      array(
                                                                            'x1'=>(empty($_POST['x1'])?null:$_POST['x1']),
                                                                            'x2'=>(empty($_POST['x2'])?null:$_POST['x2']),
                                                                            'x3'=>(empty($_POST['x3'])?null:$_POST['x3']),
                                                                            'x4'=>(empty($_POST['x4'])?null:$_POST['x4']),
                                                                            'x5'=>(empty($_POST['x5'])?null:$_POST['x5']),
                                                                            'x6'=>(empty($_POST['x6'])?null:$_POST['x6']),
                                                                            'x7'=>(empty($_POST['x7'])?null:$_POST['x7']),
                                                                            'x8'=>(empty($_POST['x8'])?null:$_POST['x8']),
                                                                            'x9'=>(empty($_POST['x9'])?null:$_POST['x9']),
                                                                            'x10'=>(empty($_POST['x10'])?null:$_POST['x10']),
                                                                            'x11'=>(empty($_POST['x11'])?null:$_POST['x11']),
                                                                            'x12'=>(empty($_POST['x12'])?null:$_POST['x12']),
                                                                            'x13'=>(empty($_POST['x13'])?null:$_POST['x13']),
                                                                            'x14'=>(empty($_POST['x14'])?null:$_POST['x14']),
                                                                            'y1'=>(empty($_POST['y1'])?null:$_POST['y1']),
                                                                            'y2'=>(empty($_POST['y2'])?null:$_POST['y2']),
                                                                            'y3'=>(empty($_POST['y3'])?null:$_POST['y3']),
                                                                            'y4'=>(empty($_POST['y4'])?null:$_POST['y4']),
                                                                            'y5'=>(empty($_POST['y5'])?null:$_POST['y5']),
                                                                            'y6'=>(empty($_POST['y6'])?null:$_POST['y6']),
                                                                            'y7'=>(empty($_POST['y7'])?null:$_POST['y7']),
                                                                            'y8'=>(empty($_POST['y8'])?null:$_POST['y8']),
                                                                            'y9'=>(empty($_POST['y9'])?null:$_POST['y9']),
                                                                            'y10'=>(empty($_POST['y10'])?null:$_POST['y10']),
                                                                            'y11'=>(empty($_POST['y11'])?null:$_POST['y11']),
                                                                            'y12'=>(empty($_POST['y12'])?null:$_POST['y12']),
                                                                            'y13'=>(empty($_POST['y13'])?null:$_POST['y13']),
                                                                            'y14'=>(empty($_POST['y14'])?null:$_POST['y14']),
                                                                            ),
                                                                      'configurl_funcion_mapa_grande_id= :id AND ZonasId=:ZonasId AND SubzonaId=:SubzonaId',
                                                                      array(':id'=>$mapa_grande->id,':ZonasId'=>$zonaId,'SubzonaId'=>$subzonaId)
                                                                      );*/
                echo json_encode(array('update'=>true));                                                      
                /*if($coordenada>0)
                    echo json_encode(array('update'=>true));
                else    
                    echo json_encode(array('update'=>false));*/
            }
         }
    }
    public function actionDeleteCoordenadaMapaGrande(){
         if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $zonaId = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $escenario = $_POST['escenario'];
                $query = "eventoId=$eventoId AND FuncionId=$funcionId";
                if($escenario=="todas")
                    $query = "eventoId=$eventoId";
                    
                $mapa_grande = MapaGrande::model()->findAll($query);
                foreach($mapa_grande as $key =>$mapa):
                    $coordenada = Yii::app()->db->createCommand()->update('configurl_mapa_grande_coordenadas',
                                                                      array(
                                                                            'x1'=>null,
                                                                            'x2'=>null,
                                                                            'x3'=>null,
                                                                            'x4'=>null,
                                                                            'x5'=>null,
                                                                            'x6'=>null,
                                                                            'x7'=>null,
                                                                            'x8'=>null,
                                                                            'x9'=>null,
                                                                            'x10'=>null,
                                                                            'x11'=>null,
                                                                            'x12'=>null,
                                                                            'x13'=>null,
                                                                            'x14'=>null,
                                                                            'y1'=>null,
                                                                            'y2'=>null,
                                                                            'y3'=>null,
                                                                            'y4'=>null,
                                                                            'y5'=>null,
                                                                            'y6'=>null,
                                                                            'y7'=>null,
                                                                            'y8'=>null,
                                                                            'y9'=>null,
                                                                            'y10'=>null,
                                                                            'y11'=>null,
                                                                            'y12'=>null,
                                                                            'y13'=>null,
                                                                            'y14'=>null,
                                                                            ),
                                                                      'configurl_funcion_mapa_grande_id= :id AND ZonasId=:ZonasId AND SubzonaId=:SubzonaId',
                                                                      array(':id'=>$mapa->id,':ZonasId'=>$zonaId,'SubzonaId'=>$subzonaId)
                                                                      );
                endforeach;
                echo json_encode(array('update'=>true));       
            }
         }
    }    
    public function actionGetCoordenadasMapaGrande(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $mapa_grande = MapaGrande::model()->find("eventoId=$eventoId AND FuncionId=$funcionId");
                $coordenadas = Yii::app()->db->createCommand("SELECT * FROM configurl_mapa_grande_coordenadas WHERE configurl_funcion_mapa_grande_id=$mapa_grande->id")->queryAll();
                //$subzonas = Subzona::model()->findAll("eventoId=$eventoId AND FuncionesId=$funcionId");
                $data = array();
                foreach($coordenadas as $key => $coordenada):
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x1'] = $coordenada['x1'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y1'] = $coordenada['y1'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x2'] = $coordenada['x2'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y2'] = $coordenada['y2'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x3'] = $coordenada['x3'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y3'] = $coordenada['y3'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x4'] = $coordenada['x4'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y4'] = $coordenada['y4'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x5'] = $coordenada['x5'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y5'] = $coordenada['y5'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x6'] = $coordenada['x6'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y6'] = $coordenada['y6'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x7'] = $coordenada['x7'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y7'] = $coordenada['y7'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x8'] = $coordenada['x8'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y8'] = $coordenada['y8'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x9'] = $coordenada['x9'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y9'] = $coordenada['y9'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x10'] = $coordenada['x10'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y10'] = $coordenada['y10'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x11'] = $coordenada['x11'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y11'] = $coordenada['y11'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x12'] = $coordenada['x12'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y12'] = $coordenada['y12'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x13'] = $coordenada['x13'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y13'] = $coordenada['y13'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x14'] = $coordenada['x14'];
                    $data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y14'] = $coordenada['y14'];
                endforeach;
                
                echo json_encode($data);
            }
        }
    }
/************************************************************************************************************************
 *Fin coordenadas Mapa Grande y Chico
 ************************************************************************************************************************/ 
     public function actionGetUrlImagenMapaChico(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $eventoId  = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $funcion   = Funciones::model()->find("EventoId=$eventoId AND FuncionesId=$funcionId");
                $foro      =  Forolevel1::model()->find("ForoId=$funcion->ForoId AND ForoMapIntId=$funcion->ForoMapIntId");
                $data      =  array('url'=>"https://www.taquillacero.com/imagesbd/$foro->ForoMapPat");
                echo json_encode($data);
            }
        }
     }
     public function actionGetUrlImagenMapaGrande(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $eventoId   = $_POST['eventoId'];
                $funcionId  = $_POST['funcionId'];
                $mapaGrande = MapaGrande::model()->find("EventoId=$eventoId AND FuncionId=$funcionId");
                $data       =  array('url'=>"https://www.taquillacero.com/imagesbd/$mapaGrande->nombre_imagen");
                echo json_encode($data);
            }
        }
     }
     public function actionGetSubzonas(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $data      = "<option data-zona='' data-subzona=''>Selecciona una Sub-Zona</option>";
                $eventoId  = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $subzonas  =  Subzona::model()->findAll(array('condition'=>"t.EventoId=$eventoId AND t.FuncionesId =$funcionId"));
                foreach($subzonas as $key => $subzona):
                     $data .= "<option data-zona='$subzona->ZonasId' data-subzona='$subzona->SubzonaId'>".$subzona->zonas->ZonasAli."-".$subzona->SubzonaId."</option>";
                endforeach;
                echo $data;
            }
        }
     }
     public function actionSubirImagenMapaChico(){
			if (Yii::app()->request->isAjaxRequest ) {
			        $foroId       = $_POST['foroId'];
                    $foroMapIntId = $_POST['foroMapIntId'];
                    $forolevel1 = Forolevel1::model()->find("ForoId=$foroId AND ForoMapIntId=$foroMapIntId");
					$prefijo='';
					if (isset($_POST['prefijo'])) {
						$prefijo=$_POST['prefijo'];
					}	
					$imagen=CUploadedFile::getInstanceByName('imagen');
					if (!is_null($imagen)) {
							$filename=$prefijo.$imagen->name;
                            $forolevel1->ForoMapPat = $filename;
                            if($forolevel1->update()){
                                if ($imagen->saveAs(
									sprintf(
											"../imagesbd/%s",
											$filename)
									))
									echo $filename;
                            }
							
					}	
					else{
							echo 0;
					}
			}
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );

		
	}
    public function actionSubirImagenMapaGrande(){
			if (Yii::app()->request->isAjaxRequest ) {
			        $eventoId  = $_POST['eventoId'];
                    //$funcionId = $_POST['funcionId'];
					$prefijo='';
					if (isset($_POST['prefijo'])) {
						$prefijo=$_POST['prefijo'];
					}	
					$imagen=CUploadedFile::getInstanceByName('imagen');
					if (!is_null($imagen)) {
							$filename=$prefijo.$imagen->name;
                            
                            $updated = MapaGrande::model()->updateAll(
                    					array(
                                                'nombre_imagen'=>$filename
                                              ),//Equivalente al set de un update //
                                              //"EventoId=:eventoId AND FuncionId=:funcionId",
                                              "EventoId=:eventoId",
                                               array( 
                                                        'eventoId'  => $eventoId, 
                                                        //'funcionId' => $funcionId,
                                                    )
                                              );
                                        
                            if($updated>0){
                                if ($imagen->saveAs(
									sprintf(
											"../imagesbd/%s",
											$filename)
									))
									echo $filename;
                            }
							
					}	
					else{
							echo 0;
					}
			}
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );

		
	}
    public function actionEditor($EventoId,$FuncionesId,$scenario='asignacion')
    {

        // $model=Forolevel1::model()->with('zonas')->findByPk(compact('ForoId','ForoMapIntId'));
        $model=Funciones::model()->with('zonas')->findByPk(compact('EventoId','FuncionesId'));
        // if(is_object($model))
            $this->render('editor',compact('model','scenario'),false,true);
        // else{
        //     throw new Exception("Error Processing Request", 1);
        // }

    }
    public function actionAgregarZona($EventoId, $FuncionesId)
    {
        # Agrega una zona a la distribucion 
        $funcion=Funciones::model()->findByPk(compact('EventoId','FuncionesId'));
        if(is_object($funcion)){
            #Si existe la funcion bajo los parametros que se le envian
            $zona=$funcion->agregarZona();
            if ($zona and is_object($zona)) {
                # Si se agrego correctamente la zona a la funcion renderiza el formulario de zona
                $this->renderPartial('_zona',array('model'=>$zona));
                return true;
            }
            
        }
        echo "false";

    }
    public function actionAsignarValorZona()
    {
        # Cambia el nombre de una zona dada
        // $model=Zonas::model()->findByPk($_POST['EventoId'],$_POST['FuncionesId'],$_POST['ZonasId']);
        extract($_POST['Zonas']);
        $model=Zonas::model()->findByPk(compact('EventoId','FuncionesId','ZonasId'));
        $model->attributes=$_POST['Zonas'];
		$model->save();
        echo CJSON::encode($model);
    }

	public function actionEliminarZona()
	{
			if (isset($_POST)) {
					$zona=Zonas::model()->findByPk($_POST['Zonas']);
					echo $zona->delete()?"true":'false';
			}	
			else{
					throw new Exception("Error al procesar su petición, vefique integridad de parametros ", 1);
			}
			
	}

	public function actionGenerarArbolCargos()
	{
			// Genera o repara el arbol de zonaslevel1
			if (isset($_POST['Zonas'])) {
					$zona=Zonas::model()->findByPk($_POST['Zonas']);
					$zonas->generarArbolCargos();
					$raiz=Zonaslevel1::model()->with('puntoventa')->findByPk(array(
							'EventoId'=>$model->EventoId,
							'FuncionesId'=>$model->FuncionesId,
							'ZonasId'=>$model->ZonasId,
							'PuntosventaId'=>Yii::app()->params['pvRaiz']
					));
					if (is_object($raiz)) {
							// Si el nodo raiz esta asignado
							$this->renderPartial('_nodoCargo', array('model'=>$raiz));
					}	
					else
							echo "";
			}
			else{
					throw new Exception("Error al procesar su petición, vefique integridad de parametros ", 1);
			}

	}

}
