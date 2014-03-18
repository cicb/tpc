<?php

class Descuentoslevel1Controller extends Controller
{
	public function actionIndex()
	{
	   if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
		$this->render('index');
	}
    public function actionAdmin($query,$tipo='cupon'){
        if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
        
        $CuponesCod = $tipo==='cupon'?"CuponesCod != '' ":"CuponesCod = ''";
        //$model = Descuentoslevel1::model()->with(array('descuentos','evento'))->findAll("CuponesCod != ''",array('limit'=>25,'order'=>'CuponesCod DESC'));  
		//$model->unsetAttributes();  // clear any default values
        if(!empty($_GET) AND $query == "inactivos" ){
            $model = Descuentoslevel1::model()->with(array('descuentos','evento'))->findAll(array('condition'=>"$CuponesCod AND (DescuentosFecIni LIKE '%0000-00-00 00:00:00%')",'order'=>'CuponesCod DESC','group'=>'descuentos.DescuentosId'));
        }else if(!empty($_GET)){
            $cupon = $query;
            $model = Descuentoslevel1::model()->with(array('descuentos','evento'))->findAll(array('condition'=>"$CuponesCod AND (CuponesCod LIKE '%$cupon%')",'order'=>'CuponesCod DESC','group'=>'descuentos.DescuentosId'));
		}   
        else{   
            //$model = Descuentoslevel1::model()->with(array('descuentos','evento'))->findAll(array('condition'=>"CuponesCod != ''",'group'=>'t.DescuentosId'));
		}
        $this->render('admin',array(
			'model'=>$model,
		));
    }
    public function actionDelete(){
        if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
        $model = new Descuentos;
        $model2 = new Descuentoslevel1;    
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $descuentos = $model->findAll("DescuentosId=$id");
            $descuentoslevel1 = $model2->findAll("DescuentosId=$id");
            //echo $descuentos[0]->DescuentosId;
            //echo $descuentoslevel1[0]->DescuentosId;
            if($descuentos[0]->DescuentosUso <= 0){
                //echo "eliminar";
                Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$id")->execute();
                Yii::app()->db->createCommand("DELETE FROM descuentos WHERE DescuentosId=$id")->execute();
                //$descuentoslevel1->delete();
                //$descuentos->delete();
                Yii::app()->user->setFlash('error', "Registro eliminado existosamente!!!");
            }else{
                $result = Yii::app()->db->createCommand("UPDATE descuentos SET DescuentosFecIni='0000-00-00 00:00:00',DescuentosFecFin='0000-00-00 00:00:00' WHERE DescuentosId=$id")->execute();
                Yii::app()->user->setFlash('error', "Registro eliminado existosamente!!!");           
            }
            $this->redirect(array('descuentoslevel1/admin','query'=>"",'tipo'=>'cupon'));
        }    
    }
    public function actionDeleteAjax(){
        if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
        if (Yii::app()->request->isAjaxRequest){
            $model = new Descuentos;
            $model2 = new Descuentoslevel1;    
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
                $descuentos = $model->findAll("DescuentosId=$id");
                $descuentoslevel1 = $model2->findAll("DescuentosId=$id");
                echo $descuentos[0]->DescuentosId;
                echo $descuentoslevel1[0]->DescuentosId;
                if($descuentos[0]->DescuentosUso <= 0){
                    Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$id")->execute();
                    Yii::app()->db->createCommand("DELETE FROM descuentos WHERE DescuentosId=$id")->execute();
                    
                }else{
                    $result = Yii::app()->db->createCommand("UPDATE descuentos SET DescuentosFecIni='0000-00-00 00:00:00',DescuentosFecFin='0000-00-00 00:00:00' WHERE DescuentosId=$id")->execute();            
                }
            }   
        } 
    }
    public function actionGetDeleteSeleccion(){
        if (Yii::app()->request->isAjaxRequest){
            $model = new Descuentos;
            $model2 = new Descuentoslevel1; 
            $datas = explode(",",$_GET['data']);
            //print_r($datas);
            foreach($datas as $key => $id):
                $descuentos = $model->findAll("DescuentosId=$id");
                $descuentoslevel1 = $model2->findAll("DescuentosId=$id");
                echo $descuentos[0]->DescuentosId;
                echo $descuentoslevel1[0]->DescuentosId;
                if($descuentos[0]->DescuentosUso <= 0){
                    Yii::app()->db->createCommand("DELETE FROM descuentoslevel1 WHERE DescuentosId=$id")->execute();
                    Yii::app()->db->createCommand("DELETE FROM descuentos WHERE DescuentosId=$id")->execute();
                }else{
                    $result = Yii::app()->db->createCommand("UPDATE descuentos SET DescuentosFecIni='0000-00-00 00:00:00',DescuentosFecFin='0000-00-00 00:00:00' WHERE DescuentosId=$id")->execute();
                    Yii::app()->user->setFlash('error', "Registro elimnado existosamente!!!");           
                }
            endforeach;
        }
    }
    public function actionGetDescuentos(){
        if (Yii::app()->request->isAjaxRequest){
            if(!empty($_GET)){
                $id = $_GET['id'];
                $descuentos = Descuentoslevel1::model()->with('descuentos')->findAll("descuentos.DescuentosId=$id");
                $evento     = new Evento;
                echo "<ul>";
                foreach($descuentos as $key => $descuento):
                    $eventoNom = $evento->findAllByPk($descuento->EventoId);
                    echo "<li class='alert-success'>".($descuento->descuentos->CuponesCod==""?"<strong class='span-5'>Descuento </strong><br/>":"<strong class='span-5'>Cup&oacute;n: </strong>".$descuento->descuentos->CuponesCod)."</li>";
                    echo "<li><strong class='span-5'>Descuentos Id: </strong>&nbsp;".$descuento->DescuentosId."</li>";
                    if($descuento->descuentos->DescuentosValRef=='todos'){
                        echo "<li><strong class='span-5'>Aplica a todos los puntos de venta</strong>&nbsp;</li>";
                    }else{
                        $punto_venta = Puntosventa::model()->find("PuntosventaId=".$descuento->descuentos->DescuentosValRef);
                        echo "<li><strong class='span-5'>Aplica al Punto de Venta:</strong> (".$descuento->descuentos->DescuentosValRef.")$punto_venta->PuntosventaNom</li>";
                    }
                    echo "<li><strong class='span-5'>Evento: </strong>&nbsp;".$eventoNom[0]->EventoNom."</li>";
                    echo "<li><strong class='span-5'>Descripci&oacute;n: </strong>&nbsp;".$descuento->descuentos->DescuentosDes."</li>";
                    echo "<li><strong class='span-5'>Forma de Descuento: </strong>&nbsp;".$descuento->descuentos->DescuentosPat."</li>";
                    echo "<li><strong class='span-5'>Monto a Descontar: </strong>&nbsp;".($descuento->descuentos->DescuentosPat=="EFECTIVO"?"$ ":"").$descuento->descuentos->DescuentosCan.($descuento->descuentos->DescuentosPat=="PORCENTAJE"?" %":"")."</li>";
                    echo "<li><strong class='span-5'>Aplica a los primeros: </strong>&nbsp;".$descuento->descuentos->DescuentosExis."</li>";
                    echo "<li><strong class='span-5'>Descuentos Usados: </strong>&nbsp;".$descuento->descuentos->DescuentosUso."</li>";
                    echo "<li><strong class='span-5'>Fecha de Inicio: </strong>&nbsp;".$descuento->descuentos->DescuentosFecIni."</li>";
                    echo "<li><strong class='span-5'>Fecha Final: </strong>&nbsp;".$descuento->descuentos->DescuentosFecFin."</li>";
                    echo "<li><strong class='span-5'>Funci&oacute;n: </strong>&nbsp;".($descuento->FuncionesId!=0?$descuento->funciones->funcionesTexto:"Todas")."</li>";
                    echo "<li><strong class='span-5'>Zona: </strong>&nbsp;".($descuento->ZonasId!=0?$descuento->zonas->ZonasAli:"Todas")."</li>";
                    echo "<li><strong class='span-5'>Subzona: </strong>&nbsp;".($descuento->SubzonaId!=0?$descuento->SubzonaId:"Todas")."</li>";
                    echo "<li><strong class='span-5'>Fila: </strong>&nbsp;".($descuento->FilasId!=0?$descuento->filas->FilasAli:"Todas")."</li>";
                    echo "<li><strong class='span-5'>Lugar: </strong>&nbsp;".($descuento->LugaresId!=0?$descuento->LugaresId:"Todas")."</li>";
                endforeach;
                echo "</ul>";
                if(!empty($_GET['cupon'])){
                    $cupon = $_GET['cupon'];
                    $relacionados = Eventosrelacionados::model()->findAll("CuponesCod='$cupon'");
                    if(!empty($relacionados)){
                        echo "<h4>Eventos Relacionados</h4>";
                        echo "<ol>";
                        
                        foreach($relacionados as $key => $relacionado):
                            echo "<li>".$relacionado->evento->EventoNom."</li>";
                        endforeach;
                        echo "</ol>";    
                    }
                    
                }
            }
        }
    }
    public function loadModel($id)
	{
		$model=Descuentoslevel1::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	// Uncomment the following methods and override them if needed
	/*
    public function actionAdmin(){
        if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->request->baseUrl);
            
        $model=new Descuentoslevel1('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Descuentoslevel1']))
			$model->attributes=$_GET['Descuentoslevel1'];

		$this->render('admin',array(
			'model'=>$model,
		));
    }
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
