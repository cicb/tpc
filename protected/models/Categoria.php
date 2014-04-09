<?php

/**
 * This is the model class for table "categoria".
 *
 * The followings are the available columns in table 'categoria':
 * @property string $CategoriaId
 * @property string $CategoriaNom
 * @property string $CategoriaSta
 */
class Categoria extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Categoria the static model class
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
		return 'categoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CategoriaId, CategoriaNom, CategoriaSta', 'required'),
			array('CategoriaId', 'length', 'max'=>20),
			array('CategoriaNom', 'length', 'max'=>50),
			array('CategoriaSta', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CategoriaId, CategoriaNom, CategoriaSta', 'safe', 'on'=>'search'),
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
			'CategoriaId' => 'Categoria',
			'CategoriaNom' => 'Categoria Nom',
			'CategoriaSta' => 'Categoria Sta',
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

		$criteria->compare('CategoriaId',$this->CategoriaId,true);
		$criteria->compare('CategoriaNom',$this->CategoriaNom,true);
		$criteria->compare('CategoriaSta',$this->CategoriaSta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}