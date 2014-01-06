<?php

/**
 * This is the model class for table "ventas".
 *
 * The followings are the available columns in table 'ventas':
 * @property string $VentasId
 * @property string $PuntosventaId
 * @property string $VentasSec
 * @property string $VentasNumTar
 * @property string $VentasFecHor
 * @property string $TempLugaresTipUsr
 * @property string $UsuariosId
 * @property string $VentasSta
 * @property string $VentasNomDerTar
 * @property string $VentasMesExpTar
 * @property string $VentasAniExpTar
 * @property string $VentasTip
 * @property string $VentasTipTar
 * @property string $VentasNumAut
 * @property string $VentasMonMetEnt
 * @property string $VentasNumRef
 * @property string $VentasBloq
 * @property string $VentasBloqDes
 */
class Ventas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ventas the static model class
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
		return 'ventas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('VentasId, PuntosventaId, VentasSec, VentasNumTar, VentasFecHor, TempLugaresTipUsr, UsuariosId, VentasSta, VentasNomDerTar, VentasMesExpTar, VentasAniExpTar, VentasTip, VentasTipTar, VentasNumAut, VentasMonMetEnt, VentasNumRef, VentasBloq, VentasBloqDes', 'required'),
			array('VentasId, PuntosventaId, VentasSec, UsuariosId, VentasSta, VentasMesExpTar, VentasAniExpTar, VentasTip, VentasTipTar, VentasNumAut, VentasMonMetEnt', 'length', 'max'=>20),
			array('VentasNumTar', 'length', 'max'=>19),
			array('TempLugaresTipUsr, VentasNomDerTar', 'length', 'max'=>150),
			array('VentasNumRef', 'length', 'max'=>30),
			array('VentasBloq', 'length', 'max'=>2),
			array('VentasBloqDes', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('VentasId, PuntosventaId, VentasSec, VentasNumTar, VentasFecHor, TempLugaresTipUsr, UsuariosId, VentasSta, VentasNomDerTar, VentasMesExpTar, VentasAniExpTar, VentasTip, VentasTipTar, VentasNumAut, VentasMonMetEnt, VentasNumRef, VentasBloq, VentasBloqDes', 'safe', 'on'=>'search'),
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
				'ventaslevel1' => array(self::HAS_MANY, 'Ventaslevel1', 'VentasId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'VentasId' => 'Ventas',
			'PuntosventaId' => 'Puntosventa',
			'VentasSec' => 'Ventas Sec',
			'VentasNumTar' => 'Ventas Num Tar',
			'VentasFecHor' => 'Ventas Fec Hor',
			'TempLugaresTipUsr' => 'Temp Lugares Tip Usr',
			'UsuariosId' => 'Usuarios',
			'VentasSta' => 'Ventas Sta',
			'VentasNomDerTar' => 'Ventas Nom Der Tar',
			'VentasMesExpTar' => 'Ventas Mes Exp Tar',
			'VentasAniExpTar' => 'Ventas Ani Exp Tar',
			'VentasTip' => 'Ventas Tip',
			'VentasTipTar' => 'Ventas Tip Tar',
			'VentasNumAut' => 'Ventas Num Aut',
			'VentasMonMetEnt' => 'Ventas Mon Met Ent',
			'VentasNumRef' => 'Ventas Num Ref',
			'VentasBloq' => 'Ventas Bloq',
			'VentasBloqDes' => 'Ventas Bloq Des',
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

		$criteria->compare('VentasId',$this->VentasId,true);
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('VentasSec',$this->VentasSec,true);
		$criteria->compare('VentasNumTar',$this->VentasNumTar,true);
		$criteria->compare('VentasFecHor',$this->VentasFecHor,true);
		$criteria->compare('TempLugaresTipUsr',$this->TempLugaresTipUsr,true);
		$criteria->compare('UsuariosId',$this->UsuariosId,true);
		$criteria->compare('VentasSta',$this->VentasSta,true);
		$criteria->compare('VentasNomDerTar',$this->VentasNomDerTar,true);
		$criteria->compare('VentasMesExpTar',$this->VentasMesExpTar,true);
		$criteria->compare('VentasAniExpTar',$this->VentasAniExpTar,true);
		$criteria->compare('VentasTip',$this->VentasTip,true);
		$criteria->compare('VentasTipTar',$this->VentasTipTar,true);
		$criteria->compare('VentasNumAut',$this->VentasNumAut,true);
		$criteria->compare('VentasMonMetEnt',$this->VentasMonMetEnt,true);
		$criteria->compare('VentasNumRef',$this->VentasNumRef,true);
		$criteria->compare('VentasBloq',$this->VentasBloq,true);
		$criteria->compare('VentasBloqDes',$this->VentasBloqDes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
