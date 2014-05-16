<?php

/**
 * This is the model class for table "zonastipo".
 *
 * The followings are the available columns in table 'zonastipo':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $ZonasTipoId
 * @property string $ZonasTipoNom
 * @property string $ZonasTipoCos
 * @property string $ZonasTipoSta
 */
class Zonastipo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zonastipo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, ZonasId, ZonasTipoId, ZonasTipoNom, ZonasTipoCos, ZonasTipoSta', 'required'),
			array('EventoId, FuncionesId, ZonasId, ZonasTipoId, ZonasTipoSta', 'length', 'max'=>20),
			array('ZonasTipoNom', 'length', 'max'=>50),
			array('ZonasTipoCos', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, ZonasTipoId, ZonasTipoNom, ZonasTipoCos, ZonasTipoSta', 'safe', 'on'=>'search'),
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
			'EventoId' => 'Evento',
			'FuncionesId' => 'Funciones',
			'ZonasId' => 'Zonas',
			'ZonasTipoId' => 'Zonas Tipo',
			'ZonasTipoNom' => 'Nombre del tipo de boleto',
			'ZonasTipoCos' => 'Costo del tipo de boleto',
			'ZonasTipoSta' => 'estatus',
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

		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('ZonasTipoId',$this->ZonasTipoId,true);
		$criteria->compare('ZonasTipoNom',$this->ZonasTipoNom,true);
		$criteria->compare('ZonasTipoCos',$this->ZonasTipoCos,true);
		$criteria->compare('ZonasTipoSta',$this->ZonasTipoSta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Zonastipo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
