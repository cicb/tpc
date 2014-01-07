<?php

/**
 * This is the model class for table "descuentos".
 *
 * The followings are the available columns in table 'descuentos':
 * @property string $DescuentosId
 * @property string $DescuentosDes
 * @property string $DescuentosPat
 * @property string $DescuentosCan
 * @property string $DescuentosValRef
 * @property string $DescuentosValIdRef
 * @property string $DescuentosFecIni
 * @property string $DescuentosFecFin
 * @property integer $DescuentosExis
 * @property integer $DescuentosUso
 * @property string $CuponesCod
 * @property string $DescuentoCargo
 *
 * The followings are the available model relations:
 * @property Descuentoslevel1[] $descuentoslevel1s
 * @property Descuentospuntosventa[] $descuentospuntosventas
 */
class Descuentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Descuentos the static model class
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
		return 'descuentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DescuentosId, DescuentosDes, DescuentosPat, DescuentosCan, DescuentosFecIni, DescuentosFecFin, DescuentosExis', 'required'),
			array('DescuentosExis, DescuentosUso', 'numerical', 'integerOnly'=>true),
			array('DescuentosId, DescuentosValIdRef', 'length', 'max'=>20),
			array('DescuentosDes', 'length', 'max'=>200),
			array('DescuentosPat, DescuentosValRef, CuponesCod', 'length', 'max'=>50),
			array('DescuentosCan', 'length', 'max'=>10),
			array('DescuentoCargo', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('DescuentosId, DescuentosDes, DescuentosPat, DescuentosCan, DescuentosValRef, DescuentosValIdRef, DescuentosFecIni, DescuentosFecFin, DescuentosExis, DescuentosUso, CuponesCod, DescuentoCargo', 'safe', 'on'=>'search'),
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
			'descuentoslevel1s' => array(self::HAS_MANY, 'Descuentoslevel1', 'DescuentosId'),
			'descuentospuntosventas' => array(self::HAS_MANY, 'Descuentospuntosventa', 'DescuentosId'),
            'evento' => array(self::BELONGS_TO, 'Evento', 'EventoId'),
            'funciones' => array(self::BELONGS_TO, 'Funciones', array('EventoId','FuncionesId')),
            'zonas' => array(self::BELONGS_TO, 'Zonas', array('EventoId','FuncionesId','ZonasId')),
            'subzonas' => array(self::BELONGS_TO, 'Subzonas', array('EventoId','FuncionesId','ZonasId','SubzonaId')),
            'filas' => array(self::BELONGS_TO, 'Filas', array('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId')),
            'lugares' => array(self::BELONGS_TO, 'Lugares', array('EventoId','FuncionesId','ZonasId','SubzonaId','FilasId','LugaresId')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'DescuentosId' => 'Descuentos',
			'DescuentosDes' => 'Descripci&oacute;n',
			'DescuentosPat' => 'Descuentos',
			'DescuentosCan' => 'Forma',
			'DescuentosValRef' => 'Descuentos Val Ref',
			'DescuentosValIdRef' => 'Descuentos Val Id Ref',
			'DescuentosFecIni' => 'Descuentos Fec Ini',
			'DescuentosFecFin' => 'Descuentos Fec Fin',
			'DescuentosExis' => 'Existencia',
			'DescuentosUso' => 'Descuentos Uso',
			'CuponesCod' => 'Cup&oacute;n',
			'DescuentoCargo' => 'Descuento Cargo',
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

		$criteria->compare('DescuentosId',$this->DescuentosId,true);
		$criteria->compare('DescuentosDes',$this->DescuentosDes,true);
		$criteria->compare('DescuentosPat',$this->DescuentosPat,true);
		$criteria->compare('DescuentosCan',$this->DescuentosCan,true);
		$criteria->compare('DescuentosValRef',$this->DescuentosValRef,true);
		$criteria->compare('DescuentosValIdRef',$this->DescuentosValIdRef,true);
		$criteria->compare('DescuentosFecIni',$this->DescuentosFecIni,true);
		$criteria->compare('DescuentosFecFin',$this->DescuentosFecFin,true);
		$criteria->compare('DescuentosExis',$this->DescuentosExis);
		$criteria->compare('DescuentosUso',$this->DescuentosUso);
		$criteria->compare('CuponesCod',$this->CuponesCod,true);
		$criteria->compare('DescuentoCargo',$this->DescuentoCargo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getMonto()
	{
			if (in_array($this->DescuentosPat,array('2X1','3X2'))) {
				return $this->DescuentosPat;
			}
			else{
				$monto= $this->DescuentosCan;
				return $this->DescuentosPat=='PORCENTAJE'?"-$monto%":"-$$monto";
			}	
	}
	public static function validarCupon($codigo,$eventoId=-1){
		return Descuentos::model()->with(array(
						'descuentoslevel1s'=>array(
								'join'=>'INNER JOIN configurl as t1 ON t1.EventoId = descuentoslevel1s.EventoId',
								'condition'=>'NOW() BETWEEN ConfigurlFecIni AND ConfigurlFecFin  ',
								'group'=>'descuentoslevel1s.EventoId,descuentoslevel1s.FuncionesId,descuentoslevel1s.ZonasId,descuentoslevel1s.SubzonaId'
						)))->count("CuponesCod=:codigo AND NOW() BETWEEN DescuentosFecIni AND DescuentosFecFin AND (DescuentosExis>DescuentosUso or DescuentosExis=0)",
								array('codigo'=>$codigo));
	}

	public  function getCriteriaDescuentosByCupon($codigo,$eventoId=-1)
	{
				$criteria = new CDbCriteria();
				$criteria->distinct="true";
				$criteria->mergeWith(array('join'=>" join descuentoslevel1 t2 ON t2.DescuentosId=t.DescuentosId",'condition'=>'CuponesCod = :codigo',));
				$criteria->addCondition("NOW() BETWEEN DescuentosFecIni AND DescuentosFecFin ");
				$criteria->params=array('codigo'=>$codigo) ;
				if ($eventoId>0) {
						$criteria->addCondition('EventoId = :evento');
						$criteria->params['evento']=$eventoId;
				}
				$criteria->together=true;
				return $criteria;
				// $cupones=Descuentos::model()->findAllByAttributes(array('CuponesCod'=>$codigo));
	}
	public static function getCupones($codigo,$eventoId=-1)
	{ //Devuelve un arreglos con los descuentos relacionados al cupon y el evento que se le pase
		$criteria=self::model()->getCriteriaDescuentosByCupon($codigo,$eventoId);	
		return CActiveRecord::model('descuentos')->with('descuentoslevel1s')->findAll($criteria); 
		// return self::model()->findAll($criteria);	
		// return self::model()->findAllBySql("SELECT EventoId FROM descuentos as t, descuentoslevel1 as t2 WHERE CuponesCod='PRUEBA' and t.DescuentosId=t2.DescuentosId group by EventoId;");
	}

	public static function aplicarDescuentos($visitante=False){
			// Aplica descuento
			$descuento=Descuentos::model()->findByPk(Yii::app()->session['descuento']['DescuentosId']);
			$usados=0;
			if(isset($descuento)){
					if (!$visitante) {
							$visitante = Utils::getVisitante();
					}else {
							$visitante=Visitantes::model()->findByPk($visitante);
					}
					$contador=0;
					$tempPrecios=$visitante->getPreciosTemporales();
					foreach ($tempPrecios as $tmp) {
							if($descuento->validarDescuento($tmp)){
									switch ($descuento->DescuentosPat) {
									case 'EFECTIVO':
											if($tmp->VentasCosBolDes!=$descuento->DescuentosCan){
													$usados+=1;		
													$tmp->VentasCosBolDes=floor($descuento->DescuentosCan);
											}
											break;
									case 'PORCENTAJE':
											if($tmp->VentasCosBolDes!= ($tmp->VentasCosBol*$descuento->DescuentosCan*0.01)){
													$usados+=1;		
													$tmp->VentasCosBolDes= floor($tmp->VentasCosBol*$descuento->DescuentosCan*0.01);
													if (strcasecmp($descuento->DescuentoCargo,"si")==0) {
															//Si aplica al cargo por servicio
															$tmp->VentasCarSerDes=floor($tmp->VentasCarSer*$descuento->DescuentosCan*0.01);
													}
											}
											break;
									case '2X1':
									case '3X2':
											$contador+=1;
											if ($tmp->VentasCosBolDes==$tmp->VentasCosBol) {
													$usados-=1;
													$tmp->VentasCosBolDes=0;
													$tmp->VentasCarSerDes=0;
											}
											if ($contador%($descuento->DescuentosPat[0])==0) {
													if (Descuentos::validarDescuento($tmp)) {
															$usados+=1;
															$tmp->VentasCosBolDes=$tmp->VentasCosBol;
															if (strcasecmp($descuento->DescuentoCargo,"si")==0) 
																	//Si aplica al cargo por servicio
																	$tmp->VentasCarSerDes=$tmp->VentasCarSer;
													}

											}else {
													$tmp->VentasCosBolDes=0;
													$tmp->VentasCarSerDes=0;
											}

											break;
									default:
											return 0;	
											break;
									}//endswitch 
									$tmp->update();
							}//endif validar descuento
							elseif ($tmp->VentasCosBolDes>0) {
									$usados-=1;
									$tmp->VentasCosBolDes=0;
									$tmp->update();
							}
					}//endforeach precio temporal
					//$descuento->DescuentosUso+=$usados;
					//$descuento->update();

			}//endif existe un descuento en sesion
			return $usados;
			//$tempPrecios->save(false);
			
	}

	public function getDescontados()
	{
			$visitante = Utils::getVisitante();
			return PreciosTempLugares::model()->count(array('condition'=>'VentasCosBolDes>0 AND TempLugaresClaVis = :visitante AND DescuentosId=:descuento','params'=>array('visitante'=>$visitante->id,':descuento'=>$this->DescuentosId)));
	}

    public static function validarDescuento($boleto)
	{
			/*
			 *Esta funcion recibe un boleto listo para vender con numero de evento, funcion, zona, subzona, fila y lugar, ademas de la cantidad de boletos y y el precio
			 *y devuelve a cambio el boleto con precio con descuento y si aplico descuento
			 * boleto=[evento,funcion,zona, subzona, fila, asiento, precio ]
			 */
		 
		if ($boleto) {
				$cupon=Descuentos::model()->findByPk(Yii::app()->session['descuento']['DescuentosId']);
				$restric=Yii::app()->session['level1'];
				if ($boleto['EventoId']==$restric['EventoId']) {
					// Ha validado que el boleto sea del evento con descuento
				  if ($restric['FuncionesId']==$boleto['FuncionesId']) {
						if ($restric['ZonasId']==$boleto['ZonasId']) {
								if ( $restric['SubzonaId']==$boleto['SubzonaId']) {
										if (in_array($boleto['FilasId'],array_keys($restric->arregloFilas))) {
												if (in_array($boleto['LugaresId'],array_keys($restric->arregloLugares))) {
													return ($cupon['DescuentosExis']==0 or $cupon['DescuentosUso']<$cupon['DescuentosExis']);	
												}
												elseif ($restric['LugaresId']>0 )   {
													//return 1;//False;
													return false;
												}
										}
										elseif ($restric['FilasId']>0 )   {
											//return 2;//False;
											return false;
										}
								} 
								elseif ($restric['SubzonaId']>0 )   {
										//return 3;//False;	
										return false;
								}
						} 
						elseif ($restric['ZonasId']>0 )   {
							//return 4;//False;
							return false;
						}
				  }
				  elseif ($restric['FuncionesId']>0 )   {
					  //return 22;
					  return False;
				  }
				  return ($cupon['DescuentosExis']==0 or $cupon['DescuentosUso']<$cupon['DescuentosExis']);	
				} //Fin evento match
				else {
					return False;//;
				}
			}
	}

	public function getCuponesDisponibles()
	{
		return $this->DescuentosExis-$this->DescuentosUso;
	}

}
