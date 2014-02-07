<?php if ( ! defined('YII_PATH')) exit('No direct script access allowed');
/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property string $UsuariosId
 * @property integer $TipUsrId
 * @property string $UsuariosNom
 * @property string $UsuariosCiu
 * @property string $UsuariosTelMov
 * @property string $UsuariosNot
 * @property string $UsuariosNick
 * @property string $UsuariosPass
 * @property string $UsuariosPasCon
 * @property string $UsuariosGruId
 * @property string $UsuariosIma
 * @property string $UsuariosInf
 * @property string $UsuariosEmail
 * @property string $UsuariosRegion
 * @property string $UsuariosStatus
 * @property string $UsuariosVigencia
 */
class Usuarios extends CActiveRecord
{
    public $initialPassword;
	private $_taquillaPrincipal=-1;
	private $taquilla=null;
	private $_permisos=array(
			'boletos_duros'=>array('id'=>1,'valor'=>-1),
			'cortesias'=>array('id'=>2,'valor'=>-1),
			'cupones'=>array('id'=>3,'valor'=>-1),
			'descuentos'=>array('id'=>4,'valor'=>-1),
			'reservaciones'=>array('id'=>5,'valor'=>-1),
			'reimpresiones'=>array('id'=>6,'valor'=>-1),
	);
	/**
	 * Returns the static model of the specified AR class.
	 * @return Usuarios the static model class
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
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				//array (
						//'password, password_repeat, UsuariosNom, nombre, puesto_id, email, perfil_id',
						//'required',
                        //'on' => 'insert' 
                    //),
			array(' UsuariosNom, UsuariosNick,UsuariosEmail,UsuariosStatus', 'required','message'=>'No puede dajarse vacio'),
			array('TipUsrId,UsuariosPass, UsuariosPasCon', 'required','on'=>'insert', 'message'=>'No puede dajarse vacio'),
			array('TipUsrId', 'numerical', 'integerOnly'=>true),
			array('UsuariosId, UsuariosTelMov, UsuariosGruId, UsuariosStatus', 'length', 'max'=>20),
			array('UsuariosNom, UsuariosNick, UsuariosPass, UsuariosPasCon', 'length', 'max'=>50),
			array('UsuariosCiu', 'length', 'max'=>30),
			array('UsuariosNick', 'unique'),
			array('UsuariosEmail, UsuariosRegion', 'length', 'max'=>200),
            array('UsuariosPass, UsuariosPasCon', 'required', 'on'=>'insert','message'=>'Las contraseñas deben coincidir'),
            array('UsuariosPass, UsuariosPasCon', 'length', 'min'=>6,'message'=>'debe tener entre 6 y 40 caracteres'),
            array('UsuariosPass, UsuariosPasCon', 'length', 'max'=>40,'message'=>'debe tener entre 6 y 40 caracteres'),

			array (
					'UsuariosPasCon',
					'compare',
					'compareAttribute' => 'UsuariosPass',
					'on' => 'insert' 
			),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('UsuariosId, TipUsrId, UsuariosNom, UsuariosCiu, UsuariosTelMov, UsuariosNot, UsuariosNick, UsuariosPass, UsuariosPasCon, UsuariosGruId, UsuariosIma, UsuariosInf, UsuariosEmail, UsuariosRegion, UsuariosStatus, UsuariosVigencia', 'safe', 'on'=>'search'),
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
				'tipusr'=>array(self::BELONGS_TO, 'Tipusr', array('TipUsrId')),
				'maxid'=>array(self::STAT, 'Usuarios', array('select'=>'MAX(UsuariosId)')),
				//'usrval'=>array(self::HAS_MANY, 'Usrval', array('UsuariosId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'UsuariosId' => 'Id',
			'TipUsrId' => 'Tipo de Usuario',
			'UsuariosNom' => 'Nombre completo',
			'UsuariosCiu' => 'Ciudad',
			'UsuariosTelMov' => 'Tel. Movil',
			'UsuariosNot' => 'Notas',
			'UsuariosNick' => 'Nombre de usuario',
			'UsuariosPass' => 'Contraseña',
			'UsuariosPasCon' => 'Confirme contraseña',
			'UsuariosGruId' => 'Grupo',
			'UsuariosIma' => 'Imagen',
			'UsuariosInf' => 'Información adicional',
			'UsuariosEmail' => 'Email',
			'UsuariosRegion' => 'Formato de impresión',
			'UsuariosStatus' => 'Status',
			'UsuariosVigencia' => 'Vigencia',
			'taquillaPrincipal'=>'Taquilla principal',
			'boleto_duro'=>'Boleto Duro',
			'cortesias'=>'Cortesias',
			'cupones'=>'Cupones',
			'descuentos'=>'Descuentos',
			'reimpresiones'=>'Reimpresiones',
			'reservaciones'=>'Reservaciones',
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

		$criteria->compare('UsuariosId',$this->UsuariosId,true);
		$criteria->compare('TipUsrId',$this->TipUsrId);
		$criteria->compare('UsuariosNom',$this->UsuariosNom,true);
		$criteria->compare('UsuariosCiu',$this->UsuariosCiu,true);
		$criteria->compare('UsuariosTelMov',$this->UsuariosTelMov,true);
		$criteria->compare('UsuariosNot',$this->UsuariosNot,true);
		$criteria->compare('UsuariosNick',$this->UsuariosNick,true);
		$criteria->compare('UsuariosPass',$this->UsuariosPass,true);
		$criteria->compare('UsuariosPasCon',$this->UsuariosPasCon,true);
		$criteria->compare('UsuariosGruId',$this->UsuariosGruId,true);
		$criteria->compare('UsuariosIma',$this->UsuariosIma,true);
		$criteria->compare('UsuariosInf',$this->UsuariosInf,true);
		$criteria->compare('UsuariosEmail',$this->UsuariosEmail,true);
		$criteria->compare('UsuariosRegion',$this->UsuariosRegion,true);
		$criteria->compare('UsuariosStatus',$this->UsuariosStatus,true);
		$criteria->compare('UsuariosVigencia',$this->UsuariosVigencia,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>30)
		));
	}

	public static function getMaxId()
	{
			//$criteria = new CDbCriteria;
			//$user = self::model()->find(array('select'=>'MIN(UsuariosId) as maxid'));
			//return $user['maxid'];
	}
	public function buscar($texto=null)
	{
			$texto=isset($texto)?$texto:$this->UsuariosNom;	
			$criteria=new CDbCriteria;
			$criteria->addSearchCondition('UsuariosNom',$texto,true,'AND','LIKE');
			$criteria->addSearchCondition('UsuariosNick',$texto,true,'OR','LIKE');
			return new CActiveDataProvider(get_class($this),array(
					'criteria'=>$criteria,
					'pagination'=>array('pageSize'=>25)
			));
	}
	public function beforeSave()
	{
        // in this case, we will use the old hashed password.
        //if(empty($this->UsuariosPass) && empty($this->UsuariosPasCon) && !empty($this->initialPassword))
            //$this->UsuariosPass=$this->UsuariosPasCon=$this->initialPassword;
		$max=Usuarios::model()->find(array('order'=>'UsuariosId desc'));
		$this->UsuariosId=isset($this->UsuariosId)?$this->UsuariosId:$max->UsuariosId+1;	
		$this->UsuariosVigencia = date('Y-m-d',strtotime($this->UsuariosVigencia ));
		if ($this->UsuariosVigencia=='1969-12-31') {
			$this->UsuariosVigencia='0000-00-00';
		}	
        return parent::beforeSave();
    }
	//public function afterSave()
	//{
			//return parent::afterSave();
		
	//}
    public function afterFind()
    {

			$this->UsuariosVigencia = date('Y-m-d',strtotime($this->UsuariosVigencia));
        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->UsuariosPass;
        $this->UsuariosPass = null;
 
        parent::afterFind();
    }
    public function saveModel($data=array())
    {
            //because the hashes needs to match
            if(!empty($data['UsuariosPass']) && !empty($data['UsuariosPasCon']))
            {
                $data['UsuariosPass'] = $data['UsuariosPass'];
                $data['UsuariosPasCon'] = $data['UsuariosPasCon'];
            }
 
            $this->attributes=$data;
			foreach($data as $key=>$row)
				$this->$key=$row;
			$this->taquillaPrincipal=$data['taquillaPrincipal'];	
 
            if(!$this->save())
                return CHtml::errorSummary($this);
			else{
					$this->savePermisos();	
					return $this->UsuariosId;
			} 
 
    }
	/*
	 *GETTERS AND SETTERS
	 */
	public function getUsuarios()
	{
		// Devuelve la lista de usuarios a los que tiene permitido ver sus operaciones
// 		$sql="select distinct(usuarios.UsuariosId), usuarios.UsuariosNom
// from usuarios
// inner join ventas on ventas.UsuariosId=usuarios.UsuariosId
// inner join usrval on usrval.UsuarioId=:logeado
// and usrval.UsrTipId=2 and usrval.UsrSubTipId=2 and usrval.UsrValIdRef='SI'
// where usuarios.UsuariosStatus like '%ALTA%'
// union

// select distinct(usuarios.UsuariosId), usuarios.UsuariosNom
// from usuarios
// inner join ventas on ventas.UsuariosId=usuarios.UsuariosId
// inner join usrval on usrval.UsuarioId=:logeado and usrval.UsrValIdRef=usuarios.UsuariosId and usrval.UsrTipId=2 and usrval.UsrSubTipId=1
// where usuarios.UsuariosStatus like '%ALTA%'";
		$criteria=new CDbCriteria;
		$criteria->join="INNER JOIN ventas ON ventas.UsuariosId=t.UsuariosId ";
		$criteria->join="INNER JOIN usrval ON usrval.UsuariosId=:logeado ";
		// $criteria->join="INNER JOIN ventas ON ventas.UsuariosId=t.UsuariosId ";
		$criteria->addCondition("usrval.UsrTipId=2 and usrval.UsrSubTipId=2 and usrval.UsrValIdRef='SI'");
		$criteria->params['logeado']=17;
		$usuarios=self::findAll($criteria);
	}
    public function validatePassword($password){
        return $this->hashPassword($password)===$this->UsuariosPass;
    }
    public function hashPassword($password){
        //return md5($password);
        return $password;
    }
    public function Accesos(){
        $model = Usrval::model()->with('usrsubtip')->findAll(array('condition'=>"UsuarioId=$this->UsuariosId",'select'=>'t.UsrTipId,t.UsrSubTipId','distinct'=>true));
        $data = array();
        if(!empty($model)){
            foreach($model as $key => $usrval):
                if (!in_array($usrval->usrsubtip->UsrSubTipDes, $data)) {
                    $data[] = $usrval->usrsubtip->UsrSubTipDes;
                }
            endforeach;
        }
        return $data;
    }
	public function getEventosAsignados(){
			$usuarioId = $this->UsuariosId;
			$hoy = date("Y-m-d G:i:s");
			$usrval = Usrval::model()->findAll(array('condition'=>"UsuarioId=$usuarioId AND UsrTipId=2 AND UsrSubTipId=4  AND  ((FecHorIni < '$hoy' AND FecHorFin > '$hoy ') OR FecHorIni = '0000-00-00 00:00:00' AND FecHorIni = '0000-00-00 00:00:00')"));
			$condiciones = "";
			$eventos = array();
			if (is_array($usrval)) {
					$eventos=array();
					foreach($usrval as $evento){
							if (strcasecmp($evento->usrValIdRef,"TODOS")==0
							 OR strcasecmp($evento->usrValIdRef,"TODAS")==0 ) {
									$eventos=array();
									break;
							}	
							else
									$eventos[]=$evento->usrValIdRef;
					}
					if (sizeof($eventos)>0) {
							$condiciones = " AND EventoId IN(".implode(',',$eventos).")";
					}	
			}
			$eventos = Evento::model()->findAll(array('condition'=>" EventoSta='ALTA'".$condiciones,'order'=>"t.EventoNom ASC"));

			return $eventos;
	}

