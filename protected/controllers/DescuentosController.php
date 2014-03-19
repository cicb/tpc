<?php

class DescuentosController extends Controller
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin',
                                 'delete',
                                 'create',
                                 'update',
                                 'generarcupon',
                                 'getfunciones',
                                 'getzonas',
                                 'getsubzonas',
                                 'getfilas',
                                 'getlugares',
                                 'tempdescuentos',
                                 'tempinput',
                                 'gettempdescuentos',
                                 'deletetempdescuentos',
                                 'validarcupon',
                                 'gettempdescuentosantesguardar',
                                 'guardartemp',
                                 'tempdescuentosrelacionados',
                                 'DeleteTempDescuentosRelacionados',
                                 'GetTempDescuentosRelacionados',
                                 'TempCupon',
                                 'DeleteAllTempDescuantosRelacionados',
                                 'GetTempDescuentosJson',
                                 'DeleteEventosRelacionadosAjax',
                                 'TempLog',
                                 'GetTreeView',
                                 'TempNodoFuncion',
                                 'NodoFuncionUpdate',
                                 'NodoFuncionDelete',
                                 'TempNodoFuncionDelete',
                                 'TempNodoZona',
                                 'NodoZonaUpdate',
                                 'NodoZonaDelete',
                                 'TempNodoZonaDelete',
                                 'TempNodoSubzona',
                                 'NodoSubzonaUpdate',
                                 'NodoSubzonaDelete',
                                 'TempNodoSubzonaDelete',
                                 'TempNodoFila',
                                 'NodoFilaUpdate',
                                 'NodoFilaDelete',
                                 'TempNodoFilaDelete',
                                 'TempNodoLugar',
                                 'NodoLugarUpdate',
                                 'NodoLugarDelete',
                                 'TempNodoLugarDelete',
                                 'TempDescuentosCorreo'
                                 ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
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
	   if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
		$model=new Descuentos;
        //echo $this->generarCodigo(10);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Descuentos']))
		{
			$model->attributes=$_POST['Descuentos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->DescuentosId));
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
	public function actionUpdate($id,$cupon,$EventoId)
	{
	   if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
          
		//$model=$this->loadModel($id);
        Yii::app()->getSession()->remove('descuentos');
        Yii::app()->getSession()->remove('descuentos_relacionados');
        Yii::app()->getSession()->remove('pv');
        $cuponActual = Descuentos::model()->findAll("DescuentosId=$id");
        
        $pv = Descuentos::model()->find("DescuentosId=$id");   
        if(!empty($pv->DescuentosValRef)){
            $pv = $pv->DescuentosValRef;
        }else{
            $pv = 'todos';
        } 
        Yii::app()->getSession()->add('pv',$pv);          
        if(empty($cupon))
            $descuentosIds             = Descuentos::model()->findAll("DescuentosId='$id'");
        else      
            $descuentosIds             = Descuentos::model()->findAll("CuponesCod='$cupon'");
            
        $ids = "";
        foreach($descuentosIds as $key => $descuentoId):
            $ids .=  $descuentoId->DescuentosId.",";
        endforeach;
            $ids.="-1";
        $model                     = Descuentoslevel1::model()->with(array('descuentos',"evento"))->findAll(array('condition'=>"t.DescuentosId IN($ids)",'group'=>'t.DescuentosId'));
        
        foreach($model as $key => $evento){
            $model2 = Descuentoslevel1::model()->with(array('descuentos',"evento"))->findAll(array('condition'=>"t.DescuentosId IN($ids) AND t.EventoId=".$evento->EventoId));
            $data   = array();
            foreach($model2 as $keymodel2 => $funcion):
            
                if($funcion->LugaresId>0){
                    $data[$funcion->FuncionesId][$funcion->ZonasId][$funcion->SubzonaId][$funcion->FilasId][$funcion->LugaresId] = array();
                }elseif($funcion->FilasId>0){
                    $data[$funcion->FuncionesId][$funcion->ZonasId][$funcion->SubzonaId][$funcion->FilasId] = array();
                }elseif($funcion->SubzonaId>0){
                    $data[$funcion->FuncionesId][$funcion->ZonasId][$funcion->SubzonaId] = array();
                }elseif($funcion->ZonasId>0){
                    $data[$funcion->FuncionesId][$funcion->ZonasId] = array();
                }elseif($funcion->FuncionesId > 0){
                    $data[$funcion->FuncionesId] = array();
                }
            endforeach;
            $datas[$evento->EventoId]['CuponesCod']       = $evento->descuentos->CuponesCod;
            $datas[$evento->EventoId]['DescuentosDes']    = $evento->descuentos->DescuentosDes;
            $datas[$evento->EventoId]['DescuentosPat']    = $evento->descuentos->DescuentosPat;
            $datas[$evento->EventoId]['DescuentosCan']    = $evento->descuentos->DescuentosCan;
            $datas[$evento->EventoId]['DescuentoCargo']   = $evento->descuentos->DescuentoCargo;
            $datas[$evento->EventoId]['DescuentoCargoCan'] = "0";
            $datas[$evento->EventoId]['DescuentosFecIni'] = $evento->descuentos->DescuentosFecIni;
            $datas[$evento->EventoId]['DescuentosFecFin'] = $evento->descuentos->DescuentosFecFin;
            $datas[$evento->EventoId]['DescuentosExis']   = $evento->descuentos->DescuentosExis;
            $datas[$evento->EventoId]['FuncionesId']      = $data;
            //$datas[$evento->EventoId]['FuncionesId']      = $evento->FuncionesId;
            $datas[$evento->EventoId]['ZonasId']          = $evento->ZonasId;
            $datas[$evento->EventoId]['SubzonaId']        = $evento->SubzonaId;
            $datas[$evento->EventoId]['FilasId']          = $evento->FilasId;
            $datas[$evento->EventoId]['LugaresId']        = $evento->LugaresId;
            $datas[$evento->EventoId]['DescuentosId']     = $evento->DescuentosId;
            //Datos para el log de descuentos
            $datas[$evento->EventoId]['UsuarioId']            = Yii::app()->user->id;
            $datas[$evento->EventoId]['Edit']                 = "-1";
            $datas[$evento->EventoId]['DescuentosIdLog']      = $evento->DescuentosId;
            $datas[$evento->EventoId]['CuponesCodLog']        = $evento->descuentos->CuponesCod;
            $datas[$evento->EventoId]['DescuentosPatLog']     = "-1";
            $datas[$evento->EventoId]['DescuentosCanLog']     = "-1";
            $datas[$evento->EventoId]['DescuentoCargoLog']    = "-1";
            $datas[$evento->EventoId]['DescuentoCargoCanLog'] = "-1";
            $datas[$evento->EventoId]['DescuentosFecIniLog'] = "0000-00-00 00:00:00";
            $datas[$evento->EventoId]['DescuentosFecFinLog'] = "0000-00-00 00:00:00";
            $datas[$evento->EventoId]['DescuentosExisLog']   = "-1";
            $datas[$evento->EventoId]['FuncionesIdLog']      = array();
            //$datas[$evento->EventoId]['FuncionesIdLog']      = "-1";
            $datas[$evento->EventoId]['ZonasIdLog']          = "-1";
            $datas[$evento->EventoId]['SubzonaIdLog']        = "-1";
            $datas[$evento->EventoId]['FilasIdLog']          = "-1";
            $datas[$evento->EventoId]['LugaresIdLog']        = "-1";
        }
        Yii::app()->getSession()->add('descuentos',$datas);
        //print_r($datas);
        $eventosRelacionados       = Eventosrelacionados::model()->findAll("CuponesCod='$cupon'");
		
        // Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Descuentos']))
		{
			$model->attributes=$_POST['Descuentos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->DescuentosId));
		}

		$this->render('update',array(
			'model'               => $model,
            'EventoId'            => $EventoId,
            'CuponActual'         => $cuponActual,
            'EventosRelacionados' => $eventosRelacionados,
            'cupon'               => $cupon,
            'DescuentosId'        => $id,
            'pv'                  => $pv,
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
    public function actionDeleteEventosRelacionadosAjax(){
        if (Yii::app()->request->isAjaxRequest){   
            if(!empty($_GET['id'])){
                $id    = $_GET['id'];
                $cupon = $_GET['cupon'];
                    Yii::app()->db->createCommand("DELETE FROM eventosrelacionados WHERE EventoId=$id AND CuponesCod='$cupon'")->execute();
            }   
        } 
    }
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Descuentos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Descuentos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Descuentos']))
			$model->attributes=$_GET['Descuentos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Descuentos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Descuentos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Descuentos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='descuentos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    public function actionGenerarCupon(){
        $data[] = array('cupon'=>$this->generarCodigo(10));
        echo json_encode($data);
    }
    public function generarCodigo($longitud) {
         $key = '';
         $pattern = '2456789abcdefghjkmnpqrstuvwxy';
         $max = strlen($pattern)-1;
         
            $validacion = 0;
            while($validacion == 0){
                for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
                $model = Descuentos::model()->findAll("CuponesCod='$key'",array('limit'=>1));
                if(empty($model))
                   $validacion =1;
            }
         
         return strtoupper($key);
    }
    public function actionGetFunciones(){
       if(!empty($_GET)){ 
            $EventoId  = $_GET['EventoId'];
            echo "<option value='0'>Todas las funciones</option>";
            $funciones = Funciones::model()->findAll("EventoId = $EventoId");
            foreach($funciones as $key => $funcion):
                 echo "<option value='".$funcion->FuncionesId."'>".$funcion->funcionesTexto."</option>";
            endforeach;
        }
    }
    public function actionGetZonas(){
       if(!empty($_GET)){ 
            $EventoId    = $_GET['EventoId'];
            $FuncionesId = $_GET['FuncionesId'];
            echo "<option value='0'>Todas las zonas</option>";
            $zonas = Zonas::model()->findAll("EventoId = $EventoId AND FuncionesId=$FuncionesId");
            foreach($zonas as $key => $zona):
                 echo "<option value='".$zona->ZonasId."'>".$zona->ZonasAli."</option>";
            endforeach;
        }
    }
    public function actionGetSubZonas(){
       if(!empty($_GET)){ 
            $EventoId    = $_GET['EventoId'];
            $FuncionesId = $_GET['FuncionesId'];
            $ZonasId = $_GET['ZonasId'];
            echo "<option value='0'>Todas las subzonas</option>";
            $subzonas = Subzona::model()->findAll("EventoId = $EventoId AND FuncionesId=$FuncionesId AND ZonasId=$ZonasId");
            foreach($subzonas as $key => $subzona):
                 echo "<option value='".$subzona->SubzonaId."'>".$subzona->SubzonaId."</option>";
            endforeach;
        }
    }
    public function actionGetFilas(){
       if(!empty($_GET)){ 
            $EventoId    = $_GET['EventoId'];
            $FuncionesId = $_GET['FuncionesId'];
            $ZonasId     = $_GET['ZonasId'];
            $SubzonaId   = $_GET['SubzonaId'];
            echo "<option value='0'>Todas las filas</option>";
            $filas = Filas::model()->findAll("EventoId = $EventoId AND FuncionesId=$FuncionesId AND ZonasId=$ZonasId AND SubzonaId=$SubzonaId");
            foreach($filas as $key => $fila):
                 echo "<option value='".$fila->FilasId."'>".$fila->FilasAli."</option>";
            endforeach;
        }
    }
    public function actionGetLugares(){
       if(!empty($_GET)){ 
            $EventoId    = $_GET['EventoId'];
            $FuncionesId = $_GET['FuncionesId'];
            $ZonasId     = $_GET['ZonasId'];
            $SubzonaId   = $_GET['SubzonaId'];
            $FilasId     = $_GET['FilasId'];
            echo "<option value='0'>Todos los lugares</option>";
            $lugares = Lugares::model()->findAll("EventoId = $EventoId AND FuncionesId=$FuncionesId AND ZonasId=$ZonasId AND SubzonaId=$SubzonaId AND FilasId=$FilasId");
            foreach($lugares as $key => $lugar):
                 echo "<option value='".$lugar->LugaresId."'>".$lugar->LugaresLug."</option>";
            endforeach;
        }
    }
    public function actionGuardarTemp(){
        $model = new Descuentos;
        //obtiene los datos del descuento que se guardaron de manera temporal
        $datas = Yii::app()->getSession()->get('descuentos');
        //obtiene los datos del punto de venta que se guardó de manera temporal
        $pv = Yii::app()->getSession()->get('pv');
        if(!empty($datas)){
            foreach($datas as $key => $data):
                $id = $model->findAll(array('limit'=>1,'order'=>'DescuentosId DESC'));
                $id = $id[0]->DescuentosId+1;
                
                $descripcion      = $data['DescuentosDes'];
                $cupon            = $data['CuponesCod'];
                $descuentosPat    = $data['DescuentosPat'];
                $descuentosCan    = $data['DescuentosCan'];
                $descuentoCargo   = $data['DescuentoCargo'];
                $descuentosFecIni = $data['DescuentosFecIni'];
                $descuentosFecFin = $data['DescuentosFecFin'];
                $descuentosExis   = $data['DescuentosExis'];
                $descuentosId     = $data['DescuentosId'];
                if($pv=="")
                   $pv ="todos";
                   
                //echo $descuentosId."</br>";
                $descuentoslevel1 = Descuentoslevel1::model()->findAll("EventoId = $key",array('limit'=>1,'order'=>'DescuentosNum ASC'));
                //print_r($descuentoslevel1);
                //arsort($descuentoslevel1);
                //foreach( $descuentoslevel1 as $key2 => $de){
                    //echo "(".$key2.")";
                    //echo "val:".$de->DescuentosNum;
                //}
                //$descuentos->DescuentosId = $id[0]->DescuentosId+1;
                //$descuentos->isNewRecord = true;
                $fecha_actual = date("Y-m-d H:i:s");
                $usuario_id   = $data['UsuarioId'];
                if($descuentosId==="-1"){
                   $result = Yii::app()->db->createCommand("INSERT INTO descuentos VALUES($id,'$descripcion','$descuentosPat','$descuentosCan','$pv',0,'$descuentosFecIni','$descuentosFecFin',$descuentosExis,0,'$cupon','$descuentoCargo')")->execute();
                    if($result > 0){
                        $descuentosNum     = 1;
                        $funcionesId      = $data['FuncionesId'];
                        $zonasId          = $data['ZonasId'];
                        $subzonasId       = $data['SubzonaId'];
                        $filasId          = $data['FilasId'];
                        $lugaresId        = $data['LugaresId'];
                        $descuentoslevel1 = Descuentoslevel1::model()->findAll("EventoId = $key");
                        if(!empty($descuentoslevel1[0]->DescuentosId)){
                            foreach($descuentoslevel1 as $key2 => $desc):
                                if($desc->DescuentosNum > $descuentosNum){
                                    $descuentosNum = $desc->DescuentosNum;
                                }
                            endforeach;
                            $descuentosNum = $descuentosNum+1;
                        }
                        $descuentoCargoCan   = $data['DescuentoCargoCan'];
                        if(is_array($funcionesId) AND count($funcionesId)>0){//if(count($funcionesId)>0){
                            foreach($funcionesId as $keyf => $funciones):
                                if(count($funciones)>0){
                                    foreach($funciones as $keyz => $zonas):
                                        if(count($zonas)>0){
                                            foreach($zonas as $keysz => $subzonas):
                                                if(count($subzonas)>0){
                                                    foreach($subzonas as $keyfl => $filas):
                                                        if(count($filas)>0){
                                                            foreach($filas as $keyl => $lugares):
                                                               $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $id",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                                                               $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                                                               Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($id,$descuentosNum,$key,$keyf,$keyz,$keysz,$keyfl,$keyl)")->execute();
                                                               Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$id,'$cupon','$descuentosPat', $descuentosCan,'$descuentoCargo',$descuentoCargoCan,'$descuentosFecIni','$descuentosFecFin',$descuentosExis,$key,$keyf,$keyz,$keysz,$keyfl,$keyl)")->execute();
                                                            endforeach;
                                                        }else{
                                                            $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $id",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                                                            $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                                                            Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($id,$descuentosNum,$key,$keyf,$keyz,$keysz,$keyfl,0)")->execute();
                                                            Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$id,'$cupon','$descuentosPat', $descuentosCan,'$descuentoCargo',$descuentoCargoCan,'$descuentosFecIni','$descuentosFecFin',$descuentosExis,$key,$keyf,$keyz,$keysz,$keyfl,-1)")->execute();
                                                        }
                                                    endforeach;
                                                }else{
                                                    $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $id",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                                                    $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                                                    Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($id,$descuentosNum,$key,$keyf,$keyz,$keysz,0,0)")->execute();
                                                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$id,'$cupon','$descuentosPat', $descuentosCan,'$descuentoCargo',$descuentoCargoCan,'$descuentosFecIni','$descuentosFecFin',$descuentosExis,$key,$keyf,$keyz,$keysz,-1,-1)")->execute();
                                                }
                                            endforeach;
                                        }else{
                                            $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $id",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                                            $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                                            Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($id,$descuentosNum,$key,$keyf,$keyz,0,0,0)")->execute();
                                            Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$id,'$cupon','$descuentosPat', $descuentosCan,'$descuentoCargo',$descuentoCargoCan,'$descuentosFecIni','$descuentosFecFin',$descuentosExis,$key,$keyf,$keyz,-1,-1,-1)")->execute();
                                        }
                                    endforeach;
                                }else{
                                    $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $id",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                                    $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                                    Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($id,$descuentosNum,$key,$keyf,0,0,0,0)")->execute();
                                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$id,'$cupon','$descuentosPat', $descuentosCan,'$descuentoCargo',$descuentoCargoCan,'$descuentosFecIni','$descuentosFecFin',$descuentosExis,$key,$keyf,-1,-1,-1,-1)")->execute();
                                }
                             endforeach;
                      
                        }else{
                            $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $id",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                                    $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                                    Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($id,$descuentosNum,$key,0,0,0,0,0)")->execute();
                                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$id,'$cupon','$descuentosPat', $descuentosCan,'$descuentoCargo',$descuentoCargoCan,'$descuentosFecIni','$descuentosFecFin',$descuentosExis,$key,-1,-1,-1,-1,-1)")->execute();
                        } 
                    } 
                }else{
                    $result2 = Yii::app()->db->createCommand("UPDATE descuentos SET DescuentosDes='$descripcion',DescuentosPat='$descuentosPat',DescuentosCan='$descuentosCan',DescuentosFecIni='$descuentosFecIni',DescuentosFecFin='$descuentosFecFin',DescuentosExis=$descuentosExis,CuponesCod='$cupon',DescuentoCargo='$descuentoCargo',DescuentosValRef='$pv' WHERE DescuentosId=$descuentosId")->execute();
                    //if($result2 > 0){
                        $funcionesId      = $data['FuncionesId'];
                        $zonasId          = $data['ZonasId'];
                        $subzonasId       = $data['SubzonaId'];
                        $filasId          = $data['FilasId'];
                        $lugaresId        = $data['LugaresId'];
                        //Yii::app()->db->createCommand("UPDATE descuentoslevel1 SET FuncionesId=$funcionesId,ZonasId=$zonasId,SubzonaId=$subzonasId,FilasId=$filasId,LugaresId=$lugaresId WHERE DescuentosId=$descuentosId")->execute();
                       if($data['Edit']=="1"){
                            $descuentosPatLog    = $data['DescuentosPatLog'];
                            $descuentosCanLog    = $data['DescuentosCanLog'];
                            $descuentoCargoLog   = $data['DescuentoCargoLog'];
                            $descuentoCargoCanLog = $data['DescuentoCargoCanLog'];
                            $descuentosFecIniLog = $data['DescuentosFecIniLog'];
                            $descuentosFecFinLog = $data['DescuentosFecFinLog'];
                            $descuentosExisLog   = $data['DescuentosExisLog'];
                            $funcionesIdLog      = $data['FuncionesIdLog'];
                            $zonasIdLog          = $data['ZonasIdLog'];
                            $subzonasIdLog       = $data['SubzonaIdLog'];
                            $filasIdLog          = $data['FilasIdLog'];
                            $lugaresIdLog        = $data['LugaresIdLog'];
                            Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'UPDATE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','$descuentosPatLog', $descuentosCanLog,'$descuentoCargoLog',$descuentoCargoCanLog,'$descuentosFecIniLog','$descuentosFecFinLog',$descuentosExisLog,$key,-1,-1,-1,-1,-1)")->execute();      
                       }
                       // }                   
                }
                
                //print_r($data);
            endforeach;
            $datas2 = Yii::app()->getSession()->get('descuentos_relacionados');
            if(!empty($datas2)){
                $relacionados = new Eventosrelacionados;
                foreach($datas2 as $key2 => $data2):
                    $rel = $relacionados->findAll("EventoId=".$key2." AND CuponesCod='".$data2['CuponesCod']."'",array('limit'=>1));
                    if(empty($rel[0]->CuponesCod)){
                         Yii::app()->db->createCommand("INSERT INTO eventosrelacionados VALUES($key2,'".$data2['CuponesCod']."')")->execute();   
                    }
                endforeach;
            }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Envio de correo de los cupones generados//////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
            $correo = Yii::app()->getSession()->get('correo');
           if($correo!=""){
            $body = "";
                $datas = Yii::app()->getSession()->get('descuentos');
                    if(!empty($datas)){
                        //$body.="<strong>Cupón: </strong>".$datas['CuponesCod']."</br>";
                        $body.= "<ol class='result'>";
                        foreach($datas as $keyevento => $data):
                            $porcentaje = $data['DescuentosPat']=="PORCENTAJE"?"%":"";//$data['DescuentosPat']=="PORCENTAJE"?"%":"";
                            $efectivo   = $data['DescuentosPat']=="EFECTIVO"?"$":"";
                            $body.= "<li class='info'>";
                            $evento = Evento::model()->findAllByPk($keyevento);
                            $body.= "<strong  class='alert alert-success'>$keyevento: ".$evento[0]->EventoNom."</strong><br/><br/>";
                            $eventoId = $keyevento;
                            $funcionesId = $data['FuncionesId'];
                            $zonasId = $data['ZonasId'];
                            $subzonasId = $data['SubzonaId'];
                            $filasId = $data['FilasId'];
                            if($pv=="todos"){
                                $body.= "<strong>Aplica a todos los puntos de venta</strong> <br/>";
                            }else{
                                $punto_venta = Puntosventa::model()->find("PuntosventaId=$pv"); 
                               $body.= "<strong>Aplica al punto de venta:</strong> ($pv)$punto_venta->PuntosventaNom<br/>";
                            }
                            foreach($data as $key => $dat):
                                switch($key):
                                    case 'CuponesCod'        : $body.= ($dat==""?"<strong>Descuento</strong><br/></strong>":"<strong>Código del Cupón:</strong> ".$dat."<br/>");
                                                               break;
                                    case 'DescuentosDes'     : $body.= "<strong>Descripción:</strong> ".$dat."<br/>";
                                                               break;
                                    case 'DescuentosPat'     : $body.= "<strong>Forma Descuento:</strong> ".$dat."<br/>";
                                                               break;
                                    case 'DescuentosCan'     : $body.= "<strong>Cantidad:</strong> ".$efectivo.$dat.$porcentaje."<br/>";
                                                               break;
                                    case 'DescuentoCargo'    : $body.= "<strong>Cargo Serv:</strong> ".$dat."<br/>";
                                                               break;
                                    case 'DescuentosFecIni' : $body.= "<strong>Fecha Inicio:</strong> ".$dat."<br/>";
                                                               break;
                                    case 'DescuentosFecFin' : $body.= "<strong>Fecha Fin:</strong> ".$dat."<br/>";
                                                               break;
                                    /*case 'DescuentosValRef' : $body.= "<strong>Punto de Venta:</strong> ".$dat."<br/>";
                                                               break;*/
                                    case 'DescuentosExis'    :$body.= ($dat=="0"?"<strong>Aplica descuentos a todos</strong>":"<strong>Aplica a los primeros:</strong> ".$dat)."<br/>";
                                                               break;
                                    //case 'DescuentosId'      : echo "<strong>Id:</strong> ".($dat=="-1"?"Ninguno":$dat)."<br/>";
                                     //                          break;                            
                                    case 'FuncionesId'       : 
                                                               if(!empty($dat)){
                                                                    $body.= "<ul id='funciones_info$keyevento'><strong>Funciones</strong>";
                                                                        foreach($dat as $keyf => $funcion):
                                                                            if(count($funcion)>0){
                                                                                $body.= "<li>";
                                                                                    $funcionTexto = Funciones::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf");
                                                                                    $body.= $funcionTexto[0]->funcionesTexto;
                                                                                    $body.= "<ul><strong>Zona</strong>";
                                                                                        foreach($funcion as $keyz => $zona):
                                                                                            if(count($zona)>0){
                                                                                                $body.= "<li>";
                                                                                                $zonasAli = Zonas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz");
                                                                                                $body.= $zonasAli[0]->ZonasAli;
                                                                                                    $body.= "<ul><strong>Subzona</strong>";
                                                                                                        foreach($zona as $keysz => $subzona):
                                                                                                            if(count($subzona)>0){
                                                                                                                $body.= "<li>";
                                                                                                                $body.= $keysz;
                                                                                                                    $body.= "<ul><strong>Filas</strong>";
                                                                                                                        foreach($subzona as $keyfl => $fila):
                                                                                                                            if(count($fila)>0){
                                                                                                                                $body.= "<li>";
                                                                                                                                    $filasAli = Filas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz AND SubzonaId=$keysz AND FilasId=$keyfl");
                                                                                                                                    $body.= $filasAli[0]->FilasAli;
                                                                                                                                    $body.= "<ul><strong>Lugares</strong>";
                                                                                                                                        foreach($fila as $keyl => $lugar):
                                                                                                                                            $body.= "<li>";
                                                                                                                                            $body.= $keyl;
                                                                                                                                            $body.= "</li>";
                                                                                                                                        endforeach;
                                                                                                                                    $body.= "</ul>";
                                                                                                                                $body.= "</li>";
                                                                                                                            }else{
                                                                                                                                $body.= "<li>";
                                                                                                                                $filasAli = Filas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz AND SubzonaId=$keysz AND FilasId=$keyfl");
                                                                                                                                $body.= $filasAli[0]->FilasAli;
                                                                                                                                $body.= "</li>";
                                                                                                                            }
                                                                                                                        endforeach;
                                                                                                                    $body.= "</ul>";
                                                                                                                $body.= "</li>";
                                                                                                            }else{
                                                                                                                $body.= "<li>";
                                                                                                                $body.= $keysz;
                                                                                                                $body.= "</li>";
                                                                                                            }
                                                                                                        endforeach;
                                                                                                    $body.= "</ul>";
                                                                                                $body.= "</li>";
                                                                                            }else{
                                                                                                $body.= "<li>";
                                                                                                $zonasAli = Zonas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz");
                                                                                                $body.= $zonasAli[0]->ZonasAli;
                                                                                                $body.= "</li>";
                                                                                            }
                                                                                        endforeach;
                                                                                    $body.= "</ul>";
                                                                                $body.= "</li>";
                                                                            }else{
                                                                                $body.= "<li>";
                                                                                    $funcionTexto = Funciones::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf");
                                                                                    $body.= $funcionTexto[0]->funcionesTexto;
                                                                                $body.= "</li>";    
                                                                            }
                                                                        endforeach;
                                                                   $body.= "</ul>";      
                                                               }else{$body.= '<strong>Aplica a todas las Funciones</strong></br>';}
                                                               break;
                                                                                                                                                                                                                                                                                                                                                                      
                                endswitch;
                            endforeach;
                            $body.= "</li>";
                        endforeach;
                        $body.= "</ol>";
                        $body.= "<p style='clear:both;'></p>";
                       //print_r($datas);
                    }
                //$headers="From: {$model->email}\r\nReply-To: {$model->email}";
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'From: '. Yii::app()->params['adminEmail'] . "\r\n";
                mail($correo,"Reporte de Cupones",$body,$cabeceras);
           } 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
           //limpiamos todas las variables de sesion usadas
           Yii::app()->getSession()->remove('descuentos_relacionados');
           Yii::app()->getSession()->remove('descuentos');
           Yii::app()->getSession()->remove('correo'); 
           Yii::app()->getSession()->remove('pv');
           $this->redirect(array('descuentoslevel1/admin&query=&tipo=cupon')); 
        }
    }
    public function actionTempDescuentosCorreo(){
        if (Yii::app()->request->isAjaxRequest){
            $session = Yii::app()->getSession()->get('correo');
            if(empty($session)){
                 Yii::app()->getSession()->add('correo',$_GET['correo']);
            }else{
                Yii::app()->getSession()->remove('correo');
                Yii::app()->getSession()->add('correo',$_GET['correo']);
            }
        }
    }
    public function actionTempDescuentosRelacionados(){
        if (Yii::app()->request->isAjaxRequest){
            $session = Yii::app()->getSession()->get('descuentos_relacionados');
            if(empty($session)){
                 $data[$_GET['EventoId']] = array("CuponesCod"=>$_GET['cupon'],"DescuentosId"=>0 );
                 Yii::app()->getSession()->add('descuentos_relacionados',$data);
            }else{
                $data = $session;
                $data[$_GET['EventoId']] = array("CuponesCod"=> $_GET['cupon'],"DescuentosId"=>0);
                Yii::app()->getSession()->remove('descuentos_relacionados');
                Yii::app()->getSession()->add('descuentos_relacionados',$data);
            }
        }
    }
    public function actionDeleteAllTempDescuentosRelacionados(){
        Yii::app()->getSession()->remove('descuentos_relacionados');
    }
    public function actionDeleteTempDescuentosRelacionados(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos_relacionados');
            if(!empty($data) AND !empty($_GET)){
                unset($data[$_GET['EventoId']]);
                Yii::app()->getSession()->remove('descuentos_relacionados');
                Yii::app()->getSession()->add('descuentos_relacionados',$data);
            }
        }
     }
     public function actionGetTempDescuentosRelacionados(){
        if (Yii::app()->request->isAjaxRequest){
            $datas = Yii::app()->getSession()->get('descuentos_relacionados');
            if(!empty($datas)){
                //print_r($datas);
                echo "<h4>Previzualizaci&oacute;n de los Eventos Relacionados</h4>";
                echo "<ol>";
                foreach($datas as $key => $data):
                    echo "<li>";
                    $evento = Evento::model()->findAllByPk($key);
                    echo "<strong  class='alert alert-success'>".$evento[0]->EventoNom."</strong><br/><br/>";
                    //echo "<strong>Cup&oacute;n: </strong>".$data['CuponesCod']."<br/><br/>";
                    echo "</li>";
                endforeach;
                echo "</ol>";
               
            }
        }
     }
    public function actionTempDescuentos(){
        if (Yii::app()->request->isAjaxRequest){
            $session = Yii::app()->getSession()->get('descuentos');
            if(empty($session)){
                $data[$_GET['EventoId']] = array(
                                                 "CuponesCod"         => "",
                                                 "DescuentosDes"      => "ninguna",
                                                 "DescuentosPat"      => "0",
                                                 "DescuentosCan"      => "0",
                                                 "DescuentoCargo"     => "no",
                                                 "DescuentoCargoCan"  => "-1",
                                                 "DescuentosFecIni"   => date("Y-m-d 01:00:00"),
                                                 "DescuentosFecFin"   => date("Y-m-d 23:59:00"),
                                                 "DescuentosExis"     => "0",
                                                 "DescuentosValRef"   => "todos",
                                                 "FuncionesId"        => array(),
                                                 //"FuncionesId"        => "0",
                                                 "ZonasId"            => "0",
                                                 "SubzonaId"          => "0",
                                                 "FilasId"            => "0",
                                                 "LugaresId"          => "0",
                                                 "DescuentosId"       => "-1",
                                                 //Datos para el log de descuentos
                                                 "UsuarioId"            => Yii::app()->user->id,
                                                 "Edit"                 => "-1",
                                                 "DescuentosIdLog"      => "-1",
                                                 "CuponesCodLog"        => "",
                                                 "DescuentosPatLog"     => "-1",
                                                 "DescuentosCanLog"     => "-1",
                                                 "DescuentoCargoLog"    => "-1",
                                                 "DescuentoCargoCanLog" => "-1",
                                                 "DescuentosFecIniLog"  => "0000-00-00 00:00:00",
                                                 "DescuentosFecFinLog"  => "0000-00-00 00:00:00",
                                                 "DescuentosExisLog"    => "-1",
                                                 "DescuentosValRefLog"   => "todos",
                                                 "FuncionesIdLog"       => array(),
                                                 //"FuncionesIdLog"       => "-1",
                                                 "ZonasIdLog"           => "-1",
                                                 "SubzonaIdLog"         => "-1",
                                                 "FilasIdLog"           => "-1",
                                                 "LugaresIdLog"         => "-1",
                                                   
                                                );
                Yii::app()->getSession()->add('descuentos',$data);
                //agrega el punto de venta ya se todos o uno en especifico solo se puede un solo punto de venta ya que la base de datos
                //asi lo permite  
                Yii::app()->getSession()->add('pv','todos');  
            }else{
                $data = $session;
                $data[$_GET['EventoId']] = array(
                                                 "CuponesCod"         => "",
                                                 "DescuentosDes"      => "ninguna",
                                                 "DescuentosPat"      => "0",
                                                 "DescuentosCan"      => "0",
                                                 "DescuentoCargo"     => "no",
                                                 "DescuentoCargoCan"  => "-1",
                                                 "DescuentosFecIni" => date("Y-m-d 01:00:00"),
                                                 "DescuentosFecFin" => date("Y-m-d 23:59:00"),
                                                 "DescuentosExis"     => "0",
                                                 "DescuentosValRef"   => "todos",
                                                 "FuncionesId"        => "0",
                                                 "ZonasId"            => "0",
                                                 "SubzonaId"          => "0",
                                                 "FilasId"            => "0",
                                                 "LugaresId"          => "0",
                                                 "DescuentosId"       => "-1",
                                                 //Datos para el log de descuentos
                                                 "UsuarioId"            => Yii::app()->user->id,
                                                 "Edit"                 => "-1",
                                                 "DescuentosIdLog"      => "-1",
                                                 "CuponesCodLog"        => "",
                                                 "DescuentosPatLog"     => "-1",
                                                 "DescuentosCanLog"     => "-1",
                                                 "DescuentoCargoLog"    => "-1",
                                                 "DescuentoCargoCanLog" => "-1",
                                                 "DescuentosFecIniLog"  => "0000-00-00 00:00:00",
                                                 "DescuentosFecFinLog"  => "0000-00-00 00:00:00",
                                                 "DescuentosExisLog"    => "-1",
                                                 "DescuentosValRefLog"  => "todos",
                                                 "FuncionesIdLog"       => array(),
                                                 //"FuncionesIdLog"       => "-1",
                                                 "ZonasIdLog"           => "-1",
                                                 "SubzonaIdLog"         => "-1",
                                                 "FilasIdLog"           => "-1",
                                                 "LugaresIdLog"         => "-1",     
                                                );
                 Yii::app()->getSession()->remove('descuentos');
                 Yii::app()->getSession()->add('descuentos',$data);
                 //agrega el punto de venta ya se todos o uno en especifico solo se puede un solo punto de venta ya que la base de datos
                //asi lo permite
                 Yii::app()->getSession()->remove('pv');
                 Yii::app()->getSession()->add('pv','todos'); 
            }
        }
    } 
     public function actionTempLog(){
        if (Yii::app()->request->isAjaxRequest){
            $session = Yii::app()->getSession()->get('log');
             if(empty($session)){
                $data[$_GET['EventoId']] = array();
                Yii::app()->getSession()->add('descuentos',$data);
             }else{
                 $data = $sesion;
                 $data[$_GET['EventoId']] = array();
                 Yii::app()->getSession()->remove('descuentos');
                 Yii::app()->getSession()->add('descuentos',$data);
             }
        }
    } 
