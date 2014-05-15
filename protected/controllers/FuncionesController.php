<?php

class FuncionesController extends Controller
{
	public function actionIndex()
	{
    $this->render('index');
  
  }
   public function filters()
   {
	 return array(
	   'accessControl', // perform access control for CRUD operations
	   'postOnly + generarArbolCPVF', // we only allow deletion via POST request
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
  public function actionRegistro()
  {
    $model=new Funciones('insert');  
    $this->guardar($model);
      $this->render('form',compact('model'));
  }

  public function actionActualizar($eid,$id)
  {

      $model=Funciones::model()->findByPk(array('EventoId'=>$eid,'FuncionesId'=>$id));
      $model->scenario='update';
      $this->guardar($model);
            //$funciones = Funciones::model()->findByPk("FuncionesId=$id");
            //$forolevel1 = Forolevel1::model()->findByAttributes(array('ForoId'=>$funciones->ForoId,'ForoMapIntId'=>$funciones->ForoMapIntId));
      $this->render('form',compact('model'));
  }
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function guardar(Funciones $funcion)
  {
      //$this->perfil();

      if(isset($_POST['Funciones']))
      {
          //$this->performAjaxValidation($funcion);
          $msg = $funcion->guardar($_POST['Funciones']);

          if ($msg==1) {
              Yii::app()->user->setFlash('success', "Se ha guardado la funcion \"".$funcion->funcionesTexto.'"');
                            $this->redirect(array('funciones/actualizar', 'eid'=>$funcion->EventoId, 'id'=>$funcion->FuncionesId));
          } 
          echo $msg;
      }
  }



	public function actionCargarFunciones()
	{
			$data = Funciones::model()->findAll('EventoId=:parent_id',
					array(':parent_id'=>(int) $_POST['evento_id']));

			$data = CHtml::listData($data,'FuncionesId','funcionesTexto');
			echo CHtml::tag('option',array('value' => ''),'TODAS',true);
			foreach($data as $id => $value)
			{
					echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
			}
	}
	public function actionCargarFuncionesFiltradas()
	{
			$data =Yii::app()->user->modelo->getFuncionesAsignadas($_POST['evento_id']);
			$lista = CHtml::listData($data,'FuncionesId','funcionesTexto');
			echo CHtml::tag('option',array('value' => 'TODAS'),'Todas',true);
			foreach($lista as $id => $value)
			{
					echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
			}
	}
	public function actionCargarFuncionesDistribucion(){
          $eventoId = $_POST['evento_id'];
          $evento = new Evento;
          $value = $evento->getFunciones($eventoId);
          $foro = $value[0]['ForoId'];
          $forointmap = $value[0]['ForoMapIntId'];
          $cantidad = $value[0]['Cantidad'];
          $distribucion = $value[0]['Distribucion'];
        /*  if ($cantidad=="1")
          {
             echo "<table id='tabla_funciones'>";
                 echo "<tr>";
                      echo "<td>";
                           echo CHtml::checkBox("todas",true,array('value'=>"0",'id'=>"funcion_id_todas","data_foro_id"=>"0",'class'=>"ck"));
                      echo "</td>";
                      echo "<td>";
                           echo "<label for='funcion_id_todas'>Todas</label>";
                      echo "</td>";
                 echo "</tr>";

                 foreach($value as $id => $funcion)
                 {
                 echo "<tr>";
                      echo "<td>";
                           echo CHtml::checkBox("funcion_id",true,array('value'=>$value[$id]['FuncionesId'],'id'=>"funcion_id_".$value[$id]['FuncionesId'],"data_foro_id"=>$value[$id]['ForoId'].$value[$id]['ForoMapIntId'],'class'=>"ck"));
                      echo "</td>";
                      echo "<td>";
                         echo "<label for='funcion_id_".$value[$id]['FuncionesId']."'>".$value[$id]['funcionesTexto']."</label>";
                      echo "</td>";
                  echo "</tr>";
                  }
			echo "</table>";
          }
          else
          {   */
              echo "<table id='tabla_funciones'>";
                 echo "<tr>";
                      echo "<td>";
                           if ($distribucion=='1')
                           {
                               echo CHtml::checkBox("todas",false,array('value'=>"todas",'id'=>"funcion_id_todas","data_foro_id"=>"0",'class'=>"ck"));
                           }
                           else
                           {
                               echo CHtml::checkBox("todas",false,array('value'=>"todas",'id'=>"funcion_id_todas","data_foro_id"=>"0",'class'=>"ck","disabled"=>"true"));
                           }
                      echo "</td>";
                      echo "<td>";
                           echo "<label for='funcion_id_todas'>Todas</label>";
                      echo "</td>";
                 echo "</tr>";

                 foreach($value as $id => $funcion){
                 $distribucionlevel1 =  Distribucionpuertalevel1::model()->find("EventoId=$eventoId  AND FuncionesId IN($funcion[FuncionesId])");   
                 $estilo = !empty($distribucionlevel1)?'distribucion_asignada':'';
                 if (($foro!=($value[$id]['ForoId'])) || ($forointmap!=($value[$id]['ForoMapIntId']))){
                           echo "<tr><td colspan='2' style='border:1px solid #959494 !important'></td></tr>";
                           //echo "<hr style='border-top:1px solid #FCAA04 !important' size=1 width= 110% align=center/>";
                         }   
                 echo "<tr>";
                      echo "<td class='$estilo'>";
                           echo CHtml::checkBox("funcion_id",false,array('value'=>$value[$id]['FuncionesId'],'id'=>"funcion_id_".$value[$id]['FuncionesId'],"data_foro_id"=>$value[$id]['ForoId'].$value[$id]['ForoMapIntId'],'data-foroId'=>$value[$id]['ForoId'],'data-mapintId'=>$value[$id]['ForoMapIntId'],"data_funcion_id"=>$value[$id]['FuncionesId'],'class'=>"ck"));
                      echo "</td>";
                      echo "<td class='$estilo'>";
                         
                           echo "<label for='funcion_id_".$value[$id]['FuncionesId']."'>".$value[$id]['funcionesTexto']."</label>";
                      echo "</td>";
                  echo "</tr>";
                  }
			echo "</table>";
         // }
	}
    
    public function actionPuertas(){
           $distribucion = $_GET['iDistribucion'];
           $puerta = $_GET['IdPuerta'];
           $evento = new Evento;
           echo "<table id='tabla_cargarPuertas'>";
                $value = $evento->getCatPuertas($distribucion,$puerta);
                //  print_r($value);
                //   print_r($evento->getDistribucionForo($eventoId,$funcion));
                echo "<tr>";
                     echo "<td>";
                          echo CHtml::label($value[0]['CatPuertaNom'].": ","#",array('id'=>"resumen_asignacion","id_puerta"=>$value[0]['IdCatPuerta']));
                      echo "</td>";
                  echo "</tr>";
            //echo $eventoId."-".$funcion."\n";
           echo "</table>";
    }

	public function actionAsignaciones(){
     $funciones = $_GET['funciones'];
     $estilo = "";
    // print_r($funciones);
     $eventoId = $_GET['EventoId'];
     $evento = new Evento;
     $value = $evento->getDistribucionForo($eventoId,$funciones);
     
     echo "<table id='tabla_distribucionP'>";
     $distribucionlevel1 =  Distribucionpuertalevel1::model()->find(" EventoId= $eventoId AND FuncionesId IN($funciones)");
     foreach($value as $key => $distribucion):
          if(!empty($distribucionlevel1))
                $estilo = $distribucionlevel1->IdDistribucionPuerta ==$distribucion['IdDistribucionPuerta']?'distribucion_asignada':'';
       //   print_r($evento->getDistribucionForo($eventoId,$funcion));
                 echo "<tr>";
                      echo "<td class='$estilo' width='300'>";
                           echo CHtml::link ($distribucion['DistribucionPuertaNom'],"#",array('id'=>"dist_puerta","data_id"=>$distribucion['IdDistribucionPuerta'],"data_evento_id"=>$distribucion['EventoId'],"data_funcion_id"=>$funciones));
                      echo "</td>";
                  echo "</tr>";
            //echo $eventoId."-".$funcion."\n";
           // break;
     endforeach;
     echo "</table>";
    }
    public function actionAsignarDistribucion(){
           $distribucionId = $_GET['IdDistribucion'];
           $eventoId = $_GET['EventoId'];
         //  $funcionId = $_GET['Idfuncion'];
           $funciones = explode(',',$_GET['Idfuncion']);
           Distribucionpuertalevel1::model()->deleteAll("IdDistribucionPuerta NOT IN($distribucionId) AND EventoId=$eventoId AND FuncionesId IN(".$_GET['Idfuncion'].")");
           $distribucion = Distribucionpuerta::model()->findAll("IdDistribucionPuerta NOT IN(SELECT IdDistribucionPuerta FROM distribucionpuertalevel1)");
           if(!empty($distribucion)){
               foreach($distribucion as $dist):
                    Distribucionpuerta::model()->deleteAll("IdDistribucionPuerta=$dist->IdDistribucionPuerta");
                    Catpuerta::model()->deleteAll("IdDistribucionPuerta=$dist->IdDistribucionPuerta");
               endforeach; 
           }
           $evento = new Evento;
           //print_r($distribucionId."-".$eventoId."-".$funciones);
           foreach($funciones as $key => $funcion):
             if($funcion!=0){
              $valuep = $evento->getCargarPuertas($distribucionId);
              foreach($valuep as $key => $puerta):
                  $valuez = $evento->getZonas($puerta['IdCatPuerta'],$distribucionId,$eventoId);
                  foreach($valuez as $key => $zonas):
                         $values = $evento->getSubZonas($eventoId,$zonas['ZonasId'],$distribucionId,$puerta['IdCatPuerta']);
                         foreach($values as $key => $subzonas):
                         $valueval = $evento->getValidacion($distribucionId,$eventoId,$funcion,$zonas['ZonasId'],$subzonas['SubzonaId']);
                         if ($valueval[0]['Total']==0)
                         {
                             Yii::app()->db->createCommand("INSERT INTO distribucionpuertalevel1 (IdCatPuerta,IdDistribucionPuerta,EventoId,FuncionesId,ZonasId,SubzonaId) VALUES ('".$puerta['IdCatPuerta']."','".$distribucionId."','".$eventoId."','".$funcion."','".$zonas['ZonasId']."','".$subzonas['SubzonaId']."')")->execute();
                         }
                         endforeach;
                  endforeach;
              endforeach;
             }
           endforeach;
           //fata enviar mensaje de Guardado
    }
    public function actionAsignar(){
        $distribucionId          = $_GET['id_distribucion'];
        $nombre_distribucion     = $_GET['nombre_distribucion'];
        $eventoId                = $_GET['EventoId'];
        $distribucion            = Distribucionpuerta::model()->find("DistribucionPuertaNom='$nombre_distribucion'");
        $distribucionpuertalvel1 = Distribucionpuertalevel1::model()->find("IdDistribucionPuerta=$distribucionId AND EventoId=$eventoId");
        $catpuerta               = Catpuerta::model()->findAll("IdDistribucionPuerta=$distribucionId AND IdCatPuerta NOT IN(SELECT IdCatPuerta FROM distribucionpuertalevel1)"); 
        if(!empty($catpuerta)){
            $p = "";
            foreach($catpuerta as $puerta):
                $p .= " ".$puerta->CatPuertaNom.",";
            endforeach;
            $p = substr($p,0,-1);
            $data = array('ok'=>-2,'puertas'=>$p);
        }elseif(empty($distribucionpuertalvel1)){
            $data =  array('ok'=>-1);
        }elseif(empty($distribucion)){
           Distribucionpuertalevel1::model()->deleteAll("IdDistribucionPuerta NOT IN($distribucionId) AND EventoId=$eventoId AND FuncionesId IN(".$_GET['funciones'].")");
           $distribucion = Distribucionpuerta::model()->findAll("IdDistribucionPuerta NOT IN(SELECT IdDistribucionPuerta FROM distribucionpuertalevel1)");
           if(!empty($distribucion)){
               foreach($distribucion as $dist):
                    Distribucionpuerta::model()->deleteAll("IdDistribucionPuerta=$dist->IdDistribucionPuerta");
                    Catpuerta::model()->deleteAll("IdDistribucionPuerta=$dist->IdDistribucionPuerta");
               endforeach; 
           }
            $distribucionpuerta = Distribucionpuerta::model()->findByPk($distribucionId);
            $distribucionpuerta->DistribucionPuertaNom = $nombre_distribucion;
            $distribucionpuerta->update();
            
            $data =  array('ok'=>1);
        }else{
            $data =  array('ok'=>0);
        }
        echo json_encode($data);
    }
    public function actionPruebaAjax(){
          print_r($_POST);
          $eventoId = $_POST['id'];
          $funcionesId = $_POST['funcion'];
          $model = new Funciones;
          $model->EventoId = $eventoId;
          $model->FuncionesId = $funcionesId+1;
          echo $model->save();

    }
    
    public function actionResumen2(){
           $distribucion = $_GET['iDistribucion'];
           $puertaid = $_GET['IdPuerta'];
           $eventoId = $_GET['EventoId'];
           $evento = new Evento;
           //print_r($evento->getPuertas($distribucionId));
           echo "<table id='tabla_Resumen'class='table table-bordered table-striped' border='1'>";

           $valuecp = $evento->getCatPuertas($distribucion,$puertaid);
           foreach($valuecp as $key => $puerta):

                 echo "<tr>";
                      echo "<td>";
                           echo ($puerta['CatPuertaNom']);
                      echo "</td>";
                      echo "<td>";
                           echo "<table border='1'>";
                                 $valuez = $evento->getZonas($puerta['IdCatPuerta'],$distribucion,$eventoId);
                                // print_r($valuez);
                                    //      echo  $eventoId."-".$funcionId."-".$puerta['ZonasId'] ;
                                        foreach($valuez as $key => $zonas):
                                             echo "<tr>";
                                             echo "<td>";
                                             echo $zonas['ZonasAli'];
                                             echo "</td>";
                                             echo "<td>";
                                             echo "<table border='1'>";
                                                 $values = $evento->getSubZonas($eventoId,$zonas['ZonasId'],$distribucion,$puerta['IdCatPuerta']);
                                               //  echo  $eventoId."-".$funcionId."-".$zonas['ZonasId']."-".$puerta['SubzonaId'] ;

                                                 foreach($values as $key => $subzonas):
                                                  echo "<tr>";
                                             echo "<td>";
                                                  echo "Subzona ".$subzonas['SubzonaId'];
                                                  echo "</td>";
                                                  endforeach;
                                                  echo "</table>";
                                             echo "</td>";
                                             echo "</tr>";
                                        endforeach;

                            echo "</table>";
                      echo "</td>";
                  echo "</tr>";
            //echo $eventoId."-".$funcion."\n";
     endforeach;
     echo "</table>";
    }
    
    public function actionResumen(){
           $distribucionId = $_GET['IdDistribucion'];
           $eventoId = $_GET['EventoId'];
           $funcionId = $_GET['Idfuncion'];
           $evento = new Evento;
           //print_r($evento->getPuertas($distribucionId));
           echo "<table id='tabla_Resumen' class='table table-bordered ' >";

           $valuecp = $evento->getCargarPuertas($distribucionId);
           foreach($valuecp as $key => $puerta):

                 echo "<tr >";
                      echo "<td style='max-width:300px;min-width:100px;'>";
                           echo ucfirst($puerta['CatPuertaNom']);
                      echo "</td>";
                      echo "<td>";
                           echo "<table class='table table-bordered table-striped'";
                                 $valuez = $evento->getZonas($puerta['IdCatPuerta'],$distribucionId,$eventoId);
                                    //      echo  $eventoId."-".$funcionId."-".$puerta['ZonasId'] ;
                                        foreach($valuez as $key => $zonas):
                                             echo "<tr style=''>";
                                             echo "<td style='max-width:300px;min-width:100px;'>";
                                             echo $zonas['ZonasAli'];
                                             echo "</td>";
                                             echo "<td>";
                                             echo "<table class='table table-bordered table-striped'>";
                                                 $values = $evento->getSubZonas($eventoId,$zonas['ZonasId'],$distribucionId,$puerta['IdCatPuerta']);
                                               //  echo  $eventoId."-".$funcionId."-".$zonas['ZonasId']."-".$puerta['SubzonaId'] ;

                                                 foreach($values as $key => $subzonas):
                                                        echo "<tr>";
                                                            echo "<td style='max-width:300px;min-width:100px;'>";
                                                            echo "Subzona ".$subzonas['SubzonaId'];
                                                            echo "</td>";
                                                        echo "</tr>";    
                                                      endforeach;
                                                      echo "</table>";
                                                      
                                            echo "</td>";
                                            echo "</tr>";
                                        endforeach;

                            echo "</table>";
                      echo "</td>";
                  echo "</tr>";
            //echo $eventoId."-".$funcion."\n";
     endforeach;
     echo "</table>";
    }

		public function actionQuitar()
		{
				// Quitar funcion elimina la ultima funcion de la cola
				// echo Funciones::quitarUltima($eid);
        if (isset($_POST['eid'],$_POST['fid'])) {
          # SI se le envian el id del evento y de la funcion
          extract($_POST);
          $funcion=Funciones::model()->findByPk(array('EventoId'=>$eid,'FuncionesId'=>$fid));
          if (is_object($funcion)) {
            $funcion->delete();
          }
        }
        else
          "Parametros invalidos";

		}

	public function actionInsertar($eid)
	{
			//Genera un formulario para una funcion
			$retorno=Funciones::insertar($eid);
			if ($retorno ) {
					// Si regresa un objeto
					$this->renderPartial('formulario',array('model'=>$retorno));	
			}	
			else
					echo CJSON::encode($retorno);
	}

  public function actionConfigPuntoventa($eid,$fid,$pvid)
  {
    # 
    if (isset($_POST['Confipvfuncion'])) {
        $model=Confipvfuncion::model()->findByPk(array('EventoId'=>$eid,'FuncionesId'=>$fid,'PuntosventaId'=>$pvid));

    }
    $funcion=Funciones::model()->with('evento')->findByPk(array('EventoId'=>$eid,'FuncionesId'=>$fid));
    $evento=$function->evento;

    $this->renderPartial('_confiPvFuncion');
  }

  public function actionUpdate($EventoId, $FuncionesId)
  {
      $model=Funciones::model()->findByPk(array('EventoId'=>$EventoId,'FuncionesId'=>$FuncionesId));
      if (isset($_POST['Funciones']))
      {
        if (!is_null($model))
        {
          $model->attributes=$_POST['Funciones'];
          if ($model->update())
          {
            $cols=$_POST['Funciones'];
            if (array_key_exists('FuncionesFecHor', $cols) or array_key_exists('FuncionesFecIni', $cols) ) 
            {
              $model->actualizarConfipvfunciones();
              echo CJSON::encode(array('respuesta'=>true));
            }           
            else 
              echo CJSON::encode(array('respuesta'=>var_export($cols)));
          }
          else
            echo CJSON::encode(array('respuesta'=>false));
        }
      }
  }

  public function actionActualizarPv($EventoId,$FuncionesId,$PuntosventaId,$atributo,$valor)
  {
    $cpf=Confipvfuncion::model()->with(array('puntoventa'=>array('with'=>'hijos')))->findByPk(compact('EventoId','FuncionesId','PuntosventaId'));
    if (!is_null($cpf)) {
      #"Si existe "
      $evento=Evento::model()->findByPk($EventoId);
      $cpf[$atributo]=$valor;
      $cpf->update($atributo);
      if ($cpf->puntoventa->hijos) {
        $criteria=new CDbCriteria;
        $criteria->addCondition("EventoId=:evento");
        $criteria->addCondition("FuncionesId=:funcion");
        $criteria->addCondition("confipvfuncion.PuntosventaId<>".$evento->PuntosventaId);
        $criteria->join=" inner join puntosventa as t2  on confipvfuncion.PuntosventaId=t2.PuntosventaId 
        and t2.PuntosventaSuperId=:actual";
        $criteria->params=array('actual'=>$PuntosventaId,'evento'=>$EventoId,'funcion'=>$FuncionesId);
      // $criteria->addInCondition("PuntosventaId",$padres);
        $actualizados=Confipvfuncion::model()->updateAll(array($atributo=>$valor), $criteria);
        $hijosPadres=$cpf->puntoventa->getChildrens(' and tipoid=0');
        foreach ($hijosPadres as $hijoPadre) {
          if ($hijoPadre->PuntosventaSuperId==$PuntosventaId) {
            $this->actionActualizarPv($EventoId,$FuncionesId,$hijoPadre->PuntosventaId,$atributo,$valor);
          }
        }
        #En esta seccion se cambia el PuntosventaId al de la taquilla del evento para a esta asignarle 4 horas mas

        // if (strcasecmp($atributo, "FuncionesFecHor")) {
        //   #SI el campo que se esta intentando cambiar es el fechor entonces se debera anadir 4 horas adicionales a la taquilla del evento
        //   $PuntosventaId=$evento->PuntosventaId;
        //   $taquilla=Confipvfuncion::model()->findByPk(compact('EventoId','FuncionesId','PuntosventaId'));
        //   $taquilla->ConfiPVFuncionFecFin=date("Y-m-d H:i:s", strtotime ('+4 hour' , strtotime ($taquilla->ConfiPVFuncionFecFin)));
        //   $taquilla->update();
        // }
      }

      }
    else {
      echo"No existe un Confipvfuncion";
      return 0;
    }

  }

  public function actionGenerarArbolCPVF(){
		  $model=Funciones::model()->with('evento')->findByPk($_POST['Funciones']);
		  $model->agregarConfpvfuncion();
		  $this->renderPartial('_arbolCPVF',compact('model'));
  }

  public function actionVerHoja($EventoId,$FuncionesId,$PuntosventaId){
		  #Genera el una rama del arbol apartir de un cofipvfuncion que cumpla 
		  $cpvf=Confipvfuncion::model()->with(array('puntoventa'))->findByPk(
				  compact('EventoId','FuncionesId','PuntosventaId'));
		  $Pv=$cpvf->puntoventa;
		  if (is_object($cpvf)) 
				  $this->renderPartial('_nodoCPVF',array('model'=>$cpvf));
  }
  
  public function actionVerRama($EventoId,$FuncionesId,$PuntosventaId){
		  #Genera el una rama del arbol apartir de un cofipvfuncion que cumpla 
		  $evento=Evento::model()->findByPk($EventoId);
		  $cpvf=Confipvfuncion::model()->with(
				  array(
						  'puntoventa'=>array(
								  'with'=>array(
										  'hijos'=>array(
												  'condition'=>"hijos.PuntosventaSta='ALTA' and hijos.PuntosventaId<>".$evento->PuntosventaId
										  )))
								  ))->findByPk(compact('EventoId','FuncionesId','PuntosventaId'));
		  $Pv=$cpvf->puntoventa;
		  echo CHtml::openTag('ul',array('id'=>"rama-".$FuncionesId.'-'.$PuntosventaId, 'class'=>"rama "));
		  foreach ($Pv->hijos as $hijo) {
				  $model=Confipvfuncion::model()->with(
						  'puntoventa')->findByPk(
								  array('EventoId'=>$EventoId,'FuncionesId'=>$FuncionesId,
								  'PuntosventaId'=>$hijo->PuntosventaId));
				  if (is_object($model)) 
						  $this->renderPartial('_nodoCPVF',array('model'=>$model));

		  }
		  echo CHtml::closeTag('ul');


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
