<?php

/**
 * This is the model class for table "distribucionpuertalevel1".
 *
 * The followings are the available columns in table 'distribucionpuertalevel1':
 * @property integer $IdDistribucionPuertalevel1
 * @property integer $IdCatPuerta
 * @property integer $IdDistribucionPuerta
 * @property integer $EventoId
 * @property integer $FuncionesId
 * @property integer $ZonasId
 * @property integer $SubzonaId
 */
class Distribucionpuertalevel1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Distribucionpuertalevel1 the static model class
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
		return 'distribucionpuertalevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IdCatPuerta, IdDistribucionPuerta, ZonasId, SubzonaId', 'required'),
			array('IdCatPuerta, IdDistribucionPuerta, EventoId, FuncionesId, ZonasId, SubzonaId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IdDistribucionPuertalevel1, IdCatPuerta, IdDistribucionPuerta, EventoId, FuncionesId, ZonasId, SubzonaId', 'safe', 'on'=>'search'),
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
			'IdDistribucionPuertalevel1' => 'Iddistribucionpuertalevel1',
			'IdCatPuerta' => 'Id Cat Puerta',
			'IdDistribucionPuerta' => 'Id Distribucion Puerta',
			'EventoId' => 'Evento',
			'FuncionesId' => 'Funciones',
			'ZonasId' => 'Zonas',
			'SubzonaId' => 'Subzona',
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

		$criteria->compare('IdDistribucionPuertalevel1',$this->IdDistribucionPuertalevel1);
		$criteria->compare('IdCatPuerta',$this->IdCatPuerta);
		$criteria->compare('IdDistribucionPuerta',$this->IdDistribucionPuerta);
		$criteria->compare('EventoId',$this->EventoId);
		$criteria->compare('FuncionesId',$this->FuncionesId);
		$criteria->compare('ZonasId',$this->ZonasId);
		$criteria->compare('SubzonaId',$this->SubzonaId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}