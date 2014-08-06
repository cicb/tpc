<?php

/**
 * This is the model class for table "refreimp".
 *
 * The followings are the available columns in table 'refreimp':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonasId
 * @property string $FilasId
 * @property string $LugaresId
 * @property string $RefReimpNumRes
 * @property string $VentasId
 * @property string $RefReimpFecHor
 * @property string $RefReimpPunVenId
 * @property integer $RefReimpSta
 */
class Refreimp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'refreimp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, ZonasId, SubzonasId, FilasId, LugaresId, RefReimpNumRes, VentasId, RefReimpFecHor, RefReimpPunVenId, RefReimpSta', 'required'),
			array('RefReimpSta', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, ZonasId, SubzonasId, FilasId, LugaresId, RefReimpNumRes, VentasId, RefReimpPunVenId', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, SubzonasId, FilasId, LugaresId, RefReimpNumRes, VentasId, RefReimpFecHor, RefReimpPunVenId, RefReimpSta', 'safe', 'on'=>'search'),
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
			'venta'=> array(self::BELONGS_TO, 'Ventas', 'VentasId'),
			'ventaslevel1' 	=> array(self::HAS_MANY, 	'Ventaslevel1', 'VentasId'),
			'ventalevel1'=>array(self::BELONGS_TO, 'Ventaslevel1',
				array('VentasId'=>'VentasId',
					'EventoId'=>'EventoId',
					'FuncionesId'=>'FuncionesId',
					'ZonasId'=>'ZonasId',
					'SubzonasId'=>'SubzonaId',
					'FilasId'=>'FilasId',
					'LugaresId'=>'LugaresId'),
			),
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
			'SubzonasId' => 'Subzonas',
			'FilasId' => 'Filas',
			'LugaresId' => 'Lugares',
			'RefReimpNumRes' => 'Ref Reimp Num Res',
			'VentasId' => 'Ventas',
			'RefReimpFecHor' => 'Ref Reimp Fec Hor',
			'RefReimpPunVenId' => 'Ref Reimp Pun Ven',
			'RefReimpSta' => 'Ref Reimp Sta',
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
		$criteria->compare('SubzonasId',$this->SubzonasId,true);
		$criteria->compare('FilasId',$this->FilasId,true);
		$criteria->compare('LugaresId',$this->LugaresId,true);
		$criteria->compare('RefReimpNumRes',$this->RefReimpNumRes,true);
		$criteria->compare('VentasId',$this->VentasId,true);
		$criteria->compare('RefReimpFecHor',$this->RefReimpFecHor,true);
		$criteria->compare('RefReimpPunVenId',$this->RefReimpPunVenId,true);
		$criteria->compare('RefReimpSta',$this->RefReimpSta);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Refreimp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
