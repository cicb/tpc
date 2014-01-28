<?php

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
			array('UsuariosId, TipUsrId, UsuariosNom, UsuariosNick, UsuariosPass, UsuariosPasCon, UsuariosEmail,UsuariosStatus', 'required'),
			array('TipUsrId', 'numerical', 'integerOnly'=>true),
			array('UsuariosId, UsuariosTelMov, UsuariosGruId, UsuariosStatus', 'length', 'max'=>20),
			array('UsuariosNom, UsuariosNick, UsuariosPass, UsuariosPasCon', 'length', 'max'=>50),
			array('UsuariosCiu', 'length', 'max'=>30),
			array('UsuariosEmail, UsuariosRegion', 'length', 'max'=>200),
            array('UsuariosPass, UsuariosPasCon', 'required', 'on'=>'insert'),
            array('UsuariosPass, UsuariosPasCon', 'length', 'min'=>6,'max'=>40),

			array (
					'UsuarioPassCon',
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
			'UsuariosTelMov' => 'Tel. Mov',
			'UsuariosNot' => 'Nota',
			'UsuariosNick' => 'Nombre de usuario',
			'UsuariosPass' => 'Contraseña',
			'UsuariosPasCon' => 'Confirme contraseña',
			'UsuariosGruId' => 'Grupo',
			'UsuariosIma' => 'Imagen',
			'UsuariosInf' => 'Inf',
			'UsuariosEmail' => 'Email',
			'UsuariosRegion' => 'Region',
			'UsuariosStatus' => 'Status',
			'UsuariosVigencia' => 'Vigencia',
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
			'pagination'=>array('pageSize'=>20)
		));
	}
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
}
