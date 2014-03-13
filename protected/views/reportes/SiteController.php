<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
   
	 
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
//        $this->layout = '//layouts/mainintro';
	//	$this->render('intro');
	$this->render('index');
	}


	public function actionIndex2()
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
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
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
    
    public function actionvernota()
    {
        $modelNotas = new CActiveDataProvider('Nota', 
        array('criteria'=>array(
                                'condition'=>'NotasSta="ALTA"',
                                
                                //'order'=>'NotasFec DESC',
                                ),
                                'pagination'=>array(
                                    'pageSize'=>3),
                                ));
                                
   /* $criteria = new CDbCriteria();
    
    $criteria->condition = 'NotasSta="ALTA"';
    $count=Nota::model()->count($criteria);
    $pages=new CPagination($count);

    // results per page
    $pages->pageSize=3;
    $pages->applyLimit($criteria);
    $models = Nota::model()->findAll($criteria);
    */
    $ver = true;

    $this->renderPartial('notas', array('model' => $modelNotas,'vernota' => $ver),false,true);
    Yii::app()->end();
        
    }

	public function actionTop10(){
		
		if($_POST[id])
			$id = $_POST[id];
		else
			$id = 0;
		$model = new CActiveDataProvider('Top', 
								array('criteria'=>array('select'   =>'*', 
													    'condition'=>'TopSta="ALTA" AND TopId = '.$id,
														'order'=>'TopNum')));									
		
		$this->renderPartial('/site/_poderosas', array('model'=>$model));
	}

    public function actiontelefono()
    {  
        $ruta = "./punto10.m3u";
        if(file_exists($ruta))
        {
            $file = file($ruta);
            $file2 = implode("", $file);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$ruta\r\n\r\n");
            header("Content-Length: ".strlen($file2)."\n\n");
            echo $file2;      
        }
        else
        {
            echo "Error: no se encuentra el archivo";
            exit;
        }
        
    }
//public function actionUstream() {
//        $this->renderPartial('_ustream');
//    }
}
