<?php
class UsuariosController extends Controller {
	
	
	private $_model;
	
	public function filters() {
            return array (
                'accessControl' 
            ); 
	}
	public function validarUsuario(){
			if(Yii::app()->user->isGuest OR !Yii::app()->user->getState("Admin")){
			$this->redirect(array("site/logout"));
		}
	}
	public function accessRules()
	{
			//$usuario = Usuarios::model()->findByPk(Yii::app()->user->id);
			//$usuario = Yii::app()->user->modelo;
			$esAdmin=false;
			$esAdmin = @Yii::app()->user->getState("Admin") ;

			return array(
					array('allow', // allow authenticated user to perform 'create' and 'update' actions
					'expression'=>$esAdmin . '== true',
			),
			array('deny',  // deny all users
			'users'=>array('*'),
	),
			);
	}

	
	/**
	 * Actualiza un Modelo en Particular.
	 * Si la creación es exitosa, el navegador será redirigido a la vista
	 * 'Index'.
	 */

	
	/**
	 * Manages all models.
	 */
	public function actionIndex() {
			//$this->layout='//layouts/column1';
			$model = new Usuarios ( 'search' );
			$model->unsetAttributes (); // clear any default values
			if (isset ( $_POST ['Usuarios'] )){
					//VAR_DUMP(@$_POST);
					$model->attributes = $_POST ['Usuarios'];

			}
			$this->render ( 'index', array (
					'model' => $model 
			) );

	}
	/**
	 * Returns the data model based on the primary key given in the GET
	 * variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel($id=null,$nick=null) {
            if ($this->_model === null) {
					if (!isset($id,$nick)) {
							if (isset ( $_GET ['id'],$_GET['nick'] )){
									$id=$_GET['id'];
									$nick=$_GET['nick'];
							}
					}	
                    $this->_model = Usuarios::model ()->findbyPk (array('UsuariosId'=>$id,'UsuariosNick'=>$nick ));
                if ($this->_model === null)
                    throw new CHttpException ( 404, 'El Usuario no existe.' );
            }
            return $this->_model;
	}
	/**
	 * Performs the AJAX validation.
	 *
	 * @param
	 *        	CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'usuarios-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}

	public function actionRegistro()
	{
			$model=new Usuarios('insert');	
			$this->saveModel($model);
			$this->render('form',compact('model'));
	}

	public function actionActualizar($id,$nick)
	{
			$model=$this->loadModel($id,$nick);
			$model->scenario='update';
			$this->saveModel($model);
			$this->render('form', compact('model'));
	}

	protected function saveModel(Usuarios $usuario)
	{
        if(isset($_POST['Usuarios']))
        {
            $this->performAjaxValidation($usuario);
            $msg = $usuario->saveModel($_POST['Usuarios']);
            //check $msg here
			//if ($msg>0) {
					//echo $msg;
			//}	
		}
    }
	public function actionConmutarEstatus()
	{
			if (Yii::app()->request->isAjaxRequest ) {
					$model=$this->loadModel();
					if ($model->UsuariosId>0) {
							$model->conmutarEstatus();	
					}	
					echo $model->UsuariosStatus;
			}	
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );
	}
}
