<?php

/**
 * This is the model class for table "zonaslevel1".
 *
 * The followings are the available columns in table 'zonaslevel1':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $PuntosventaId
 * @property string $ZonasFacCarSer
 * @property string $ZonasBanVen
 */
class Zonaslevel1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zonaslevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, ZonasId, PuntosventaId, ZonasFacCarSer, ZonasBanVen', 'required'),
			array('EventoId, FuncionesId, ZonasId, PuntosventaId, ZonasBanVen', 'length', 'max'=>20),
			array('ZonasFacCarSer', 'length', 'max'=>13),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, PuntosventaId, ZonasFacCarSer, ZonasBanVen', 'safe', 'on'=>'search'),
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
			'puntoventa'=>array(self::BELONGS_TO,'Puntosventa','PuntosventaId'),
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
			'PuntosventaId' => 'Puntosventa',
			'ZonasFacCarSer' => 'Cargo por servicio',
			'ZonasBanVen' => 'Zonas Ban Ven',
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
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('ZonasFacCarSer',$this->ZonasFacCarSer,true);
		$criteria->compare('ZonasBanVen',$this->ZonasBanVen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Zonaslevel1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
