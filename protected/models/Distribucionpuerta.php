<?php

/**
 * This is the model class for table "distribucionpuerta".
 *
 * The followings are the available columns in table 'distribucionpuerta':
 * @property integer $IdDistribucionPuerta
 * @property integer $ForoId
 * @property integer $ForoIntMapId
 * @property integer $DistribucionPuertaSta
 * @property string $DistribucionPuertaNom
 */
class Distribucionpuerta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Distribucionpuerta the static model class
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
		return 'distribucionpuerta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ForoId, ForoIntMapId, DistribucionPuertaSta, DistribucionPuertaNom', 'required'),
			array('ForoId, ForoIntMapId, DistribucionPuertaSta', 'numerical', 'integerOnly'=>true),
			array('DistribucionPuertaNom', 'length', 'max'=>65),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IdDistribucionPuerta, ForoId, ForoIntMapId, DistribucionPuertaSta, DistribucionPuertaNom', 'safe', 'on'=>'search'),
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
			'IdDistribucionPuerta' => 'Id Distribucion Puerta',
			'ForoId' => 'Foro',
			'ForoIntMapId' => 'Foro Int Map',
			'DistribucionPuertaSta' => 'Distribucion Puerta Sta',
			'DistribucionPuertaNom' => 'Distribucion Puerta Nom',
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

		$criteria->compare('IdDistribucionPuerta',$this->IdDistribucionPuerta);
		$criteria->compare('ForoId',$this->ForoId);
		$criteria->compare('ForoIntMapId',$this->ForoIntMapId);
		$criteria->compare('DistribucionPuertaSta',$this->DistribucionPuertaSta);
		$criteria->compare('DistribucionPuertaNom',$this->DistribucionPuertaNom,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}