	public function getFuncionesAsignadas($EventoId){
			$usuarioId = $this->UsuariosId;
			$hoy = date("Y-m-d G:i:s");
			$usrval = Usrval::model()->findAll(array('condition'=>"UsuarioId=$usuarioId AND UsrTipId=2 AND UsrSubTipId=4  AND  ((FecHorIni < '$hoy ' AND FecHorFin > '$hoy ') OR FecHorIni = '0000-00-00 00:00:00' AND FecHorIni = '0000-00-00 00:00:00')"));
			$condiciones = "";
			$eventos = array();
			if (is_array($usrval)) {		
					if($usrval[0]->usrValIdRef2=="TODAS"){

					}else{
							$condicion ="";
							foreach($usrval as $key => $funcion){
									$condicion .= $funcion->usrValIdRef2.",";
							}

							if (strlen($condicion)>0) {
									$condiciones = " AND FuncionesId IN(".substr($condicion,0,-1).")";
							}
					}
					$funciones = Funciones::model()->findAll(array('condition'=>" EventoId=$EventoId".$condiciones,'order'=>"t.FuncionesId ASC"));
			}
			return $funciones;
	}
	public function getTipo()
	{
			$tipo=Tipusr::model()->findByPk($this->TipUsrId);
			if (is_object($tipo)) {
					return $tipo->tipUsrIdDes;
			}	
			else return 'Sin tipo';
	}

