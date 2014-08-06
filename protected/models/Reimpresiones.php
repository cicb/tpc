<?php

/**
 * This is the model class for table "reimpresiones".
 *
 * The followings are the available columns in table 'reimpresiones':
 * @property string $ReimpresionesId
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $LugaresId
 * @property string $ReimpresionesMod
 * @property string $ReimpresionesSta
 * @property string $UsuarioId
 * @property string $ReimpresionesFecHor
 * @property string $LugaresNumBol
 */
class Reimpresiones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reimpresiones the static model class
	 */

	public $maxId;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reimpresiones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ReimpresionesId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, ReimpresionesMod, ReimpresionesSta, UsuarioId, ReimpresionesFecHor, LugaresNumBol', 'required'),
			array('ReimpresionesId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, ReimpresionesSta, UsuarioId', 'length', 'max'=>20),
			array('ReimpresionesMod, LugaresNumBol', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ReimpresionesId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, ReimpresionesMod, ReimpresionesSta, UsuarioId, ReimpresionesFecHor, LugaresNumBol', 'safe', 'on'=>'search'),
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
				'ventaslevel1'=>array(self::BELONGS_TO,'Ventaslevel1', 
					array('EventoId','FuncionesId','ZonasId',
						'SubzonaId','FilasId','LugaresId') ),
				'venta'=>array(self::BELONGS_TO,'Ventas', 'VentasId' ),
				'log'=>array(self::BELONGS_TO,'Logreimp', array('EventoId','FuncionesId','ZonasId',
				'SubzonaId','FilasId','LugaresId') ),
				'usuario'=>array(self::BELONGS_TO,'Usuarios','UsuarioId')
		);
	}
	public static function getMaxId()
	{
		$row = Reimpresiones::model()->find(array('select'=>'MAX(ReimpresionesId) as maxId'));
		return $row['maxId'];
	}

		public function beforeSave()
	{
		if ($this->scenario=='insert') {
			$this->ReimpresionesId=self::getMaxId()+1;
			$this->ReimpresionesFecHor=new CDbExpression('NOW()');

		}	
		return parent::beforeSave();
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ReimpresionesId' => 'Reimpresiones',
			'EventoId' => 'Evento',
			'FuncionesId' => 'Funciones',
			'ZonasId' => 'Zonas',
			'SubzonaId' => 'Subzona',
			'FilasId' => 'Filas',
			'LugaresId' => 'Lugares',
			'ReimpresionesMod' => 'Reimpresiones Mod',
			'ReimpresionesSta' => 'Reimpresiones Sta',
			'UsuarioId' => 'Usuario',
			'ReimpresionesFecHor' => 'Reimpresiones Fec Hor',
			'LugaresNumBol' => 'Lugares Num Bol',
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

		//$criteria->compare('ReimpresionesId',$this->ReimpresionesId,true);
		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('SubzonaId',$this->SubzonaId,true);
		$criteria->compare('FilasId',$this->FilasId,true);
		$criteria->compare('LugaresId',$this->LugaresId,true);
		$criteria->compare('ReimpresionesMod',$this->ReimpresionesMod,true);
		$criteria->compare('ReimpresionesSta',$this->ReimpresionesSta,true);
		$criteria->compare('UsuarioId',$this->UsuarioId,true);
		$criteria->compare('ReimpresionesFecHor',$this->ReimpresionesFecHor,true);
		$criteria->compare('LugaresNumBol',$this->LugaresNumBol,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
