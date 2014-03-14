<?php

/**
 * This is the model class for table "logreimp".
 *
 * The followings are the available columns in table 'logreimp':
 * @property string $LogReimpId
 * @property string $LogReimpFecHor
 * @property string $LogReimpTip
 * @property string $LogCosAnt
 * @property string $LogReimpTipAnt
 * @property string $LogReimpUsuId
 * @property string $LogReimpPunVenId
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $LugaresId
 */
class Logreimp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Logreimp the static model class
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
		return 'logreimp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('LogReimpId, LogReimpFecHor, LogReimpTip, LogCosAnt, LogReimpTipAnt, LogReimpUsuId, LogReimpPunVenId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId', 'required'),
			array('LogReimpId, LogReimpTip, LogReimpTipAnt, LogReimpUsuId, LogReimpPunVenId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId', 'length', 'max'=>20),
			array('LogCosAnt', 'length', 'max'=>13),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('LogReimpId, LogReimpFecHor, LogReimpTip, LogCosAnt, LogReimpTipAnt, LogReimpUsuId, LogReimpPunVenId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId', 'safe', 'on'=>'search'),
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
			'LogReimpId' => 'Log Reimp',
			'LogReimpFecHor' => 'Log Reimp Fec Hor',
			'LogReimpTip' => 'Log Reimp Tip',
			'LogCosAnt' => 'Log Cos Ant',
			'LogReimpTipAnt' => 'Log Reimp Tip Ant',
			'LogReimpUsuId' => 'Log Reimp Usu',
			'LogReimpPunVenId' => 'Log Reimp Pun Ven',
			'EventoId' => 'Evento',
			'FuncionesId' => 'Funciones',
			'ZonasId' => 'Zonas',
			'SubzonaId' => 'Subzona',
			'FilasId' => 'Filas',
			'LugaresId' => 'Lugares',
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

		$criteria->compare('LogReimpId',$this->LogReimpId,true);
		$criteria->compare('LogReimpFecHor',$this->LogReimpFecHor,true);
		$criteria->compare('LogReimpTip',$this->LogReimpTip,true);
		$criteria->compare('LogCosAnt',$this->LogCosAnt,true);
		$criteria->compare('LogReimpTipAnt',$this->LogReimpTipAnt,true);
		$criteria->compare('LogReimpUsuId',$this->LogReimpUsuId,true);
		$criteria->compare('LogReimpPunVenId',$this->LogReimpPunVenId,true);
		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('SubzonaId',$this->SubzonaId,true);
		$criteria->compare('FilasId',$this->FilasId,true);
		$criteria->compare('LugaresId',$this->LugaresId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}