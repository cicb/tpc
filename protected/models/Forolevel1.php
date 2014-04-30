<?php

/**
 * This is the model class for table "forolevel1".
 *
 * The followings are the available columns in table 'forolevel1':
 * @property string $ForoId
 * @property string $ForoMapIntId
 * @property string $ForoMapIntNom
 * @property string $foroMapConfig
 * @property string $ForoMapIntIma
 * @property string $ForoMapZonInt
 * @property integer $ForoMapZonIntWei
 * @property integer $ForoMapZonIntHei
 * @property string $ForoMapPat
 */
class Forolevel1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $EventoNom;
	public function tableName()
	{
		return 'forolevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('foroMapConfig', 'required'),
			array('ForoMapZonIntWei, ForoMapZonIntHei', 'numerical', 'integerOnly'=>true),
			array('ForoId, ForoMapIntId', 'length', 'max'=>20),
			array('ForoMapIntNom', 'length', 'max'=>75),
			array('foroMapConfig, ForoMapIntIma, ForoMapZonInt', 'length', 'max'=>200),
			array('ForoMapPat', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ForoId, ForoMapIntId, ForoMapIntNom, foroMapConfig, ForoMapIntIma, ForoMapZonInt, ForoMapZonIntWei, ForoMapZonIntHei, ForoMapPat', 'safe', 'on'=>'search'),
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
			'foro'=>array(self::BELONGS_TO,'Foro','ForoId'),
			// 'funciones'=>array(self::HAS_MANY,'Funciones',array('ForoId','ForoMapIntId')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ForoId' => 'Foro',
			'ForoMapIntId' => 'Foro Map Int',
			'ForoMapIntNom' => 'Nombre de la distribución',
			'foroMapConfig' => 'Foro Map Config',
			'ForoMapIntIma' => 'No se usa',
			'ForoMapZonInt' => 'No se usa',
			'ForoMapZonIntWei' => 'No se usa',
			'ForoMapZonIntHei' => 'No se usa',
			'ForoMapPat' => 'Imagen del foro',
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

		if (strlen($this->EventoNom)>2) {
			$criteria->join="INNER JOIN funciones as t1 ON t1.ForoId=t.ForoId 
							and t1.ForoMapIntId=t.ForoId ";
			$criteria->join.="INNER JOIN evento as t2 ON t2.EventoId=t1.EventoId";
			$criteria->compare('t2.EventoNom',$this->EventoNom);
			// $criteria->addCondition("t2.EventoNom like ':EventoNom' ")
		}
		else{
			
		// $criteria->compare('ForoId',$this->ForoId,true);
			$criteria->addCondition('LENGTH(ForoMapPat)>3');
			$criteria->compare('ForoMapIntId',$this->ForoMapIntId,true);
			$criteria->compare('ForoMapIntNom',$this->ForoMapIntNom,true);
			$criteria->compare('foroMapConfig',$this->foroMapConfig,true);
			$criteria->compare('ForoMapIntIma',$this->ForoMapIntIma,true);
			$criteria->compare('ForoMapZonInt',$this->ForoMapZonInt,true);
			$criteria->compare('ForoMapZonIntWei',$this->ForoMapZonIntWei);
			$criteria->compare('ForoMapZonIntHei',$this->ForoMapZonIntHei);
			$criteria->compare('ForoMapPat',$this->ForoMapPat,true);
			$criteria->order="ForoId desc, ForoMapIntId desc";
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Forolevel1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
