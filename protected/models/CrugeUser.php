<?php

/**
 * This is the model class for table "cruge_user".
 *
 * The followings are the available columns in table 'cruge_user':
 * @property integer $iduser
 * @property string $regdate
 * @property string $actdate
 * @property string $logondate
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authkey
 * @property integer $state
 * @property integer $totalsessioncounter
 * @property integer $currentsessioncounter
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $telefono
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property string $calle
 * @property string $numero_exterior
 * @property string $numero_interior
 * @property string $referencia_calles
 * @property string $colonia
 * @property string $ciudad_municipio
 * @property string $pais
 * @property string $codigo_postal
 * @property integer $estado_id
 *
 * The followings are the available model relations:
 * @property CrugeAuthitem[] $crugeAuthitems
 * @property CrugeFieldvalue[] $crugeFieldvalues
 * @property Estados $estado
 */
class CrugeUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cruge_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state, totalsessioncounter, currentsessioncounter, estado_id', 'numerical', 'integerOnly'=>true),
			array('regdate, actdate, logondate', 'length', 'max'=>30),
			array('username, email, password, nombre, apellido_paterno, apellido_materno, telefono, fecha_nacimiento, numero_exterior, numero_interior, pais', 'length', 'max'=>45),
			array('authkey, calle, colonia, ciudad_municipio', 'length', 'max'=>100),
			array('sexo', 'length', 'max'=>1),
			array('referencia_calles', 'length', 'max'=>255),
			array('codigo_postal', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iduser, regdate, actdate, logondate, username, email, password, authkey, state, totalsessioncounter, currentsessioncounter, nombre, apellido_paterno, apellido_materno, telefono, sexo, fecha_nacimiento, calle, numero_exterior, numero_interior, referencia_calles, colonia, ciudad_municipio, pais, codigo_postal, estado_id', 'safe', 'on'=>'search'),
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
			'crugeAuthitems' => array(self::MANY_MANY, 'CrugeAuthitem', 'cruge_authassignment(userid, itemname)'),
			'crugeFieldvalues' => array(self::HAS_MANY, 'CrugeFieldvalue', 'iduser'),
			'estado' => array(self::BELONGS_TO, 'Estados', 'estado_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iduser' => 'Iduser',
			'regdate' => 'Fecha de registro',
			'actdate' => 'Fecha de activacion',
			'logondate' => 'Fecha de logeo',
			'username' => 'Nombre de usuario',
			'email' => 'Email',
			'password' => 'Contraseña',
			'authkey' => 'Llave de autentificacion',
			'state' => 'Estatus',
			'totalsessioncounter' => 'Total de sesiones',
			'currentsessioncounter' => 'Actual contador de sesiones',
			'nombre' => 'Nombre',
			'apellido_paterno' => '	Apellido Paterno',
			'apellido_materno' => 'Apellido Materno',
			'telefono' => 'Telefono',
			'sexo' => 'Sexo',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'calle' => 'Calle',
			'numero_exterior' => 'Numero Exterior',
			'numero_interior' => 'Numero Interior',
			'referencia_calles' => 'Referencia Calles',
			'colonia' => 'Colonia',
			'ciudad_municipio' => 'Ciudad Municipio',
			'pais' => 'Pais',
			'codigo_postal' => 'Codigo Postal',
			'estado_id' => 'Estado',
			'estadoNom'=>'Estado',
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

		//$criteria->compare('iduser',$this->iduser);
		$criteria->compare('regdate',$this->regdate,true);
		$criteria->compare('actdate',$this->actdate,true);
		$criteria->compare('logondate',$this->logondate,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		//$criteria->compare('password',$this->password,true);
		//$criteria->compare('authkey',$this->authkey,true);
		//$criteria->compare('state',$this->state);
		//$criteria->compare('totalsessioncounter',$this->totalsessioncounter);
		//$criteria->compare('currentsessioncounter',$this->currentsessioncounter);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido_paterno',$this->apellido_paterno,true);
		$criteria->compare('apellido_materno',$this->apellido_materno,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('sexo',$this->sexo,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('numero_exterior',$this->numero_exterior,true);
		$criteria->compare('numero_interior',$this->numero_interior,true);
		$criteria->compare('referencia_calles',$this->referencia_calles,true);
		$criteria->compare('colonia',$this->colonia,true);
		$criteria->compare('ciudad_municipio',$this->ciudad_municipio,true);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('codigo_postal',$this->codigo_postal,true);
		//$criteria->compare('estado_id',$this->estado_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
					'pageSize'=>20,),
		));
	}
	public function getNombreCompleto()
	{
		return sprintf("%s %s %s",$this->nombre,$this->apellido_paterno,$this->apellido_materno);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CrugeUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getDireccion()
	{
		return sprintf("%s %s %s %s",$this->calle,$this->numero_exterior,$this->numero_interior,$this->referencia_calles);
	}
	public function getEstadoNom()
	{
			if(isset($this->estado)){
					return $this->estado->nombre;
			}
	}
}
