<?php

/**
 * This is the model class for table "forolevel1".
 *
 * The followings are the available columns in table 'forolevel1':
 * @property string $ForoId
 * @property string $ForoMapIntId
 * @property string $ForoMapIntNom
 * @property string $foroMapConfig
 * @property string $ForoMapIntIma
 * @property string $ForoMapZonInt
 * @property integer $ForoMapZonIntWei
 * @property integer $ForoMapZonIntHei
 * @property string $ForoMapPat
 */
class Forolevel1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $EventoId;
	public function tableName()
	{
		return 'forolevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('foroMapConfig', 'required'),
			array('ForoMapZonIntWei, ForoMapZonIntHei', 'numerical', 'integerOnly'=>true),
			array('ForoId, ForoMapIntId', 'length', 'max'=>20),
			array('ForoMapIntNom', 'length', 'max'=>75),
			array('foroMapConfig, ForoMapIntIma, ForoMapZonInt', 'length', 'max'=>200),
			array('ForoMapPat', 'length', 'max'=>128),
			array('EventoId', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ForoId, ForoMapIntId, ForoMapIntNom, foroMapConfig, ForoMapIntIma, ForoMapZonInt, ForoMapZonIntWei, ForoMapZonIntHei, ForoMapPat', 'safe', 'on'=>'search'),
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
			'foro'=>array(self::BELONGS_TO,'Foro','ForoId'),
			'funciones'=> array(self::HAS_MANY,'Funciones', array('ForoId','ForoMapIntId')),
			'funcion'=> array(self::HAS_ONE,'Funciones', array('ForoId','ForoMapIntId')),
			'eventos'=>array(
                self::HAS_MANY,'Evento',array('EventoId'=>'EventoId'),'through'=>'funciones','joinType'=>'INNER JOIN'
            ),
			'evento'=>array(
                self::HAS_ONE,'Evento',array('EventoId'=>'EventoId'),'through'=>'funciones',
            ),
            'zonas'=>array(self::HAS_MANY,'Zonas',array(
            		'EventoId'=>'EventoId',
            		'FuncionesId'=>'FuncionesId',
            	),'through'=>'funciones' )
			// 'funciones'=>array(self::HAS_MANY,'Funciones',array('ForoId','ForoMapIntId')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ForoId' => 'Foro',
			'ForoMapIntId' => 'Foro Map Int',
			'ForoMapIntNom' => 'Nombre de la distribución',
			'foroMapConfig' => 'Foro Map Config',
			'ForoMapIntIma' => 'No se usa',
			'ForoMapZonInt' => 'No se usa',
			'ForoMapZonIntWei' => 'No se usa',
			'ForoMapZonIntHei' => 'No se usa',
			'ForoMapPat' => 'Imagen del foro',
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

		// error_log("EventoId: ".$this->EventoId,3,'/tmp/log');
		if ($this->EventoId>0) {
			$criteria->join="INNER JOIN funciones as t1 ON t1.ForoId=t.ForoId 
							and t1.ForoMapIntId=t.ForoMapIntId ";
			// $criteria->join.="INNER JOIN evento as t2 ON t2.EventoId=t1.EventoId";
			$criteria->compare('t1.EventoId ',$this->EventoId);
			// $criteria->addCondition("t2.EventoId like ':EventoId' ")
		}
		
		$criteria->compare('ForoId',$this->ForoId,true);
		$criteria->compare('ForoMapIntId',$this->ForoMapIntId,true);
		$criteria->compare('ForoMapIntNom',$this->ForoMapIntNom,true);
		$criteria->compare('foroMapConfig',$this->foroMapConfig,true);
		$criteria->compare('ForoMapIntIma',$this->ForoMapIntIma,true);
		$criteria->compare('ForoMapZonInt',$this->ForoMapZonInt,true);
		$criteria->compare('ForoMapZonIntWei',$this->ForoMapZonIntWei);
		$criteria->compare('ForoMapZonIntHei',$this->ForoMapZonIntHei);
		$criteria->compare('ForoMapPat',$this->ForoMapPat,true);
		$criteria->order="ForoId desc, ForoMapIntId desc";

		$criteria->addCondition('LENGTH(ForoMapPat)>3');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Forolevel1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListaEventos()
	{
		$eventos=array();
		if (isset($this->eventos) and sizeof($this->eventos)>0) {
			foreach ($this->eventos as $evento) {
				$eventos[]=$evento->EventoNom;
			}
		}
		$eventos=array_slice($eventos, -5,5);
		return implode(', ', $eventos);
	}

	public function getArregloZonas()
	{
		# Regresa un arreglo de zonas con su numero de asientos
		$tabla=array();
		if (isset($this->funcion) and sizeof($this->funcion->zonas)>0) {
			foreach ($this->funcion->zonas as $zona) {
				$tabla[$zona->ZonasAli]=$zona->capacidad;
			}
		}
		return $tabla;
	}

	public function getTablaZonas($htmlOptions=array())
	{
		$tabla=$this->getArregloZonas();
		$filas="";
		if (sizeof($tabla)>0) {
			$i=0;
			$filas.="<TR><TH>Zona</TH> <TH>Asientos</TH></TR>";
			foreach ($tabla as $key => $value) {
					$i++;
					$filas.=sprintf("<TR %s><TD>%s</TD> <TD>%s</TD></TR>",
						$i%2?'class=\'odd\'':'',
						$key,$value
						);
				}
			return CHtml::tag('table',$htmlOptions,$filas);	
		}
	}
	public function getAsientos()
	{
		#Devuelve el numero total de asiento de cualquier evento con esta distribucion
		# 0 si no tiene eventos
		if (isset($this->funcion) and is_object($this->funcion)) {
			# Si existe al menos una sola funcion
			return $this->funcion->asientos;
		}
		else
			return 0;
	}

	static function removerAsignacion($EventoId,$FuncionesId){
		//Elimina todas las zonas, subzonas, filas, lugares de la funcion que se le indique
		$identificandor=compact('EventoId','FuncionesId');
		$transaction = Yii::app()->db->beginTransaction();
		if(Lugares::model()->deleteAllByAttributes($identificandor))
			if(Filas::model()->deleteAllByAttributes($identificandor))
				if(Subzona::model()->deleteAllByAttributes($identificandor))
					if(Zonas::model()->deleteAllByAttributes($identificandor))
						if(Zonaslevel1::model()->deleteAllByAttributes($identificandor)){
							$funcion=Funciones::model()->findByPk($identificandor);
							$funcion->ForoId=0;
							$funcion->ForoMapIntId=0;
							$transaction->commit();
							return true;
						}
						else {$transaction->rollback();return false;}
					else {$transaction->rollback();return false;}
				else {$transaction->rollback();return false;}
			else {$transaction->rollback();return false;}
		else {$transaction->rollback();return true;} 
	}

	public function asignar($EventoId,$FuncionesId)
	{
		# Asigna la distribucion a una funcion.
		$identificandor=compact('EventoId','FuncionesId');
		$origen=Funciones::model()->findByAttributes(array(
			'ForoId'=>$this->ForoId,'ForoMapIntId'=>$this->ForoMapIntId,
			));
		$funcion=Funciones::model()->findByPk($identificandor);
		if (is_object($funcion) and is_object($origen)) {
		# Si la función existe se inicia la transacción
			//Se eliminan toda distribucion anterior-----------------------------------------------------
			if (self::removerAsignacion($EventoId,$FuncionesId)){
				$conexion=Yii::app()->db;
				$transaction = $conexion->beginTransaction();
				$insertar=array(
					'zonas'=>sprintf("
						INSERT INTO zonas (SELECT %d, %d, ZonasId, ZonasAli,
							ZonasTipoBol, ZonasTipo, ZonasNum, ZonasCantSubZon, ZonasCanLug,
							ZonasBanExp, ZonasCosBol FROM zonas WHERE EventoId=%d and FuncionesId=%d);
					",$funcion->EventoId,$funcion->FuncionesId, $origen->EventoId, $origen->FuncionesId),
					'subzonas'=>sprintf(" 
						INSERT INTO subzona (SELECT %d, %d, ZonasId, SubzonaId,
							SubzonaAcc, SubzonaNum, SubzonaCanFil, SubzonaFilCanLug, SubzonaBanExp,
							SubzonaX1, SubzonaY1, SubzonaX2, SubzonaY2, SubzonaX3, SubzonaY3, SubzonaX4,
							SubzonaY4, SubzonaX5, SubzonaY5, SubzonaFor, SubzonaColor FROM subzona WHERE
							EventoId=%d and FuncionesId=%d);
					",$funcion->EventoId,$funcion->FuncionesId,$origen->EventoId,$origen->FuncionesId),
					'filas'=>sprintf("   
						INSERT INTO filas (SELECT %d, %d, ZonasId, SubzonaId,
							FilasId, FilasAli, FilasNum, FilasCanLug, FilasIniCol, FilasIniFin,
							FilasBanExp, LugaresIni, LugaresFin, MesasX, MesasY, MesasWidth, MesasHeight
							FROM filas WHERE EventoId=%d and FuncionesId=%d);
					",$funcion->EventoId,$funcion->FuncionesId,$origen->EventoId,$origen->FuncionesId),
					'lugares'=>sprintf("   
						INSERT INTO lugares (SELECT %d, %d, ZonasId, SubzonaId,
							FilasId, LugaresId, LugaresLug, LugaresNum, LugaresStatus, LugaresNumBol
							FROM lugares WHERE EventoId=%d and FuncionesId=%d);
					",$funcion->EventoId,$funcion->FuncionesId,$origen->EventoId,$origen->FuncionesId),
					'zonaslevel1'=>sprintf("   
						INSERT INTO zonaslevel1 (SELECT %d, %d, ZonasId, PuntosventaId,
							ZonasFacCarSer, ZonasBanVen FROM zonaslevel1 WHERE EventoId=%d and FuncionesId=%d);
					",$funcion->EventoId,$funcion->FuncionesId,$origen->EventoId,$origen->FuncionesId),
					);
					// try{	
						$conexion->createCommand($insertar['zonas'])->execute();
						$conexion->createCommand($insertar['subzonas'])->execute();
						$conexion->createCommand($insertar['filas'])->execute();
						$conexion->createCommand($insertar['lugares'])->execute();
						$conexion->createCommand($insertar['zonaslevel1'])->execute();
						$funcion->ForoId=$this->ForoId;
						$funcion->ForoMapIntId=$this->ForoMapIntId;
						$funcion->update();
						Lugares::model()->updateAll(array('LugaresStatus'=>'TRUE'),
							sprintf("EventoId= %d AND FuncionesId= %d AND LugaresStatus<>'OFF'",
								$funcion->EventoId,$funcion->FuncionesId)
							);
						$transaction->commit();
						return true;
					// }
					// catch(Exception $e){
					// 	$transaction->rollback();
					// 	return false;
					// }

				}
				else return false;

			}
			else return false;

		}

}
