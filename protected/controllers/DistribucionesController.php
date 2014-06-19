<?php

class DistribucionesController extends Controller
{
		public $scenario;
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'postOnly + asignar asignarATodas generarAsientosGenerales asignarValorFila',
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
						array(
								'deny',
								'actions'=>array('index'),
								'users'=>array('?'),
						),
						array(
								'allow',
								'actions'=>array('index', 'asignar','editor','generarAsientosGenerales'),
								'roles'=>array('admin'),
						),
						array(
								'deny',
								'actions'=>array('@'),
								//'actions'=>array('asignar editor'),
								'users'=>array('*'),
						),
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

		public function actionAsignar()
	{
		extract($_POST);	
		$distribucion=Forolevel1::model()->with('funcion')->findByPk(compact('ForoId','ForoMapIntId'));
		echo $distribucion->asignar($EventoId,$FuncionesId)?"true":"false";
	}

		public function actionAsignarComo()
	{
		extract($_POST);	
		$distribucion=Forolevel1::model()->with('funcion')->findByPk(compact('ForoId','ForoMapIntId'));
		$funcion=Funciones::model()->findByPk(compact('EventoId','FuncionesId'));
		if ($distribucion->asignar($EventoId,$FuncionesId)) {
				// Se asigna a la distribucion origen y si todo es correcto se inserta como nueva
				$distribucion->scenario='insert';
				$distribucion->ForoMapIntNom=$ForoMapIntNom;
				if($distribucion->save()){
						//Si se logra insertar como nueva se le asigna a la funcion los ids
						$funcion->ForoId=$distribucion->ForoId;
						$funcion->ForoMapIntId=$distribucion->ForoMapIntId;
						echo $funcion->save()?'true':'false';
				}
				else
						echo 'false';
									

		}
		else 
				echo 'false';
	}
	public function actionAsignarATodas()
	{
		extract($_POST);	
		$distribucion=Forolevel1::model()->with('funcion')->findByPk(compact('ForoId','ForoMapIntId'));
		$funciones=Funciones::model()->findAllByAttributes(compact('EventoId')
				,"FuncionesId<>".$distribucion->funcion->FuncionesId
		);
		$retorno=sizeof($funciones)>0;
		foreach ($funciones as $funcion) {
				if (is_object($funcion)) {
						$retorno=$retorno and $distribucion->asignar($EventoId,$funcion->FuncionesId);
				}	
		}
		echo $retorno?'true':'false';
	}


