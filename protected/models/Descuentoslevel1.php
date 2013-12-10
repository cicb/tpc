<?php

/**
 * This is the model class for table "descuentoslevel1".
 *
 * The followings are the available columns in table 'descuentoslevel1':
 * @property string $DescuentosId
 * @property string $DescuentosNum
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $LugaresId
 *
 * The followings are the available model relations:
 * @property Evento $evento
 * @property Descuentos $descuentos
 */
class Descuentoslevel1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Descuentoslevel1 the static model class
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
		return 'descuentoslevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DescuentosId, DescuentosNum, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId', 'required'),
			array('DescuentosId, DescuentosNum, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('DescuentosId, DescuentosNum, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId', 'safe', 'on'=>'search'),
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
			'evento' => array(self::BELONGS_TO, 'Evento', 'EventoId'),
			'funcion' => array(self::BELONGS_TO, 'Funciones', array('EventoId','FuncionesId')),
			'zona' => array(self::BELONGS_TO, 'Zonas', array('EventoId','FuncionesId','ZonasId')),
			'subzona' => array(self::BELONGS_TO, 'Subzonas', array('EventoId','FuncionesId','ZonasId','SubzonaId')),
			'fila' => array(self::BELONGS_TO, 'Filas', array('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId')),
			'lugar' => array(self::BELONGS_TO, 'Lugares', array('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId','LugaresId')),
			'descuentos' => array(self::BELONGS_TO, 'Descuentos', 'DescuentosId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'DescuentosId' => 'Descuentos',
			'DescuentosNum' => 'Descuentos Num',
			'EventoId' => 'Evento',
			'FuncionesId' => 'Funciones',
			'ZonasId' => 'Zonas',
			'SubzonaId' => 'Subzona',
			'FilasId' => 'Filas',
			'LugaresId' => 'Lugares',
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

		$criteria->compare('DescuentosId',$this->DescuentosId,true);
		$criteria->compare('DescuentosNum',$this->DescuentosNum,true);
		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('SubzonaId',$this->SubzonaId,true);
		$criteria->compare('FilasId',$this->FilasId,true);
		$criteria->compare('LugaresId',$this->LugaresId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getArregloFilas()
	{
		$criteria=new CDbCriteria();
		$criteria->compare('DescuentosId',$this->DescuentosId,true);
		$criteria->compare('t.EventoId',$this->EventoId,true);
		if ($this->FuncionesId>0)
				$criteria->compare('t.FuncionesId',$this->FuncionesId,true);
		if ($this->ZonasId>0)
				$criteria->compare('t.ZonasId',$this->ZonasId,true);
		if ($this->SubzonaId>0)
				$criteria->compare('t.SubzonaId',$this->SubzonaId,true);
		//$criteria->join="INNER JOIN filas as t2 ON t2.FilasId=t.FilasId";
		//$criteria->group="DescuentosId,EventoId,FuncionesId, ZonasId,SubzonaId";
		$out=array();
		$level1s=$this->with(array('fila'=>array('distinct'=>true)))->findAll($criteria);
		if (sizeof($level1s)>0) {
				foreach ($level1s as $level1) {
						if (is_object($level1->fila))
								$out[$level1->fila->FilasId]=$level1->fila->FilasAli;
				}
		}

		return $out;
	}
	public function getArregloLugares()
	{
		$criteria=new CDbCriteria();
		$criteria->compare('DescuentosId',$this->DescuentosId,true);
		$criteria->compare('t.EventoId',$this->EventoId,true);
		if ($this->FuncionesId>0)
				$criteria->compare('t.FuncionesId',$this->FuncionesId,true);
		if ($this->ZonasId>0)
				$criteria->compare('t.ZonasId',$this->ZonasId,true);
		if ($this->SubzonaId>0)
				$criteria->compare('t.SubzonaId',$this->SubzonaId,true);
		//$criteria->group="DescuentosId,EventoId,FuncionesId, ZonasId,SubzonaId";
		$out=array();
		foreach ($this->with('lugar')->findAll($criteria) as $level1) {
				if (is_object($level1->lugar))
						$out[$level1->lugar->LugaresId]=$level1->lugar->LugaresLug;
		}
		return $out;

	}
	public function getFilas()
	{
		// Devuelve una cadena de los nombres de filas del descuento
		$filas=$this->getArregloFilas();
		return implode(',',$filas);
	}
	public function getLugares()
	{
		// Devuelve una cadena de los nombres de filas del descuento
		$lugares=$this->getArregloLugares();
		return implode(',',$lugares);
	}
}