	public function conmutarEstatus(){
			if ($this->UsuariosStatus=='ALTA') {
					$this->UsuariosStatus='BAJA';
			}	
			else {
				$this->UsuariosStatus='ALTA';
			}
			return $this->update('UsuariosStatus');
	}

	public function getTaquillaPrincipal()
	{
			if ($this->_taquillaPrincipal>=0) {
				return $this->_taquillaPrincipal;
			}	else{
					if(is_null($this->taquilla))$this->taquilla=$this->getModeloTaquillaPrincipal();
					$this->_taquillaPrincipal=is_object($this->taquilla)?$this->taquilla->usrValIdRef>0?$this->taquilla->usrValIdRef:0:0;
					return $this->getTaquillaPrincipal();
			}
	}
	public function setTaquillaPrincipal($valor)
	{	

			if(is_null($this->taquilla))$this->taquilla=$this->getModeloTaquillaPrincipal();
			$usrval=$this->taquilla;
			$usrval->usrValIdRef=$valor;
			if ($usrval->save(false))
						$this->_taquillaPrincipal=$valor;
	}

	public function getModeloTaquillaPrincipal()
	{
			$usrval=Usrval::model()->findByPk(
					array(
							'UsuarioId'=>$this->UsuariosId,
							'UsrTipId'=>5,
							'UsrSubTipId'=>9,
							'UsrValPrivId'=>1,
					));
			if(is_null($usrval)) {
					$usrval=new Usrval('insert');	
					$usrval->UsrValRef='puntosventa.PuntosventaId';
					$usrval->UsuarioId=$this->UsuariosId;
					$usrval->UsrTipId=5;
					$usrval->UsrSubTipId=9;
					$usrval->UsrValPrivId=1;
			}
			return $usrval;
	}

