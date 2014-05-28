<?php

/**
 * This is the model class for table "zonas".
 *
 * The followings are the available columns in table 'zonas':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $ZonasAli
 * @property string $ZonasTipo
 * @property integer $ZonasNum
 * @property integer $ZonasCantSubZon
 * @property integer $ZonasCanLug
 * @property integer $ZonasBanExp
 * @property string $ZonasCosBol
 */
class Zonas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Zonas the static model class
	 */
	public $maxId;
	public $countZonas;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zonas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId', 'required'),
			//array('EventoId, FuncionesId, ZonasId, ZonasAli, ZonasTipo, ZonasNum, ZonasCantSubZon, ZonasCanLug, ZonasBanExp, ZonasCosBol', 'required'),
			array('ZonasNum, ZonasCantSubZon, ZonasCanLug, ZonasBanExp', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, ZonasId, ZonasTipo', 'length', 'max'=>20),
			array('ZonasAli', 'length', 'max'=>75),
			array('ZonasCosBol', 'length', 'max'=>13),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, ZonasAli, ZonasTipo, ZonasNum, ZonasCantSubZon, ZonasCanLug, ZonasBanExp, ZonasCosBol', 'safe', 'on'=>'search'),
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
        'subzonas'	=> array(self::HAS_MANY, 'Subzona', array('EventoId','FuncionesId','ZonasId')),
        'filas'	=> array(self::HAS_MANY, 'Filas', array( 'EventoId','FuncionesId','ZonasId')),
        'capacidad'	=> array(self::STAT, 'Lugares', 'EventoId, FuncionesId, ZonasId',
        	'condition'=>"LugaresStatus<>'OFF'"),
        'funcion'	=> array(self::BELONGS_TO, 'Funciones', array('EventoId','FuncionesId')),
		'evento'	=> array(self::BELONGS_TO, 'Evento','EventoId'),
        'zonaslevel1'=>array(self::HAS_MANY,'Zonaslevel1', array('EventoId','FuncionesId','ZonasId')),
        'nzonas'=>	array(self::STAT,'Zonas','zonas(EventoId,FuncionesId)'),
        'max'=>	array(self::STAT,'Zonas','zonas(EventoId,FuncionesId,ZonasId)','select'=> 'MAX(ZonasId)'),
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
			'ZonasId' => 'Zonas',
			'ZonasAli' => 'Zonas Ali',
			'ZonasTipo' => 'Zonas Tipo',
			'ZonasNum' => 'Zonas Num',
			'ZonasCantSubZon' => 'Zonas Cant Sub Zon',
			'ZonasCanLug' => 'Zonas Can Lug',
			'ZonasBanExp' => 'Zonas Ban Exp',
			'ZonasCosBol' => 'Zonas Cos Bol',
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
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('ZonasAli',$this->ZonasAli,true);
		$criteria->compare('ZonasTipo',$this->ZonasTipo,true);
		$criteria->compare('ZonasNum',$this->ZonasNum);
		$criteria->compare('ZonasCantSubZon',$this->ZonasCantSubZon);
		$criteria->compare('ZonasCanLug',$this->ZonasCanLug);
		$criteria->compare('ZonasBanExp',$this->ZonasBanExp);
		$criteria->compare('ZonasCosBol',$this->ZonasCosBol,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	protected function beforeSave()
	{
		if ($this->scenario=='insert') {
				$this->ZonasId= self::maxId($this->EventoId,$this->FuncionesId)+1;
				$this->ZonasNum=self::countZonas($this->EventoId,$this->FuncionesId)+1;
				$this->generarArbolCargos();
		}	
		return parent::beforeSave();
	 
	}
	public function beforeDelete()
	{
			$identificador=array('EventoId'=>$this->EventoId,'FuncionesId'=>$this->FuncionesId,'ZonasId'=>$this->ZonasId);
			$ventas=Ventaslevel1::model()->countByAttributes(array( 'EventoId'=>$this->EventoId));
			if($ventas==0){
					//Si no hay ventas
					Subzona::model()->deleteAllByAttributes($identificador);
					Filas::model()->deleteAllByAttributes($identificador);
					Lugares::model()->deleteAllByAttributes($identificador);
					Zonaslevel1::model()->deleteAllByAttributes($identificador);
					Zonastipo::model()->deleteAllByAttributes($identificador);
					Zonastipolevel1::model()->deleteAllByAttributes($identificador);
					 //$mapagrande=ConfigurlFuncionesMapaGrande::model()->findByAttributes(array(
							 //'EventoId'=>$this->EventoId,'FuncionId'=>$this->FuncionesId));	
					 //if (is_object($mapagrande)) {
						 //// Si tiene un mapa grande se eliminan primero sus coordenadas para que no de restriccion de llaves foraneas
							 //ConfigurlMapaGrandeCoordenadas::model()->deleteAllByAttributes(array(
									 //'configurl_funcion_mapa_grande_id'=>$mapagrande->id));
							 //$mapagrande->delete();	
					 //}	
					return parent::beforeDelete();
			}
			else {
					// Si hay ventas, no elimina
					//error_log(sprintf("v:$ventas EID:%d\n",$this->EventoId),3,'/tmp/errores.php');
					return false;
			}

	}

	protected function afterDelete(){
									
			$this->reenumerar($this->EventoId,$this->FuncionesId);
			return parent::afterDelete();
	}	

		public static function reenumerar($EventoId, $FuncionesId)
		{
				// Vuelve a generar las ZonasNum
				$zonas=Zonas::model()->findAllByAttributes(compact('EventoId','FuncionesId'));
				$i=1;
				foreach ($zonas as $zona) {
						if (is_object($zona)) {
								$zona->ZonasNum=$i;
								$zona->save();
								$i++;
						}	
				}

		}

	public static function maxId($EventoId, $FuncionesId)
	 {
			 $row = self::model()->find(array(
					 'select'=>'MAX(ZonasId) as maxId',
					 'condition'=>"EventoId=:evento and FuncionesId=:funcion",
					 'params'=>array('evento'=>$EventoId,'funcion'=>$FuncionesId)
			 ));
			 return $row['maxId'];
	 }

	public static function countZonas($EventoId, $FuncionesId)
	 {
			 $row = self::model()->find(array(
					 'select'=>'COUNT(ZonasId) as countZonas',
					 'condition'=>"EventoId=:evento and FuncionesId=:funcion",
					 'params'=>array('evento'=>$EventoId,'funcion'=>$FuncionesId)
			 ));
			 return $row['countZonas'];
	 }

	 public function init()
	 {
	 	# Valor iniciales por default del modelo
	 	$this->ZonasAli="Nombre de la zona";
	 	$this->ZonasTipo='1';
	 	$this->ZonasCosBol=0;
	 	$this->ZonasCantSubZon=0;
	 	$this->ZonasCanLug=0;	
	 }

	 public function generarArbolCargos()
	 {
			 // Por cada punto de venta genera su ventaslevel1 ...
			 //Obtiene todo el catalogo de puntos de venta
			 $conexion=Yii::app()->db;
			 $conexion->createCommand(sprintf("INSERT IGNORE INTO zonaslevel1 
					 (SELECT %s,%s,%s,PuntosventaId,0,PuntosventaSta from puntosventa);" ,
					 $this->EventoId,$this->FuncionesId,$this->ZonasId
			 ))->execute();
	 }

	 public function agregarSubzona()
	 {
	 	// Agrega un subzona con los valores por defecto
		$subzona=new Subzona('insert');
		$subzona->EventoId=$this->EventoId;
		$subzona->FuncionesId=$this->FuncionesId;
		$subzona->ZonasId=$this->ZonasId;
		//$subzona->SubzonaId=1;
		$subzona->SubzonaNum=0;
		if ( $subzona->save() ) {
				// Si se pudo guardar regresa el modelo de la subzona
				return $subzona;
		}	
		else return false;
	 }
	 public function agregarSubzonas($cantidad)
	 {
			 // Agrega un numero ($cantidad) de subzonas con sus valores por defecto
			 //$subzonas=array();
			 $ret=0;
			 for ($i = 0; $i <$cantidad; $i++) {
			 	$subzona=$this->agregarSubzona(); 
				if ($subzona) {
					// Si se pudo crear la subzona entonces la contabiliza y continúa 
						$ret++; 
				}	
				else {return 0; }
			 }
			 return $ret;
	 }

	 public function eliminarSubzonas()
	 {
			 #### !!!!!    Elimina todas las subzonas, filas y lugares de la zona	 !!!! ####
			 $identificador=array('EventoId'=>$this->EventoId,'FuncionesId'=>$this->FuncionesId,'ZonasId'=>$this->ZonasId);
			 $ventas=Ventaslevel1::model()->countByAttributes(array( 'EventoId'=>$this->EventoId));
			 if($ventas==0){
					 //Si no hay ventas elimina todas las subzonas filas y lugares
					 $ret=Subzona::model()->deleteAllByAttributes($identificador);
					 Filas::model()->deleteAllByAttributes($identificador);
					 Lugares::model()->deleteAllByAttributes($identificador);
					 return $ret; 
			 }
			 else
					 return -1;

	 }

	 public function generarLugares()
	 {
			 // Genera los lugares dependiendo de si la zona es general o numerada.
			 if ($this->ZonasTipo==1 and $this->ZonasCanLug>0) {
					 // Cuando el tipo de zona sea general y se haya definido el numero de lugares
					 $this->eliminarSubzonas();
					 $tamanoFila=($this->ZonasCanLug/100.0)>1?100:10;	
					 $numeroFilas=ceil($this->ZonasCanLug/$tamanoFila);
					 $filas=array();
					 $lugares=array();
					 for ($i = 1; $i <=$numeroFilas; $i++) {
							 $filas[]=sprintf("(%d,%d,%d,1,%d,'General',%d,%d,%d,%d)",
									 $this->EventoId,$this->FuncionesId,$this->ZonasId,$i,$i,$tamanoFila,1,$tamanoFila
							 );
							 for ($j = 1; $j <=$tamanoFila; $j++) {
									 $lugares[]=sprintf("(%d,%d,%d,1,%d,%d,%d,%d,'TRUE')",
											 $this->EventoId,$this->FuncionesId,$this->ZonasId,$i,$j,$j,$j
									 );
							 }
					 }
					 $conexion=Yii::app()->db;
					 $conexion->createCommand("INSERT IGNORE INTO filas 
							 (EventoId,FuncionesId,ZonasId,SubzonaId,FilasId, FilasAli, FilasNum,FilasCanLug,LugaresIni,LugaresFin)
							 VALUE ".implode(',',$filas))->execute();
					 ### Hasta este punto se han creado las filas y solo hace falta agregar los lugares
					 //----------------------------------------------------------------------------------
					 $conexion->createCommand("INSERT IGNORE INTO lugares 
							 (EventoId,FuncionesId,ZonasId,SubzonaId,FilasId, LugaresId, LugaresLug,LugaresNum, LugaresStatus)
							 VALUE ".implode(',',$lugares))->execute();

					 Lugares::model()->updateAll(array("LugaresStatus"=>"OFF"),
							 sprintf("EventoId=$this->EventoId and FuncionesId=$this->FuncionesId and ZonasId=$this->ZonasId and
							 SubzonaId=1 and FilasId=$numeroFilas and LugaresId>%d",$tamanoFila-(($tamanoFila*$numeroFilas)-$this->ZonasCanLug)
			 ));

					 return array('filas'=>$numeroFilas,'lugares'=>$this->ZonasCanLug);

			 }	
			 else return 0;

	 }
}
