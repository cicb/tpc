<?php 
class AccesosController extends Controller
{

		public function actionView($id){
				$this->render('view',array(
						'model'=>$this->loadModel($id),
				));
		}
		public function perfil(){
				if(Yii::app()->user->isGuest OR !Yii::app()->user->getState("Admin")){
						$this->redirect(array("site/logout"));
				}
		}
		/**
		 * Creates a new model.
		 * If creation is successful, the browser will be redirected to the 'view' page.
		 */
		public function actionCreate($EventoId,$EventoDistribucionId,$funcionId,$funciones,$IdDistribucion,$ForoId,$ForoMapIntId){
				$this->perfil();
				set_time_limit(0);
				$user_id = Yii::app()->user->id;
				if($ForoId=="0" or $ForoMapIntId=="0"){
						$foro = Funciones::model()->find("EventoId=$EventoId");
						$ForoId = $foro->ForoId;
						$ForoMapIntId = $foro->ForoMapIntId;
				}
				$distribucion_id = Distribucionpuerta::model()->find("ForoId=$ForoId AND ForoIntMapId=$ForoMapIntId AND DistribucionPuertaNom='DISTRIBUCION_TEMP_$user_id'");

				if(!empty($distribucion_id)){
						$catpuertas = Catpuerta::model()->findAll("IdDistribucionPuerta=$distribucion_id->IdDistribucionPuerta");
						$distribucion                  = Distribucionpuerta::model()->deleteAll("ForoId=$ForoId AND ForoIntMapId=$ForoMapIntId AND DistribucionPuertaNom='DISTRIBUCION_TEMP_$user_id'"); 
						if($distribucion >0){  
								$puertas_eliminadas            = CatPuerta::model()->deleteAll("IdDistribucionPuerta=$distribucion_id->IdDistribucionPuerta"); 
								if($puertas_eliminadas>0){
										foreach($catpuertas as $key => $catpuerta):
												$distribucionlevel1_eliminadas = Distribucionpuertalevel1::model()->deleteAll("IdCatPuerta = $catpuerta->IdCatPuerta AND IdDistribucionPuertalevel1=$distribucion_id->IdDistribucionPuerta "); 
endforeach;
								}   
						}        
				} 

				$distribucion_nueva = new Distribucionpuerta;
				$distribucion_nueva->ForoId = $ForoId;
				$distribucion_nueva->ForoIntMapId = $ForoMapIntId;
				$distribucion_nueva->DistribucionPuertaSta = "1";
				$distribucion_nueva->DistribucionPuertaNom = "DISTRIBUCION_TEMP_$user_id";
				$distribucion_nueva->save();

				$id_distribucion_nueva = $distribucion_nueva->IdDistribucionPuerta;

				$model=new Evento;
				$resumen_distribucion = $model->getCargarPuertas($IdDistribucion);
				echo "f".$funciones;
				$funciones_id = explode(",",$funciones);

				foreach( $resumen_distribucion as $key => $resumen):
						$catpuerta = new Catpuerta;
				$catpuerta->IdDistribucionPuerta = $id_distribucion_nueva;
				$catpuerta->CatPuertaNom = $resumen['CatPuertaNom'];
				$catpuerta->save();
				$catpuerta_id_nuevo = $catpuerta->IdCatPuerta;
				foreach($funciones_id as $f_ids):
						if($f_ids!="0"){

								$distribucionpl1_old = Distribucionpuertalevel1::model()->findAll(array('condition'=>"IdCatPuerta=".$resumen['IdCatPuerta']." AND IdDistribucionPuerta=$IdDistribucion AND EventoId=$EventoDistribucionId"));

								foreach($distribucionpl1_old as $level1_old):

										$distribucionpl1_new = Distribucionpuertalevel1::model()->findAll(array('condition'=>"IdCatPuerta=$catpuerta_id_nuevo AND IdDistribucionPuerta=$id_distribucion_nueva AND EventoId=$EventoId AND FuncionesId IN($f_ids) AND ZonasId=$level1_old->ZonasId AND SubzonaId=$level1_old->SubzonaId"));
								if(empty($distribucionpl1_new)){
										$distlevel1 = new Distribucionpuertalevel1;
										$distlevel1->IdCatPuerta          = $catpuerta_id_nuevo;
										$distlevel1->IdDistribucionPuerta = $id_distribucion_nueva;
										$distlevel1->EventoId             = $EventoId;
										$distlevel1->FuncionesId          = $level1_old->FuncionesId;
										$distlevel1->ZonasId              = $level1_old->ZonasId;
										$distlevel1->SubzonaId            = $level1_old->SubzonaId;
										$distlevel1->save();
								}

								endforeach;   
						}

endforeach;
endforeach;

$distribucionpl1 = Distribucionpuertalevel1::model()->findAll(array('condition'=>"IdDistribucionPuerta=$id_distribucion_nueva AND EventoId=$EventoId AND FuncionesId IN($funciones)")); 
$funcion=$this->loadFuncion($EventoId,$funcionId);
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

$puertas=Evento::getCargarPuertas($id_distribucion_nueva);
$resumen_distribucion_nuevo = $model->getCargarPuertas($id_distribucion_nueva);
$this->render('create',array(
		"funcion"               => $funcion, 
		"puertas"               => $puertas,
		"distribucionpl1"       => $distribucionpl1,
		"resumen_distribucion"  => $resumen_distribucion_nuevo,
		"model"                 => $model,
		"EventoId"              => $EventoId,
		"funcionId"             => $funcionId,
		"IdDistribucion"        => $id_distribucion_nueva,
		"ForoId"                => $ForoId,
		"ForoMapIntId"          => $ForoMapIntId,
		"id_distribucion_nueva" => $id_distribucion_nueva,
));
		}
		public function actionPuertaNueva(){
				//print_r($_GET);
				$nombre_puerta   = $_GET['nombre_puerta'];
				$id_distribucion = $_GET['id_distribucion'];
				$puerta = Catpuerta::model()->find("CatPuertaNom='$nombre_puerta' AND IdDistribucionPuerta=$id_distribucion");
				if(empty($puerta)){
						$catpuerta =new Catpuerta;
						$catpuerta->IdDistribucionPuerta = $id_distribucion;
						$catpuerta->CatPuertaNom = $nombre_puerta;
						$catpuerta->save();

						$data =  array('ok'=>1,'id_puerta'=>$catpuerta->IdCatPuerta);
				}else{
						$data =  array('ok'=>0,'id_puerta'=>0);
				}
				echo json_encode($data);
		}
		public function actionDeletePuerta(){
				//print_r($_GET);
				$IdCatPuerta   = $_GET['IdCatPuerta'];
				$id_distribucion = $_GET['id_distribucion'];
				$puerta = Catpuerta::model()->deleteAll("IdCatPuerta=$IdCatPuerta");
				$distribucionpuetalevel1 = Distribucionpuertalevel1::model()->deleteAll("IdCatPuerta=$IdCatPuerta AND IdDistribucionPuerta=$id_distribucion");
				if($puerta>0){
						$data =  array('ok'=>1);
				}else{
						$data =  array('ok'=>0);
				}
				echo json_encode($data);
		}
		private function loadFuncion($eventoId, $funcionId) {
				$model = Funciones::model()->findByAttributes(array('EventoId'=>$eventoId, 'FuncionesId'=>$funcionId));

				if($model===null)
						throw new CHttpException(404,'La página solicitada no existe.');

				return $model;
		}
		public function actionGetCoordPuerta(){
				//print_r($_GET);
				$id_evento       = $_GET['id_evento'];
				$id_puerta       = $_GET['id_puerta'];
				$id_distribucion = $_GET['id_distribucion'];
				$funciones       = explode(",",$_GET['funciones']);
				$funciones = end($funciones);
				$data = array();

				$distribucionpl1 = Distribucionpuertalevel1::model()->findAll("EventoId=$id_evento AND IdCatPuerta=$id_puerta AND IdDistribucionPuerta=$id_distribucion ");
				foreach($distribucionpl1 as $key => $level1):
						$coordenadas = ConfigurlMapaGrandeCoordenadas::model()->with('mapa')->findAll(array('condition'=>"mapa.EventoId=$id_evento AND mapa.FuncionId=$funciones AND t.ZonasId=$level1->ZonasId AND t.SubzonaId=$level1->SubzonaId"));
				foreach($coordenadas as $keycoords => $coordenada):
						$id     = $coordenada->x1.$coordenada->y1.$coordenada->x2.$coordenada->y2.$coordenada->x3.$coordenada->y3.$coordenada->x4.$coordenada->y4.$coordenada->x5.$coordenada->y5.$coordenada->x6.$coordenada->y6.$coordenada->x7.$coordenada->y7.$coordenada->x8.$coordenada->y8.$coordenada->x9.$coordenada->y9.$coordenada->x10.$coordenada->y10.$coordenada->x11.$coordenada->y11.$coordenada->x12.$coordenada->y12.$coordenada->x13.$coordenada->y13.$coordenada->x14.$coordenada->y14;
				if($coordenada->x1!="") 
						$coords = $coordenada->x1.",".$coordenada->y1.",";
				if($coordenada->x2!="")
						$coords .= $coordenada->x2.",".$coordenada->y2.",";
				if($coordenada->x3!="")
						$coords .= $coordenada->x3.",".$coordenada->y3.",";
				if($coordenada->x4!="")
						$coords .= $coordenada->x4.",".$coordenada->y4.",";
				if($coordenada->x5!="")
						$coords .= $coordenada->x5.",".$coordenada->y5.",";
				if($coordenada->x6!="")
						$coords .= $coordenada->x6.",".$coordenada->y6.",";
				if($coordenada->x7!="")
						$coords .= $coordenada->x7.",".$coordenada->y7.",";
				if($coordenada->x8!="")
						$coords .= $coordenada->x8.",".$coordenada->y8.",";
				if($coordenada->x9!="")
						$coords .= $coordenada->x9.",".$coordenada->y9.",";
				if($coordenada->x10!="")
						$coords .= $coordenada->x10.",".$coordenada->y10.",";
				if($coordenada->x11!="")
						$coords .= $coordenada->x11.",".$coordenada->y11.",";
				if($coordenada->x12!="")
						$coords .= $coordenada->x12.",".$coordenada->y12.",";
				if($coordenada->x13!="")
						$coords .= $coordenada->x13.",".$coordenada->y13.",";
				if($coordenada->x14!="")
						$coords .= $coordenada->x14.",".$coordenada->y14.",";                                        

				$data[$key]['id'] = $id;
				$data[$key]['coords'] = substr($coords,0,-1); 
endforeach;
endforeach;
echo json_encode($data);
		}
		public function actionAddZona(){
				//print_r($_GET);
				$eventoId        = $_GET['id_evento'];
				$funciones       = explode(",",$_GET['funciones']);
				$distribucionId = $_GET['id_distribucion_nueva'];
				$puertaId        = $_GET['id_puerta'];
				$zonaId          = $_GET['id_zona'];
				$subzonaId       = $_GET['id_subzona'];


				foreach($funciones as $funcion):
						if($funcion!="0"){
								$distribucion    = new Distribucionpuertalevel1;
								$distribucion->IdCatPuerta          = $puertaId;
								$distribucion->IdDistribucionPuerta = $distribucionId;
								$distribucion->EventoId             = $eventoId;
								$distribucion->FuncionesId          = $funcion;
								$distribucion->ZonasId              = $zonaId;
								$distribucion->SubzonaId            = $subzonaId;
								if($distribucion->save()){
										$data =array('ok'=>1);
								}else{
										$data =array('ok'=>0);
								}   
						}

endforeach;
echo json_encode($data);
		}
		public function actionDeleteZona(){
				$eventoId        = $_GET['id_evento'];
				$funciones       = explode(",",$_GET['funciones']);
				$distribucionId  = $_GET['id_distribucion_nueva'];
				$puertaId        = $_GET['id_puerta'];
				$zonaId          = $_GET['id_zona'];
				$subzonaId       = $_GET['id_subzona'];
				foreach($funciones as $funcion):
						if($funcion!="0"){
								$distribucion  = Distribucionpuertalevel1::model()->deleteAll("IdCatPuerta=$puertaId AND IdDistribucionPuerta=$distribucionId AND EventoId=$eventoId AND FuncionesId=$funcion AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
								if($distribucion>0){
										$data =array('ok'=>1);
								}else{
										$data =array('ok'=>0);
								}   
						}

endforeach;
echo json_encode($data);
		}
		/**
		 * Updates a particular model.
		 * If update is successful, the browser will be redirected to the 'view' page.
		 * @param integer $id the ID of the model to be updated
		 */
		public function actionUpdate($id)
		{
				$model=$this->loadModel($id);

				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);

				if(isset($_POST['Evento']))
				{
						$model->attributes=$_POST['Evento'];
						if($model->save())
								$this->redirect(array('view','id'=>$model->EventoId));
				}

				$this->render('update',array(
						'model'=>$model,
				));
		}

