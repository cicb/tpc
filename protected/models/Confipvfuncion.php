<?php

/**
 * This is the model class for table "confipvfuncion".
 *
 * The followings are the available columns in table 'confipvfuncion':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $PuntosventaId
 * @property string $ConfiPVFuncionDes
 * @property string $ConfiPVFuncionTipSel
 * @property string $ConfiPVFuncionFecIni
 * @property string $ConfiPVFuncionFecFin
 * @property string $ConfiPVFuncionSta
 * @property integer $ConfiPVFuncionBan
 */
class Confipvfuncion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'confipvfuncion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, PuntosventaId, ConfiPVFuncionTipSel, ConfiPVFuncionFecIni, ConfiPVFuncionFecFin, ConfiPVFuncionSta, ConfiPVFuncionBan', 'required'),
			array('ConfiPVFuncionBan', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, PuntosventaId, ConfiPVFuncionTipSel, ConfiPVFuncionSta', 'length', 'max'=>20),
			array('ConfiPVFuncionDes', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, PuntosventaId, ConfiPVFuncionDes, ConfiPVFuncionTipSel, ConfiPVFuncionFecIni, ConfiPVFuncionFecFin, ConfiPVFuncionSta, ConfiPVFuncionBan', 'safe', 'on'=>'search'),
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
			'puntoventa' => array(self::BELONGS_TO, 'Puntosventa', 'PuntosventaId'),

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
			'PuntosventaId' => 'Puntosventa',
			'ConfiPVFuncionDes' => 'Confi Pvfuncion Des',
			'ConfiPVFuncionTipSel' => 'Tipo de seleccion por funcion',
			'ConfiPVFuncionFecIni' => 'Fecha inicial',
			'ConfiPVFuncionFecFin' => 'Fecha Final',
			'ConfiPVFuncionSta' => 'Estatus',
			'ConfiPVFuncionBan' => 'Confi Pvfuncion Ban',
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
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('ConfiPVFuncionDes',$this->ConfiPVFuncionDes,true);
		$criteria->compare('ConfiPVFuncionTipSel',$this->ConfiPVFuncionTipSel,true);
		$criteria->compare('ConfiPVFuncionFecIni',$this->ConfiPVFuncionFecIni,true);
		$criteria->compare('ConfiPVFuncionFecFin',$this->ConfiPVFuncionFecFin,true);
		$criteria->compare('ConfiPVFuncionSta',$this->ConfiPVFuncionSta,true);
		$criteria->compare('ConfiPVFuncionBan',$this->ConfiPVFuncionBan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Confipvfuncion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function actualizarAtributo()
	{
		# code...
	}
}
