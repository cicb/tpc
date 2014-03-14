<?php

/**
 * This is the model class for table "templugares".
 *
 * The followings are the available columns in table 'templugares':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $LugaresId
 * @property integer $TempLugaresNum
 * @property string $PuntosventaId
 * @property string $TempLugaresTipUsr
 * @property string $UsuariosId
 * @property string $TempLugaresFecHor
 * @property string $TempLugaresSta
 * @property string $TempLugaresSta2
 * @property string $TempLugaresClaVis
 * @property string $DescuentosId
 * @property string $tempLugaresNumRef
 * @property string $ClientesId
 * @property string $templugaresnot
 */
class Templugares extends CActiveRecord
{
    public $Estatus;
    public $Zona;
    public $Fila;
    public $LugaresLug;
    public $Barras;
    public $DescuentosDes;
    public $quienvende;
    public $FilasAli;
    public $ClientesNom;

	
	public $buscar;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Templugares the static model class
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
		return 'templugares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, TempLugaresNum, PuntosventaId, TempLugaresTipUsr, UsuariosId, TempLugaresFecHor, TempLugaresSta, TempLugaresSta2, TempLugaresClaVis, DescuentosId, tempLugaresNumRef, ClientesId', 'required'),
			array('TempLugaresNum', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, PuntosventaId, TempLugaresTipUsr, UsuariosId, TempLugaresSta, TempLugaresSta2, DescuentosId, ClientesId', 'length', 'max'=>20),
			array('TempLugaresClaVis', 'length', 'max'=>255),
			array('tempLugaresNumRef', 'length', 'max'=>30),
			array('templugaresnot', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, TempLugaresNum, PuntosventaId, TempLugaresTipUsr, UsuariosId, TempLugaresFecHor, TempLugaresSta, TempLugaresSta2, TempLugaresClaVis, DescuentosId, tempLugaresNumRef, ClientesId, templugaresnot', 'safe', 'on'=>'search'),
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
			'TempLugaresNum' => 'Temp Lugares Num',
			'PuntosventaId' => 'Puntosventa',
			'TempLugaresTipUsr' => 'Temp Lugares Tip Usr',
			'UsuariosId' => 'Usuarios',
			'TempLugaresFecHor' => 'Temp Lugares Fec Hor',
			'TempLugaresSta' => 'Temp Lugares Sta',
			'TempLugaresSta2' => 'Temp Lugares Sta2',
			'TempLugaresClaVis' => 'Temp Lugares Cla Vis',
			'DescuentosId' => 'Descuentos',
			'tempLugaresNumRef' => 'Temp Lugares Num Ref',
			'ClientesId' => 'Clientes',
			'EventoNom' => 'Evento',
			'funcionesTexto' => 'Funcion',
			'ZonasAli' => 'Zona',
			'FilasAli' => 'Fila',
			'LugaresLug' => 'Asiento',
			'TempLugaresSta' => 'Estatus',
			'TempLugaresFecHor' => 'Fecha',
			'tempLugaresNumRef' => 'Referencia',
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
		$criteria->compare('TempLugaresNum',$this->TempLugaresNum);
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('TempLugaresTipUsr',$this->TempLugaresTipUsr,true);
		$criteria->compare('UsuariosId',$this->UsuariosId,true);
		$criteria->compare('TempLugaresFecHor',$this->TempLugaresFecHor,true);
		$criteria->compare('TempLugaresSta',$this->TempLugaresSta,true);
		$criteria->compare('TempLugaresSta2',$this->TempLugaresSta2,true);
		$criteria->compare('TempLugaresClaVis',$this->TempLugaresClaVis,true);
		$criteria->compare('DescuentosId',$this->DescuentosId,true);
		$criteria->compare('tempLugaresNumRef',$this->tempLugaresNumRef,true);
		$criteria->compare('ClientesId',$this->ClientesId,true);
		$criteria->compare('templugaresnot',$this->templugaresnot,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}