	private function savePermiso($key){
			//Se valida si la llave del permiso esta definida
			if(array_key_exists($key,$this->_permisos)){
					$permiso=5;
					$id=$this->_permisos[$key]['id'];
					$usrval=Usrval::model()->findByPk(
							array(
									'UsuarioId'=>$this->UsuariosId,
									'UsrTipId'=>$permiso,
									'UsrSubTipId'=>$id,
									'UsrValPrivId'=>1,
							));
					if(is_null($usrval)) {
							$usrval=new Usrval('insert');	
							$usrval->UsuarioId=$this->UsuariosId;
							$usrval->UsrTipId=$permiso;
							$usrval->UsrSubTipId=$id;
							$usrval->UsrValPrivId=1;
					}
					$usrval->usrValIdRef=$this->_permisos[$key]['valor']?'SI':'NO';
					return $usrval->save(false);
			}else{
					return false;
			}
	}
	public function savePermisos()
	{
		foreach ($this->_permisos as $key=>$row) {
				$this->savePermiso($key);
		}
	}
	//setters
	private function setPermiso($key,$valor){
			$this->_permisos[$key]['valor']=$valor;
	}
	public function setBoletosDuros($valor){
			$this->setPermiso('boletos_duros',$valor);
	} public function setCortesias($valor){
			$this->setPermiso('cortesias',$valor);
	}public function setCupones($valor){
			$this->setPermiso('cupones',$valor);
	}public function setDescuentos($valor){
			$this->setPermiso('descuentos',$valor);
	}public function setReimpresiones($valor){
			$this->setPermiso('reimpresiones',$valor);
	}public function setReservaciones($valor){
			$this->setPermiso('reservaciones',$valor);
	}
	//getters
	private function getPermiso($key)
	{
			if(array_key_exists($key,$this->_permisos)){
					$permiso=5;
					$id=$this->_permisos[$key]['id'];
					if ($this->_permisos[$key]['valor']>=0) {
							return $this->_permisos[$key]['valor'];
					}	else{
							$criteria=new CDbCriteria;
							$criteria->select="usrValIdRef";
							$criteria->addCondition("UsuarioId=:usuario");
							$criteria->addCondition("UsrTipId=$permiso AND UsrSubTipId=$id ");
							$criteria->params=array(':usuario'=>$this->UsuariosId);
							$usrval= Usrval::model()->find($criteria);		
							$this->_permisos[$key]['valor']=is_object($usrval)?strcasecmp($usrval->usrValIdRef,'SI')==0:0;
							return $this->getPermiso($key);
					}

			}
			else return false;
	}
	public function getBoletosDuros(){
			return $this->getPermiso('boletos_duros');
	} public function getCortesias(){
			return $this->getPermiso('cortesias');
	}public function getCupones(){
			return $this->getPermiso('cupones');
	}public function getDescuentos(){
			return $this->getPermiso('descuentos');
	}public function getReimpresiones(){
			return $this->getPermiso('reimpresiones');
	}public function getReservaciones(){
			return $this->getPermiso('reservaciones');
	}