/**
 * 
 */           
     public function actionTempInput(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                $data[$_GET['EventoId']][$_GET['name']] = $_GET['value'];
               /* if($data[$_GET['EventoId']]['DescuentosId']!="-1"){
                   $data[$_GET['EventoId']]['Edit']="1"; 
                }*/
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
                //agrega el punto de venta ya se todos o uno en especifico solo se puede un solo punto de venta ya que la base de datos
                //asi lo permite
                if($_GET['name']=="DescuentosValRef"){
                    Yii::app()->getSession()->remove('pv');
                    Yii::app()->getSession()->add('pv',$_GET['value']);
                }
                 
            }
        }
     }
/**
 * Almacena El nodo funcion Temporal
 */     
    public function actionTempNodoFuncion(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                $data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']] = array();
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Update El nodo Funcion
 */
    public function actionNodoFuncionUpdate(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,".$descuentos->ZonasId.",-1,-1,-1)")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=0 AND ZonasId=0 AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=0 AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId")->execute();
                
                $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;  
                Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,0,0,0,0)")->execute();
                Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,-1,-1,-1,-1)")->execute();    
                
            }
        }
     }         
/**
 * Elimina El nodo funcion Temporal
 */     
    public function actionTempNodoFuncionDelete(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                unset($data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']]);
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Delete El nodo Funcion
 */
    public function actionNodoFuncionDelete(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,".$descuentos->ZonasId.",-1,-1,-1)")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=0 AND ZonasId=0 AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=0 AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId")->execute();
                $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                $count = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId=$descuentosId AND EventoId=$eventoId"));
                if(count($count)<=0){
                    Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,0,0,0,0,0)")->execute();
                }
                     
            }
        }
     }          
