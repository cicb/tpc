<?php

/**
 * This is the model class for table "funciones".
 *
 * The followings are the available columns in table 'funciones':
 * @property string $EventoId
 * @property string $FuncionesId
 * @property string $FuncionesTip
 * @property string $FuncionesFor
 * @property string $FuncionesFecIni
 * @property string $FuncionesFecHor
 * @property string $FuncionesNomDia
 * @property string $ForoId
 * @property string $ForoMapIntId
 * @property integer $FuncionesBanExp
 * @property string $FuncPuntosventaId
 * @property string $FuncionesSta
 * @property string $funcionesTexto
 * @property string $FuncionesBanEsp
 * @property string $funcionesAccExtra
 *
 * The followings are the available model relations:
 * @property ConfigurlFuncionesMapaGrande[] $configurlFuncionesMapaGrandes
 * @property ConfigurlFuncionesMapaGrande[] $configurlFuncionesMapaGrandes1
 */
class Funciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Funciones the static model class
	 */
	 
	public $pathUrlImagesBD;

    public function init() {

        //$this->pathUrlImagesBD = Yii::app()->baseUrl . '/imagesbd/';
        $this->pathUrlImagesBD =  'https://www.taquillacero.com/imagesbd/';
        return parent::init();
    }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'funciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EventoId, FuncionesId, FuncionesTip, FuncionesFor, FuncionesFecIni, FuncionesFecHor, FuncionesNomDia, ForoId, ForoMapIntId, FuncionesBanExp, FuncPuntosventaId, FuncionesSta, funcionesTexto, FuncionesBanEsp, funcionesAccExtra', 'required'),
			array('FuncionesBanExp', 'numerical', 'integerOnly'=>true),
			array('EventoId, FuncionesId, FuncionesTip, FuncionesFor, FuncionesNomDia, ForoId, ForoMapIntId, FuncPuntosventaId, FuncionesSta, FuncionesBanEsp', 'length', 'max'=>20),
			array('funcionesTexto', 'length', 'max'=>200),
			array('funcionesAccExtra', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, FuncionesId, FuncionesTip, FuncionesFor, FuncionesFecIni, FuncionesFecHor, FuncionesNomDia, ForoId, ForoMapIntId, FuncionesBanExp, FuncPuntosventaId, FuncionesSta, funcionesTexto, FuncionesBanEsp, funcionesAccExtra', 'safe', 'on'=>'search'),
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
			'configurlFuncionesMapaGrandes' => array(self::HAS_MANY, 'ConfigurlFuncionesMapaGrande', 'EventoId'),
			'configurlFuncionesMapaGrandes1' => array(self::HAS_MANY, 'ConfigurlFuncionesMapaGrande', 'FuncionId'),
            'zonas' => array(self::HAS_MANY, 'Zonas', array('EventoId','FuncionesId')),
            'evento' => array(self::BELONGS_TO, 'Evento', array('EventoId')),
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
			'FuncionesTip' => 'Funciones Tip',
			'FuncionesFor' => 'Funciones For',
			'FuncionesFecIni' => 'Funciones Fec Ini',
			'FuncionesFecHor' => 'Funciones Fec Hor',
			'FuncionesNomDia' => 'Funciones Nom Dia',
			'ForoId' => 'Foro',
			'ForoMapIntId' => 'Foro Map Int',
			'FuncionesBanExp' => 'Funciones Ban Exp',
			'FuncPuntosventaId' => 'Func Puntosventa',
			'FuncionesSta' => 'Funciones Sta',
			'funcionesTexto' => 'Funciones Texto',
			'FuncionesBanEsp' => 'Funciones Ban Esp',
			'funcionesAccExtra' => 'Funciones Acc Extra',
		);
	}
	
	public function getListaFunciones()
    {
        return array(
                CHtml::listData(Funciones::model()->findAll(), 'EventoId','name'),array('empty'=>array(NULL=>'-- Seleccione --')),
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
		$criteria->compare('FuncionesTip',$this->FuncionesTip,true);
		$criteria->compare('FuncionesFor',$this->FuncionesFor,true);
		$criteria->compare('FuncionesFecIni',$this->FuncionesFecIni,true);
		$criteria->compare('FuncionesFecHor',$this->FuncionesFecHor,true);
		$criteria->compare('FuncionesNomDia',$this->FuncionesNomDia,true);
		$criteria->compare('ForoId',$this->ForoId,true);
		$criteria->compare('ForoMapIntId',$this->ForoMapIntId,true);
		$criteria->compare('FuncionesBanExp',$this->FuncionesBanExp);
		$criteria->compare('FuncPuntosventaId',$this->FuncPuntosventaId,true);
		$criteria->compare('FuncionesSta',$this->FuncionesSta,true);
		$criteria->compare('funcionesTexto',$this->funcionesTexto,true);
		$criteria->compare('FuncionesBanEsp',$this->FuncionesBanEsp,true);
		$criteria->compare('funcionesAccExtra',$this->funcionesAccExtra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getZonasInteractivasMapaGrande() {
        $criteria = new CDbCriteria();
        $criteria->join = 'INNER JOIN configurl_funciones_mapa_grande t1 ON (t1.id = t.configurl_funcion_mapa_grande_id)';
        $criteria->addCondition('t1.EventoId = :EventoId');
        $criteria->addCondition('t1.FuncionId = :FuncionId');
        $criteria->params = array(
            ':EventoId'=>$this->EventoId,
            ':FuncionId'=>$this->FuncionesId
        );

        return ConfigurlMapaGrandeCoordenadas::model()->findAll($criteria);
    }
    
    public function getForoGrande() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.FuncionId = :FuncionId');
        $criteria->params = array(
            ':EventoId'=>$this->EventoId,
            ':FuncionId'=>$this->FuncionesId
        );

        $reg = MapaGrande::model()->find($criteria);

        return isset($reg) ? $this->pathUrlImagesBD .  $reg->nombre_imagen : '';
    }
}
