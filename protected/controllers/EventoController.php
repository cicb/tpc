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

			$model=$this->loadModel($id);
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
}
