<?php

/**
 * This is the model class for table "evento".
 *
 * The followings are the available columns in table 'evento':
 * @property string $EventoId
 * @property string $EventoNom
 * @property string $EventoSta
 * @property string $EventoFecIni
 * @property string $EventoFecFin
 * @property string $CategoriaId
 * @property string $CategoriaSubId
 * @property string $EventoTemFecFin
 * @property string $EventoDesBol
 * @property string $EventoImaBol
 * @property string $EventoImaMin
 * @property string $EventoDesWeb
 * @property string $ForoId
 * @property string $PuntosventaId
 * @property string $EventoSta2
 *
 * The followings are the available model relations:
 * @property Categorialevel1 $categoria
 * @property Categorialevel1 $categoriaSub
 */
class Evento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Evento the static model class
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
		return 'evento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, EventoNom, EventoSta, EventoFecIni, EventoFecFin, CategoriaId, CategoriaSubId, EventoTemFecFin, EventoDesBol, EventoImaBol, EventoImaMin, EventoDesWeb, ForoId, PuntosventaId, EventoSta2', 'required'),
			array('EventoId, EventoSta, CategoriaId, CategoriaSubId, ForoId, PuntosventaId, EventoSta2', 'length', 'max'=>20),
			array('EventoNom', 'length', 'max'=>150),
			array('EventoDesBol', 'length', 'max'=>75),
			array('EventoImaBol, EventoImaMin, EventoDesWeb', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, EventoNom, EventoSta, EventoFecIni, EventoFecFin, CategoriaId, CategoriaSubId, EventoTemFecFin, EventoDesBol, EventoImaBol, EventoImaMin, EventoDesWeb, ForoId, PuntosventaId, EventoSta2', 'safe', 'on'=>'search'),
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
			'categoria' => array(self::BELONGS_TO, 'Categorialevel1', 'CategoriaId'),
			'categoriaSub' => array(self::BELONGS_TO, 'Categorialevel1', 'CategoriaSubId'),
             'funciones' => array(self::HAS_MANY, 'Funciones', array( 'EventoId')),
             'zonas' => array(self::HAS_MANY, 'Zonas', array('FuncionesId', 'EventoId')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'EventoId' => 'Evento',
			'EventoNom' => 'Evento Nom',
			'EventoSta' => 'Evento Sta',
			'EventoFecIni' => 'Evento Fec Ini',
			'EventoFecFin' => 'Evento Fec Fin',
			'CategoriaId' => 'Categoria',
			'CategoriaSubId' => 'Categoria Sub',
			'EventoTemFecFin' => 'Evento Tem Fec Fin',
			'EventoDesBol' => 'Evento Des Bol',
			'EventoImaBol' => 'Evento Ima Bol',
			'EventoImaMin' => 'Evento Ima Min',
			'EventoDesWeb' => 'Evento Des Web',
			'ForoId' => 'Foro',
			'PuntosventaId' => 'Puntosventa',
			'EventoSta2' => 'Evento Sta2',
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

		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('EventoNom',$this->EventoNom,true);
		$criteria->compare('EventoSta',$this->EventoSta,true);
		$criteria->compare('EventoFecIni',$this->EventoFecIni,true);
		$criteria->compare('EventoFecFin',$this->EventoFecFin,true);
		$criteria->compare('CategoriaId',$this->CategoriaId,true);
		$criteria->compare('CategoriaSubId',$this->CategoriaSubId,true);
		$criteria->compare('EventoTemFecFin',$this->EventoTemFecFin,true);
		$criteria->compare('EventoDesBol',$this->EventoDesBol,true);
		$criteria->compare('EventoImaBol',$this->EventoImaBol,true);
		$criteria->compare('EventoImaMin',$this->EventoImaMin,true);
		$criteria->compare('EventoDesWeb',$this->EventoDesWeb,true);
		$criteria->compare('ForoId',$this->ForoId,true);
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('EventoSta2',$this->EventoSta2,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}