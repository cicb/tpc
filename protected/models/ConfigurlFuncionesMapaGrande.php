<?php

/**
 * This is the model class for table "configurl_funciones_mapa_grande".
 *
 * The followings are the available columns in table 'configurl_funciones_mapa_grande':
 * @property integer $id
 * @property string $configurl_Id
 * @property string $EventoId
 * @property string $FuncionId
 * @property string $nombre_imagen
 *
 * The followings are the available model relations:
 * @property Configurl $configurl
 * @property Funciones $evento
 * @property Funciones $funcion
 * @property ConfigurlMapaGrandeCoordenadas[] $configurlMapaGrandeCoordenadases
 */
class ConfigurlFuncionesMapaGrande extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'configurl_funciones_mapa_grande';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('configurl_Id, EventoId, FuncionId', 'required'),
			array('configurl_Id, EventoId, FuncionId', 'length', 'max'=>20),
			array('nombre_imagen', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('configurl_Id, EventoId, FuncionId, nombre_imagen', 'safe', 'on'=>'search'),
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
			'configurl' => array(self::BELONGS_TO, 'Configurl', 'configurl_Id'),
			'evento' => array(self::BELONGS_TO, 'Funciones', 'EventoId'),
			'funcion' => array(self::BELONGS_TO, 'Funciones', 'FuncionId'),
			'configurlMapaGrandeCoordenadases' => array(self::HAS_MANY, 'ConfigurlMapaGrandeCoordenadas', 'configurl_funcion_mapa_grande_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'configurl_Id' => 'Configurl',
			'EventoId' => 'Evento',
			'FuncionId' => 'Funcion',
			'nombre_imagen' => 'Nombre Imagen',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('configurl_Id',$this->configurl_Id,true);
		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionId',$this->FuncionId,true);
		$criteria->compare('nombre_imagen',$this->nombre_imagen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConfigurlFuncionesMapaGrande the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterDelete()
	{
			//Antes de eliminar, elimina todas sus coordenadas
			ConfigurlMapaGrandeCoordenadas::model()->deleteAllByAttributes(array('configurl_funcion_mapa_grande_id'=>$this->id));
			return parent::afterDelete();
	}
}
