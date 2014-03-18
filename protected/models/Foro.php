<?php

/**
 * This is the model class for table "foro".
 *
 * The followings are the available columns in table 'foro':
 * @property string $ForoId
 * @property string $ForoNom
 * @property string $ForoMapCiu
 * @property string $ForoMapExt
 * @property string $ForoSta
 */
class Foro extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'foro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ForoId, ForoNom, ForoMapCiu, ForoMapExt, ForoSta', 'required'),
			array('ForoId', 'length', 'max'=>20),
			array('ForoNom', 'length', 'max'=>75),
			array('ForoSta', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ForoId, ForoNom, ForoMapCiu, ForoMapExt, ForoSta', 'safe', 'on'=>'search'),
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
			'ForoId' => 'Foro',
			'ForoNom' => 'Nombre del foro',
			'ForoMapCiu' => 'No se usa',
			'ForoMapExt' => 'No se usa',
			'ForoSta' => 'Estatus',
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

		$criteria->compare('ForoId',$this->ForoId,true);
		$criteria->compare('ForoNom',$this->ForoNom,true);
		$criteria->compare('ForoMapCiu',$this->ForoMapCiu,true);
		$criteria->compare('ForoMapExt',$this->ForoMapExt,true);
		$criteria->compare('ForoSta',$this->ForoSta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Foro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
