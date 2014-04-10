<?php

/**
 * This is the model class for table "configurl".
 *
 * The followings are the available columns in table 'configurl':
 * @property string $ConfigurlId
 * @property string $EventoId
 * @property string $ConfigurlDes
 * @property string $ConfigurlURL
 * @property string $ConfigurlIdeVen
 * @property string $ConfigurlPos
 * @property string $ConfigurlTipSel
 * @property string $ConfigurlFecIni
 * @property string $ConfigurlFecFin
 * @property string $ConfigurlImaGra
 * @property string $ConfigurlImaPanChiAzu
 * @property string $ConfigurlImaChi
 * @property string $ConfigurlImaPanGra
 * @property string $ConfigurlImaPanChiAma
 * @property string $ConfigurlImaPanChi
 * @property string $ConfigurlVisPos
 */
class Configurl extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Configurl the static model class
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
		return 'configurl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, ConfigurlDes, ConfigurlPos, ConfigurlFecIni, ConfigurlFecFin', 'required'),
			array('EventoId, ConfigurlIdeVen, ConfigurlPos, ConfigurlTipSel, ConfigurlVisPos', 'length', 'max'=>20),
			array('ConfigurlURL', 'length', 'max'=>255),
			array('ConfigurlImaGra, ConfigurlImaPanChiAzu, ConfigurlImaChi, ConfigurlImaPanGra, ConfigurlImaPanChiAma, ConfigurlImaPanChi', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ConfigurlId, EventoId, ConfigurlDes, ConfigurlURL, ConfigurlIdeVen, ConfigurlPos, ConfigurlTipSel, ConfigurlFecIni, ConfigurlFecFin, ConfigurlImaGra, ConfigurlImaPanChiAzu, ConfigurlImaChi, ConfigurlImaPanGra, ConfigurlImaPanChiAma, ConfigurlImaPanChi, ConfigurlVisPos', 'safe', 'on'=>'search'),
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
			'ConfigurlId' => 'Configurl',
			'EventoId' => 'Evento',
			'ConfigurlDes' => 'Configurl Des',
			'ConfigurlURL' => 'Configurl Url',
			'ConfigurlIdeVen' => 'Configurl Ide Ven',
			'ConfigurlPos' => 'Configurl Pos',
			'ConfigurlTipSel' => 'Configurl Tip Sel',
			'ConfigurlFecIni' => 'Configurl Fec Ini',
			'ConfigurlFecFin' => 'Configurl Fec Fin',
			'ConfigurlImaGra' => 'Configurl Ima Gra',
			'ConfigurlImaPanChiAzu' => 'Configurl Ima Pan Chi Azu',
			'ConfigurlImaChi' => 'Configurl Ima Chi',
			'ConfigurlImaPanGra' => 'Configurl Ima Pan Gra',
			'ConfigurlImaPanChiAma' => 'Configurl Ima Pan Chi Ama',
			'ConfigurlImaPanChi' => 'Configurl Ima Pan Chi',
			'ConfigurlVisPos' => 'Configurl Vis Pos',
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

		$criteria->compare('ConfigurlId',$this->ConfigurlId,true);
		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('ConfigurlDes',$this->ConfigurlDes,true);
		$criteria->compare('ConfigurlURL',$this->ConfigurlURL,true);
		$criteria->compare('ConfigurlIdeVen',$this->ConfigurlIdeVen,true);
		$criteria->compare('ConfigurlPos',$this->ConfigurlPos,true);
		$criteria->compare('ConfigurlTipSel',$this->ConfigurlTipSel,true);
		$criteria->compare('ConfigurlFecIni',$this->ConfigurlFecIni,true);
		$criteria->compare('ConfigurlFecFin',$this->ConfigurlFecFin,true);
		$criteria->compare('ConfigurlImaGra',$this->ConfigurlImaGra,true);
		$criteria->compare('ConfigurlImaPanChiAzu',$this->ConfigurlImaPanChiAzu,true);
		$criteria->compare('ConfigurlImaChi',$this->ConfigurlImaChi,true);
		$criteria->compare('ConfigurlImaPanGra',$this->ConfigurlImaPanGra,true);
		$criteria->compare('ConfigurlImaPanChiAma',$this->ConfigurlImaPanChiAma,true);
		$criteria->compare('ConfigurlImaPanChi',$this->ConfigurlImaPanChi,true);
		$criteria->compare('ConfigurlVisPos',$this->ConfigurlVisPos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}