<?php

/**
 * This is the model class for table "usrsubtip".
 *
 * The followings are the available columns in table 'usrsubtip':
 * @property integer $UsrTipId
 * @property integer $UsrSubTipId
 * @property string $usrsubtipMul
 * @property string $UsrSubTipDes
 */
class Usrsubtip extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usrsubtip the static model class
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
		return 'usrsubtip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UsrTipId, UsrSubTipId, usrsubtipMul, UsrSubTipDes', 'required'),
			array('UsrTipId, UsrSubTipId', 'numerical', 'integerOnly'=>true),
			array('usrsubtipMul', 'length', 'max'=>2),
			array('UsrSubTipDes', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('UsrTipId, UsrSubTipId, usrsubtipMul, UsrSubTipDes', 'safe', 'on'=>'search'),
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
        'usrval'=>array(self::BELONGS_TO, 'Usrval', array('UsrTipId','UsrSubTipId')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'UsrTipId' => 'Usr Tip',
			'UsrSubTipId' => 'Usr Sub Tip',
			'usrsubtipMul' => 'Usrsubtip Mul',
			'UsrSubTipDes' => 'Usr Sub Tip Des',
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

		$criteria->compare('UsrTipId',$this->UsrTipId);
		$criteria->compare('UsrSubTipId',$this->UsrSubTipId);
		$criteria->compare('usrsubtipMul',$this->usrsubtipMul,true);
		$criteria->compare('UsrSubTipDes',$this->UsrSubTipDes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}