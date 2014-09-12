<?php

/**
 * This is the model class for table "corredores".
 *
 * The followings are the available columns in table 'corredores':
 * @property integer $numero
 * @property integer $boleto
 * @property string $paterno
 * @property string $materno
 * @property string $nombre
 * @property string $sexo
 * @property string $nacimiento
 * @property string $categoria
 * @property string $distancia
 * @property string $equipo
 * @property string $direccion1
 * @property string $direccion2
 * @property string $direccion3
 * @property integer $cp
 * @property string $ciudad
 * @property string $telefono
 * @property string $email
 */
class Corredores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'corredores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, boleto, paterno, materno, nombre, sexo, nacimiento, categoria, distancia, email', 'required'),
			array('numero, boleto, cp', 'numerical', 'integerOnly'=>true),
			array('paterno, materno, nombre, equipo, direccion1, direccion2, direccion3, ciudad, telefono, email', 'length', 'max'=>45),
			array('sexo', 'length', 'max'=>1),
			array('categoria', 'length', 'max'=>7),
			array('distancia', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numero, boleto, paterno, materno, nombre, sexo, nacimiento, categoria, distancia, equipo, direccion1, direccion2, direccion3, cp, ciudad, telefono, email', 'safe', 'on'=>'search'),
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
			'numero' => 'Numero',
			'boleto' => 'Boleto',
			'paterno' => 'Paterno',
			'materno' => 'Materno',
			'nombre' => 'Nombre',
			'sexo' => 'Sexo',
			'nacimiento' => 'Nacimiento',
			'categoria' => 'Categoria',
			'distancia' => 'Distancia',
			'equipo' => 'Equipo',
			'direccion1' => 'Direccion1',
			'direccion2' => 'Direccion2',
			'direccion3' => 'Direccion3',
			'cp' => 'Cp',
			'ciudad' => 'Ciudad',
			'telefono' => 'Telefono',
			'email' => 'Email',
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

		$criteria->compare('numero',$this->numero);
		$criteria->compare('boleto',$this->boleto);
		$criteria->compare('paterno',$this->paterno,true);
		$criteria->compare('materno',$this->materno,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('sexo',$this->sexo,true);
		$criteria->compare('nacimiento',$this->nacimiento,true);
		$criteria->compare('categoria',$this->categoria,true);
		$criteria->compare('distancia',$this->distancia,true);
		$criteria->compare('equipo',$this->equipo,true);
		$criteria->compare('direccion1',$this->direccion1,true);
		$criteria->compare('direccion2',$this->direccion2,true);
		$criteria->compare('direccion3',$this->direccion3,true);
		$criteria->compare('cp',$this->cp);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Corredores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
