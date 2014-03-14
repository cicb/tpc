<?php

/**
 * This is the model class for table "lugares".
 *
 * The followings are the available columns in table 'lugares':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $LugaresId
 * @property string $LugaresLug
 * @property integer $LugaresNum
 * @property string $LugaresStatus
 * @property string $LugaresNumBol
 */
 
 
 

 
 
 
class Lugares extends CActiveRecord
{
	
	public $evento;
 	public $funciones;
	public $zonas;
	public $filas;
 	public $lugares;
	public $EventoNom;
	public $funcionesTexto; 
	public $Zona;
	public $Fila;
	public $Asiento;
	public $Barras;
	public $Estatus;
	public $FechaVenta;
	public $VentasId;
	public $VentasNumRef;
	public $TipoVenta;
	public $TipoBoleto;
	public $Descuento;
	public $PuntosventaId;
	public $PuntoVenta;
	public $UsuariosId;
	public $QuienVende;
	public $NombreTarjeta;
	public $NumeroTarjeta;
	public $QuienCancelo;
	public $FechaCancelacion;
	public $VecesImpreso;
    public $DescuentosDes;
    public $quienvende;
    public $FilasAli;
    public $ClientesNom;
    public $TempLugaresFecHor;
 
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lugares the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lugares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('LugaresNum', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, LugaresLug, LugaresStatus', 'length', 'max'=>20),
			array('LugaresNumBol', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, LugaresLug, LugaresNum, LugaresStatus, LugaresNumBol', 'safe', 'on'=>'search'),
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
            'evento' => array(self::BELONGS_TO, 'Evento', 'EventoId'),
            'funciones' => array(self::BELONGS_TO, 'Funciones', array('EventoId','FuncionesId')),
            'zonas' => array(self::BELONGS_TO, 'Zonas', array('EventoId','FuncionesId','ZonasId')),
            'subzonas' => array(self::BELONGS_TO, 'Subzonas', array('EventoId','FuncionesId','ZonasId','SubzonaId')),
            'filas' => array(self::BELONGS_TO, 'Filas', array('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId')),
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
			'LugaresId' => 'Lugares',
			'LugaresLug' => 'Lugares Lug',
			'LugaresNum' => 'Lugares Num',
			'LugaresStatus' => 'Lugares Status',
			'LugaresNumBol' => 'Lugares Num Bol',
			'evento' => 'Evento',
 	 		'funciones' => 'Funcion',
			'zonas' => 'Zona',
			'filas' => 'Fila',
			'lugares' => 'Asiento',
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
		$criteria->compare('LugaresId',$this->LugaresId,true);
		$criteria->compare('LugaresLug',$this->LugaresLug,true);
		$criteria->compare('LugaresNum',$this->LugaresNum);
		$criteria->compare('LugaresStatus',$this->LugaresStatus,true);
		$criteria->compare('LugaresNumBol',$this->LugaresNumBol,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function getAsiento()
	{
		return sprintf("%s, %s",$this->fila->FilasAli,$this->LugaresLug);
	}
}
