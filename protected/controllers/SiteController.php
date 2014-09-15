<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
    public $defaultAction = 'Login';
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
			$model=new LoginForm;
			if(!Yii::app()->user->isGuest){
					$this->redirect(array("reportes/index"));
			}
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
					echo CActiveForm::validate($model);
					Yii::app()->end();
			}

			// collect user input data
			if(isset($_POST['LoginForm']))
			{
					$model->attributes=$_POST['LoginForm'];
					// validate user input and redirect to the previous page if valid
					if($model->validate() && $model->login())
							$this->redirect(Yii::app()->user->returnUrl);
			}
			// display the login form
			$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->homeUrl);
	}

	public function actionAbout()
	{
		$this->render('pages/about');
	}
	// Demo del formulario para el evento de la carrera UDLAP -------------------------------------------------------------
	public function actionFormularioUdlap()
	{
		if (isset($_GET['boleto'])) {
			
		}
		$this->renderPartial('formularios/carreraUdlap');
	}

	public function actionValidarBoletos($boleto)
	{
		# Verifica si se trata de un numero de referencia o de un numero de boleto
		$service=new Servicios($boleto);
		$lugaresVendidos=array();
		try{
			if (is_numeric($boleto)) 
				$lugaresVendidos=$service->buscarBoletos(false,array($boleto));
			else
				$lugaresVendidos=$service->buscarBoletos($boleto);
		} catch (Exception $e) {
			// echo $e->getMessage();
		}
		foreach ($lugaresVendidos as $lugar) {
			$corredor=Corredores::model()->findByPk($lugar->getPrimaryKey());
			if (is_null($corredor)) {
				$corredor=new Corredores('insert');
			}
			$this->renderPartial('formularios/corredor',compact('lugar','corredor'));
		}
		if (empty($lugaresVendidos)) {
			throw new Exception("Boletos no encontrados", 503);
			
			// echo CHtml::tag('div',array('class'=>'alert alert-danger'),'Numero de boleto/referencia invalido.');
		}
		// echo CJSON::encode($boletos);
	}
	public function actionRegistrarCorredor()
	{
		if (isset($_POST, $_POST['Corredores'])) {
			$corredor=Corredores::model()->findByAttributes(array('boleto'=>$_POST['Corredores']['boleto']));
			if(empty($corredor))
				$corredor=new Corredores();
			$corredor->attributes=$_POST['Corredores'];
			if ($corredor->save())
				$this->renderPartial('formularios',compact('corredor'));
			else{
				$lugar=$corredor->lugar;
				$this->renderPartial('formularios/corredor',compact('lugar','corredor'));
			}
		}


			// if ($corredor->validate()) {
			// 	# code...
			// }
		// print_r($corredor->attributes) ;
		
		else
			throw new Exception("Datos incompletos", 404);
		
	}
	// Demo del formulario para el evento de la carrera UDLAP -------------------------------------------------------------


}
