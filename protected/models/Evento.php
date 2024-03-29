<?php

/**
 * This is the model class for table "evento".
 *
 * The followings are the available columns in table 'evento':
 * @property string $EventoId
 * @property string $EventoNom
 * @property string $EventoSta
 * @property string $EventoFecIni
 * @property string $EventoFecFin
 * @property string $CategoriaId
 * @property string $CategoriaSubId
 * @property string $EventoTemFecFin
 * @property string $EventoDesBol
 * @property string $EventoImaBol
 * @property string $EventoImaMin
 * @property string $EventoDesWeb
 * @property string $ForoId
 * @property string $PuntosventaId
 * @property string $EventoSta2
 *
 * The followings are the available model relations:
 * @property Categorialevel1 $categoria
 * @property Categorialevel1 $categoriaSub
 */
class Evento extends CActiveRecord
{
		public $imaBol, $imaMin;
		public $maxId;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Evento the static model class
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
		return 'evento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array(' EventoNom, EventoSta, EventoFecIni, EventoFecFin, CategoriaId, EventoDesBol, ForoId', 'required'),
			array('EventoId, EventoSta, CategoriaId, CategoriaSubId, ForoId, PuntosventaId, EventoSta2', 'length', 'max'=>20),
			array('EventoNom', 'length', 'max'=>150),
			array('EventoDesBol', 'length', 'max'=>75),
			array('EventoImaBol, EventoImaMin, EventoDesWeb', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventoId, EventoNom, EventoSta, EventoFecIni, EventoFecFin, CategoriaId, CategoriaSubId, EventoTemFecFin, EventoDesBol, EventoImaBol, EventoImaMin, EventoDesWeb, ForoId, PuntosventaId, EventoSta2', 'safe', 'on'=>'search'),
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
			'categoria' => array(self::HAS_ONE, 'Categorialevel1', 'CategoriaId'),
			'configurl' => array(self::HAS_ONE, 'Configurl', 'EventoId'),
			'categoriaSub' => array(self::BELONGS_TO, 'Categorialevel1', 'CategoriaSubId'),
			'puntoventa' => array(self::HAS_ONE, 'Puntosventa', 'PuntosventaId'),
			'foro' => array(self::BELONGS_TO, 'Foro', 'ForoId'),
            'asientos'=>array(self::STAT,'Lugares','EventoId','condition'=>"LugaresStatus<>'OFF'"),
            'distribucionpuertalevel1' =>array(self::BELONGS_TO,'Distribucionpuertalevel1','EventoId'),
             'funciones' => array(self::HAS_MANY, 'Funciones', array( 'EventoId')),
             'zonas' => array(self::HAS_MANY, 'Zonas', array( 'EventoId','FuncionesId')),
             'subzona' => array(self::HAS_MANY, 'Subzona', array('SubzonaId','FuncionesId', 'EventoId')),
			 'boletosVendidos'=>array(self::STAT, 'Ventaslevel1', 'EventoId','condition'=>"VentasSta NOT LIKE 'CANCELADO'"),
			 'accesos'=>array(self::STAT, 'Acceso', 'EventoId'),
			 'ventaslevel1'=>array(self::STAT,'Ventaslevel1', 'EventoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'EventoId' => 'Evento',
			'EventoNom' => 'Nombre del evento: ',
			'EventoSta' => 'Estatus del Evento',
			'EventoFecIni' => 'Fecha Inicio',
			'EventoFecFin' => 'Fecha Fin',
			'CategoriaId' => 'Categoria',
			'CategoriaSubId' => 'Sub Categoria ',
			'EventoTemFecFin' => 'Evento Tem Fec Fin',
			'EventoDesBol' => 'Texto en el Boleto',
			'EventoImaBol' => 'Imagen del boleto',
			'EventoImaMin' => 'Imagen para PV',
			'EventoDesWeb' => 'Descripcion en Web',
			'ForoId' => 'Foro',
			'PuntosventaId' => 'Punto de venta',
			'EventoSta2' => 'Tipo',
			'FuncionesId' => 'Funciones',
			'imaBol' => 'Imagen:',
			'imaMin' => 'Imagen:',
		);
	}
	public function getAllFunciones()
	{
			return $this->funciones;
	}
    public function getListaEvento()
    {
        return array(
                CHtml::listData(evento::model()->findAll(array('order'=>'EventoId desc')), 'EventoId','name'),array('empty'=>array(NULL=>'-- Seleccione --')),
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

		//$criteria->compare('EventoId',$this->EventoId,true);
		$criteria->compare('EventoNom',$this->EventoNom,true);
		$criteria->compare('EventoSta',$this->EventoSta,true);
		$criteria->compare('EventoFecIni',$this->EventoFecIni,true);
		$criteria->compare('EventoFecFin',$this->EventoFecFin,true);
		$criteria->compare('CategoriaId',$this->CategoriaId,true);
		$criteria->compare('CategoriaSubId',$this->CategoriaSubId,true);
		$criteria->compare('EventoTemFecFin',$this->EventoTemFecFin,true);
		$criteria->compare('EventoDesBol',$this->EventoDesBol,true);
		$criteria->compare('EventoImaBol',$this->EventoImaBol,true);
		$criteria->compare('EventoImaMin',$this->EventoImaMin,true);
		$criteria->compare('EventoDesWeb',$this->EventoDesWeb,true);
		$criteria->compare('ForoId',$this->ForoId,true);
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('EventoSta2',$this->EventoSta2,true);
		$criteria->order="EventoId desc";
        //$criteria->with =array('evento');
        //$criteria->addSearchCondition('evento.EventoNom', $this->EventoId);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>20
			)
		));
	}
	
	public function getAsignaciones($EventoId){
		$query = "SELECT DISTINCT idAsignacion,idCatTerminal,AsignacionFecha,asignacion.IdCatPuerta,CatPuertaNom
				 FROM asignacion INNER JOIN catpuerta ON catpuerta.IdCatPuerta=asignacion.IdCatPuerta
                 INNER JOIN distribucionpuertalevel1 ON distribucionpuertalevel1.IdDistribucionPuerta=asignacion.IdDistribucionPuerta
                 WHERE distribucionpuertalevel1.EventoId = '$EventoId'";
        return new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
     }
     
     public function getPuertas($DistribucionId){
		$query = "SELECT DISTINCT catpuerta.CatPuertaNom,catpuerta.IdCatPuerta,ZonasId,SubzonaId
                 FROM catpuerta INNER JOIN distribucionpuertalevel1 ON distribucionpuertalevel1.IdCatPuerta=catpuerta.IdCatPuerta
				 WHERE distribucionpuertalevel1.IdDistribucionPuerta='$DistribucionId' AND EventoId=(SELECT EventoId
                 FROM distribucionpuertalevel1 where IdDistribucionPuerta='$DistribucionId' order by IdDistribucionPuertalevel1 LIMIT 1) order by catpuerta.IdCatPuerta";
        $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
        return $data->getData();
     }
     
     public static function getCargarPuertas($DistribucionId){
		$query = "SELECT DISTINCT catpuerta.CatPuertaNom,catpuerta.IdCatPuerta
                 FROM catpuerta INNER JOIN distribucionpuertalevel1 ON distribucionpuertalevel1.IdCatPuerta=catpuerta.IdCatPuerta
				 WHERE distribucionpuertalevel1.IdDistribucionPuerta='$DistribucionId' AND EventoId=(SELECT EventoId
                 FROM distribucionpuertalevel1 where IdDistribucionPuerta='$DistribucionId' order by IdDistribucionPuertalevel1 LIMIT 1) order by catpuerta.IdCatPuerta";
        $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
        return $data->getData();
     }
     
     public function getCatPuertas($DistribucionId,$PuertaId){
		$query = "SELECT DISTINCT catpuerta.CatPuertaNom,catpuerta.IdCatPuerta
                 FROM catpuerta
				 WHERE IdDistribucionPuerta='$DistribucionId' AND IdCatPuerta='$PuertaId'";
        $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
        return $data->getData();
     }
     
     public function getZonas($IdCatPuerta,$distribucionId,$eventoId){
		$query = "SELECT DISTINCT ZonasAli,ZonasId
				 FROM zonas
                 WHERE ZonasId IN(SELECT DISTINCT ZonasId
                 FROM distribucionpuertalevel1 WHERE IdCatPuerta='$IdCatPuerta' AND IdDistribucionPuerta='$distribucionId'
                 AND EventoId=(SELECT EventoId FROM distribucionpuertalevel1 WHERE IdDistribucionPuerta='$distribucionId' ORDER BY IdDistribucionPuerta LIMIT 1))
                 AND EventoId='$eventoId'";
        $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
        return $data->getData();
     }
     
     public function getFunciones($EventoId){
		$query = "SELECT FuncionesId,funcionesTexto,ForoId,ForoMapIntId,(SELECT COUNT(FuncionesId)
                 FROM funciones WHERE EventoId='$EventoId') AS Cantidad,(SELECT COUNT(distinctrow CONCAT(ForoId,ForoMapIntId))
                 FROM funciones WHERE EventoId='$EventoId') AS Distribucion
				 FROM funciones
                 WHERE EventoId= '$EventoId' ORDER BY ForoId,ForoMapIntId,FuncionesId";
        $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
        return $data->getData();
     }
     
      public function getSubZonas($EventoId,$ZonaId,$distribucionId,$IdCatPuerta){
		 $query = "SELECT DISTINCT SubzonaAcc,SubzonaId
				 FROM subzona
                 WHERE SubzonaId IN(SELECT DISTINCT SubzonaId
                 FROM distribucionpuertalevel1 WHERE IdCatPuerta='$IdCatPuerta' AND IdDistribucionPuerta='$distribucionId' AND ZonasId='$ZonaId'
                 AND EventoId=(SELECT EventoId FROM distribucionpuertalevel1 WHERE IdDistribucionPuerta='$distribucionId' ORDER BY IdDistribucionPuerta LIMIT 1))
                 AND EventoId='$EventoId' AND ZonasId='$ZonaId'";
         $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
         return $data->getData();
     }
     
     public function getDistribucionForo($EventoId,$FuncionesId){
        $query = "SELECT DISTINCT distribucionpuertalevel1.EventoId,distribucionpuerta.IdDistribucionPuerta,DistribucionPuertaNom
        FROM distribucionpuerta inner join funciones on funciones.ForoId=distribucionpuerta.ForoId and funciones.ForoMapIntId=distribucionpuerta.ForoIntMapId
        INNER JOIN distribucionpuertalevel1 ON distribucionpuerta.IdDistribucionPuerta =  distribucionpuertalevel1.IdDistribucionPuerta                
        WHERE funciones.EventoId='$EventoId' AND funciones.FuncionesId IN ('$FuncionesId') AND DistribucionPuertaNom NOT LIKE '%DISTRIBUCION_TEMP_%'
        GROUP BY distribucionpuertalevel1.IdCatPuerta,distribucionpuertalevel1.IdDistribucionPuerta";
		/*$query = "SELECT DISTINCT EventoId,IdDistribucionPuerta,DistribucionPuertaNom
                 FROM distribucionpuerta inner join funciones on funciones.ForoId=distribucionpuerta.ForoId and funciones.ForoMapIntId=distribucionpuerta.ForoIntMapId
                 WHERE funciones.EventoId='$EventoId' AND funciones.FuncionesId IN ('$FuncionesId') AND DistribucionPuertaNom NOT LIKE '%DISTRIBUCION_TEMP_%'";
        */
        $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
       return $data->getData();
     }
     
     public function getValidacion($distribucionId,$eventoId,$funcion,$ZonasId,$SubzonaId){
		$query = "SELECT Count(IdDistribucionPuerta) As Total
                 FROM distribucionpuertalevel1
                 WHERE IdDistribucionPuerta = '$distribucionId' AND EventoId = '$eventoId' AND FuncionesId = '$funcion'
                 AND ZonasId = '$ZonasId' AND SubzonaId = '$SubzonaId'";
                 
        $data= new CSqlDataProvider($query, array(
					//		'totalItemCount'=>$count,//$count,
                            'pagination'=>false,
			));
       return $data->getData();
     }
	public function conmutarEstatus(){
			if ($this->EventoSta=='ALTA') {
					$this->EventoSta='BAJA';
			}	
			else {
				$this->EventoSta='ALTA';
			}
			return $this->update('EventoSta');
	}

	 public function saveModel($data=array())
	 {
	 	$this->attributes=$data;
        $new  = $this->isNewRecord;
		if(!$this->save())
		    return CHtml::errorSummary($this);
        else{
            if($new){
                $semana      = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
                $meses       = array('ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
                $dia_semana  = date('w',strtotime('now'));
                $dia         = date('d',strtotime('now'));
                $mes         = date('n',strtotime('now'));
                $anio        = date('Y',strtotime('now'));
                $hrs         = date('H:i',strtotime('now'));
                
                $funcionesTexto    = strtoupper($semana[$dia_semana]).' '.$dia.' - '.$meses[$mes-1].' - '.$anio.' '.$hrs.' HRS'; 
                $last_configurl = Configurl::model()->find(array('order'=>'ConfigurlId DESC'));
                $last_configurl = $last_configurl->ConfigurlId + 1;
                Yii::app()->db->createCommand("INSERT INTO funciones (EventoId,FuncionesId,FuncionesFecIni,FuncionesFecHor,FuncionesNomDia,ForoId,FuncPuntosventaId,FuncionesSta,funcionesTexto) VALUES($this->EventoId,1,'".date("Y-m-d H.i:s")."','".date("Y-m-d H.i:s")."','".$semana[$dia_semana]."',$this->ForoId,$this->PuntosventaId,'ALTA','$funcionesTexto')")->execute();
                
                Yii::app()->db->createCommand("INSERT INTO configurl (ConfigurlId,EventoId,ConfigurlURL,ConfigurlPos,ConfigurlTipSel,ConfigurlFecIni,ConfigurlFecFin) VALUES($last_configurl,$this->EventoId,'http://taquillacero.com',1,'Mixta','".date("Y-m-d H.i:s")."','".date("Y-m-d H.i:s",strtotime('now + 2 hour'))."')")->execute();
                $puntosVentas = Puntosventa::model()->findAll("PuntosventaSta='ALTA'");
                foreach($puntosVentas as $key => $puntoventa):
                    $configPVFuncionDes ="N/A";
                    if($puntoventa->PuntosventaId == 101)
                        $configPVFuncionDes ="WEB";
                        
                    Yii::app()->db->createCommand("INSERT INTO confipvfuncion (EventoId,FuncionesId,PuntosventaId,ConfiPVFuncionDes,ConfiPVFuncionTipSel,ConfiPVFuncionFecIni,ConfiPVFuncionFecFin,ConfiPVFuncionSta) VALUES($this->EventoId,1,$puntoventa->PuntosventaId,'$configPVFuncionDes','MIXTA','".date("Y-m-d H.i:s")."','".date("Y-m-d H.i:s",strtotime('now + 2 hour'))."','ALTA')")->execute();    
                endforeach;
            
            }  
             return 1;  
        }
	 }

	 public static function getMaxId()
	 {
			 $row = Evento::model()->find(array('select'=>'MAX(EventoId) as maxId'));
			 return $row['maxId'];
	 }

	 public function beforeSave()
	 {
				if ($this->scenario=='insert') {
						$this->EventoId=Evento::getMaxId()+1;
						$this->EventoTemFecFin=$this->EventoFecFin;
				}	
			 return parent::beforeSave();
	 }
}
