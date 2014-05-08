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

}
