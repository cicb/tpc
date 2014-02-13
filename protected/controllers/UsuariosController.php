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
	public function loadModel($id=null) {
            if ($this->_model === null) {
					if (!isset($id)) {
							if (isset ( $_GET ['id'] )){
									$id=$_GET['id'];
							}
					}	
                    $this->_model = Usuarios::model ()->findbyPk($id);
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

	public function actionActualizar($id)
	{
			$model=$this->loadModel($id);
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
	public function actionAsignarEvento()
	{
			if (Yii::app()->request->isAjaxRequest ){
					$model=$this->loadModel();
					if (isset($_GET['eid']) and ($_GET['eid']>0 or (strlen($_GET['eid'])>0 and $_GET['eid']=="TODAS"))) {
							echo  $model->asignarEvento($_GET['eid'])?'true':'false';
					}	

			} 
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );
	}
	public function actionDesasignarEvento()
	{
			if (Yii::app()->request->isAjaxRequest ){
					$this->validarUsuario();
					$model=$this->loadModel();
					if (isset($_GET['evento'],$_GET['funcion']) and !is_null($_GET['evento'])) {
							echo  $model->desasignarEvento($_GET['evento'],$_GET['funcion']);
					}	
			}
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );

	}
	public function actionEventosAsignados()
	{
			if (Yii::app()->request->isAjaxRequest ){
					$this->validarUsuario();
					$model=$this->loadModel();
					if (is_object($model)) {
							$data =$model->getEventosAsignados();
							$lista = CHtml::listData($data,'EventoId','EventoNom');
							foreach($lista as $id => $value)
							{
									echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
							}
					}	
			}
			else
					throw new CHttpException ( 404, 'Petición incorrecta.' );
	}
	public function actionTablaReportes()
	{
			if (Yii::app()->request->isAjaxRequest ){
					$this->validarUsuario();
					if (isset($_GET['evento_id'])) {
							$model=$this->loadModel();
							$this->renderPartial('_tablaReportes',array('model'=>$model),false,true);
					}else throw new CHttpException ( 404, 'Petición incompleta.' );
						
			}else
					throw new CHttpException ( 404, 'Petición incorrecta.' );

	}
		public function actionAutorizarReporte()
		{
			if (Yii::app()->request->isAjaxRequest ){
					$this->validarUsuario();
					if (isset($_GET['id'])) {
							$model=$this->loadModel();
							echo $model->autorizarReporte($_GET)	;
					}else throw new CHttpException ( 404, 'Petición incompleta.' );

			}else
					throw new CHttpException ( 404, 'Petición incorrecta.' );	
		}
		public function actionDenegarReporte()
		{
			if (Yii::app()->request->isAjaxRequest ){
					$this->validarUsuario();
					if (isset($_GET['id'])) {
							$model=$this->loadModel();
							echo $model->denegarReporte($_GET)	;
					}else throw new CHttpException ( 404, 'Petición incompleta.' );

			}else
					throw new CHttpException ( 404, 'Petición incorrecta.' );	
		}

		public function actionCambiarClave($id)
		{
					$this->validarUsuario();
					if (isset($id, $_POST['up'])) {
							$model=$this->loadModel($id);
							$model->UsuariosPass=$_POST['up'];
							if ($model->update(array('UsuariosPass','UsuariosPasCon'))) {
									Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
											sprintf('<h3>Contraseña cambiada</h3> <br/>	Se ha modificado exitosamente la contraseña del usuario %s.',$model->UsuariosNom));
									$this->widget('bootstrap.widgets.TbAlert', array(
											'block'=>true,
									));
							}	
					}else throw new CHttpException ( 404, 'Petición incompleta.');
		}
		public function actionUsuariosWeb()
		{
				$model=new CrugeUser('search');
				if (isset($_POST) and array_key_exists('CrugeUser',$_POST)) {
						$model->attributes = $_POST ['CrugeUser'];
				}	
				$this->render('usuariosWeb',array('model'=>$model));	
		}
		public function actionHistorialCompras()
		{
				if (isset($_GET['id']) and $_GET['id']>0) {
						$model=CrugeUser::model()->findByPk($_GET['id']);
						$this->render('historialCompras',compact('model'));
				}else throw new CHttpException ( 404, 'Petición incompleta.');
		}
} 
