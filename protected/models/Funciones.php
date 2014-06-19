<?php

/**
 * This is the model class for table "funciones".
 *
 * The followings are the available columns in table 'funciones':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $FuncionesTip
 * @property string $FuncionesFor
 * @property string $FuncionesFecIni
 * @property string $FuncionesFecHor
 * @property string $FuncionesNomDia
 * @property string $ForoId
 * @property string $ForoMapIntId
 * @property integer $FuncionesBanExp
 * @property string $FuncPuntosventaId
 * @property string $FuncionesSta
 * @property string $funcionesTexto
 * @property string $FuncionesBanEsp
 * @property string $funcionesAccExtra
 *
 * The followings are the available model relations:
 * @property ConfigurlFuncionesMapaGrande[] $configurlFuncionesMapaGrandes
 * @property ConfigurlFuncionesMapaGrande[] $configurlFuncionesMapaGrandes1
 */
class Funciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Funciones the static model class
	 */
	 
	public $pathUrlImagesBD;
	public $maxId;
	public $EventoNom;

	public $dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");


    public function init() {

        //$this->pathUrlImagesBD = Yii::app()->baseUrl . '/imagesbd/';
        $this->pathUrlImagesBD = 'https://'.$_SERVER['SERVER_NAME'].'/imagesbd/';
        return parent::init();
    }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'funciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, FuncionesTip, FuncionesFor, FuncionesFecIni, FuncionesFecHor, FuncionesNomDia, ForoId, ForoMapIntId, FuncionesBanExp, FuncPuntosventaId, FuncionesSta, funcionesTexto', 'required','on'=>'delete'),
			array('FuncionesBanExp', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, FuncionesTip, FuncionesFor, FuncionesNomDia, ForoId, ForoMapIntId, FuncPuntosventaId, FuncionesSta, FuncionesBanEsp', 'length', 'max'=>20),
			array('funcionesTexto', 'length', 'max'=>200),
			array('funcionesAccExtra', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, FuncionesTip, FuncionesFor, FuncionesFecIni, FuncionesFecHor, FuncionesNomDia, ForoId, ForoMapIntId, FuncionesBanExp, FuncPuntosventaId, FuncionesSta, funcionesTexto, FuncionesBanEsp, funcionesAccExtra', 'safe', 'on'=>'search'),
			array('FuncionesFecHor, FuncionesFecIni' , 'length', 'min'=>4, 'on'=>'update'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'configurlFuncionesMapaGrandes' => array(self::HAS_MANY, 'ConfigurlFuncionesMapaGrande', 'EventoId'),
			'configurlFuncionesMapaGrandes1' => array(self::HAS_MANY, 'ConfigurlFuncionesMapaGrande', 'FuncionId'),
            'forolevel1' => array(self::BELONGS_TO, 'Forolevel1',array('ForoId','ForoMapIntId')),
            'zonas' => array(self::HAS_MANY, 'Zonas', array('EventoId','FuncionesId')),
            'evento' => array(self::BELONGS_TO, 'Evento', array('EventoId')),
            'asientos'=>array(self::STAT,'Lugares','EventoId, FuncionesId','condition'=>"LugaresStatus<>'OFF'"),
			'configurl'=>array(self::HAS_ONE, 'Configurl','EventoId'),
			'mapagrande' => array(self::HAS_ONE, 'ConfigurlFuncionesMapaGrande', '','foreignKey'=>array('EventoId'=>'EventoId','FuncionId'=>'FuncionesId')),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'EventoId' => 'Evento',
			'FuncionesId' => 'Funciones',
			'FuncionesTip' => 'Funciones Tip',
			'FuncionesFor' => 'Funciones For',
			'FuncionesFecIni' => 'Funciones Fec Ini',
			'FuncionesFecHor' => 'Funciones Fec Hor',
			'FuncionesNomDia' => 'Funciones Nom Dia',
			'ForoId' => 'Foro',
			'ForoMapIntId' => 'Foro Map Int',
			'FuncionesBanExp' => 'Funciones Ban Exp',
			'FuncPuntosventaId' => 'Func Puntosventa',
			'FuncionesSta' => 'Funciones Sta',
			'funcionesTexto' => 'Funciones Texto',
			'FuncionesBanEsp' => 'Funciones Ban Esp',
			'funcionesAccExtra' => 'Funciones Acc Extra',
		);
	}
	
	public function getListaFunciones()
    {
        return array(
                CHtml::listData(Funciones::model()->findAll(), 'EventoId','name'),array('empty'=>array(NULL=>'-- Seleccione --')),
        );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('FuncionesTip',$this->FuncionesTip,true);
		$criteria->compare('FuncionesFor',$this->FuncionesFor,true);
		$criteria->compare('FuncionesFecIni',$this->FuncionesFecIni,true);
		$criteria->compare('FuncionesFecHor',$this->FuncionesFecHor,true);
		$criteria->compare('FuncionesNomDia',$this->FuncionesNomDia,true);
		$criteria->compare('ForoId',$this->ForoId,true);
		$criteria->compare('ForoMapIntId',$this->ForoMapIntId,true);
		$criteria->compare('FuncionesBanExp',$this->FuncionesBanExp);
		$criteria->compare('FuncPuntosventaId',$this->FuncPuntosventaId,true);
		$criteria->compare('FuncionesSta',$this->FuncionesSta,true);
		$criteria->compare('funcionesTexto',$this->funcionesTexto,true);
		$criteria->compare('FuncionesBanEsp',$this->FuncionesBanEsp,true);
		$criteria->compare('funcionesAccExtra',$this->funcionesAccExtra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		// Guarda siempre el configpvfunciones...
		$this->FuncionesNomDia=ucwords(strftime($this->dias[date('w',strtotime ($this->FuncionesFecHor))]));
		return parent::beforeSave();
	}
	public function getZonasInteractivasMapaGrande() {
        $criteria = new CDbCriteria();
        $criteria->join = 'INNER JOIN configurl_funciones_mapa_grande t1 ON (t1.id = t.configurl_funcion_mapa_grande_id)';
        $criteria->addCondition('t1.EventoId = :EventoId');
        $criteria->addCondition('t1.FuncionId = :FuncionId');
        $criteria->params = array(
            ':EventoId'=>$this->EventoId,
            ':FuncionId'=>$this->FuncionesId
        );

        return ConfigurlMapaGrandeCoordenadas::model()->findAll($criteria);
    }
    public function getForoPequenio() {
        $criteria = new CDbCriteria();
        $criteria->join = ' INNER JOIN foro t2 ON (t2.ForoId = t.ForoId) ';
        $criteria->addCondition('t.ForoId = :ForoId');
        $criteria->addCondition('t.ForoMapIntId  = :ForoMapIntId');
        $criteria->params = array(
            ':ForoId'=>$this->ForoId,
            ':ForoMapIntId'=>$this->ForoMapIntId
        );
        
        $reg = Forolevel1::model()->find($criteria);
        return isset($reg)? $this->pathUrlImagesBD .  $reg->ForoMapPat : '';
        
    }
    public function getUrlForoPequenio() {
        $criteria = new CDbCriteria();
        $criteria->join = ' INNER JOIN foro t2 ON (t2.ForoId = t.ForoId) ';
        $criteria->addCondition('t.ForoId = :ForoId');
        $criteria->addCondition('t.ForoMapIntId  = :ForoMapIntId');
        $criteria->params = array(
            ':ForoId'=>$this->ForoId,
            ':ForoMapIntId'=>$this->ForoMapIntId
        );
        
        $reg = Forolevel1::model()->find($criteria);
        return isset($reg)?$reg->ForoMapPat : '';
        
    }
    public function getForoGrande() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.FuncionId = :FuncionId');
        $criteria->params = array(
            ':EventoId'=>$this->EventoId,
            ':FuncionId'=>$this->FuncionesId
        );

        $reg = MapaGrande::model()->find($criteria);

        return isset($reg) ? $this->pathUrlImagesBD .  $reg->nombre_imagen : '';
    }

    public function guardar($data=array())
	 {
	 	$this->EventoId = $data['eid'];
	 	$this->FuncionesFecHor = $data['FuncionesFecHor'];
	 	$this->FuncionesFecIni = date("Y-m-d H:i:s");
	 	$this->FuncionesSta = 'ALTA';
	 	$incremento = 0;
	 	$foroid_temp = Evento::model()->find(array('condition'=>"EventoId=".$data['eid']));
	 	$this->ForoId = $foroid_temp->ForoId;
	 	$this->FuncPuntosventaId = $foroid_temp->PuntosventaId;
	 	$ultimo = $this->find(array('condition'=>"EventoId=".$data['eid'],'order'=>'FuncionesId DESC'));
         if(!empty($ultimo))
         	 $incremento = $ultimo->FuncionesId + 1;
	 	$this->FuncionesId = $incremento;

	 	$dia = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
        $mes = array("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC");

        $fecha_texto_temp = strtotime( $data['FuncionesFecHor']);
        $fech = date("w", $fecha_texto_temp);
        $fechaTextoAntd = date(" d", $fecha_texto_temp);
        $fechaTextoAnty = date(" Y G:i ", $fecha_texto_temp);
        $fechaMes = date("n", $fecha_texto_temp);

		$this->funcionesTexto = strtoupper($dia[$fech].$fechaTextoAntd." - ".$mes[$fechaMes-1]." -".$fechaTextoAnty." "."HRS");
		$this->FuncionesNomDia = $dia[$fech];


		if(!$this->save())
				return CHtml::errorSummary($this);
		else
				return 1;
	 }

	 public static function maxId($evento)
	 {
			 $row = Funciones::model()->find(array(
					 'select'=>'MAX(FuncionesId) as maxId',
					 'condition'=>"EventoId=:evento",
					 'params'=>array('evento'=>$evento)
			 ));
			 return $row['maxId'];
	 }

    public function getUrlForoGrande() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.FuncionId = :FuncionId');
        $criteria->params = array(
            ':EventoId'=>$this->EventoId,
            ':FuncionId'=>$this->FuncionesId
        );

        $reg = MapaGrande::model()->find($criteria);

        return isset($reg) ? $reg->nombre_imagen : '';
    }

	 public static function insertar($eventoId)
	 {
			//Genera una funcion minima
			$ret=array('estado'=>false,'modelo'=>null);	
			$evento=Evento::model()->with('foro')->findByPk($eventoId);
			$model=new Funciones('insert');
			if (is_object($evento)) {
				// Si el id del evento es valido
					$model->EventoId=$evento->EventoId;
					$maximo=Funciones::maxId($eventoId);
					$model->FuncionesId=$maximo+1;
					$anterior=Funciones::model()->findByPk(array('EventoId'=>$model->EventoId, 'FuncionesId'=>$maximo));
					//$model->ForoMapIntId=$anterior->ForoMapIntId;
					$model->FuncionesFecIni=date('Y-m-d H:i:s');
					$model->FuncionesFecHor=date('Y-m-d H:i:s');
					$model->FuncPuntosventaId=$evento->PuntosventaId;
					$model->FuncionesNomDia=date('l');
					$model->ForoId=$evento->ForoId;
					$model->funcionesTexto=strtoupper(strftime('%A %d - %b - %Y %H:%M HRS'));
					$model->FuncionesSta='ALTA';
					if ($model->save()){
							return $model;
					}
			}	

			return false;
	 }

	 public static function quitarUltima($eventoId)
	 {
			 $lastId=self::maxId($eventoId);
			 $model=Funciones::model()->findByPk(array('EventoId'=>$eventoId,'FuncionesId'=>$lastId));
			 if (!is_null($model)) {
			 	//Si se valida el modelo 
					 return $model->delete();
			 }	
	 }

	 public function agregarConfpvfuncion($puntosventaId=0)
	 {
	 	if ($puntosventaId>0) {
	 		$model = new Confipvfuncion('insert');

	 		$model->EventoId=$this->EventoId;
	 		$model->FuncionesId=$this->FuncionesId;
	 		$model->ConfiPVFuncionFecIni=$this->FuncionesFecIni;
	 		$model->ConfiPVFuncionFecFin=$this->FuncionesFecHor;
	 		if ($this->evento->PuntosventaId==$puntosventaId)
	 		{
	 			$model->ConfiPVFuncionFecFin=date("Y-m-d H:i:s", strtotime ('+4 hour' , strtotime ($this->FuncionesFecHor)));
	 		}
	 		$model->ConfiPVFuncionDes="N/A";
	 		$model->ConfiPVFuncionTipSel="MIXTA";
	 		$model->ConfiPVFuncionSta="ALTA";
	 		$model->ConfiPVFuncionBan=0;
	 		$model->PuntosventaId=$puntosventaId;
	 		$model->save();
	 	}
	 	else{
				$conexion=Yii::app()->db;
				$conexion->createCommand(
						sprintf(" INSERT IGNORE INTO confipvfuncion  ( SELECT %d 
						, %d , PuntosventaId, 'N/A','MIXTA', '%s' ,'%s', PuntosventaSta,0 
						FROM puntosventa WHERE PuntosventaSta='ALTA' )",
						$this->EventoId,$this->FuncionesId, $this->FuncionesFecIni,$this->FuncionesFecHor )
				)->execute();
	 	}

	 }
	 public function actualizarConfipvfunciones()
	 {
	 	# Actualiza los config Pv funcion en base a la informacion de la funcion 
	 	$eventoId=$this->EventoId;
	 	$funcion=$this->FuncionesId;
	 	Confipvfuncion::model()->updateAll(
	 		array(
	 			'ConfiPVFuncionFecFin'=>$this->FuncionesFecHor,
	 			'ConfiPVFuncionFecIni'=>$this->FuncionesFecIni,
	 			),
	 		"EventoId=:eventoId and FuncionesId=:funcion ",
	 		compact('eventoId','funcion')
	 		);
	 	$Evento=Evento::model()->findByPk($eventoId);
	 	if (is_object($Evento)) {
	 		Confipvfuncion::model()->updateByPk(
	 			array(
	 				'EventoId'=>$eventoId,
	 				'FuncionesId'=>$funcion,'PuntosventaId'=>$Evento->PuntosventaId),
	 			array(
	 				'ConfiPVFuncionFecFin'=>date("Y-m-d H:i:s", strtotime ('+4 hour' , strtotime ($this->FuncionesFecHor))),
	 				));
	 	}
	 }

	 public function deleteConfpvfuncion()
	 {
	 	return Confipvfuncion::model()->deleteAllByAttributes(array('EventoId' =>$this->EventoId,'FuncionesId'=>$this->FuncionesId));
	 }

	 public function afterSave()
	 {
	 	if ($this->scenario=='insert')
	 		$this->agregarConfpvfuncion();
	 	return parent::afterSave();
	 }

	 public function afterUpdate()
	 {
	 	return parent::afterUpdate();
	 }

	 public function beforeDelete()
	 {
			 if ( $this->eliminarDistribucion()) {
			 	// Si se elimina todo lo relacionado con esta funcion.
					 return parent::beforeDelete();	 	
			 }	
			 else {
			 	return false;
			 }
	 }

	 public function eliminarDistribucion()
	 {
			 $identificador=array('EventoId'=>$this->EventoId) ;
			 $nfunciones=Funciones::model()->countByAttributes($identificador);	 
			 if ($nfunciones>1) {
			 	// Si no se esta tratando de eliminar la unica funcion.
					 $identHijos=array('EventoId'=>$this->EventoId,'FuncionesId'=>$this->FuncionesId);
					 $this->deleteConfpvfuncion();
					 Zonas::model()->deleteAllByAttributes($identHijos);
					 Subzona::model()->deleteAllByAttributes($identHijos);
					 Filas::model()->deleteAllByAttributes($identHijos);
					 Lugares::model()->deleteAllByAttributes($identHijos);
					 $mapagrande=ConfigurlFuncionesMapaGrande::model()->findByAttributes(array(
							 'EventoId'=>$this->EventoId,'FuncionId'=>$this->FuncionesId));	
					 if (is_object($mapagrande)) {
					 	// Si tiene un mapa grande se eliminan primero sus coordenadas para que no de restriccion de llaves foraneas
							 ConfigurlMapaGrandeCoordenadas::model()->deleteAllByAttributes(array(
									 'configurl_funcion_mapa_grande_id'=>$mapagrande->id));
							 $mapagrande->delete();	
					 }	
					 $this->ForoMapIntId=0;
					 $this->save();
					 return true;	 	
			 }	
			 else {
			 	return false;
			 }
	 }
	 public function getConfiPvFuncion($puntosventaId)
	{
		#Devuelve el confiPvFuncion que este asociado
		 // con este punto de venta en el evento y 
		//  la funcion que se envie como parametros
		$model=Confipvfuncion::model()->findByPk(array(
			'EventoId'=>$this->evento,
			'Funtion'=>$this->FuncionesId,
			'PuntosventaId'=>$puntosventaId
			));
		if (is_null($model)) {
			# sino existe entonces se crea;
			$model=$this->agregarConfpvfuncion($puntosventaId);
		}
		return $model;
	}

	public function verDistribucionZonas()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('EventoNom', $this->EventoNom, true);
		
	}

	public function agregarZona()
	{
		/*
		* Agrega una zona con sus datos por default
		* normalmente se ocuparía solo cuando se crea o edita una distribución
		*/
		$model=new Zonas;
		// $model->attributes=$this;
		$model->EventoId=$this->EventoId;
		$model->FuncionesId=$this->FuncionesId;
		if ($model->save()) {
			return $model;
		}
		else
			return false;

	}
		private function agregarZonas($numero=1)
	{
		/*
		* Agrega un numero de  zona con sus datos por default
		* normalmente se ocuparía solo cuando se crea o edita una distribución
		*/



	}
}
