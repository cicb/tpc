<?php

/**
 * This is the model class for table "ventaslevel1".
 *
 * The followings are the available columns in table 'ventaslevel1':
 * @property string $VentasId
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $FilasId
 * @property string $LugaresId
 * @property string $DescuentosId
 * @property string $VentasMonDes
 * @property string $VentasBolTip
 * @property string $VentasCosBol
 * @property string $VentasCarSer
 * @property string $VentasSta
 * @property string $LugaresNumBol
 * @property string $VentasBolPara
 * @property string $VentasCon
 * @property string $CancelUsuarioId
 * @property string $CancelFecHor
 */
class Ventaslevel1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Ventaslevel1 the static model class
	 */
	 
	 public $buscar;
     public $buscarfnc;
     public $tipo;
     public $PuntosventaNom;
     public $total_de_venta_en_pesos;
     public $total_transacciones;
     public $PuntosventaId;
     public $total_de_boletos;
	 public $VentasFecHor;
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ventaslevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('buscar', 'required', 'message'=> 'Debes seleccionar un Evento'),
            array('buscarfnc','default', 'message'=> ''),
			array('VentasId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, DescuentosId, VentasMonDes, VentasBolTip, VentasCosBol, VentasCarSer, VentasSta, LugaresNumBol, VentasBolPara, VentasCon, CancelUsuarioId, CancelFecHor', 'required'),
			array('VentasId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, DescuentosId, VentasBolTip, VentasSta, CancelUsuarioId', 'length', 'max'=>20),
			array('VentasMonDes, VentasCosBol, VentasCarSer', 'length', 'max'=>13),
			array('LugaresNumBol', 'length', 'max'=>64),
			array('VentasBolPara', 'length', 'max'=>100),
			array('VentasCon', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('VentasId, EventoId, FuncionesId, ZonasId, SubzonaId, FilasId, LugaresId, DescuentosId, VentasMonDes, VentasBolTip, VentasCosBol, VentasCarSer, VentasSta, LugaresNumBol, VentasBolPara, VentasCon, CancelUsuarioId, CancelFecHor', 'safe', 'on'=>'search'),
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
        'venta' => array(self::BELONGS_TO, 'Ventas', 'VentasId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Buscar' => 'Buscar',
            'buscarfnc'=>'Selecciona una Funcion',
			'VentasId' => 'Ventas',
			'EventoId' => 'Evento',
			'FuncionesId' => 'Funciones',
			'ZonasId' => 'Zonas',
			'SubzonaId' => 'Subzona',
			'FilasId' => 'Filas',
			'LugaresId' => 'Lugares',
			'DescuentosId' => 'Descuentos',
			'VentasMonDes' => 'Ventas Mon Des',
			'VentasBolTip' => 'Ventas Bol Tip',
			'VentasCosBol' => 'Ventas Cos Bol',
			'VentasCarSer' => 'Ventas Car Ser',
			'VentasSta' => 'Ventas Sta',
			'LugaresNumBol' => 'Lugares Num Bol',
			'VentasBolPara' => 'Ventas Bol Para',
			'VentasCon' => 'Ventas Con',
			'CancelUsuarioId' => 'Cancel Usuario',
			'CancelFecHor' => 'Cancel Fec Hor',
            'PuntosventaNom'=>'Sucursal',
            'total_de_venta_en_pesos'=>'total de la venta',
            'total_transacciones'=>'total de transaciones',
            'VentasFecHor'=>'Fecha',
            'total_de_boletos'=>'total de boletos',
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
		$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('SubzonaId',$this->SubzonaId,true);
		$criteria->compare('FilasId',$this->FilasId,true);
		$criteria->compare('LugaresId',$this->LugaresId,true);
		$criteria->compare('DescuentosId',$this->DescuentosId,true);
		$criteria->compare('VentasMonDes',$this->VentasMonDes,true);
		$criteria->compare('VentasBolTip',$this->VentasBolTip,true);
		$criteria->compare('VentasCosBol',$this->VentasCosBol,true);
		$criteria->compare('VentasCarSer',$this->VentasCarSer,true);
		$criteria->compare('VentasSta',$this->VentasSta,true);
		$criteria->compare('LugaresNumBol',$this->LugaresNumBol,true);
		$criteria->compare('VentasBolPara',$this->VentasBolPara,true);
		$criteria->compare('VentasCon',$this->VentasCon,true);
		$criteria->compare('CancelUsuarioId',$this->CancelUsuarioId,true);
		$criteria->compare('CancelFecHor',$this->CancelFecHor,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		)); 
	}

}
