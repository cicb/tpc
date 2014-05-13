<?php

class PuntosVentaController extends Controller
{
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
	public function accessRules()
	{
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(''),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(''),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),*/
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Puntosventa;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        if(isset($_POST['ajax']) && $_POST['ajax']==='puntosventa-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		if(isset($_POST['Puntosventa']))
		{
		    $rango1 = 1000;
            $rango2 = 1300;
            if($_POST['tipo_sucursal']=="FF"){
                $rango1 = 1;
                $rango2 = 99;
            }elseif($_POST['tipo_sucursal']=="T"){
                $rango1 = 102;
                $rango2 = 299;
            }elseif($_POST['tipo_sucursal']=="FL"){
                $rango1 = 300;
                $rango2 = 999;
            } 
            
            $pv_id = Puntosventa::model()->find(array('condition'=>"PuntosventaId BETWEEN $rango1 AND $rango2",'order'=>'PuntosventaId DESC'));
			$pv_id = (empty($pv_id->PuntosventaId)?$rango1:$pv_id->PuntosventaId) + 1;
            $model->attributes=$_POST['Puntosventa'];
            $model->PuntosventaId = $pv_id;
            $model->PuntosventaIdeTra = $_POST['tipo_sucursal'].$pv_id;
			if($model->save()){
			     $mensaje_rango = "";
			     if($_POST['tipo_sucursal']=="FF"){
                    if(($rango2-$pv_id)<=10)
                            $mensaje_rango = "SOLO QUEDAN ".($rango2-$pv_id)." IDS DISPONIBLES PARA FARMATODO ";
                }elseif($_POST['tipo_sucursal']=="T"){
                    if(($rango2-$pv_id)<=10)
                            $mensaje_rango = "SOLO QUEDAN ".($rango2-$pv_id)." IDS DISPONIBLES PARA TAQUILLA ";
                }
			     Yii::app()->user->setFlash('success', $mensaje_rango."Se ha guardado el evento \"".$model->PuntosventaNom.'"');
			     $this->redirect(array('index'));
				//$this->redirect(array('view','id'=>$model->PuntosventaId));
			}
                 
		}

		$this->render('create',array(
			'model'=>$model,
		));
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
		if(isset($_POST['Puntosventa']))
		{
			$model->attributes=$_POST['Puntosventa'];
			if($model->save()){
			     Yii::app()->user->setFlash('success', "Se ha guardado el evento \"".$model->PuntosventaNom.'"');
			     $this->redirect(array('index'));
			}
				
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
	{
		$model = new Puntosventa('search');
        if (isset($_POST['Puntosventa'])) {
					$model->attributes = $_POST['Puntosventa'];
		}
		$this->render('index',array('model'=>$model));
	}
    public function actionConmutarEstatus()
	{
			$this->perfil();
			if (Yii::app()->request->isAjaxRequest ) {
					$model=$this->loadModel($_GET['id']);
					if ($model->PuntosventaId>0) {
							$model->conmutarEstatus();	
					}	
					echo $model->PuntosventaSta;
			}	
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Puntosventa('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Puntosventa']))
			$model->attributes=$_GET['Puntosventa'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Puntosventa the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Puntosventa::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Puntosventa $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='puntosventa-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionCargarPuntosventa()
	{
		if (isset($_POST['usuario_id'])) {
			$usuario=$_POST['usuario_id'];
			$data = Puntosventa::model()->with(array(
				'ventas'=>array(
				'condition'=>"PuntosventaSta like '%ALTA%' and ventas.UsuariosId=:usuario",
				'order'=>'PuntosventaNom',
					'params'=>array(
						'usuario'=>$usuario))))->findAll();
		}
		else{
			$data = Puntosventa::model()->findAll(array(
				'condition'=>"PuntosventaSta like '%ALTA%'",
				'order'=>'PuntosventaNom',
				));			
		}
			$list = CHtml::listData($data,'PuntosventaId','PuntosventaNom');
			echo CHtml::tag('option',array('value' => ''),'Seleccione un punto de venta...',true);
			foreach($list as $id => $value)
			{
					echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
			}
	}

	public function actionVerRama($pid=0,$fid='')
	{
		#Visualiza el arbol de puntos de venta de acuerdo a su jerarquia
		$rama=Puntosventa::getHijos($pid);
		if (sizeof($rama)>0) {
			# Si tiene hijos
			echo CHtml::openTag('ul',array('class'=>'rama-pvs', 'id'=>"rama-$fid-$pid"));	
			foreach ($rama as $model) {
				// echo $model->getAsNode('li',$fid);
				$pid=$model->PuntosventaId;
				$nombre=$model->PuntosventaNom;
				$padre=$model->tieneHijos;
				$this->renderPartial('/funciones/_nodoCPVF',compact('fid','pid','nombre','padre'));
			}
			echo CHtml::closeTag('ul');	
		}
		else
			echo "";
	}
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