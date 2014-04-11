<?php

/**
 * This is the model class for table "puntosventa".
 *
 * The followings are the available columns in table 'puntosventa':
 * @property string $tipoid
 * @property string $PuntosventaId
 * @property string $PuntosventaNom
 * @property integer $puntosventaTipoId
 * @property string $PuntosventaInf
 * @property string $PuntosventaIdeTra
 * @property string $PuntosventaSta
 */
class Puntosventa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puntosventa the static model class
	 */
	private $padre;
	private $_childs=null;
 	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**


	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'puntosventa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PuntosventaId, PuntosventaNom, puntosventaTipoId, PuntosventaInf, PuntosventaIdeTra, PuntosventaSta', 'required'),
			array('puntosventaTipoId', 'numerical', 'integerOnly'=>true),
			array('tipoid, PuntosventaId, PuntosventaIdeTra, PuntosventaSta', 'length', 'max'=>20),
			array('PuntosventaNom', 'length', 'max'=>75),
			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			// @todo Please remove those attributes that should not be searched.

			array('tipoid, PuntosventaId, PuntosventaNom, puntosventaTipoId, PuntosventaInf, PuntosventaIdeTra, PuntosventaSta', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
			// NOTE: you may need to adjust the relation name and the related
			// class name for the relations automatically generated below.

			//return array(


			return array(
					'ventas' => array(self::HAS_MANY, 'Ventas', 'PuntosventaId'),
					'padre' => array(self::BELONGS_TO, 'Puntosventa', 'PuntosventaSuperId'),
					//'hijos'	=> array(self::HAS_MANY, 'Puntosventa','Puntosventa')
			);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tipoid' => 'Tipoid',
			'PuntosventaId' => 'Puntosventa',
			'PuntosventaNom' => 'Puntosventa Nom',
			'puntosventaTipoId' => 'Puntosventa Tipo',
			'PuntosventaInf' => 'Puntosventa Inf',
			'PuntosventaIdeTra' => 'Puntosventa Ide Tra',
			'PuntosventaSta' => 'Puntosventa Sta',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.

	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.


		$criteria=new CDbCriteria;

		$criteria->compare('tipoid',$this->tipoid,true);
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('PuntosventaNom',$this->PuntosventaNom,true);
		$criteria->compare('puntosventaTipoId',$this->puntosventaTipoId);
		$criteria->compare('PuntosventaInf',$this->PuntosventaInf,true);
		$criteria->compare('PuntosventaIdeTra',$this->PuntosventaIdeTra,true);
		$criteria->compare('PuntosventaSta',$this->PuntosventaSta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function generarArbol($criterio)
	{
		# Genera la estructura de árbol
		// $criteria=new CDbCriteria;
		// // $criteria->addCondition('')
		// if (isset($criterio)) {
		// 	$criteria->mergeWith($criterio);
		// }
		// $puntos=Puntosventa::model()->findAll($criteria);
		// $lista=array();
		// $arbol=array();
		// foreach ($puntos as $punto) {
		// 	# va ordenando los nodos en padres
		// 	$lista[$punto->PuntosventaId]=$punto;
		// }
		// foreach ($lista as $li) {
		// 	# Recorre la lista para asignarle el padre
		// 	if(array_key_exists($li->PuntosventaSuperId, $lista))
		// 		$li->padre=$lista[$li->PuntosventaSuperId];
		// }
		// // foreach ($lista as $i=>$li) {
		// // 	$arbol[$i]
		// // }



	}

	public function hasChildrens()
	{
		# Busca todos los elementos que lo tengan como padre

	}

	public function getChildrens()
	{
		# Devuelve los puntos de venta que lo ven como un nodo padre
		if (is_null($this->_childs)) {
			$this->_childs= self::model()->findAll(array(
				'condition'=>"PuntosventaSta='ALTA' and  PuntosventaSuperId=".$this->PuntosventaId));
		}
		return $this->_childs;
	}


}

