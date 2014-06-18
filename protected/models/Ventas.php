<?php

/**
 * This is the model class for table "ventas".
 *
 * The followings are the available columns in table 'ventas':
 * @property string $VentasId
 * @property string $PuntosventaId
 * @property string $VentasSec
 * @property string $VentasNumTar
 * @property string $VentasFecHor
 * @property string $TempLugaresTipUsr
 * @property string $UsuariosId
 * @property string $VentasSta
 * @property string $VentasNomDerTar
 * @property string $VentasMesExpTar
 * @property string $VentasAniExpTar
 * @property string $VentasTip
 * @property string $VentasTipTar
 * @property string $VentasNumAut
 * @property string $VentasMonMetEnt
 * @property string $VentasNumRef
 * @property string $VentasBloq
 * @property string $VentasBloqDes
 */
class Ventas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ventas the static model class
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
		return 'ventas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('VentasId, PuntosventaId, VentasSec, VentasNumTar, VentasFecHor, TempLugaresTipUsr, UsuariosId, VentasSta, VentasNomDerTar, VentasMesExpTar, VentasAniExpTar, VentasTip, VentasTipTar, VentasNumAut, VentasMonMetEnt, VentasNumRef, VentasBloq, VentasBloqDes', 'required'),
			array('VentasId, PuntosventaId, VentasSec, UsuariosId, VentasSta, VentasMesExpTar, VentasAniExpTar, VentasTip, VentasTipTar, VentasNumAut, VentasMonMetEnt', 'length', 'max'=>20),
			array('VentasNumTar', 'length', 'max'=>19),
			array('TempLugaresTipUsr, VentasNomDerTar', 'length', 'max'=>150),
			array('VentasNumRef', 'length', 'max'=>30),
			array('VentasBloq', 'length', 'max'=>2),
			array('VentasBloqDes', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('VentasId, PuntosventaId, VentasSec, VentasNumTar, VentasFecHor, TempLugaresTipUsr, UsuariosId, VentasSta, VentasNomDerTar, VentasMesExpTar, VentasAniExpTar, VentasTip, VentasTipTar, VentasNumAut, VentasMonMetEnt, VentasNumRef, VentasBloq, VentasBloqDes', 'safe', 'on'=>'search'),
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
				'ventaslevel1' 	=> array(self::HAS_MANY, 	'Ventaslevel1', 'VentasId'),
				'puntoventa'	=> array(self::BELONGS_TO, 	'Puntosventa',	'PuntosventaId'),
				'total'			=> array(self::STAT,'Ventaslevel1','VentasId','select'=>'SUM(VentasCosBol+VentasCarSer-VentasMondes)', 'group'=>'VentasId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'VentasId' => 'Ventas',
			'PuntosventaId' => 'Puntosventa',
			'VentasSec' => 'Ventas Sec',
			'VentasNumTar' => 'Ventas Num Tar',
			'VentasFecHor' => 'Ventas Fec Hor',
			'TempLugaresTipUsr' => 'Temp Lugares Tip Usr',
			'UsuariosId' => 'Usuarios',
			'VentasSta' => 'Estatus',
			'VentasNomDerTar' => 'Ventas Nom Der Tar',
			'VentasMesExpTar' => 'Ventas Mes Exp Tar',
			'VentasAniExpTar' => 'Ventas Ani Exp Tar',
			'VentasTip' => 'Ventas Tip',
			'VentasTipTar' => 'Ventas Tip Tar',
			'VentasNumAut' => 'Ventas Num Aut',
			'VentasMonMetEnt' => 'Ventas Mon Met Ent',
			'VentasNumRef' => 'Ventas Num Ref',
			'VentasBloq' => 'Ventas Bloq',
			'VentasBloqDes' => 'Ventas Bloq Des',
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

		$criteria->compare('VentasId',$this->VentasId,true);
		$criteria->compare('PuntosventaId',$this->PuntosventaId,true);
		$criteria->compare('VentasSec',$this->VentasSec,true);
		$criteria->compare('VentasNumTar',$this->VentasNumTar,true);
		$criteria->compare('VentasFecHor',$this->VentasFecHor,true);
		$criteria->compare('TempLugaresTipUsr',$this->TempLugaresTipUsr,true);
		$criteria->compare('UsuariosId',$this->UsuariosId,true);
		$criteria->compare('VentasSta',$this->VentasSta,true);
		$criteria->compare('VentasNomDerTar',$this->VentasNomDerTar,true);
		$criteria->compare('VentasMesExpTar',$this->VentasMesExpTar,true);
		$criteria->compare('VentasAniExpTar',$this->VentasAniExpTar,true);
		$criteria->compare('VentasTip',$this->VentasTip,true);
		$criteria->compare('VentasTipTar',$this->VentasTipTar,true);
		$criteria->compare('VentasNumAut',$this->VentasNumAut,true);
		$criteria->compare('VentasMonMetEnt',$this->VentasMonMetEnt,true);
		$criteria->compare('VentasNumRef',$this->VentasNumRef,true);
		$criteria->compare('VentasBloq',$this->VentasBloq,true);
		$criteria->compare('VentasBloqDes',$this->VentasBloqDes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
	public function getTarjeta()
	{
			return 'XXXX-XXXX-XXXX-'.substr($this->VentasNumTar,-4);
	}
    public function getTotalVentasMiasNormal($id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT  ventas.UsuariosId id,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
                                             funciones.FuncionesId,  funciones.funcionesTexto,  ventaslevel1.DescuentosId,
                                             COUNT(ventaslevel1.LugaresId) as cantidad,
                                             SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer-ventaslevel1.VentasMonDes) AS total
                                             FROM ventaslevel1
                                             INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                             INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                             INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                             AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                             WHERE
                                             (ventas.UsuariosId = '$id') AND
                                             (ventaslevel1.VentasSta = 'VENDIDO') AND
                                             (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                             (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
    	  return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
        
    }
    public function getTotalVentasMiasNormalDesc($id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT  ventas.UsuariosId id,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
                                             funciones.FuncionesId,  funciones.funcionesTexto,  ventaslevel1.DescuentosId,
                                             COUNT(ventaslevel1.LugaresId) as cantidad,
                                             SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer-ventaslevel1.VentasMonDes) AS total
                                             FROM ventaslevel1
                                             INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                             INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                             INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                             AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                             WHERE
                                             (ventas.UsuariosId = '$id') AND
                                             (ventaslevel1.VentasSta = 'VENDIDO') AND
                                             (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                             ventaslevel1.DescuentosId <> 0 AND
                                             (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
    	  return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
        
    }
    public function getTotalBoletosDuros($id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT  ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
                                             funciones.FuncionesId,  funciones.funcionesTexto, 
                                             COUNT(ventaslevel1.LugaresId) as cantidad,
                                             SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer - ventaslevel1.VentasMonDes) AS total
                                             FROM ventaslevel1
                                             INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                             INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                             INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                             AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                             WHERE
                                             (ventas.UsuariosId = '$id') AND
                                             (ventaslevel1.VentasSta = 'VENDIDO') AND
                                             (ventaslevel1.VentasBolTip = 'BOLETO DURO') AND
                                             (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
       return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));                                      
    }
    public function getTotalVentasNormalSinDescuento($id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT  ventas.UsuariosId,  ventas.PuntosventaId,  evento.EventoNom,  evento.EventoId,
                                            funciones.FuncionesId,  funciones.funcionesTexto, 
                                            COUNT(ventaslevel1.LugaresId) as cantidad,  ventaslevel1.DescuentosId,
                                            SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer - ventaslevel1.VentasMonDes) AS total
                                            FROM ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                            INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                            AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                            WHERE
                                            (ventas.UsuariosId = '$id') AND
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')                                                                                                                                    
                                            GROUP BY ventaslevel1.EventoId, funciones.FuncionesId")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalTipo($id,$desde,$hasta,$eventoId="",$funcionId="",$tipo=""){
        $query = "";
        if($eventoId!="" AND $funcionId!="")
            $query ="(ventaslevel1.EventoId ='$eventoId') AND (ventaslevel1.FuncionesId='$funcionId') AND";
            
        $data=Yii::app()->db->createCommand("SELECT ventaslevel1.VentasCarSer,
                                            (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as VentasCosBol, 
                                            COUNT(ventaslevel1.LugaresId) as cantidad,
                                            SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) AS VentasCosBolT,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT,
                                            SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
                                            FROM ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                            INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                            AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                            WHERE
                                            $query
                                            (ventas.UsuariosId = '$id') AND
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = '$tipo') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalTipoIndividual($id,$desde,$hasta,$eventoId="",$funcionId="",$tipo){
        $query = "";
        if($eventoId!="" AND $funcionId!="")
            $query ="(ventaslevel1.EventoId ='$eventoId') AND (ventaslevel1.FuncionesId='$funcionId') AND";
            
        $data=Yii::app()->db->createCommand("SELECT zonas.ZonasAli,zonas.ZonasId,
                                            ventaslevel1.EventoId,ventaslevel1.FuncionesId,
                                            (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as VentasCosBol,ventaslevel1.VentasCarSer,
                                            COUNT(ventaslevel1.LugaresId) as cantidad,
                                            SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) AS VentasCosBolT,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT,
                                            SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total 
                                            FROM ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                            INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                            AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                            INNER JOIN zonas ON zonas.EventoId= evento.EventoId AND zonas.FuncionesId=funciones.FuncionesId and zonas.ZonasId=ventaslevel1.ZonasId
                                            WHERE
                                            $query
                                            (ventas.UsuariosId = '$id') AND
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = '$tipo') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')
                                            GROUP BY ventaslevel1.EventoId,ventaslevel1.FuncionesId,ventaslevel1.ZonasId")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalBoletos($id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT   ventas.VentasTip, ventaslevel1.VentasBolTip,
                                             if (ventaslevel1.DescuentosId > '0', 'SI', 'NO') AS DESCUENTO, COUNT(ventaslevel1.VentasId) as cantidad,
                                             SUM(ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes) AS VentasCosBol,
                                             SUM(ventaslevel1.VentasCarSer) AS VentasCarSer
                                             FROM
                                             ventaslevel1
                                             INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                             INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                             INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                             AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                             WHERE
                                             (ventas.UsuariosId = '$id') AND
                                             (ventaslevel1.VentasSta = 'VENDIDO') and
                                             (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')     
                                             GROUP BY ventaslevel1.VentasBolTip,
                                             if (ventaslevel1.DescuentosId > '0', 'DESCUENTO', 'NORMAL')")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalBoletosCancelados($id,$desde,$hasta,$eventoId="",$funcionId=""){
        $query = "";
        if($eventoId!="" AND $funcionId!="")
            $query ="(ventaslevel1.EventoId ='$eventoId') AND (ventaslevel1.FuncionesId='$funcionId') AND";
        
         $data=Yii::app()->db->createCommand("SELECT  '$id' as UsuariosId,
                                              evento.EventoNom,  evento.EventoId,
                                              funciones.FuncionesId,  funciones.funcionesTexto, 
                                              COUNT(ventaslevel1.LugaresId) as cantidad,
                                              SUM(ventaslevel1.VentasCosBol + ventaslevel1.VentasCarSer) AS total
                                              FROM ventaslevel1
                                              INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                              INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                              INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                              AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                              WHERE
                                              $query
                                              (ventaslevel1.CancelUsuarioId = '$id') AND
                                              (ventaslevel1.VentasSta = 'CANCELADO') AND
                                              (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalVentas($id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT   ventas.VentasTip,
                                            SUM(ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes) AS VentasCosBol,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSer
                                            FROM
                                            ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                            INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                            AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                            WHERE
                                            (ventas.UsuariosId = '$id') AND
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            ventas.VentasTip = 'EFECTIVO' AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalVentasVisaMaster($id,$desde,$hasta,$eventoId="",$funcionId=""){
        $query = "";
        if($eventoId!="" AND $funcionId!="")
            $query ="(ventaslevel1.EventoId ='$eventoId') AND (ventaslevel1.FuncionesId='$funcionId') AND";
            
        $data=Yii::app()->db->createCommand("SELECT   ventas.VentasTip,
                                            SUM(ventaslevel1.VentasCosBol+ventaslevel1.VentasCarSer-ventaslevel1.VentasMonDes) AS total,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSer
                                            FROM
                                            ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                            INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                            AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                            WHERE
                                            $query
                                            (ventas.UsuariosId = '$id') AND
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            VentasTip='TARJETA' AND VentasTipTar IN('MC','VC') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalVentasAmerican($id,$desde,$hasta,$eventoId="",$funcionId=""){
        $query = "";
        if($eventoId!="" AND $funcionId!="")
            $query ="(ventaslevel1.EventoId ='$eventoId') AND (ventaslevel1.FuncionesId='$funcionId') AND";
            
        $data=Yii::app()->db->createCommand("SELECT   ventas.VentasTip,
                                            SUM(ventaslevel1.VentasCosBol+ventaslevel1.VentasCarSer-ventaslevel1.VentasMonDes) AS total,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSer
                                            FROM
                                            ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                            INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                            AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                            WHERE
                                            $query
                                            (ventas.UsuariosId = '$id') AND
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            VentasTip='TARJETA' AND VentasTipTar NOT IN('MC','VC','','NORMAL') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalVentasTerminal($id,$desde,$hasta,$eventoId="",$funcionId=""){
        $query = "";
        if($eventoId!="" AND $funcionId!="")
            $query ="(ventaslevel1.EventoId ='$eventoId') AND (ventaslevel1.FuncionesId='$funcionId') AND";
            
        $data=Yii::app()->db->createCommand("SELECT   ventas.VentasTip,
                                            SUM(ventaslevel1.VentasCosBol+ventaslevel1.VentasCarSer-ventaslevel1.VentasMonDes) AS total,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSer
                                            FROM
                                            ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                            INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                            AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                            WHERE
                                            $query
                                            (ventas.UsuariosId = '$id') AND
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            VentasTip='TERMINAL' AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getVentasDetalleIndividual($eventoId,$funcionId,$zonaId,$usuarioId,$desde,$hasta,$descuentoId){
        $data=Yii::app()->db->createCommand("SELECT  ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
                                             zonas.ZonasAli,  ventaslevel1.LugaresId,  ventas.VentasTip,
                                             ventaslevel1.VentasBolTip,  ventaslevel1.CancelUsuarioId,
                                             ventaslevel1.CancelFecHor, lugares.LugaresLug, filas.FilasAli,
                                             ventas.VentasFecHor, descuentos.DescuentosDes,
                                             (SELECT (COUNT(reimpresiones.ReimpresionesId) - 1) AS reimpresiones
                                             FROM   reimpresiones
                                             WHERE (reimpresiones.EventoId = ventaslevel1.EventoId) AND
                                             (reimpresiones.FuncionesId = ventaslevel1.FuncionesId) AND
                                             (reimpresiones.ZonasId = ventaslevel1.ZonasId) AND
                                             (reimpresiones.SubzonaId = ventaslevel1.SubzonaId) AND
                                             (reimpresiones.FilasId = ventaslevel1.FilasId) AND
                                             (reimpresiones.LugaresId = ventaslevel1.LugaresId)
                                             GROUP BY  reimpresiones.EventoId,
                                             reimpresiones.FuncionesId,
                                             reimpresiones.ZonasId,
                                             reimpresiones.SubzonaId,
                                             reimpresiones.FilasId,
                                             reimpresiones.LugaresId) AS reimpresiones
                                             FROM ventaslevel1
                                             INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                             INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
                                             AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
                                             AND (ventaslevel1.ZonasId=zonas.ZonasId)
                                             INNER JOIN lugares ON (ventaslevel1.EventoId=lugares.EventoId)
                                             AND (ventaslevel1.FuncionesId=lugares.FuncionesId)
                                             AND (ventaslevel1.ZonasId=lugares.ZonasId)
                                             AND (ventaslevel1.SubzonaId=lugares.SubzonaId)
                                             AND (ventaslevel1.FilasId=lugares.FilasId)
                                             AND (ventaslevel1.LugaresId=lugares.LugaresId)
                                             INNER JOIN filas ON (lugares.EventoId=filas.EventoId)
                                             AND (lugares.FuncionesId=filas.FuncionesId)
                                             AND (lugares.ZonasId=filas.ZonasId)
                                             AND (lugares.SubzonaId=filas.SubzonaId)
                                             AND (lugares.FilasId=filas.FilasId)
                                             INNER JOIN descuentos ON (descuentos.DescuentosId = ventaslevel1.DescuentosId)
                                             WHERE
                                             (ventaslevel1.EventoId = '$eventoId') AND
                                             (ventaslevel1.FuncionesId = '$funcionId') AND
                                             (ventaslevel1.ZonasId = '$zonaId') AND
                                             (ventas.VentasSta = 'FIN') AND
                                             (ventas.UsuariosId = '$usuarioId') AND
                                             (ventaslevel1.VentasSta = 'VENDIDO') AND
                                             (ventaslevel1.VentasBolTip = 'NORMAL') AND ventaslevel1.DescuentosId =$descuentoId AND
                                             (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00') ")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
     public function getVentasDetalleIndividualTipo($eventoId,$funcionId,$zonaId,$usuarioId,$desde,$hasta,$tipo){
        $data=Yii::app()->db->createCommand("SELECT  ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
                                             zonas.ZonasAli,  ventaslevel1.LugaresId,  ventas.VentasTip,
                                             ventaslevel1.VentasBolTip,  ventaslevel1.CancelUsuarioId,
                                             ventaslevel1.CancelFecHor, lugares.LugaresLug, filas.FilasAli,
                                             ventas.VentasFecHor, descuentos.DescuentosDes,
                                             (SELECT (COUNT(reimpresiones.ReimpresionesId) - 1) AS reimpresiones
                                             FROM   reimpresiones
                                             WHERE (reimpresiones.EventoId = ventaslevel1.EventoId) AND
                                             (reimpresiones.FuncionesId = ventaslevel1.FuncionesId) AND
                                             (reimpresiones.ZonasId = ventaslevel1.ZonasId) AND
                                             (reimpresiones.SubzonaId = ventaslevel1.SubzonaId) AND
                                             (reimpresiones.FilasId = ventaslevel1.FilasId) AND
                                             (reimpresiones.LugaresId = ventaslevel1.LugaresId)
                                             GROUP BY  reimpresiones.EventoId,
                                             reimpresiones.FuncionesId,
                                             reimpresiones.ZonasId,
                                             reimpresiones.SubzonaId,
                                             reimpresiones.FilasId,
                                             reimpresiones.LugaresId) AS reimpresiones
                                             FROM ventaslevel1
                                             INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                             INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
                                             AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
                                             AND (ventaslevel1.ZonasId=zonas.ZonasId)
                                             INNER JOIN lugares ON (ventaslevel1.EventoId=lugares.EventoId)
                                             AND (ventaslevel1.FuncionesId=lugares.FuncionesId)
                                             AND (ventaslevel1.ZonasId=lugares.ZonasId)
                                             AND (ventaslevel1.SubzonaId=lugares.SubzonaId)
                                             AND (ventaslevel1.FilasId=lugares.FilasId)
                                             AND (ventaslevel1.LugaresId=lugares.LugaresId)
                                             INNER JOIN filas ON (lugares.EventoId=filas.EventoId)
                                             AND (lugares.FuncionesId=filas.FuncionesId)
                                             AND (lugares.ZonasId=filas.ZonasId)
                                             AND (lugares.SubzonaId=filas.SubzonaId)
                                             AND (lugares.FilasId=filas.FilasId)
                                             INNER JOIN descuentos ON (descuentos.DescuentosId = ventaslevel1.DescuentosId)
                                             WHERE
                                             (ventaslevel1.EventoId = '$eventoId') AND
                                             (ventaslevel1.FuncionesId = '$funcionId') AND
                                             (ventaslevel1.ZonasId = '$zonaId') AND
                                             (ventas.VentasSta = 'FIN') AND
                                             (ventas.UsuariosId = '$usuarioId') AND
                                             (ventaslevel1.VentasSta = 'VENDIDO') AND
                                             (ventaslevel1.VentasBolTip = '$tipo') AND
                                             (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00') ")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getEventos($id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT evento.EventoNom, evento.EventoId, funciones.FuncionesId, funciones.funcionesTexto
                                             FROM ventaslevel1
                                             INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                             INNER JOIN evento ON (evento.EventoId=ventaslevel1.EventoId)
                                             INNER JOIN funciones ON (funciones.EventoId=evento.EventoId)
                                             AND (funciones.FuncionesId=ventaslevel1.FuncionesId)
                                             WHERE
                                             (ventas.UsuariosId = '$id') AND
                                             (ventaslevel1.VentasSta = 'VENDIDO') AND
                                             (ventaslevel1.VentasBolTip IN( 'CORTESIA','NORMAL')) AND
                                             (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00')     
                                             GROUP BY ventaslevel1.EventoId, funciones.FuncionesId
                                             ORDER BY EventoId DESC ")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getVentasDetallePorZona($eventoId,$funcionId,$id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
                                            if(ventaslevel1.VentasMonDes = 0, zonas.ZonasAli, descuentos.DescuentosDes) AS ZonasAli, count(ventaslevel1.LugaresId) AS cantidad,
                                            SUM(ventaslevel1.VentasMonDes) AS descuento,
                                            if(ventaslevel1.VentasBolTip = 'BOLETO DURO', 'NINGUNO', ventas.VentasTip) AS VentasTip, ventaslevel1.VentasBolTip,
                                            (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as VentasCosBol, ventaslevel1.VentasCarSer,
                                            SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) AS VentasCosBolT,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT
                                            FROM ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
                                            AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
                                            AND (ventaslevel1.ZonasId=zonas.ZonasId)
                                            INNER JOIN descuentos ON descuentos.DescuentosId = ventaslevel1.DescuentosId
                                            WHERE (ventaslevel1.EventoId = '$eventoId') AND
                                            (ventaslevel1.FuncionesId = '$funcionId') AND
                                            (ventas.VentasSta = 'FIN') AND
                                            (ventas.UsuariosId = '$id') AND 
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00') 
                                            GROUP BY
                                            ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId, zonas.ZonasAli, ventaslevel1.DescuentosId")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getVentasDetallePorZonaIndividual($eventoId,$funcionId,$id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT ventaslevel1.DescuentosId,ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
                                            if(ventaslevel1.VentasMonDes = 0, zonas.ZonasAli, CONCAT(zonas.ZonasAli,' ',descuentos.DescuentosDes )) AS ZonasAli, count(ventaslevel1.LugaresId) AS cantidad,
                                            SUM(ventaslevel1.VentasMonDes) AS descuento,
                                            if(ventaslevel1.VentasBolTip = 'BOLETO DURO', 'NINGUNO', ventas.VentasTip) AS VentasTip, ventaslevel1.VentasBolTip,
                                            (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as VentasCosBol, ventaslevel1.VentasCarSer,
                                            SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) AS VentasCosBolT,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT
                                            FROM ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
                                            AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
                                            AND (ventaslevel1.ZonasId=zonas.ZonasId)
                                            INNER JOIN descuentos ON descuentos.DescuentosId = ventaslevel1.DescuentosId
                                            WHERE (ventaslevel1.EventoId = '$eventoId') AND
                                            (ventaslevel1.FuncionesId = '$funcionId') AND
                                            (ventas.VentasSta = 'FIN') AND
                                            (ventas.UsuariosId = '$id') AND 
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00') 
                                            GROUP BY
                                            ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId, zonas.ZonasAli, ventaslevel1.DescuentosId")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalEfectivo($eventoId,$funcionId,$id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT 
                                            SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) AS VentasCosBolT,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT 
                                            FROM ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
                                            AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
                                            AND (ventaslevel1.ZonasId=zonas.ZonasId)
                                            INNER JOIN descuentos ON descuentos.DescuentosId = ventaslevel1.DescuentosId
                                            WHERE (ventaslevel1.EventoId = '$eventoId') AND
                                            (ventaslevel1.FuncionesId = '$funcionId') AND
                                            (ventas.VentasSta = 'FIN') AND
                                            (ventas.UsuariosId = '$id') AND 
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            ventas.VentasTip = 'EFECTIVO' AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00') 
                                            ")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
    public function getTotalIndividual($eventoId,$funcionId,$id,$desde,$hasta){
        $data=Yii::app()->db->createCommand("SELECT ventaslevel1.EventoId, ventaslevel1.FuncionesId, ventaslevel1.ZonasId,
                                            zonas.ZonasAli, count(ventaslevel1.LugaresId) AS cantidad,
                                            SUM(ventaslevel1.VentasMonDes) AS descuento,
                                            if(ventaslevel1.VentasBolTip = 'BOLETO DURO', 'NINGUNO', ventas.VentasTip) AS VentasTip, ventaslevel1.VentasBolTip,
                                            (ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) as VentasCosBol, ventaslevel1.VentasCarSer,
                                            SUM(ventaslevel1.VentasCosBol - ventaslevel1.VentasMonDes) AS VentasCosBolT,
                                            SUM(ventaslevel1.VentasCarSer) AS VentasCarSerT
                                            FROM ventaslevel1
                                            INNER JOIN ventas ON (ventaslevel1.VentasId=ventas.VentasId)
                                            INNER JOIN zonas ON (ventaslevel1.EventoId=zonas.EventoId)
                                            AND (ventaslevel1.FuncionesId=zonas.FuncionesId)
                                            AND (ventaslevel1.ZonasId=zonas.ZonasId)
                                            INNER JOIN descuentos ON descuentos.DescuentosId = ventaslevel1.DescuentosId
                                            WHERE (ventaslevel1.EventoId = '$eventoId') AND
                                            (ventaslevel1.FuncionesId = '$funcionId') AND
                                            (ventas.VentasSta = 'FIN') AND
                                            (ventas.UsuariosId = '$id') AND 
                                            (ventaslevel1.VentasSta = 'VENDIDO') AND
                                            (ventaslevel1.VentasBolTip = 'NORMAL') AND
                                            (ventas.VentasFecHor BETWEEN '$desde 00:00:00' AND '$hasta 23:59:00') 
                                            GROUP BY
                                            ventaslevel1.EventoId, ventaslevel1.FuncionesId")->queryAll();
        return new CArrayDataProvider($data, array(
                            'pagination'=>false,
			));
    }
}
