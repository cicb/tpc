<?php

/**
 * This is the model class for table "formatosimpresionlevel1".
 *
 * The followings are the available columns in table 'formatosimpresionlevel1':
 * @property string $FormatoId
 * @property string $FormatoLevel1Id
 * @property string $FormatoObj
 * @property integer $FormatoX
 * @property integer $FormatoY
 * @property string $FormatoVisible
 */
class Formatosimpresionlevel1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Formatosimpresionlevel1 the static model class
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
		return 'formatosimpresionlevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('FormatoId, FormatoLevel1Id, FormatoObj, FormatoX, FormatoY, FormatoVisible', 'required'),
			array('FormatoX, FormatoY', 'numerical', 'integerOnly'=>true),
			array('FormatoId, FormatoLevel1Id', 'length', 'max'=>20),
			array('FormatoObj', 'length', 'max'=>50),
			array('FormatoVisible', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('FormatoId, FormatoLevel1Id, FormatoObj, FormatoX, FormatoY, FormatoVisible', 'safe', 'on'=>'search'),
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
			'FormatoLevel1Id' => 'Formato Level1',
			'FormatoObj' => 'Formato Obj',
			'FormatoX' => 'Formato X',
			'FormatoY' => 'Formato Y',
			'FormatoVisible' => 'Formato Visible',
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
		$criteria->compare('FormatoLevel1Id',$this->FormatoLevel1Id,true);
		$criteria->compare('FormatoObj',$this->FormatoObj,true);
		$criteria->compare('FormatoX',$this->FormatoX);
		$criteria->compare('FormatoY',$this->FormatoY);
		$criteria->compare('FormatoVisible',$this->FormatoVisible,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}