/**
 * Almacena El nodo Zona Temporal
 */      
     public function actionTempNodoZona(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                $data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']] = array();
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Update El nodo Zona 
 */
    public function actionNodoZonaUpdate(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,".$descuentos->SubzonaId.",-1,-1)")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=0 AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId")->execute();
                
                $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;  
                Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,$zonasId,0,0,0)")->execute();
                Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,-1,-1,-1)")->execute();    
                
            }
        }
     }      
/**
 * Elimina El nodo Zona Temporal
 */      
     public function actionTempNodoZonaDelete(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                unset($data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']]);
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Delete El nodo Zona 
 */
    public function actionNodoZonaDelete(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,".$descuentos->SubzonaId.",-1,-1)")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=0 AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId ")->execute();
                //$descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                //$descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                //Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,$zonasId,0,0 ,0)")->execute(); 
            }
        }
     }          
 
/**
 * Almacena El nodo Subzona Temporal
 */      
     public function actionTempNodoSubzona(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                $data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']][$_GET['SubzonaId']] = array();
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Update El nodo Subzona 
 */
    public function actionNodoSubzonaUpdate(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                $subzonaId     = $_GET['SubzonaId'];
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,".$descuentos->FilasId.",-1)")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId")->execute();
                
                $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;  
                Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,$zonasId,$subzonaId,0,0)")->execute();
                Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,-1,-1)")->execute();    
                
            }
        }
     }     
