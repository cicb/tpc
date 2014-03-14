<?php

/**
 * This is the model class for table "usrval".
 *
 * The followings are the available columns in table 'usrval':
 * @property integer $UsuarioId
 * @property integer $UsrTipId
 * @property integer $UsrSubTipId
 * @property integer $UsrValPrivId
 * @property string $FecHorIni
 * @property string $FecHorFin
 * @property string $UsrValRef
 * @property string $usrValIdRef
 * @property string $UsrValRef2
 * @property string $usrValIdRef2
 */
class Usrval extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usrval';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UsuarioId, UsrTipId, UsrSubTipId, UsrValPrivId, FecHorIni, FecHorFin, UsrValRef, usrValIdRef, UsrValRef2, usrValIdRef2', 'required'),
			array('UsuarioId, UsrTipId, UsrSubTipId, UsrValPrivId', 'numerical', 'integerOnly'=>true),
			array('UsrValRef, usrValIdRef, UsrValRef2, usrValIdRef2', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('UsuarioId, UsrTipId, UsrSubTipId, UsrValPrivId, FecHorIni, FecHorFin, UsrValRef, usrValIdRef, UsrValRef2, usrValIdRef2', 'safe', 'on'=>'search'),
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
			'evento'=>array(self::BELONGS_TO, 'Evento', 'usrValIdRef'),
			'funcion'=>array(self::BELONGS_TO, 'Funciones', 'usrValIdRef2'),
			'usuario'=>array(self::BELONGS_TO, 'Usuarios', 'UsuarioId'),
			'tipusr'=>array(self::BELONGS_TO, 'Tipusr', 'UsrTipId'),
            'usrsubtip'=>array(self::BELONGS_TO, 'Usrsubtip', array('UsrTipId','UsrSubTipId')),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'UsuarioId' => 'Usuario',
			'UsrTipId' => 'Usr Tip',
			'UsrSubTipId' => 'Usr Sub Tip',
			'UsrValPrivId' => 'Usr Val Priv',
			'FecHorIni' => 'Fec Hor Ini',
			'FecHorFin' => 'Fec Hor Fin',
			'UsrValRef' => 'Usr Val Ref',
			'usrValIdRef' => 'Usr Val Id Ref',
			'UsrValRef2' => 'Usr Val Ref2',
			'usrValIdRef2' => 'Usr Val Id Ref2',
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

		$criteria->compare('UsuarioId',$this->UsuarioId);
		$criteria->compare('UsrTipId',$this->UsrTipId);
		$criteria->compare('UsrSubTipId',$this->UsrSubTipId);
		$criteria->compare('UsrValPrivId',$this->UsrValPrivId);
		$criteria->compare('FecHorIni',$this->FecHorIni,true);
		$criteria->compare('FecHorFin',$this->FecHorFin,true);
		$criteria->compare('UsrValRef',$this->UsrValRef,true);
		$criteria->compare('usrValIdRef',$this->usrValIdRef,true);
		$criteria->compare('UsrValRef2',$this->UsrValRef2,true);
		$criteria->compare('usrValIdRef2',$this->usrValIdRef2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usrval the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/*
	 *Getters and setters
	 */
	public function getSubTipo()
	{
			return $this->tipusr;
	}
	public function getTipo()
	{
			return $this->tipusr;
	}
	public function getUsuario()
	{
			return $this->usuario;
	}
	public function getEvento()
	{
			return $this->evento;
	}
	public function getFuncion()
	{
			return $this->funcion;
	}
	public function getCompareCriteria()
	{
			$criteria=new CDbCriteria;
			$criteria->compare('UsuarioId',$this->UsuarioId);
			$criteria->compare('UsrTipId',$this->UsrTipId);
			$criteria->compare('UsrSubTipId',$this->UsrSubTipId);
			$criteria->compare('UsrValRef',$this->UsrValRef,true);
			$criteria->compare('usrValIdRef',$this->usrValIdRef,true);
			$criteria->compare('UsrValRef2',$this->UsrValRef2,true);
			$criteria->compare('usrValIdRef2',$this->usrValIdRef2,true);
			$criteria->order="UsrValPrivId desc";
			return $criteria;
	}
	public function getExiste()
	{
			$criteria=$this->getCompareCriteria();
			return $this->exists($criteria);	
	}
	public function getMaxPrivId(){
			if ($this->UsrValPrivId>0) {
				return $this->UsrValPrivId;
			}	
			else{
				$criteria=new CDbCriteria;
				$criteria->compare('UsuarioId',$this->UsuarioId);
				$criteria->compare('UsrTipId',$this->UsrTipId);
				$criteria->compare('UsrSubTipId',$this->UsrSubTipId);
				$criteria->compare('UsrValRef',$this->UsrValRef,true);
				//$criteria->compare('usrValIdRef',$this->usrValIdRef,true);
				$criteria->compare('UsrValRef2',$this->UsrValRef2,true);
				//$criteria->compare('usrValIdRef2',$this->usrValIdRef2,true);
				$criteria->order="UsrValPrivId desc";
				//$criteria->select="MAX(UsrValPrivId) as maxpriv";
				$usrval= self::model()->find($criteria);
				if (is_object($usrval)) {
						return $usrval->UsrValPrivId;
				}	
				else
							return 0;
			}

	}


}
