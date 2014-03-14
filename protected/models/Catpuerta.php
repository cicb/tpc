<?php

/**
 * This is the model class for table "catpuerta".
 *
 * The followings are the available columns in table 'catpuerta':
 * @property integer $IdCatPuerta
 * @property integer $IdDistribucionPuerta
 * @property string $CatPuertaNom
 */
class Catpuerta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Catpuerta the static model class
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
		return 'catpuerta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IdDistribucionPuerta', 'required'),
			array('IdDistribucionPuerta', 'numerical', 'integerOnly'=>true),
			array('CatPuertaNom', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IdCatPuerta, IdDistribucionPuerta, CatPuertaNom', 'safe', 'on'=>'search'),
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
			'IdCatPuerta' => 'Id Cat Puerta',
			'IdDistribucionPuerta' => 'Id Distribucion Puerta',
			'CatPuertaNom' => 'Cat Puerta Nom',
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

		$criteria->compare('IdCatPuerta',$this->IdCatPuerta);
		$criteria->compare('IdDistribucionPuerta',$this->IdDistribucionPuerta);
		$criteria->compare('CatPuertaNom',$this->CatPuertaNom,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}