		/**
		 * Deletes a particular model.
		 * If deletion is successful, the browser will be redirected to the 'admin' page.
		 * @param integer $id the ID of the model to be deleted
		 */
		public function actionDelete($id)
		{
				$this->loadModel($id)->delete();

				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
						$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}

		/**
		 * Lists all models.
		 */
		public function actionIndex()
		{   $this->perfil(); 
		$temps = Distribucionpuerta::model()->findAll("DistribucionPuertaNom LIKE '%DISTRIBUCION_TEMP_%'");
		if(!empty($temps)){
				foreach($temps as $temp):
						$puertas = Catpuerta::model()->findAll("IdDistribucionPuerta=$temp->IdDistribucionPuerta");
				if(!empty($puertas)){
						foreach($puertas as $puerta):
								$level1s = Distribucionpuertalevel1::model()->findAll("IdDistribucionPuerta=$temp->IdDistribucionPuerta AND IdCatPuerta=$puerta->IdCatPuerta");
						if(!empty($level1s)){
								foreach($level1s as $level1):
										Distribucionpuertalevel1::model()->deleteAll("IdDistribucionPuertalevel1=$level1->IdDistribucionPuertalevel1");
endforeach;
						}
						Catpuerta::model()->deleteAll("IdCatPuerta=$puerta->IdCatPuerta");
endforeach;
				}
				Distribucionpuerta::model()->deleteAll("IdDistribucionPuerta=$temp->IdDistribucionPuerta");    
endforeach;
		}

		$dataProvider=new CActiveDataProvider('Evento');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
		}


}
?>