/**
 * Elimina El nodo Subzona Temporal
 */      
     public function actionTempNodoSubzonaDelete(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                unset($data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']][$_GET['SubzonaId']]);
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Delete El nodo Subzona 
 */
    public function actionNodoSubzonaDelete(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                $subzonaId     = $_GET['SubzonaId'];
                
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,".$descuentos->SubzonaId.",-1,-1)")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=0 AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId")->execute();
                $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,$zonasId,0,0 ,0)")->execute(); 
            }
        }
     }        
/**
 * Almacena El nodo Fila Temporal
 */      
     public function actionTempNodoFila(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                $data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']][$_GET['SubzonaId']][$_GET['FilasId']] = array();
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Update El nodo Fila 
 */
    public function actionNodoFilaUpdate(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                $subzonaId     = $_GET['SubzonaId'];
                $filasId       = $_GET['FilasId'];
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId= $filasId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,".$descuentos->LugaresId.")")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId")->execute();
                
                $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;  
                Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId ,0)")->execute();
                Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,-1)")->execute();    
                
            }
        }
     }  
/**
 * Elimina El nodo Fila Temporal
 */      
     public function actionTempNodoFilaDelete(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                unset($data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']][$_GET['SubzonaId']][$_GET['FilasId']]);
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Delete El nodo Fila 
 */
    public function actionNodoFilaDelete(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                $subzonaId     = $_GET['SubzonaId'];
                $filasId       = $_GET['FilasId'];
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual  = date("Y-m-d H:i:s");
                $usuario_id    = Yii::app()->user->id;
                $model         = Descuentoslevel1::model()->findAll("DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId= $filasId");
                
                foreach($model as $key => $descuentos):
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,".$descuentos->LugaresId.")")->execute();
                endforeach;
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=0 AND LugaresId=0")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId")->execute();
                $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;
                Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,$zonasId,$subzonaId,0 ,0)")->execute(); 
            }
        }
     }            