	//private function getEvento($eventoId){

	//}
	public function asignarEvento($eventoId)
	{


			if ($eventoId>0 or $eventoId=='TODAS') {
				$usrval=new Usrval();
				$usrval->UsuarioId=$this->UsuariosId;
				$usrval->UsrTipId=2;
				$usrval->UsrSubTipId=4;
				$usrval->UsrValRef='evento.EventoId';
				$usrval->usrValIdRef=$eventoId;
				$usrval->UsrValRef2='funciones.FuncionesId';
				$usrval->usrValIdRef2='TODAS';
				if (!$usrval->existe) {
						$usrval->UsrValPrivId=$usrval->maxPrivId+1;
						return $usrval->save(false);
				}			

			}
				else return false;			
	}
	public function desasignarEvento($eventoId,$funcionesId)
	{
			if ($eventoId>0 or $eventoId=='TODAS') {
					return Usrval::model()->deleteAllByAttributes(array(
							'UsuarioId'=>$this->UsuariosId,
							'UsrTipId'=>2,
							'UsrSubTipId'=>4,
							'UsrValRef'=>'evento.EventoId',
							'UsrValRef2'=>'funciones.FuncionesId',
							'usrValIdRef'=>$eventoId,
							'usrValIdRef2'=>$funcionesId,
					));
			}	
	}
	public function getReportes($eventoId)
	{
			if ($eventoId>0 or $eventoId=="TODAS") {
					$query=sprintf("
							SELECT DISTINCT	t.UsrValMulId as id,  t.` usrValMulDes` as descripcion,ifnull(t2.UsrValPrivId,0) as estado,
									t1.UsrValPrivId,t1.UsrTipId,
									t1.UsrSubTipId FROM usrvalmul as t
					LEFT JOIN  usrval AS t1
						ON 	t1.UsuarioId=%d
						AND t1.UsrTipId=2
						AND t1.UsrSubTipId=4
						AND t1.usrValIdRef='%s'
					LEFT JOIN idvalopc AS t2 
						ON   t2.UsrTipId=t.UsrTip
						AND  t2.UsrSubTipId=t.UsrSubTip
						AND  t2.UsrValMulId=t.usrValMulId
						AND t1.UsrValPrivId=t2.UsrValPrivId
						AND  t2.UsuarioId=t1.UsuarioId
						",$this->UsuariosId,$eventoId);
					return new CSqlDataProvider($query);
			}	
			else  return null;
	}
	public function denegarReporte($pks=null)
	{
			if (!is_null($pks)) {
					if (
							array_key_exists('id',$pks) and
							array_key_exists('UsrValPrivId',$pks) and
							array_key_exists('UsrValMulId',$pks)
					) {
							try{
									$reporte=Idvalopc::model()->deleteAllByAttributes(array(
									'UsuarioId'=>$pks['id'],	
									'UsrValPrivId'=>$pks['UsrValPrivId'],
									'UsrTipId'=>2,
									'UsrSubTipId'=>4,
									'UsrValMulId'=>$pks['UsrValMulId'],
							));
									return $reporte;
							}
							catch(Exception $e){
									return $e;
							}
				}	
					return false;
			}	
	}
	public function autorizarReporte($pks=null)
	{
			if (!is_null($pks)) {
					if (
							array_key_exists('id',$pks) and
							array_key_exists('UsrValMulId',$pks)
					) {
							try{
									$usrval=Usrval::model()->findByAttributes(array(
											'UsuarioId'=>$pks['id'],
											'UsrTipId'=>2,
											'UsrSubTipId'=>4,
											'UsrValRef'=>'evento.EventoId',
											'usrValIdRef'=>$pks['eid']
									));
									if (is_object($usrval)){
											$reporte=new Idvalopc();
											$reporte->UsuarioId=$pks['id'];	
											$reporte->UsrValPrivId=$usrval->UsrValPrivId;
											$reporte->UsrTipId=2;
											$reporte->UsrSubTipId=4;
											$reporte->UsrValMulId=$pks['UsrValMulId'];
											return $reporte->save(false);
									}
									else{
											return false;
									}
							}
							catch(Exception $e){
									return $e;
							}
				}	
					return false;
			}	
	}
    public  function notificar($asunto,$mensaje){
// //     Envia una notificacion al usuario.
	  set_time_limit ( 0 );
	  ini_set('max_execution_time', 0);
  // 	$config=Yii::app()->getParams(false);
	  $message = new YiiMailMessage();
	  $message->setCharset('UTF8');
	  $message->setTo( $this->UsuariosEmail);
	  $message->setFrom('sistema@taquillacero.com');
	  $message->setSubject($asunto);
	  $message->setBody($mensaje, 'Text/HTML');
	  
	  return Yii::app()->mail->send($message) ? true : false;
      }
}
