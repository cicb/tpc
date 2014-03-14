<?php

/**
 * This is the model class for table "categorialevel1".
 *
 * The followings are the available columns in table 'categorialevel1':
 * @property string $CategoriaId
 * @property string $CategoriaSubId
 * @property string $CategoriaSubNom
 * @property string $CategoriaSubSta
 *
 * The followings are the available model relations:
 * @property Categoria $categoria
 * @property Evento[] $eventos
 * @property Evento[] $eventos1
 */
class Categorialevel1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'categorialevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CategoriaId, CategoriaSubId, CategoriaSubNom, CategoriaSubSta', 'required'),
			array('CategoriaId, CategoriaSubId', 'length', 'max'=>20),
			array('CategoriaSubNom', 'length', 'max'=>50),
			array('CategoriaSubSta', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('CategoriaId, CategoriaSubId, CategoriaSubNom, CategoriaSubSta', 'safe', 'on'=>'search'),
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
			'categoria' => array(self::BELONGS_TO, 'Categoria', 'CategoriaId'),
			'eventos' => array(self::HAS_MANY, 'Evento', 'CategoriaId'),
			'eventos1' => array(self::HAS_MANY, 'Evento', 'CategoriaSubId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CategoriaId' => 'Categoria',
			'CategoriaSubId' => 'Categoria Sub',
			'CategoriaSubNom' => 'Categoria Sub Nom',
			'CategoriaSubSta' => 'Categoria Sub Sta',
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

		$criteria->compare('CategoriaId',$this->CategoriaId,true);
		$criteria->compare('CategoriaSubId',$this->CategoriaSubId,true);
		$criteria->compare('CategoriaSubNom',$this->CategoriaSubNom,true);
		$criteria->compare('CategoriaSubSta',$this->CategoriaSubSta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categorialevel1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
