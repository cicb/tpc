<?php
class UsuariosController extends Controller {
	
	
	private $_model;
	
	public function filters() {
            return array (
                'accessControl' 
            ); 
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
	public function actionActualizar() {
		$model = $this->loadModel ();
		
		// Descomente la siguiente línea si la validación de AJAX es necesaria
		// $this->performAjaxValidation($model);
		
		if (isset ( $_POST ['Usuarios'] )) {
			$model->attributes = $_POST ['Usuarios'];
			if ($model->save ())
				$this->redirect ( array (
						'index' 
				) );
		}
		
		/**
		 * Cargar el perfil del Usuario
		 */
		$model->perfil_id = UsuariosPerfiles::model ()->find ( 'usuario_id = :param1', array (
				':param1' => $model->id 
		) );
		
		$this->render ( 'actualizar', array (
				'model' => $model 
		) );
	}
	
	
	public function actionUpdate() {
            $model = $this->loadModel ();
		
            $model->perfil_id = UsuariosPerfiles::model()->find('usuario_id = :param1', array(
                ':param1' => $model->id 
            ));

            if (isset ( $_POST ['Usuarios'] )) {
                $model->attributes = $_POST ['Usuarios'];
                if ($model->validate ()) {
                    if ($model->update ()) {
                        $this->redirect(array('index'));
                    }
                }
            }
            
            $this->render('update', array('model'=>$model));
	}    
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
	public function loadModel() {
            if ($this->_model === null) {
                if (isset ( $_GET ['id'] ))
                    $this->_model = Usuarios::model ()->findbyPk ( $_GET ['id'] );
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
			$model=new Usuarios;	
			$this->render('_nuevo',array('model'=>$model));
		}
        
}
