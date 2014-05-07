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

	public function actionIndex()
	{
			$model=new Evento('search');
			if (isset($_POST['Evento'])) {
					$model->attributes=$_POST['Evento'];
			}
			$this->render('index',compact('model'));
	}

	public function actionRegistro()
	{
			$model=new Evento('insert');	
			$this->saveModel($model);
			$this->render('form',compact('model'));
	}

	public function actionActualizar($id)
	{

			$model=Evento::model()->with(array('funciones'=>array('with'=>'forolevel1')))->findByPk($id);
			$model->scenario='update';
			$this->saveModel($model);
            
            $funciones = Funciones::model()->find("EventoId=$id");
            //$forolevel1 = Forolevel1::model()->findByAttributes(array('ForoId'=>$funciones->ForoId,'ForoMapIntId'=>$funciones->ForoMapIntId));
			$this->render('form',compact('model','funciones'));
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function saveModel(Evento $evento)
	{
			$this->perfil();
			if(isset($_POST['Evento']))
			{
					$this->performAjaxValidation($evento);
					$msg = $evento->saveModel($_POST['Evento']);
					if ($msg==1) {
							Yii::app()->user->setFlash('success', "Se ha guardado el evento \"".$evento->EventoNom.'"');
                            $this->redirect(array('evento/actualizar','id'=>$evento->EventoId));
					}	
			}
	}
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
	public function loadModel($id=null)
	{
			if (!isset($id)) {
					if (isset ( $_GET ['id'] )){
							$id=$_GET['id'];
					}
			}	
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
	public function actionCargarSubcategorias()
	{
			$data = Categorialevel1::model()->findAll('CategoriaId=:id',
					array(':id'=>(int) $_POST['Evento']['CategoriaId']));
			echo CHtml::tag('option',array('value' => '0'),'Sin Subcategoria',true);
			foreach($data as $id => $value)
			{
					echo CHtml::tag('option',array('value' => $value->CategoriaSubId),CHtml::encode($value->CategoriaSubNom),true);
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
	public function actionConmutarEstatus()
	{
			$this->perfil();
			if (Yii::app()->request->isAjaxRequest ) {
					$model=$this->loadModel();
					if ($model->EventoId>0) {
							$model->conmutarEstatus();	
					}	
					echo $model->EventoSta;
			}	
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );
	}


	public function actionSubirImagen()
	{
			$this->perfil();
			if (Yii::app()->request->isAjaxRequest ) {
					$prefijo='';
					if (isset($_POST['prefijo'])) {
						$prefijo=$_POST['prefijo'];
					}	
					$imagen=CUploadedFile::getInstanceByName('imagen');
					if (!is_null($imagen)) {
							$filename=$prefijo.$imagen->name;
							if ($imagen->saveAs(
									sprintf(
											"../imagesbd/%s",
											$filename)
									))
									echo $filename;
					}	
					else{
							echo 0;
					}
			}
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );

		
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
                $zonaId = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $subzona = Subzona::model()->find("eventoId=$eventoId AND FuncionesId=$funcionId AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
                $subzona->SubzonaX1 = 0;
                $subzona->SubzonaY1 = 0;
                $subzona->SubzonaX2 = 0;
                $subzona->SubzonaY2 = 0;
                $subzona->SubzonaX3 = 0;
                $subzona->SubzonaY3 = 0;
                $subzona->SubzonaX4 = 0;
                $subzona->SubzonaY4 = 0;
                $subzona->SubzonaX5 = 0;
                $subzona->SubzonaY5 = 0;
                if($subzona->update())
                    echo json_encode(array('update'=>true));
                else    
                    echo json_encode(array('update'=>false));
            }
         }
    } 
    public function actionGuardarCoordenadasMapaChico(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $zonaId = $_POST['zona'];
                $subzonaId = $_POST['subzona'];
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $subzona = Subzona::model()->find("eventoId=$eventoId AND FuncionesId=$funcionId AND ZonasId=$zonaId AND SubzonaId=$subzonaId");
                $subzona->SubzonaX1 = $_POST['x1'];
                $subzona->SubzonaY1 = $_POST['y1'];
                $subzona->SubzonaX2 = $_POST['x2'];
                $subzona->SubzonaY2 = $_POST['y2'];
                $subzona->SubzonaX3 = $_POST['x3'];
                $subzona->SubzonaY3 = $_POST['y3'];
                $subzona->SubzonaX4 = $_POST['x4'];
                $subzona->SubzonaY4 = $_POST['y4'];
                $subzona->SubzonaX5 = $_POST['x5'];
                $subzona->SubzonaY5 = $_POST['y5'];
                if($subzona->update())
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
                $mapa_grande = MapaGrande::model()->find("eventoId=$eventoId AND FuncionId=$funcionId");
                $coordenada = Yii::app()->db->createCommand()->update('configurl_mapa_grande_coordenadas',
                                                                      array(
                                                                            'x1'=>$_POST['x1'],
                                                                            'x2'=>$_POST['x2'],
                                                                            'x3'=>$_POST['x3'],
                                                                            'x4'=>$_POST['x4'],
                                                                            'x5'=>$_POST['x5'],
                                                                            'x6'=>$_POST['x6'],
                                                                            'x7'=>$_POST['x7'],
                                                                            'x8'=>$_POST['x8'],
                                                                            'x9'=>$_POST['x9'],
                                                                            'x10'=>$_POST['x10'],
                                                                            'x11'=>$_POST['x11'],
                                                                            'x12'=>$_POST['x12'],
                                                                            'x13'=>$_POST['x13'],
                                                                            'x14'=>$_POST['x14'],
                                                                            'y1'=>$_POST['y1'],
                                                                            'y2'=>$_POST['y2'],
                                                                            'y3'=>$_POST['y3'],
                                                                            'y4'=>$_POST['y4'],
                                                                            'y5'=>$_POST['y5'],
                                                                            'y6'=>$_POST['y6'],
                                                                            'y7'=>$_POST['y7'],
                                                                            'y8'=>$_POST['y8'],
                                                                            'y9'=>$_POST['y9'],
                                                                            'y10'=>$_POST['y10'],
                                                                            'y11'=>$_POST['y11'],
                                                                            'y12'=>$_POST['y12'],
                                                                            'y13'=>$_POST['y13'],
                                                                            'y14'=>$_POST['y14'],
                                                                            ),
                                                                      'configurl_funcion_mapa_grande_id= :id AND ZonasId=:ZonasId AND SubzonaId=:SubzonaId',
                                                                      array(':id'=>$mapa_grande->id,':ZonasId'=>$zonaId,'SubzonaId'=>$subzonaId)
                                                                      );
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
                $mapa_grande = MapaGrande::model()->find("eventoId=$eventoId AND FuncionId=$funcionId");
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
                                                                      array(':id'=>$mapa_grande->id,':ZonasId'=>$zonaId,'SubzonaId'=>$subzonaId)
                                                                      );
                echo json_encode(array('update'=>true));                                                     
                /*if($coordenada>0)
                    echo json_encode(array('update'=>true));
                else    
                    echo json_encode(array('update'=>false));*/
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
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $funcion = Funciones::model()->find("EventoId=$eventoId AND FuncionesId=$funcionId");
                $foro    =  Forolevel1::model()->find("ForoId=$funcion->ForoId AND ForoMapIntId=$funcion->ForoMapIntId");
                $data =  array('url'=>"https://www.taquillacero.com/imagesbd/$foro->ForoMapPat");
                echo json_encode($data);
            }
        }
     }
     public function actionGetUrlImagenMapaGrande(){
        if (Yii::app()->request->isAjaxRequest ) {
            if(isset($_POST)){
                $eventoId = $_POST['eventoId'];
                $funcionId = $_POST['funcionId'];
                $mapaGrande = MapaGrande::model()->find("EventoId=$eventoId AND FuncionId=$funcionId");
                $data =  array('url'=>"https://www.taquillacero.com/imagesbd/$mapaGrande->nombre_imagen");
                echo json_encode($data);
            }
        }
     }
}
