<?php

/**
 * This is the model class for table "preciostemplugares".
 *
 * The followings are the available columns in table 'preciostemplugares':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $LugaresId
 * @property string $PuntosventaId
 * @property string $TempLugaresClaVis
 * @property integer $DescuentosId
 * @property string $VentasCosBol
 * @property string $VentasCosBolDes
 * @property string $VentasCarSer
 * @property string $VentasCarSerDes
 */
class Preciostemplugares extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'preciostemplugares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, PuntosventaId, DescuentosId, VentasCarSer', 'required'),
			array('DescuentosId', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, PuntosventaId', 'length', 'max'=>20),
			array('TempLugaresClaVis', 'length', 'max'=>255),
			array('VentasCosBol, VentasCosBolDes, VentasCarSer, VentasCarSerDes', 'length', 'max'=>13),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, PuntosventaId, TempLugaresClaVis, DescuentosId, VentasCosBol, VentasCosBolDes, VentasCarSer, VentasCarSerDes', 'safe', 'on'=>'search'),
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
			'PuntosventaId' => 'Puntosventa',
			'TempLugaresClaVis' => 'Temp Lugares Cla Vis',
			'DescuentosId' => 'Descuentos',
			'VentasCosBol' => 'Ventas Cos Bol',
			'VentasCosBolDes' => 'Ventas Cos Bol Des',
			'VentasCarSer' => 'Ventas Car Ser',
			'VentasCarSerDes' => 'Ventas Car Ser Des',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('SubzonaId',$this->SubzonaId,true);
		$criteria->compare('FilasId',$this->FilasId,true);
		$criteria->compare('LugaresId',$this->LugaresId,true);
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('TempLugaresClaVis',$this->TempLugaresClaVis,true);
		$criteria->compare('DescuentosId',$this->DescuentosId);
		$criteria->compare('VentasCosBol',$this->VentasCosBol,true);
		$criteria->compare('VentasCosBolDes',$this->VentasCosBolDes,true);
		$criteria->compare('VentasCarSer',$this->VentasCarSer,true);
		$criteria->compare('VentasCarSerDes',$this->VentasCarSerDes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Preciostemplugares the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
