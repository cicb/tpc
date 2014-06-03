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
				'ancho'   => array(self::STAT, 'Filas','EventoId, FuncionesId,ZonasId,SubzonaId','select'=>'MAX(ABS(LugaresIni-LugaresFin))+1',),

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
					return $sql;

			}	
	}
}
