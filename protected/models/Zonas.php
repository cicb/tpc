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
	private $maxId;
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
			array('EventoId, FuncionesId, ZonasId, ZonasAli, ZonasTipo, ZonasNum, ZonasCantSubZon, ZonasCanLug, ZonasBanExp, ZonasCosBol', 'required'),
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
        'zonaslevel1'=>array(self::HAS_MANY,'Zonaslevel1', array('EventoId','FuncionesId','ZonasId')),
        'nzonas'=>	array(self::STAT,'Zonas','Zonas(EventoId,FuncionesId)'),
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
			$this->ZonasId=self::getMaxId()+1;
			$this->ZonasNum=$this->nzonas+1;

		}	
		return parent::beforeSave();
	 
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
	 public function init()
	 {
	 	# Valor iniciales por default del modelo
	 	$this->ZonasAli="Nombre de la zona";
	 	$this->ZonasTipo='1';
	 	$this->ZonasCosBol=0;
	 	$this->ZonasCantSubZon=0;
	 	$this->ZonasCanLug=0;	
	 }

}
