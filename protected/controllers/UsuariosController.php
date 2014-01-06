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
            $usuario = Usuarios::model()->findByPk(Yii::app()->user->id);
	    $isMesa = isset($usuario)?$usuario->esMesaDeControl:false ;

            return array(
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'expression'=>$isMesa . '== true',
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
        }
	
	public function actionBoletines($id){
// 	  $usuario=Usuarios::model()->findByPk($id);
// 	  foreach($usuario->getBoletines() as $aviso){
// 	    print_r($aviso->nombreCompleto);
// 	  }
	  $aviso=Avisos::model()->findByPk($id);
	  foreach ($aviso->getListaUsuarios() as $usr)
	    echo $usr->nombreCompleto." ".$usr->organigrama_id." \n<br>";
	  echo $aviso->para;
	}
	/**
	 * Crea un nuevo modelo.
	 * Si la creación es exitosa, el navegador será redirigido a la vista
	 * 'Index'.
	 */
	public function actionAgregar() {
            $model = new Usuarios ( 'insert' );
		
            if (isset ( $_POST ['Usuarios'] )) {
                $model->attributes = $_POST ['Usuarios'];
                $model->es_interno = 0;
                if ($model->validate ()) {
                    //$model->organigrama_id = Organigrama::getNodoRaiz()->id;
                    $model->fecha_registro = date('Ymd');
                    if ($model->validate ()) {
                        $model->password = md5($model->n_Password);
                        if ($model->save ()) {
                            EQuickDlgs::checkDialogJsScript();
                            $this->redirect(array('index'));
                        }
                    }
                }
                
            }
            EQuickDlgs::render('create',array('model'=>$model, 'selectRama'=>1));
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
	
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
	    
            if (isset($_GET['id'])) {
                $usuario = Usuarios::model()->findByPk($_GET['id']);
                $revisiones=$usuario->archivosPorRevisar();
		if ($revisiones==0){
		  $usuario->eliminarLogicamente();
		  echo "Usuario eliminado";
		  }
		else
		  echo "Este usuario no se puede eliminar, porque esta revisando algun recurso.";
                //$usuario->delete();
                
                if(!isset($_GET['ajax']))
                    $this->redirect(array('index'));
            } else {
                throw new CHttpException(404,'El usuario no existe.');
            }
        }
        else
            throw new CHttpException(400,'Petición no válida.');
    }
    
	/**
	 * Manages all models.
	 */
	public function actionIndex() {
			$this->layout='//layouts/column1';
			$model = new Usuarios ( 'search' );
			$model->unsetAttributes (); // clear any default values
			if (isset ( $_GET ['Usuarios'] ))
					$model->attributes = $_GET ['Usuarios'];
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
	public function actionCambiarPassword() {
            $model = $this->loadModel ();
            $model->setScenario('cambiarPassword');
            if (isset($_POST['Usuarios'])) {
                $model->attributes = $_POST['Usuarios'];
                if ($model->validate()) {
                    $model->password = md5($model->n_Password);
                    if ($model->save()) {
                        $this->redirect(array (
                            'index' 
                        ));
                    }
                }
            }
            $this->render('cambiarPassword', array(
                'model' => $model 
            ));
	}
        
    public function actionGetNombre($id) {
        if ($_GET['id']) {
            $result = array();
            $model = $this->loadModel();
            $result['nombre'] = $model->nombreCompleto;

            echo CJSON::encode($result);
        }
    }

	public function actionUsuarios()
	{
		// incompleta
			$data = Usuarios::model()->findAll('UsuariosId=:parent_id',
					array(':parent_id'=>(int) $_POST['evento_id']));

			$data = CHtml::listData($data,'FuncionesId','funcionesTexto');
			echo CHtml::tag('option',array('value' => ''),'Seleccione ...',true);
			foreach($data as $id => $value)
			{
					echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
			}
	}
}