	public function actionNueva()
	{
			if (isset($_POST['Funciones'])) {
					$funcion=Funciones::model()->findByAttributes($_POST['Funciones']);
					if (is_object($funcion)) {
							// Si la funcion a aplicar existe
							$distribucion=new Forolevel1;
							$distribucion->ForoId=$funcion->ForoId;		
							if($distribucion->save()){
									//Si se guarda correctamente la distribucion, se crea la primera zona
									$funcion->ForoMapIntId=$distribucion->ForoMapIntId;
									if($funcion->agregarZona())
											echo $funcion->save()?'true':'false';
									else 
											echo 'false';

							}
							else{
									throw new CHttpException ( 404, 'Error al registrar la distribución.' );
							}
					}	
			}	
			else{
					throw new CHttpException ( 404, 'Parametros incorrectos' );
			}
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



	//public function actionActualizar($scenario=""){

		//$this->scenario=$scenario;	
		 //$eventoId = $_GET['eventoId']; 
         //$funcionId = $_GET['funcionId']; 
		 //$model = Funciones::model()->find("EventoId=$eventoId AND FuncionesId=$funcionId");  
		 //$this->render('actualizar',compact('model'));  
	//}
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
                                                'SubzonaX1'=>0, 'SubzonaX2'=>0, 'SubzonaX3'=>0, 'SubzonaX4'=>0,
                                                'SubzonaX5'=>0, 'SubzonaY1'=>0, 'SubzonaY2'=>0, 'SubzonaY3'=>0,
                                                'SubzonaY4'=>0, 'SubzonaY5'=>0,
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
				for($i=1;$i<15;$i++){
						$data['x'.$i] = $coordenada['x'.$i];
						$data['y'.$i] = $coordenada['y'.$i];
				}
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
                if($escenario=="todas"){
                    $query = "eventoId=$eventoId";
                    $configUrlMapaGrande = ConfigurlFuncionesMapaGrande::model()->findAll($query);
                    foreach($configUrlMapaGrande as $key => $mapaGrande):
                        $coordenadasMapaGrande = ConfigurlMapaGrandeCoordenadas::model()->find("configurl_funcion_mapa_grande_id=$mapaGrande->id AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
                        if(empty($coordenadasMapaGrande)){
                            $nuevaCoordenada = new ConfigurlMapaGrandeCoordenadas;
                            $nuevaCoordenada->configurl_funcion_mapa_grande_id = $mapaGrande->id;
                            $nuevaCoordenada->ZonasId                          = $zonaId;
                            $nuevaCoordenada->SubzonaId                        = $subzonaId;
                            $nuevaCoordenada->save(false);
                        }
                    endforeach;
                    
                }else{
                    $configUrlMapaGrande = ConfigurlFuncionesMapaGrande::model()->find($query);
                    $coordenadasMapaGrande = ConfigurlMapaGrandeCoordenadas::model()->find("configurl_funcion_mapa_grande_id=$configUrlMapaGrande->id AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
                        if(empty($coordenadasMapaGrande)){
                            $nuevaCoordenada = new ConfigurlMapaGrandeCoordenadas;
                            $nuevaCoordenada->configurl_funcion_mapa_grande_id = $configUrlMapaGrande->id;
                            $nuevaCoordenada->ZonasId                          = $zonaId;
                            $nuevaCoordenada->SubzonaId                        = $subzonaId;
                            $nuevaCoordenada->save(false);
                        }
                }
                    
                
                    
                $mapa_grande = MapaGrande::model()->findAll($query);
                foreach($mapa_grande as $key =>$mapa):
						$coords=array();
						for($i=1;$i<15;$i++){
								$coords['x'.$i]=(empty($_POST['x'.$i])?null:$_POST['x'.$i]);
								$coords['y'.$i]=(empty($_POST['y'.$i])?null:$_POST['y'.$i]);
						}
                    $coordenada = Yii::app()->db->createCommand()->update('configurl_mapa_grande_coordenadas',
							$coords,
							'configurl_funcion_mapa_grande_id= :id AND ZonasId=:ZonasId AND SubzonaId=:SubzonaId',
							array(':id'=>$mapa->id,':ZonasId'=>$zonaId,'SubzonaId'=>$subzonaId)
                                                                      );
                endforeach;
                echo json_encode(array('update'=>true));                                                      
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
									'x1'=>null, 'x2'=>null, 'x3'=>null, 'x4'=>null,
									'x5'=>null, 'x6'=>null, 'x7'=>null, 'x8'=>null,
									'x9'=>null, 'x10'=>null, 'x11'=>null, 'x12'=>null,
									'x13'=>null, 'x14'=>null, 'y1'=>null, 'y2'=>null,
									'y3'=>null, 'y4'=>null, 'y5'=>null, 'y6'=>null,
									'y7'=>null, 'y8'=>null, 'y9'=>null, 'y10'=>null,
									'y11'=>null, 'y12'=>null, 'y13'=>null, 'y14'=>null,
							), 'configurl_funcion_mapa_grande_id= :id AND ZonasId=:ZonasId AND SubzonaId=:SubzonaId',
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
                $mapa_grande = MapaGrande::model()->find("EventoId=$eventoId AND FuncionId=$funcionId");
                $coordenadas = Yii::app()->db->createCommand("SELECT * FROM configurl_mapa_grande_coordenadas WHERE configurl_funcion_mapa_grande_id=$mapa_grande->id")->queryAll();
                //$subzonas = Subzona::model()->findAll("eventoId=$eventoId AND FuncionesId=$funcionId");
                $data = array();
                foreach($coordenadas as $key => $coordenada):
						for($i=1;$i<15;$i++){
								$data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['x'.$i] = $coordenada['x'.$i];
								$data[$coordenada['ZonasId']][$coordenada['SubzonaId']]['y'.$i] = $coordenada['y'.$i];
						}
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
		$this->scenario=$scenario;
		$model=Funciones::model()->with(
				array(
						'zonas'=>array(
								'with'=>'evento'
						),
						array(
								'forolevel1'=>array(
										'with'=>array('eventos')
								))))->findByPk(compact('EventoId','FuncionesId'));
		 if(is_object($model))
		switch ($scenario) {
					case 'nueva':
					case 'editar':
						// En caso de la asignacion se cargan los formulario con campos deshabilitados
							if (isset($model->forolevel1) and $model->forolevel1->esEditable()) {
									// Si la funcion tiene efectivamente una distribucion y esta puede editarse por completo
									$this->render('editor',compact('model'),false,true);
									break;
							}	
							//else
									//echo CHtml::tag('h1',array(),serialize($model->forolevel1->esEditable()));
							break;
					case 'asignacion':
						// En caso de la asignacion se cargan los formulario con campos deshabilitados
					default:
						$this->render('asignar',compact('model'),false,true);
						break;
				}
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
                $this->renderPartial('_zona',array('model'=>$zona,'editar'=>true));
                return true;
            }
            
		}
		else
				echo "false";

    }
    public function actionAsignarValorZona()
    {
        # Cambia el nombre de una zona dada
        // $model=Zonas::model()->findByPk($_POST['EventoId'],$_POST['FuncionesId'],$_POST['ZonasId']);
        extract($_POST['Zonas']);
        $model=Zonas::model()->findByPk(compact('EventoId','FuncionesId','ZonasId'));
		if (isset($_POST['Zonas']['ZonasCantSubZon'])) {
				// CASO ESPECIAL CUANDO SE CAMBIA EL NUMERO DE SUBZONAS
				// Se eliminan todas las subzonas y con ello todas las filas y lugares de la zona y se generan las subzonas
				$diff=$_POST['Zonas']['ZonasCantSubZon']-$model->ZonasCantSubZon;
				if ($diff!=0) {
						//echo "Se va a modificar las subzonas ".$diff;
					// Si el numero de zonas que se quiere es mayor al que se tiene solo se agregan l
						 $model->eliminarSubzonas();
						 $model->agregarSubzonas($_POST['Zonas']['ZonasCantSubZon']);
				}
		}	
		$model->attributes=$_POST['Zonas'];
		$model->save();
        echo CJSON::encode($model);
    }

	public function actionActualizar($EventoId, $FuncionesId)
	{
			// Establece el los datos de la distribucion
			$funcion=Funciones::model()->with('forolevel1')->findByPk(compact('EventoId','FuncionesId'));
			if (isset($funcion->forolevel1)) {
					$model=$funcion->forolevel1;
					if (isset($_POST['Forolevel1'])) {
							// Si se reciben datos del formulario de edicion de distribucion se guardan los datos
							$model->attributes=$_POST['Forolevel1'];
							if (isset($_POST['Forolevel1']['ForoId'])) {
									// Si se cambio el foro  se cambia tambien en la funcion
									$funcion->ForoId=$model->ForoId;
									$funcion->save();
							}	
							if($model->save())
									echo "true";
							else
									echo "false";
					}	
			}	
			else {
					  
					throw new Exception("Error al procesar su petición, la función no tiene una distribucion valida ", 3);
			}
				
	}
    public function actionAsignarValorFila()
    {
        # Cambia el nombre de una zona dada
        // $model=Zonas::model()->findByPk($_POST['EventoId'],$_POST['FuncionesId'],$_POST['ZonasId']);
        extract($_POST['Filas']);
        $model=Filas::model()->findByPk(compact('EventoId','FuncionesId','ZonasId', 'SubzonaId','FilasId'));
		if (isset($_POST['Filas']['FilasAli'])) {
				// Si se trata del titulo de la fila
				Filas::model()->updateAll(array('FilasAli'=>$model->FilasAli),
						"EventoId=$EventoId AND FuncionesId=$FuncionesId and ZonasId=$ZonasId and FilasId=$FilasId");
		}	
		$model->attributes=$_POST['Filas'];
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
	public function actionEliminarFila($EventoId,$FuncionesId, $ZonasId,$FilasId)
	{
					$filas=Filas::model()->findAllByAttributes(compact('EventoId','FuncionesId','ZonasId','FilasId'));
					$ret=true;
					foreach ($filas as $fila) {
						// Por fila X de cada zona...
							$ret=$ret and $fila->delete();
					}
					echo $ret?'true':'false';

			
	}
	public function actionGenerarArbolCargos()
	{
			// Genera o repara el arbol de zonaslevel1
			if (isset($_POST['Zonas'])) {
					$model=Zonas::model()->with('evento')->findByPk($_POST['Zonas']);
					$model->generarArbolCargos();
					$this->renderPartial('_arbolCargos', compact('model'));

			}
			else{
					throw new Exception("Error al procesar su petición, vefique integridad de parametros ", 1);
			}

	}
  public function actionVerRamaCargo($EventoId,$FuncionesId, $ZonasId,$PuntosventaId){
		  #Genera el una rama del arbol apartir de un cofipvfuncion que cumpla 
		  //$funcion=Funciones::model()->findByPk(array(compact('EventoId','FuncionesId')));
		  $evento=Evento::model()->findByPk($EventoId);
		  $zl1=Zonaslevel1::model()->with(
				  array(
						  'puntoventa'=>array(
								  'with'=>array(
										  'hijos'=>array(
												  'condition'=>"hijos.PuntosventaSta='ALTA' 
												  and hijos.PuntosventaId<>".$evento->PuntosventaId
										  )))
								  ))->findByPk(compact('EventoId','FuncionesId','ZonasId','PuntosventaId'));
		  $Pv=$zl1->puntoventa;
		  echo CHtml::openTag('ul',array('id'=>"rama-".$ZonasId.'-'.$PuntosventaId, 'class'=>"rama "));
		  foreach ($Pv->hijos as $hijo) {
				  $model=ZonasLevel1::model()->with(
						  'puntoventa')->findByPk(
								  array('EventoId'=>$EventoId,'FuncionesId'=>$FuncionesId,'ZonasId'=>$ZonasId,
								  'PuntosventaId'=>$hijo->PuntosventaId));
				  if (is_object($model)) 
						  $this->renderPartial('_nodoCargo',array('model'=>$model));

		  }
		  echo CHtml::closeTag('ul');
  }
	public function actionCambiarCargo($EventoId,$FuncionesId,$ZonasId,$PuntosventaId,$valor)
	{
			$zl1=Zonaslevel1::model()->with(array(
					'puntoventa'=>array(
							'with'=>'hijos')))->findByPk(
							compact('EventoId','FuncionesId','ZonasId' ,'PuntosventaId'));
			if (!is_null($zl1)) {
					#"Si existe "
					$evento=Evento::model()->findByPk($EventoId);
					$zl1['ZonasFacCarSer']=$valor;
					$zl1->update('ZonasFacCarSer');
					if ($zl1->puntoventa->hijos) {
							$criteria=new CDbCriteria;
							$criteria->compare('EventoId',$EventoId);
							$criteria->compare('FuncionesId',$FuncionesId);
							$criteria->compare('ZonasId',$ZonasId);
							$criteria->compare("zonaslevel1.PuntosventaId","<>".$evento->PuntosventaId);
							$criteria->join=" INNER JOIN puntosventa as t2  on zonaslevel1.PuntosventaId=t2.PuntosventaId 
									and t2.PuntosventaSuperId=:actual";
							$criteria->params['actual']=$PuntosventaId;
							// $criteria->addInCondition("PuntosventaId",$padres);
							$actualizados=Zonaslevel1::model()->updateAll(array('ZonasFacCarSer'=>$valor), $criteria);
							$hijosPadres=$zl1->puntoventa->getChildrens(' and tipoid=0');
							foreach ($hijosPadres as $hijoPadre) {
									if ($hijoPadre->PuntosventaSuperId==$PuntosventaId) {
											$this->actionCambiarCargo($EventoId,$FuncionesId,$ZonasId, $hijoPadre->PuntosventaId,$valor);
									}
							}
					}

			}
			else {
					//echo "No existe la zonalevel1";
					return 0;
			}

	}

	public function actionAgregarSubzonas($EventoId,$FuncionesId, $ZonasId,$cantidad)
	{
			// Borra todas las subzonas que tenga la zona y le asigna nuevas subzonas en base a la cantidad
			$zona=Zonas::model()->findByPk(compact('EventoId','FuncionesId','ZonasId'));
			$zona->agregarSubzonas($cantidad);// Guarda nuevas subzonas

	}

	public function actionAgregarFila($EventoId,$FuncionesId,$ZonasId)
	{
			// Agrega una fila por cada subzona de una zona dada.
			$zona=Zonas::model()->with('subzonas')->findByPk(compact('EventoId','FuncionesId','ZonasId'));
			$filas=array();
			foreach ($zona->subzonas as $subzona) {
					//error_log("Subzona:".$subzona->SubzonaId."\n",3, '/tmp/error.log');
				$tmpFila=$subzona->agregarFila();
				if ($tmpFila) {
						$filas[]=$tmpFila;
				}	
			}
			if (sizeof($filas)>0) {
					$this->actionVerFila($EventoId,$FuncionesId,$ZonasId,$filas[0]->FilasId);
			}	
			else
			{
					throw new Exception("Error al procesar su petición, vefique integridad de parametros ", 3);
			}

	}

	public function actionVerFila($EventoId,$FuncionesId,$ZonasId,$FilasId)
	{
			// Muestra los controles de las una fila por subzona de una zona dada
			$models=Filas::model()->findAllByAttributes(compact('EventoId','FuncionesId','ZonasId','FilasId'));
			if (sizeof($models)>0) {
					// Si existen tales filas 
					echo TbHtml::openTag('tr',array('id'=>"fila-$FilasId"));
					echo TbHtml::tag('td',array(),$FilasId);
					echo TbHtml::tag('td',array(),
							TbHtml::link(' ',
							array(
									'eliminarFila',
									'EventoId'=>$EventoId,
									'FuncionesId'=>$FuncionesId,
									'ZonasId'=>$ZonasId,
									'FilasId'=>$FilasId,
							),
							array(
									'data-fid'=>$FilasId,
									'title'=>'Eliminar fila',
									'class'=>'btn btn-mini btn-danger fa fa-times btn-eliminar-fila',
							)));
					echo TbHtml::tag('td',array(),
							TbHtml::textField('FilasAli', $models[0]['FilasAli'],
							array('class'=>'FilasAli input-mini vivo',
							'data-fid'=>$FilasId,
							'data-sid'=>$models[0]['SubzonaId'],
							'data-zid'=>$ZonasId,
					)));
					foreach ($models as $model) {
						// Por cada fila de las subzonas, renderiza sus campos  
							$this->renderPartial('_fila',array('model'=>$model));
					}
					echo TbHtml::tag('td',array(),
							CHtml::textField('Subtotal',0,array(
									'class'=>'Subtotal pull-right text-right input-mini',
									'id'=>'Subtotal-'.$FilasId,
									'data-fid'=>$FilasId,
									'readonly'=>true,
							)));
					echo TbHtml::closeTag('tr');
			}	
	}
	public function actionGenerarAsientosGenerales($EventoId, $FuncionesId)
	{
			if (isset($_POST['ZonasId'])) {
					$ZonasId=$_POST['ZonasId'];
					$zona=Zonas::model()->findByPk(compact('EventoId','FuncionesId','ZonasId'));
					echo CJSON::encode($zona->generarLugares());
			}	
			else{
					
					throw new Exception("Error al procesar su petición, vefique integridad de parametros ", 1);
			}
	}
	public function actionGenerarNumerados($EventoId, $FuncionesId, $ZonasId)
	{
			// Genera asientos numerados de una zona
					// Si le han pasado el id de zona
					$zona=	Zonas::model()->findByPk(compact('EventoId','FuncionesId', 'ZonasId'));
					if ($zona->generarLugares()){
							echo TbHtml::openTag('div',array('style'=>'color:#FFF'));
							echo TbHtml::tag('h2',array(),'Se han generado los lugares.');
							echo TbHtml::tag('p', array(),'Los lugares se han registrado conforme a la configuración que ústed acaba de definir.' );
							echo "<br>";
							echo TbHtml::link(' Regresar a zonas', 
									array('editorSubzona', 'EventoId'=>$EventoId, 'FuncionesId'=>$FuncionesId,'ZonasId'=>$ZonasId,'SubzonaId'=>1
									//'scenario'=>'editar',
									//'#'=>'zona-'.$ZonasId
							),
								   	array(
											'class'=>'btn btn-large btn-primary fa fa-arrow-left',
									));
							echo TbHtml::closeTag('div');
					}
					

	}
	public function actionGeneracionFilas($EventoId,$FuncionesId, $ZonasId)
	{
			// Genera filas distribuidas por las subzonas
			$model=Zonas::model()->with('disfilas')->findByPk(compact('EventoId','FuncionesId','ZonasId'));
			
			//Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			//$this->renderPartial('editorFilas',compact('model'));
			$this->render('editorFilas',compact('model'));
	}

	public function actionEditorSubzona($EventoId, $FuncionesId,$ZonasId,$SubzonaId,$modo='completo')
	{
			// Muestra un editor de lugares ordenados por filas de una subzona dada
			$subzona=Subzona::model()->with(array('hermanas', 'filas'=>array('lugares','ntrue')))->findByPk(compact('EventoId','FuncionesId', 'ZonasId','SubzonaId'));
			if (is_object($subzona)) {
					// 
					if ($modo=="completo") {
						// Se renderiza toda la pagina del editor
							$this->render('editorSubzona',compact('subzona'));
					}	
					else{
							//Sino solo se renderiza parcialmente la tabla con los lugares actualizados
							$this->renderPartial('_subzona',compact('subzona'));
					}
			}	
			else
					throw new Exception("Error al procesar su petición, vefique integridad de parametros ", 3);

	}

	public function actionAlinearSubzona($EventoId, $FuncionesId,$ZonasId,$SubzonaId,$direccion='izquierda')
	{
			// alinea todos los lugares de una subzona 
			$subzona=Subzona::model()->with('filas')->findByPk(compact('EventoId','FuncionesId','ZonasId','SubzonaId'));
			foreach ($subzona->filas as $fila) {
					// alinea los lugares de cada fila
					$fila->alinear($direccion);
			}
			 
	}
	public function actionAlinearFila($EventoId, $FuncionesId,$ZonasId,$SubzonaId, $FilasId,$direccion='izquierda')
	{
			// alinea todos los lugares de una fila 
			$fila=Filas::model()->findByPk(compact('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId'));
			$fila->alinear($direccion);
	}
	public function actionMoverFila($EventoId, $FuncionesId,$ZonasId,$SubzonaId, $FilasId,$direccion='izquierda')
	{
			// alinea todos los lugares de una fila 
			$fila=Filas::model()->findByPk(compact('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId'));
			$delta=array('izquierda'=>-1,'derecha'=>1);
			if($fila->recorrer($delta[$direccion])){
					echo "true";
			}
			else
					echo 'false';

	}

	public function actionCambiarLugar()
	{
		// Cambia el valor de un lugar y en base a su contenido lo pone en OFF o en TRUE
			if (isset($_POST['Lugares'])) {
					extract($_POST['Lugares']);
					$lugar=Lugares::model()->findByPk(compact('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId','LugaresId'));
					$lugar->attributes=$_POST['Lugares'];
					if (isset($_POST['Lugares']['LugaresLug']))
						   if( empty($_POST['Lugares']['LugaresLug'])){
									$lugar->LugaresStatus='OFF';
							}
						   else{
								   $lugar->LugaresStatus='TRUE';
						   }
					if ($lugar->save(false)) {
							// Si los datos son correctos
							echo 'true';
					}	

			}	
			else
					throw new Exception("Datos incompletos, verifique parametros", 1);
	}



}