/**
 * Almacena El nodo Lugar temporal
 */      
     public function actionTempNodoLugar(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                $data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']][$_GET['SubzonaId']][$_GET['FilasId']][$_GET['LugaresId']] = array();
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
 /**
 * Update El nodo Lugar 
 */
    public function actionNodoLugarUpdate(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                $subzonaId     = $_GET['SubzonaId'];
                $filasId       = $_GET['FilasId'];
                $lugaresId     = $_GET['LugaresId'];
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual = date("Y-m-d H:i:s");
                $usuario_id   = Yii::app()->user->id;
                $result = Yii::app()->db->createCommand("SELECT * FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=$lugaresId")->execute();  
                if($result>0){
                    Yii::app()->db->createCommand("UPDATE descuentoslevel1 set DescuentosId=$descuentosId,EventoId=$eventoId,FuncionesId=$funcionesId,ZonasId=$zonasId,SubzonaId=$subzonaId,FilasId=$filasId,LugaresId=$lugaresId WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=$lugaresId")->execute();
                     Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'UPDATE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId)")->execute();
                }else{
                      Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=0")->execute();  
                      $descuentoslevel1 = Descuentoslevel1::model()->findAll(array('condition'=>"DescuentosId = $descuentosId",'order'=>'t.DescuentosNum DESC','limit'=>'1'));
                      $descuentosNum = !empty($descuentoslevel1[0]->DescuentosNum)?$descuentoslevel1[0]->DescuentosNum + 1:$descuentosNum;  
                      Yii::app()->db->createCommand("INSERT INTO descuentoslevel1 VALUES($descuentosId,$descuentosNum,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId ,$lugaresId)")->execute();
                      Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'CREATE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId)")->execute();  
                }
            }
        }
     }  
 /**
 * Elimina El nodo Lugar temporal
 */      
     public function actionTempNodoLugarDelete(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                unset($data[$_GET['EventoId']]["FuncionesId"][$_GET['FuncionesId']][$_GET['ZonasId']][$_GET['SubzonaId']][$_GET['FilasId']][$_GET['LugaresId']]);
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
/**
 * Delete El nodo Lugar
 */
    public function actionNodoLugarDelete(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $descuentosId  = $_GET['DescuentosId'];
                $eventoId      = $_GET['EventoId'];
                $funcionesId   = $_GET['FuncionesId'];
                $zonasId       = $_GET['ZonasId'];
                $subzonaId     = $_GET['SubzonaId'];
                $filasId       = $_GET['FilasId'];
                $lugaresId     = $_GET['LugaresId'];
                $cupon         = $_GET['CuponesCod'];
                $descuentosNum = 1;
                $fecha_actual = date("Y-m-d H:i:s");
                $usuario_id   = Yii::app()->user->id;
                $result = Yii::app()->db->createCommand("SELECT * FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=$lugaresId")->execute();  
                if($result>0){
                    Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=0")->execute();
                    Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$descuentosId AND EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonaId AND FilasId=$filasId AND LugaresId=$lugaresId")->execute();
                    Yii::app()->db->createCommand("INSERT INTO descuentoslog VALUES(null,'DELETE','$fecha_actual',$usuario_id,$descuentosId,'$cupon','-1', -1,'-1',-1,'0000-00-00 00:00:00','0000-00-00 00:00:00',-1,$eventoId,$funcionesId,$zonasId,$subzonaId,$filasId,$lugaresId)")->execute();
                }
            }
        }
     }      
     public function actionGetTreeView(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($_GET['DescuentosId'])){
                $descuentosId = $_GET['DescuentosId'];
                $cuponesCod   = $_GET['CuponesCod'];
            }else{$descuentosId = "-1";$cuponesCod   ="";}
            $model = Evento::model()->with(array('funciones','zonas'))->findAll("t.EventoId=".$_GET['EventoId']);
            $this->renderPartial('_getTreeView',array('model'=>$model,'data'=>$data,'descuentosId'=>$descuentosId,'cuponesCod'=>$cuponesCod));       
        }
     } 
      public function actionGetTempDescuentosJson(){
        if (Yii::app()->request->isAjaxRequest){
            $datas = Yii::app()->getSession()->get('descuentos');
            if(!empty($datas)){
                $current = current($datas);
                $eventoNuevo =  $datas[$_GET['EventoId']];
                if($eventoNuevo['DescuentosDes']=="ninguna" AND $eventoNuevo['DescuentosId']=="-1"){
                    unset($datas[$_GET['EventoId']]);
                    $datas[$_GET['EventoId']]['CuponesCod']       = $current['CuponesCod'];
                    $datas[$_GET['EventoId']]['DescuentosDes']    = $current['DescuentosDes'];
                    $datas[$_GET['EventoId']]['DescuentosPat']    = $current['DescuentosPat'];
                    $datas[$_GET['EventoId']]['DescuentosCan']    = $current['DescuentosCan'];
                    $datas[$_GET['EventoId']]['DescuentoCargo']   = $current['DescuentoCargo'];
                    $datas[$_GET['EventoId']]['DescuentoCargoCan'] = $current['DescuentoCargoCan'];
                    $datas[$_GET['EventoId']]['DescuentosFecIni'] = $current['DescuentosFecIni'];
                    $datas[$_GET['EventoId']]['DescuentosFecFin'] = $current['DescuentosFecFin'];
                    $datas[$_GET['EventoId']]['DescuentosExis']   = $current['DescuentosExis'];
                    $datas[$_GET['EventoId']]['DescuentosValRef']   = $current['DescuentosValRef'];
                    $datas[$_GET['EventoId']]['FuncionesId']      = array();
                    //$datas[$_GET['EventoId']]['FuncionesId']      = "0";
                    $datas[$_GET['EventoId']]['ZonasId']          = "0";
                    $datas[$_GET['EventoId']]['SubzonaId']        = "0";
                    $datas[$_GET['EventoId']]['FilasId']          = "0";
                    $datas[$_GET['EventoId']]['LugaresId']        = "0";
                    $datas[$_GET['EventoId']]['DescuentosId']     = "-1";
                    //Datos para el log de descuentos
                    $datas[$_GET['EventoId']]['UsuarioId']            = $current['UsuarioId'];
                    $datas[$_GET['EventoId']]['Edit']                 = "-1";
                    $datas[$_GET['EventoId']]['DescuentosIdLog']      = $current['DescuentosIdLog'];
                    $datas[$_GET['EventoId']]['CuponesCodLog']        = $current['CuponesCodLog'];
                    $datas[$_GET['EventoId']]['DescuentosPatLog']     = "-1";
                    $datas[$_GET['EventoId']]['DescuentosCanLog']     = "-1";
                    $datas[$_GET['EventoId']]['DescuentoCargoLog']    = "-1";
                    $datas[$_GET['EventoId']]['DescuentoCargoCanLog'] = "-1";
                    $datas[$_GET['EventoId']]['DescuentosFecIniLog']  = "0000-00-00 00:00:00";
                    $datas[$_GET['EventoId']]['DescuentosFecFinLog']  = "0000-00-00 00:00:00";
                    $datas[$_GET['EventoId']]['DescuentosExisLog']    = "-1";
                    $datas[$_GET['EventoId']]['DescuentosValRefLog']   = $current['DescuentosValRef'];
                    $datas[$_GET['EventoId']]['FuncionesIdLog']       = $current['FuncionesIdLog'];
                    $datas[$_GET['EventoId']]['ZonasIdLog']           = "-1";
                    $datas[$_GET['EventoId']]['SubzonaIdLog']         = "-1";
                    $datas[$_GET['EventoId']]['FilasIdLog']           = "-1";
                    $datas[$_GET['EventoId']]['LugaresIdLog']         = "-1";
                    Yii::app()->getSession()->remove('descuentos');
                    Yii::app()->getSession()->add('descuentos',$datas);
                    $datas = Yii::app()->getSession()->get('descuentos');
                    echo json_encode($datas[$_GET['EventoId']]);
                }else{
                    echo json_encode($datas[$_GET['EventoId']]);
                }
                
               //print_r($datas); 
            }
        }
     }
     public function actionGetTempDescuentos(){
        if (Yii::app()->request->isAjaxRequest){
            $datas = Yii::app()->getSession()->get('descuentos');
            $pv = Yii::app()->getSession()->get('pv');
            if(!empty($datas)){
                echo "<ul class='result'>";
                foreach($datas as $keyevento => $data):
                    //print_r($data);
                    $porcentaje = $data['DescuentosPat']=="PORCENTAJE"?"%":"";//$data['DescuentosPat']=="PORCENTAJE"?"%":"";
                    $efectivo   = $data['DescuentosPat']=="EFECTIVO"?"$":"";
                    echo "<li class='info'>";
                    $evento = Evento::model()->findAllByPk($keyevento);
                    echo "<strong  class='alert alert-success'>$keyevento: ".$evento[0]->EventoNom."</strong><br/><br/>";
                    $eventoId = $keyevento;
                    $funcionesId = $data['FuncionesId'];
                    $zonasId = $data['ZonasId'];
                    $subzonasId = $data['SubzonaId'];
                    $filasId = $data['FilasId'];
                    //especifica el punto de venta al que se aplicara el descuento $pv
                    if($pv=="todos"){
                        echo "<strong>Aplica a todos los puntos de venta</strong> <br/>";
                    }else{
                        $punto_venta = Puntosventa::model()->find("PuntosventaId=$pv"); echo "<strong>Aplica al punto de venta:</strong> ($pv)$punto_venta->PuntosventaNom<br/>";
                    }
                    foreach($data as $key => $dat):
                        switch($key):
                            //case 'CuponesCod'        : echo "<strong>C&oacutedigo del Cup&oacute;n:</strong> ".$dat."<br/>";
                             //                          break;
                            case 'DescuentosDes'     : echo "<strong>Descripci&oacuten:</strong> ".$dat."<br/>";
                                                       break;
                            case 'DescuentosPat'     : echo "<strong>Forma Descuento:</strong> ".$dat."<br/>";
                                                       break;
                            case 'DescuentosCan'     : echo "<strong>Cantidad:</strong> ".$efectivo.$dat.$porcentaje."<br/>";
                                                       break;
                            case 'DescuentoCargo'    : echo "<strong>Cargo Serv:</strong> ".$dat."<br/>";
                                                       break;
                            case 'DescuentosFecIni' : echo "<strong>Fecha Inicio:</strong> ".$dat."<br/>";
                                                       break;
                            case 'DescuentosFecFin' : echo "<strong>Fecha Fin:</strong> ".$dat."<br/>";
                                                       break;
                            case 'DescuentosExis'    : echo ($dat=="0"?"<strong>Aplica descuentos a todos</strong>":"<strong>Aplica a los primeros:</strong> ".$dat)."<br/>";
                                                       break;
                            case 'DescuentosValRef' :  /*if($dat=="todos"){
                                                            echo "<strong>Punto de Venta:</strong> TODOS<br/>";
                                                       }else{
                                                            $punto_venta = Puntosventa::model()->find("PuntosventaId=$dat"); echo "<strong>Punto de Venta:</strong> ($dat)$punto_venta->PuntosventaNom<br/>";
                                                       }*/
                                                       
                                                       break;                           
                            case 'DescuentosId'      : echo "<strong>Id:</strong> ".($dat=="-1"?"Ninguno":$dat)."<br/>";
                                                       break;                            
                            case 'FuncionesId'       : 
                                                       if(!empty($dat)){
                                                            echo "<ul id='funciones_info$keyevento'><strong>Funciones</strong>";
                                                                foreach($dat as $keyf => $funcion):
                                                                    if(count($funcion)>0){
                                                                        echo "<li>";
                                                                            $funcionTexto = Funciones::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf");
                                                                            echo $funcionTexto[0]->funcionesTexto;
                                                                            echo "<ul><strong>Zona</strong>";
                                                                                foreach($funcion as $keyz => $zona):
                                                                                    if(count($zona)>0){
                                                                                        echo "<li>";
                                                                                        $zonasAli = Zonas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz");
                                                                                        echo $zonasAli[0]->ZonasAli;
                                                                                            echo "<ul><strong>Subzona</strong>";
                                                                                                foreach($zona as $keysz => $subzona):
                                                                                                    if(count($subzona)>0){
                                                                                                        echo "<li>";
                                                                                                        echo $keysz;
                                                                                                            echo "<ul><strong>Filas</strong>";
                                                                                                                foreach($subzona as $keyfl => $fila):
                                                                                                                    if(count($fila)>0){
                                                                                                                        echo "<li>";
                                                                                                                            $filasAli = Filas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz AND SubzonaId=$keysz AND FilasId=$keyfl");
                                                                                                                            echo $filasAli[0]->FilasAli;
                                                                                                                            echo "<ul><strong>Lugares</strong>";
                                                                                                                                foreach($fila as $keyl => $lugar):
                                                                                                                                    echo "<li>";
                                                                                                                                    echo $keyl;
                                                                                                                                    echo "</li>";
                                                                                                                                endforeach;
                                                                                                                            echo "</ul>";
                                                                                                                        echo "</li>";
                                                                                                                    }else{
                                                                                                                        echo "<li>";
                                                                                                                        $filasAli = Filas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz AND SubzonaId=$keysz AND FilasId=$keyfl");
                                                                                                                        echo $filasAli[0]->FilasAli;
                                                                                                                        echo "</li>";
                                                                                                                    }
                                                                                                                endforeach;
                                                                                                            echo "</ul>";
                                                                                                        echo "</li>";
                                                                                                    }else{
                                                                                                        echo "<li>";
                                                                                                        echo $keysz;
                                                                                                        echo "</li>";
                                                                                                    }
                                                                                                endforeach;
                                                                                            echo "</ul>";
                                                                                        echo "</li>";
                                                                                    }else{
                                                                                        echo "<li>";
                                                                                        $zonasAli = Zonas::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf AND ZonasId=$keyz");
                                                                                        echo $zonasAli[0]->ZonasAli;
                                                                                        echo "</li>";
                                                                                    }
                                                                                endforeach;
                                                                            echo "</ul>";
                                                                        echo "</li>";
                                                                    }else{
                                                                        echo "<li>";
                                                                            $funcionTexto = Funciones::model()->findAll("EventoId=$keyevento AND FuncionesId=$keyf");
                                                                            echo $funcionTexto[0]->funcionesTexto;
                                                                        echo "</li>";    
                                                                    }
                                                                endforeach;
                                                           echo "</ul>";      
                                                       }else{echo '<strong>Aplica a todas las Funciones</strong></br>';}
                                                       break;
                            /*case 'ZonasId'           : $zonas = Zonas::model()->findAll("EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId");
                                                       echo "<strong>Zona:</strong> ".($dat=="0"?"Todas":$zonas[0]->ZonasAli)."<br/>";
                                                       break; 
                            case 'SubzonaId'         : echo "<strong>SubZona:</strong> ".($dat=="0"?"Todas":$dat)."<br/>";
                                                       break; 
                            case 'FilasId'           : $filas = Filas::model()->findAll("EventoId=$eventoId AND FuncionesId=$funcionesId AND ZonasId=$zonasId AND SubzonaId=$subzonasId AND FilasId=$filasId");
                                                       echo "<strong>Fila:</strong> ".($dat=="0"?"Todas":$filas[0]->FilasAli)."<br/>";
                                                       break; 
                            case 'LugaresId'         : echo "<strong>Lugar:</strong> ".($dat=="0"?"Todas":$dat)."<br/>";
                                                       break;*/
                                                                                                                                                                                                                                                                                                                                                              
                        endswitch;
                        //echo $key.":".$dat."<br/>";
                    endforeach;
                    echo "</li>";
                endforeach;
                echo "</ul>";
                echo "<p style='clear:both;'></p>";
               //print_r($datas);
            }
        }
     }
     public function actionGetTempDescuentosAntesGuardar(){
        if (Yii::app()->request->isAjaxRequest){
            $datas = Yii::app()->getSession()->get('descuentos');
            if(!empty($datas)){
                echo "<ol>";
                foreach($datas as $key => $data):
                    echo "<li>";
                    $evento = Evento::model()->findAllByPk($key);
                    echo "<strong  class='alert alert-success'>".$evento[0]->EventoNom."</strong><br/><br/>";
                    //echo "<strong>Edit: </strong>".$data['Edit']."<br/>";
                    //echo "<strong>DescId: </strong>".$data['DescuentosId']."<br/>";
                    //echo "<strong>UsuarioId: </strong>".$data['Edit']."<br/>";
                    //print_r($data);
                    //echo 'Correo:'. Yii::app()->getSession()->get('correo');
                    echo "</li>";
                endforeach;
                echo "</ol>";
               //print_r($datas);
            }
        }
     }
     public function actionDeleteTempDescuentos(){
        if (Yii::app()->request->isAjaxRequest){
            $data = Yii::app()->getSession()->get('descuentos');
            if(!empty($data) AND !empty($_GET)){
                unset($data[$_GET['EventoId']]);
                Yii::app()->getSession()->remove('descuentos');
                Yii::app()->getSession()->add('descuentos',$data);
            }
        }
     }
     public function actionValidarCupon(){
        if (Yii::app()->request->isAjaxRequest){
            $texto = $_GET['texto'];
             $texto = str_replace( array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï",
                                      "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", 
                                      "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", 
                                      "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç","Ñ","ñ","\\", "¨", "º", "-", "~",
                                     "#", "@", "|", "!", "\"","·", "$", "%", "&", "/","(", ")", "?", "'", 
                                     "¡","¿", "[", "^", "`", "]","+", "}", "{", "¨", "´",">", "<", ";", 
                                     ",", ":",".","_","=","*"," "),
                               array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", 
                                     "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", 
                                     "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", 
                                     "O", "O", "U", "U", "U", "U", "C",""),
             utf8_decode( $texto));
            $model = Descuentos::model()->findAll("CuponesCod='$texto'",array('limit'=>1));
            $validacion ="1";
            if(!empty($model))
                $validacion ="0";
            $data = array('validacion'=>$validacion,'texto'=>strtoupper($texto));
            
            echo json_encode($data);
        }
     }
     
}
