<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property string $UsuariosId
 * @property integer $TipUsrId
 * @property string $UsuariosNom
 * @property string $UsuariosCiu
 * @property string $UsuariosTelMov
 * @property string $UsuariosNot
 * @property string $UsuariosNick
 * @property string $UsuariosPass
 * @property string $UsuariosPasCon
 * @property string $UsuariosGruId
 * @property string $UsuariosIma
 * @property string $UsuariosInf
 * @property string $UsuariosEmail
 * @property string $UsuariosRegion
 * @property string $UsuariosStatus
 * @property string $UsuariosVigencia
 */
class Usuarios extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Usuarios the static model class
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
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UsuariosId, TipUsrId, UsuariosNom, UsuariosCiu, UsuariosTelMov, UsuariosNot, UsuariosNick, UsuariosPass, UsuariosPasCon, UsuariosGruId, UsuariosIma, UsuariosInf, UsuariosEmail, UsuariosRegion, UsuariosStatus, UsuariosVigencia', 'required'),
			array('TipUsrId', 'numerical', 'integerOnly'=>true),
			array('UsuariosId, UsuariosTelMov, UsuariosGruId, UsuariosStatus', 'length', 'max'=>20),
			array('UsuariosNom, UsuariosNick, UsuariosPass, UsuariosPasCon', 'length', 'max'=>50),
			array('UsuariosCiu', 'length', 'max'=>30),
			array('UsuariosEmail, UsuariosRegion', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('UsuariosId, TipUsrId, UsuariosNom, UsuariosCiu, UsuariosTelMov, UsuariosNot, UsuariosNick, UsuariosPass, UsuariosPasCon, UsuariosGruId, UsuariosIma, UsuariosInf, UsuariosEmail, UsuariosRegion, UsuariosStatus, UsuariosVigencia', 'safe', 'on'=>'search'),
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
			'UsuariosId' => 'Usuarios',
			'TipUsrId' => 'Tip Usr',
			'UsuariosNom' => 'Usuarios Nom',
			'UsuariosCiu' => 'Usuarios Ciu',
			'UsuariosTelMov' => 'Usuarios Tel Mov',
			'UsuariosNot' => 'Usuarios Not',
			'UsuariosNick' => 'Usuarios Nick',
			'UsuariosPass' => 'Usuarios Pass',
			'UsuariosPasCon' => 'Usuarios Pas Con',
			'UsuariosGruId' => 'Usuarios Gru',
			'UsuariosIma' => 'Usuarios Ima',
			'UsuariosInf' => 'Usuarios Inf',
			'UsuariosEmail' => 'Usuarios Email',
			'UsuariosRegion' => 'Usuarios Region',
			'UsuariosStatus' => 'Usuarios Status',
			'UsuariosVigencia' => 'Usuarios Vigencia',
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

		$criteria->compare('UsuariosId',$this->UsuariosId,true);
		$criteria->compare('TipUsrId',$this->TipUsrId);
		$criteria->compare('UsuariosNom',$this->UsuariosNom,true);
		$criteria->compare('UsuariosCiu',$this->UsuariosCiu,true);
		$criteria->compare('UsuariosTelMov',$this->UsuariosTelMov,true);
		$criteria->compare('UsuariosNot',$this->UsuariosNot,true);
		$criteria->compare('UsuariosNick',$this->UsuariosNick,true);
		$criteria->compare('UsuariosPass',$this->UsuariosPass,true);
		$criteria->compare('UsuariosPasCon',$this->UsuariosPasCon,true);
		$criteria->compare('UsuariosGruId',$this->UsuariosGruId,true);
		$criteria->compare('UsuariosIma',$this->UsuariosIma,true);
		$criteria->compare('UsuariosInf',$this->UsuariosInf,true);
		$criteria->compare('UsuariosEmail',$this->UsuariosEmail,true);
		$criteria->compare('UsuariosRegion',$this->UsuariosRegion,true);
		$criteria->compare('UsuariosStatus',$this->UsuariosStatus,true);
		$criteria->compare('UsuariosVigencia',$this->UsuariosVigencia,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}