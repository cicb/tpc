<?php

class EventoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
            /*
			array('deny',  // deny all users
				'users'=>array('*'),
			),                           
		);
	}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
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
        $catpuertas = Catpuerta::model()->findAll("idDistribucionPuerta=$distribucion_id->idDistribucionPuerta");
   		$distribucion                  = Distribucionpuerta::model()->deleteAll("ForoId=$ForoId AND ForoIntMapId=$ForoMapIntId AND DistribucionPuertaNom='DISTRIBUCION_TEMP_$user_id'"); 
            if($distribucion >0){  
                $puertas_eliminadas            = CatPuerta::model()->deleteAll("idDistribucionPuerta=$distribucion_id->idDistribucionPuerta"); 
                if($puertas_eliminadas>0){
                    foreach($catpuertas as $key => $catpuerta):
                          $distribucionlevel1_eliminadas = Distribucionpuertalevel1::model()->deleteAll("idCatPuerta = $catpuerta->idCatPuerta AND IdDistribucionPuerta=$distribucion_id->idDistribucionPuerta "); 
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
        
        $id_distribucion_nueva = $distribucion_nueva->idDistribucionPuerta;
                  
        $model=new Evento;
        $resumen_distribucion = $model->getCargarPuertas($IdDistribucion);
        $funciones_id = explode(",",$funciones);
        
        foreach( $resumen_distribucion as $key => $resumen):
            $catpuerta = new Catpuerta;
            $catpuerta->idDistribucionPuerta = $id_distribucion_nueva;
            $catpuerta->CatPuertaNom = $resumen['CatPuertaNom'];
            $catpuerta->save();
            $catpuerta_id_nuevo = $catpuerta->idCatPuerta;
            foreach($funciones_id as $f_ids):
                if($f_ids!="0"){
                    $distribucionpl1_old = Distribucionpuertalevel1::model()->findAll(array('condition'=>"idCatPuerta=".$resumen['idCatPuerta']." AND idDistribucionPuerta=$IdDistribucion AND EventoId=$EventoDistribucionId AND FuncionesId IN($f_ids)"));
                    foreach($distribucionpl1_old as $level1_old):
                            $distribucionpl1_new = Distribucionpuertalevel1::model()->findAll(array('condition'=>"idCatPuerta=$catpuerta_id_nuevo AND idDistribucionPuerta=$id_distribucion_nueva AND EventoId=$EventoId AND FuncionesId IN($f_ids) AND ZonasId=$level1_old->ZonasId AND SubzonaId=$level1_old->SubzonaId"));
                            if(empty($distribucionpl1_new)){
                                $distlevel1 = new Distribucionpuertalevel1;
                                $distlevel1->idCatPuerta          = $catpuerta_id_nuevo;
                                $distlevel1->idDistribucionPuerta = $id_distribucion_nueva;
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
        
        $distribucionpl1 = Distribucionpuertalevel1::model()->findAll(array('condition'=>"idDistribucionPuerta=$id_distribucion_nueva AND EventoId=$EventoId AND FuncionesId IN($funciones)")); 
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
        $puerta = Catpuerta::model()->find("CatPuertaNom='$nombre_puerta' AND idDistribucionPuerta=$id_distribucion");
        if(empty($puerta)){
            $catpuerta =new Catpuerta;
            $catpuerta->idDistribucionPuerta = $id_distribucion;
            $catpuerta->CatPuertaNom = $nombre_puerta;
            $catpuerta->save();
            
            $data =  array('ok'=>1,'id_puerta'=>$catpuerta->idCatPuerta);
        }else{
            $data =  array('ok'=>0,'id_puerta'=>0);
        }
        echo json_encode($data);
    }
    public function actionDeletePuerta(){
        //print_r($_GET);
        $idCatPuerta   = $_GET['idCatPuerta'];
        $id_distribucion = $_GET['id_distribucion'];
        $puerta = Catpuerta::model()->deleteAll("idCatPuerta=$idCatPuerta");
        $distribucionpuetalevel1 = Distribucionpuertalevel1::model()->deleteAll("idCatPuerta=$idCatPuerta AND idDistribucionPuerta=$id_distribucion");
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
        
        $distribucionpl1 = Distribucionpuertalevel1::model()->findAll("EventoId=$id_evento AND idCatPuerta=$id_puerta AND idDistribucionPuerta=$id_distribucion AND FuncionesId IN($funciones)");
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
                $distribucion->idCatPuerta          = $puertaId;
                $distribucion->idDistribucionPuerta = $distribucionId;
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
                $distribucion  = Distribucionpuertalevel1::model()->deleteAll("idCatPuerta=$puertaId AND idDistribucionPuerta=$distribucionId AND EventoId=$eventoId AND FuncionesId=$funcion AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
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
		$dataProvider=new CActiveDataProvider('Evento');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Evento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Evento']))
			$model->attributes=$_GET['Evento'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Evento the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Evento::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Evento $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='evento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
 public function actionCargarFunciones()
	{
			$data = Funciones::model()->findAll('EventoId=:parent_id',
					array(':parent_id'=>(int) $_POST['evento_Id']));

			$data = CHtml::listData($data,'FuncionesId','funcionesTexto');
			echo CHtml::tag('option',array('value' => ''),'Seleccione ...',true);
			foreach($data as $id => $value)
			{
					echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
			}
	}
	public function actionEvento()
    {
        $data = Evento::model()->findAll('EventoId=:parent_id',
                        array(':parent_id'=>(int) $_POST['evento_Id']));


        $data = CHtml::listData($data,'EventoId','EventoNom');
		echo CHtml::tag('option',array('value' => ''),'Seleccione un evento...',true);
            foreach($data as $id => $value)
            {
                echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
            }

    }

}
