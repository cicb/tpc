<?php

/**
 * This is the model class for table "formatosimpresion".
 *
 * The followings are the available columns in table 'formatosimpresion':
 * @property string $FormatoId
 * @property string $FormatoNom
 * @property string $FormatoDes
 * @property string $FormatoIma
 * @property string $FormatoSta
 */
class Formatosimpresion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Formatosimpresion the static model class
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
		return 'formatosimpresion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('FormatoId, FormatoNom, FormatoIma, FormatoSta', 'required'),
			array('FormatoId, FormatoSta', 'length', 'max'=>20),
			array('FormatoNom', 'length', 'max'=>100),
			array('FormatoDes, FormatoIma', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('FormatoId, FormatoNom, FormatoDes, FormatoIma, FormatoSta', 'safe', 'on'=>'search'),
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
			'FormatoId' => 'Formato',
			'FormatoNom' => 'Formato Nom',
			'FormatoDes' => 'Formato Des',
			'FormatoIma' => 'Formato Ima',
			'FormatoSta' => 'Formato Sta',
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

		$criteria->compare('FormatoId',$this->FormatoId,true);
		$criteria->compare('FormatoNom',$this->FormatoNom,true);
		$criteria->compare('FormatoDes',$this->FormatoDes,true);
		$criteria->compare('FormatoIma',$this->FormatoIma,true);
		$criteria->compare('FormatoSta',$this->FormatoSta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}