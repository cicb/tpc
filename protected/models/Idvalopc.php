<?php

/**
 * This is the model class for table "idvalopc".
 *
 * The followings are the available columns in table 'idvalopc':
 * @property integer $UsuarioId
 * @property integer $UsrValPrivId
 * @property integer $UsrTipId
 * @property integer $UsrSubTipId
 * @property integer $UsrValMulId
 */
class Idvalopc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'idvalopc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UsuarioId, UsrValPrivId, UsrTipId, UsrSubTipId, UsrValMulId', 'required'),
			array('UsuarioId, UsrValPrivId, UsrTipId, UsrSubTipId, UsrValMulId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('UsuarioId, UsrValPrivId, UsrTipId, UsrSubTipId, UsrValMulId', 'safe', 'on'=>'search'),
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
			'UsuarioId' => 'Usuario',
			'UsrValPrivId' => 'Usr Val Priv',
			'UsrTipId' => 'Usr Tip',
			'UsrSubTipId' => 'Usr Sub Tip',
			'UsrValMulId' => 'Usr Val Mul',
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

		$criteria->compare('UsuarioId',$this->UsuarioId);
		$criteria->compare('UsrValPrivId',$this->UsrValPrivId);
		$criteria->compare('UsrTipId',$this->UsrTipId);
		$criteria->compare('UsrSubTipId',$this->UsrSubTipId);
		$criteria->compare('UsrValMulId',$this->UsrValMulId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Idvalopc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
