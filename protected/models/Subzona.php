<?php

/**
 * This is the model class for table "subzona".
 *
 * The followings are the available columns in table 'subzona':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property string $SubzonaAcc
 * @property integer $SubzonaNum
 * @property integer $SubzonaCanFil
 * @property integer $SubzonaFilCanLug
 * @property integer $SubzonaBanExp
 * @property string $SubzonaX1
 * @property string $SubzonaY1
 * @property integer $SubzonaX2
 * @property integer $SubzonaY2
 * @property integer $SubzonaX3
 * @property integer $SubzonaY3
 * @property integer $SubzonaX4
 * @property integer $SubzonaY4
 * @property integer $SubzonaX5
 * @property integer $SubzonaY5
 * @property string $SubzonaFor
 * @property string $SubzonaColor
 */
class Subzona extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Subzona the static model class
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
		return 'subzona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, ZonasId, SubzonaId, SubzonaAcc, SubzonaNum, SubzonaCanFil, SubzonaFilCanLug, SubzonaBanExp, SubzonaX1, SubzonaY1, SubzonaX2, SubzonaY2, SubzonaX3, SubzonaY3, SubzonaX4, SubzonaY4, SubzonaX5, SubzonaY5, SubzonaFor, SubzonaColor', 'required'),
			array('SubzonaNum, SubzonaCanFil, SubzonaFilCanLug, SubzonaBanExp, SubzonaX2, SubzonaY2, SubzonaX3, SubzonaY3, SubzonaX4, SubzonaY4, SubzonaX5, SubzonaY5', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, ZonasId, SubzonaId, SubzonaAcc, SubzonaFor', 'length', 'max'=>20),
			array('SubzonaX1', 'length', 'max'=>200),
			array('SubzonaY1', 'length', 'max'=>100),
			array('SubzonaColor', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, ZonasId, SubzonaId, SubzonaAcc, SubzonaNum, SubzonaCanFil, SubzonaFilCanLug, SubzonaBanExp, SubzonaX1, SubzonaY1, SubzonaX2, SubzonaY2, SubzonaX3, SubzonaY3, SubzonaX4, SubzonaY4, SubzonaX5, SubzonaY5, SubzonaFor, SubzonaColor', 'safe', 'on'=>'search'),
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
        'filas' => array(self::HAS_MANY, 'Filas', array('EventoId','FuncionesId','ZonasId','SubzonaId')),
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
			'ZonasId' => 'Zonas',
			'SubzonaId' => 'Subzona',
			'SubzonaAcc' => 'Subzona Acc',
			'SubzonaNum' => 'Subzona Num',
			'SubzonaCanFil' => 'Subzona Can Fil',
			'SubzonaFilCanLug' => 'Subzona Fil Can Lug',
			'SubzonaBanExp' => 'Subzona Ban Exp',
			'SubzonaX1' => 'Subzona X1',
			'SubzonaY1' => 'Subzona Y1',
			'SubzonaX2' => 'Subzona X2',
			'SubzonaY2' => 'Subzona Y2',
			'SubzonaX3' => 'Subzona X3',
			'SubzonaY3' => 'Subzona Y3',
			'SubzonaX4' => 'Subzona X4',
			'SubzonaY4' => 'Subzona Y4',
			'SubzonaX5' => 'Subzona X5',
			'SubzonaY5' => 'Subzona Y5',
			'SubzonaFor' => 'Subzona For',
			'SubzonaColor' => 'Subzona Color',
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
		$criteria->compare('FuncionesId',$this->FuncionesId,true);
		$criteria->compare('ZonasId',$this->ZonasId,true);
		$criteria->compare('SubzonaId',$this->SubzonaId,true);
		$criteria->compare('SubzonaAcc',$this->SubzonaAcc,true);
		$criteria->compare('SubzonaNum',$this->SubzonaNum);
		$criteria->compare('SubzonaCanFil',$this->SubzonaCanFil);
		$criteria->compare('SubzonaFilCanLug',$this->SubzonaFilCanLug);
		$criteria->compare('SubzonaBanExp',$this->SubzonaBanExp);
		$criteria->compare('SubzonaX1',$this->SubzonaX1,true);
		$criteria->compare('SubzonaY1',$this->SubzonaY1,true);
		$criteria->compare('SubzonaX2',$this->SubzonaX2);
		$criteria->compare('SubzonaY2',$this->SubzonaY2);
		$criteria->compare('SubzonaX3',$this->SubzonaX3);
		$criteria->compare('SubzonaY3',$this->SubzonaY3);
		$criteria->compare('SubzonaX4',$this->SubzonaX4);
		$criteria->compare('SubzonaY4',$this->SubzonaY4);
		$criteria->compare('SubzonaX5',$this->SubzonaX5);
		$criteria->compare('SubzonaY5',$this->SubzonaY5);
		$criteria->compare('SubzonaFor',$this->SubzonaFor,true);
		$criteria->compare('SubzonaColor',$this->SubzonaColor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getCoordenadasComoCadena() {
        $coordenadas = '';
        
        if (isset($this->SubzonaX1) && isset($this->SubzonaY1) &&
            $this->SubzonaX1 != 0 && $this->SubzonaY1 != 0) {
            $coordenadas .= $this->SubzonaX1 . ',' . $this->SubzonaY1;
        }
        
        if (isset($this->SubzonaX2) && isset($this->SubzonaY2) &&
            $this->SubzonaX2 != 0 && $this->SubzonaY2 != 0) {
            $coordenadas .= ','. $this->SubzonaX2 . ',' . $this->SubzonaY2;
        }
        
        if (isset($this->SubzonaX3) && isset($this->SubzonaY3) &&
            $this->SubzonaX3 != 0 && $this->SubzonaY3 != 0) {
            $coordenadas .= ',' . $this->SubzonaX3 . ',' . $this->SubzonaY3;
        }
        
        if (isset($this->SubzonaX4) && isset($this->SubzonaY4) &&
            $this->SubzonaX4 != 0 && $this->SubzonaY4 != 0) {
            $coordenadas .= ','. $this->SubzonaX4 . ',' . $this->SubzonaY4;
        }
        
        if (isset($this->SubzonaX5) && isset($this->SubzonaY5) &&
            $this->SubzonaX5 != 0 && $this->SubzonaY5 != 0) {
            $coordenadas .= ',' .$this->SubzonaX5 . ',' . $this->SubzonaY5;
        }
        
        return $coordenadas;
    }
}
