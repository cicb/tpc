<?php

/**
 * This is the model class for table "filas".
 *
 * The followings are the available columns in table 'filas':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $FilasAli
 * @property integer $FilasNum
 * @property integer $FilasCanLug
 * @property integer $FilasIniCol
 * @property integer $FilasIniFin
 * @property integer $FilasBanExp
 * @property integer $LugaresIni
 * @property integer $LugaresFin
 */
class Filas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Filas the static model class
	 */
	public $maxId;	
	public $maxAsientos;	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'filas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, ZonasId, SubzonaId', 'required'),
			array('FilasNum, FilasCanLug, FilasIniCol, FilasIniFin, FilasBanExp, LugaresIni, LugaresFin', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId', 'length', 'max'=>20),
			array('FilasAli', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, FilasAli, FilasNum, FilasCanLug, FilasIniCol, FilasIniFin, FilasBanExp, LugaresIni, LugaresFin', 'safe', 'on'=>'search'),
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
				'lugares' => array(self::HAS_MANY, 'Lugares', array('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId')),
				'nlugares' => array(self::STAT, 'Lugares', 'EventoId,FuncionesId,ZonasId,SubzonaId,FilasId', ),
				//'' => array(self::HAS_MANY, 'Lugares', array('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId'),
				//'condition'=>"LugaresStatus='OFF'"),
				'ancho'   => array(self::STAT, 'Filas','EventoId, FuncionesId,ZonasId,SubzonaId','select'=>'MAX(ABS(LugaresIni-LugaresFin))+1',),
				'minTrue'   => array(self::STAT, 'Lugares','EventoId, FuncionesId,ZonasId,SubzonaId, FilasId','select'=>'MIN(LugaresId)', 
						'condition'=>"LugaresStatus='TRUE'"
				),
				'maxTrue'   => array(self::STAT, 'Lugares','EventoId, FuncionesId,ZonasId,SubzonaId, FilasId','select'=>'MAX(LugaresId)', 
						'condition'=>"LugaresStatus='TRUE'"
				),
				'minLugar'   => array(self::STAT, 'Lugares','EventoId, FuncionesId,ZonasId,SubzonaId, FilasId','select'=>'MIN(LugaresId)' ),
				'maxLugar'   => array(self::STAT, 'Lugares','EventoId, FuncionesId,ZonasId,SubzonaId, FilasId','select'=>'MAX(LugaresId)' ),
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
			'SubzonaId' => 'Subzona',
			'FilasId' => 'Filas',
			'FilasAli' => 'Filas Ali',
			'FilasNum' => 'Filas Num',
			'FilasCanLug' => 'Filas Can Lug',
			'FilasIniCol' => 'Filas Ini Col',
			'FilasIniFin' => 'Filas Ini Fin',
			'FilasBanExp' => 'Filas Ban Exp',
			'LugaresIni' => 'Lugares Ini',
			'LugaresFin' => 'Lugares Fin',
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
		$criteria->compare('SubzonaId',$this->SubzonaId,true);
		$criteria->compare('FilasId',$this->FilasId,true);
		$criteria->compare('FilasAli',$this->FilasAli,true);
		$criteria->compare('FilasNum',$this->FilasNum);
		$criteria->compare('FilasCanLug',$this->FilasCanLug);
		$criteria->compare('FilasIniCol',$this->FilasIniCol);
		$criteria->compare('FilasIniFin',$this->FilasIniFin);
		$criteria->compare('FilasBanExp',$this->FilasBanExp);
		$criteria->compare('LugaresIni',$this->LugaresIni);
		$criteria->compare('LugaresFin',$this->LugaresFin);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public static function maxId($EventoId, $FuncionesId, $ZonasId,$SubzonaId)
	 {
			 $row = self::model()->find(array(
					 'select'=>'max(FilasId) as maxId',
					 'condition'=>"EventoId=:evento and FuncionesId=:funcion and ZonasId=:zona and SubzonaId=:subzona",
					 'params'=>array('evento'=>$EventoId,'funcion'=>$FuncionesId,'zona'=>$ZonasId,'subzona'=>$SubzonaId)
			 ));
			 return $row['maxId'];
	 }
	public function maxAsientos()
	 {
			$EventoId= $FuncionesId= $ZonasId=$SubzonaId=0;
			 extract($this->getAttributes(),EXTR_IF_EXISTS);
			 $row = self::model()->find(array(
					 'select'=>'MAX(ABS(LugaresIni-LugaresFin))+1 as maxAsientos',
					 'condition'=>"EventoId=:evento and FuncionesId=:funcion and ZonasId=:zona and SubzonaId=:subzona",
					 'params'=>array('evento'=>$EventoId,'funcion'=>$FuncionesId,'zona'=>$ZonasId,'subzona'=>$SubzonaId)
			 ));
			 return $row['maxAsientos'];
	 }

	public function init()
	{
			$this->LugaresIni=1;
			$this->LugaresFin=1;
		return parent::init();
	}
	public function beforeDelete()
	{
			//Antes de eliminar la fila verifica que no tenga ventas y elimina tambien sus lugares
			$identificador=array('EventoId'=>$this->EventoId,
					'FuncionesId'=>$this->FuncionesId,
					'ZonasId'=>$this->ZonasId,
					'SubzonaId'=>$this->SubzonaId,
				   	'FilasId'=>$this->FilasId);
			$ventas=Ventaslevel1::model()->countByAttributes(array( 'EventoId'=>$this->EventoId));
			if($ventas==0){
					//Si no hay ventas se procede a eliminar sus asientos
					Lugares::model()->deleteAllByAttributes($identificador);
					return parent::beforeDelete();
			}
			else{
					//Si existen ventas no se puede eliminar
					return false;
			}
	}
	public function beforeSave()
	{
			if ($this->scenario=='insert') {
				$this->FilasId=self::maxId($this->EventoId,$this->FuncionesId,$this->ZonasId,$this->SubzonaId)+1;
				$this->FilasNum=$this->FilasId;
			}	
		return parent::beforeSave();
	}

	public function generarLugares($ignorar=false)
	{
			 //#Si el registro de la fila tiene todo lo necesario para generarlo
			if ($this->LugaresIni>0 && $this->LugaresFin>0 ) {
							// Si los indices limitantes estan establecidos...
					$anchoMax=$this->maxAsientos();
					$k=1;
					$asientos=array();
					$validos=range($this->LugaresIni, $this->LugaresFin) ;
					for ($i = 1; $i <= $anchoMax; $i++) {
							// lugares netos a crear
							if ($i<=sizeof($validos)) {
									// Para el subdominio de los asientos en TRUE
									$status='TRUE';
									$num=$validos[$i-1];
							}	
							else{
									//Para los asientos en OFF
									$num=0;
									$status='OFF';
							}
							$asientos[]=sprintf("( %d, %d, %d, %d, %d, %d, %d, %d, '%s' )",
									$this->EventoId,$this->FuncionesId, 
									$this->ZonasId,$this->SubzonaId,$this->FilasId,
									$i,$num,$num,$status);
					}
				$sql=sprintf("INSERT %s INTO lugares 
							( EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId,
								   	LugaresLug, LugaresNum, LugaresStatus) 
									VALUES %s;" ,$ignorar?'IGNORE':'', implode(',',$asientos)
							) ;
					$conexion=Yii::app()->db;
					$conexion->createCommand($sql)->execute();
					$this->FilasCanLug=abs($this->LugaresIni-$this->LugaresFin)+1;
					$this->save();
					return true;

			}	
	}

	public function actualizarLugaresId($delta,$condicion="true")
	{
			// Suma el delta al id
			if ($delta!=0) {
					// solo cuando el delta sea distinto de cero 
					$ide=array(
							'EventoId'=>$this->EventoId,
							'FuncionesId'=>$this->FuncionesId,
							'ZonasId'=>$this->ZonasId,
							'SubzonaId'=>$this->SubzonaId,
							'FilasId'=>$this->FilasId
					);
					$ordenamiento="ORDER BY LugaresId ";
					if ($delta>0) {
						// para recorridos a la izquierda empezar con el primero
							$ordenamiento.="DESC";
					}	
					$nlugares=$this->nlugares;
					//Elimina los OFF
					Lugares::model()->deleteAllByAttributes($ide,"LugaresStatus='OFF'");
					//Actualiza los ID
					$sql="UPDATE lugares set LugaresId=LugaresId+$delta WHERE 
							EventoId=%d AND 
							FuncionesId=%d AND 
							ZonasId=%d AND 
							SubzonaId=%d AND 
							FilasId=%d AND
							%s %s";

					$params=array_values($this->getPrimaryKey());
					$params[]=$condicion;
					$params[]=$ordenamiento;
					$sql=vsprintf($sql,$params);
					$conexion=Yii::app()->db;
					$transaccion=$conexion->beginTransaction(); 
					try{
							$affected=$conexion->createCommand($sql)->execute();
							$this->restaurarLugaresOff();
							$transaccion->commit();
							return $affected;
					}
					catch( Exception $e ){
							$transaccion->rollback();
							return false;
					}
			}	
			else {
					return 0;
			}
	}

	public function restaurarLugaresOff()
	{
			// Completa los huecos vacios con lugares en OFF
			$conexion=Yii::app()->db;
			$asientos=array();
			$totalLugares=$this->maxAsientos();
			for ($i = 1; $i <= $totalLugares; $i++) {
							$asientos[]=sprintf("( %d, %d, %d, %d, %d, %d, 0, 0, 'OFF' )",
									$this->EventoId,$this->FuncionesId, 
									$this->ZonasId,$this->SubzonaId,$this->FilasId,
									$i);
			}
			$sql=sprintf("INSERT IGNORE INTO lugares ( EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId,
								   	LugaresLug, LugaresNum, LugaresStatus) VALUES  %s ",implode(',',$asientos));
			$conexion->createCommand($sql)->execute();
	}

	public function alinear($direccion)
	{
			// Alinea los lugares todos a la izquierda
			$ide=array(
					'EventoId'=>$this->EventoId,
					'FuncionesId'=>$this->FuncionesId,
					'ZonasId'=>$this->ZonasId,
					'SubzonaId'=>$this->SubzonaId,
					'FilasId'=>$this->FilasId
			);
			//Numero de lugares en la fila
			$nlugares=$this->nlugares;
			//Numero de lugares en OFF
			$noff=Lugares::model()->countByAttributes($ide,"LugaresStatus='OFF'");	
			if ($nlugares>0 and $noff>1) {
					// Solamente si existen lugares en la fila...
					switch ($direccion) {
					case 'derecha':
							//A lado derecha todo
							$ultimoLugar=Lugares::model()->findAllByAttributes($ide,array( 
									'order'=>'LugaresId desc', 'limit'=>1,));	
							$ultimoLugar=$ultimoLugar[0];
							if ($ultimoLugar->LugaresStatus!="TRUE") {
									// Si el lugar mas a la derecha es true no hay nada mas que mover, sino
									$maxTrue=	Lugares::model()->findAllByAttributes($ide,array(
											'condition'=>"LugaresStatus='TRUE'",
											'order'=>'LugaresId desc',
											'limit'=>1
									));	
									if (sizeof($maxTrue)>0) {
											// SI existe un asiento true en la fila

											$delta=$nlugares-$maxTrue[0]->LugaresId;
											$this->actualizarLugaresId($delta);
									}	
							}
							break;
					case 'izquierda':
							//A la izquierda todo
							$primerLugar=Lugares::model()->findAllByAttributes($ide,array( 
									'order'=>'LugaresId', 'limit'=>1,));	
							$primerLugar=$primerLugar[0];
							if ($primerLugar->LugaresStatus!="TRUE") {
									// Si el lugar mas a la izquierda es true no hay nada mas que mover, sino
									$minTrue=	Lugares::model()->findAllByAttributes($ide,array(
											'condition'=>"LugaresStatus='TRUE'",
											'order'=>'LugaresId',
											'limit'=>1
									));	
									if (sizeof($minTrue>0)) {
										// Si exite un asiento en true 
											$delta=$minTrue[0]->LugaresId-1;
											$this->actualizarLugaresId(-$delta);
									}	
							}

							break;			
					case 'centro':
							//A la derecha todo
							if($noff>1){
									if(			isset($this->minTrue)
											and isset($this->minLugar)
											and isset($this->maxTrue)
											and isset($this->maxLugar)){
													// SI existen lugares ...
													$minTrue=$this->minTrue;
													$maxTrue=$this->maxTrue;
													$minLugar=$this->minLugar;
													$maxLugar=$this->maxLugar;
													$noff=abs($minTrue-$minLugar)+abs($maxLugar-$maxTrue)+1;
													$noff=ceil($noff/2);
													$delta=$noff-$minTrue;
													$this->actualizarLugaresId($delta);
											}
							}
							break;

					default:
							// code...
							break;
					}
			}	

			else{
					$this->restaurarLugaresOff();
			}
	}

	public function recorrer($delta=1 )
	{
			// Recorre los id de asientos en  delta posiciones en direccion $direccion
			if (	$delta!=0 
					and $this->maxTrue+$delta<=$this->maxLugar
					and $this->minTrue+$delta>0
			) {
					// Si al sumar el delta al maximo asiento en true no supera al ultimo lugar
					// o si la suma de minimo y el delta en siempre mayor a 0
				return	$this->actualizarLugaresId($delta);
			}	
			else return false;

	}
}
