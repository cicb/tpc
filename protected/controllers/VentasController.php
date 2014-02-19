<?php

class VentasController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function validarUsuario(){
			if(Yii::app()->user->isGuest OR !Yii::app()->user->getState("Admin")){
			$this->redirect(array("site/logout"));
		}
	}
	public function validarAjax()
	{
		if (!Yii::app()->request->isAjaxRequest) {
				throw new CHttpException ( 404, 'Petición incorrecta.' );
		}	
	}
    public function actionReimpresionBoletos(){
        $region = null;
        $dataProvider = null;
        if(!empty($_POST['evento_id'])){
            $user = Usuarios::model()->findByAttributes(array('UsuariosId'=>Yii::app()->user->id));
            $region = $user->UsuariosRegion;
            $eventoId = $_POST['evento_id'];
            $funciones = empty($_POST['funciones_id'])?"":" AND funciones.FuncionesId = ".$_POST['funciones_id'];
            //echo "<br/><br/><br/>";
            //print_r($_POST);
            $count = Yii::app()->db->createCommand("select subzona.SubzonaAcc, zonas.ZonasAli, filas.FilasAli, lugares.LugaresLug, ventaslevel1.VentasBolTip, 
            (ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes) as costbol, ventaslevel1.VentasCarSer, evento.EventoImaBol, ventaslevel1.LugaresNumBol,
            evento.EventoDesBol, evento.EventoNom,foro.ForoNom, funciones.funcionesTexto, ventaslevel1.VentasCon
            from ventaslevel1 
            inner join ventas on ventas.VentasId=ventaslevel1.VentasId and PuntosventaId=101
            inner join evento on evento.EventoId=ventaslevel1.EventoId and evento.EventoId=$eventoId
            inner join funciones on funciones.EventoId=ventaslevel1.EventoId and funciones.FuncionesId=ventaslevel1.FuncionesId
            inner join foro on foro.ForoId=funciones.ForoId
            inner join zonas on zonas.EventoId=ventaslevel1.EventoId and zonas.FuncionesId=ventaslevel1.FuncionesId and zonas.ZonasId=ventaslevel1.ZonasId
            inner join subzona on subzona.EventoId=ventaslevel1.EventoId and subzona.FuncionesId=ventaslevel1.FuncionesId and subzona.ZonasId=ventaslevel1.ZonasId and subzona.SubzonaId=ventaslevel1.SubzonaId
            inner join filas on filas.EventoId=ventaslevel1.EventoId and filas.FuncionesId=ventaslevel1.FuncionesId and filas.ZonasId=ventaslevel1.ZonasId and filas.SubzonaId=ventaslevel1.SubzonaId and filas.FilasId=ventaslevel1.FilasId
            inner join lugares on lugares.EventoId=ventaslevel1.EventoId and lugares.FuncionesId=ventaslevel1.FuncionesId and lugares.ZonasId=ventaslevel1.ZonasId and lugares.SubzonaId=ventaslevel1.SubzonaId and lugares.FilasId=ventaslevel1.FilasId and lugares.LugaresId=ventaslevel1.LugaresId
            INNER JOIN cruge_user ON (cruge_user.iduser=ventas.UsuariosId)
            where ventaslevel1.VentasSta not like '%CANCELADO%' $funciones")->execute();
           $query = "select '' as id,cruge_user.email,ventas.VentasNumRef,ventas.VentasFecHor,ventaslevel1.VentasCon, subzona.SubzonaAcc, zonas.ZonasAli, filas.FilasAli, lugares.LugaresLug, ventaslevel1.VentasBolTip, 
                        (ventaslevel1.VentasCosBol-ventaslevel1.VentasMonDes) as costbol, ventaslevel1.VentasCarSer, evento.EventoImaBol, ventaslevel1.LugaresNumBol,
                        evento.EventoDesBol, evento.EventoNom,foro.ForoNom, funciones.funcionesTexto, ventaslevel1.VentasCon
                        from ventaslevel1 
                        inner join ventas on ventas.VentasId=ventaslevel1.VentasId and PuntosventaId=101
                        inner join evento on evento.EventoId=ventaslevel1.EventoId and evento.EventoId=$eventoId
                        inner join funciones on funciones.EventoId=ventaslevel1.EventoId and funciones.FuncionesId=ventaslevel1.FuncionesId
                        inner join foro on foro.ForoId=funciones.ForoId
                        inner join zonas on zonas.EventoId=ventaslevel1.EventoId and zonas.FuncionesId=ventaslevel1.FuncionesId and zonas.ZonasId=ventaslevel1.ZonasId
                        inner join subzona on subzona.EventoId=ventaslevel1.EventoId and subzona.FuncionesId=ventaslevel1.FuncionesId and subzona.ZonasId=ventaslevel1.ZonasId and subzona.SubzonaId=ventaslevel1.SubzonaId
                        inner join filas on filas.EventoId=ventaslevel1.EventoId and filas.FuncionesId=ventaslevel1.FuncionesId and filas.ZonasId=ventaslevel1.ZonasId and filas.SubzonaId=ventaslevel1.SubzonaId and filas.FilasId=ventaslevel1.FilasId
                        inner join lugares on lugares.EventoId=ventaslevel1.EventoId and lugares.FuncionesId=ventaslevel1.FuncionesId and lugares.ZonasId=ventaslevel1.ZonasId and lugares.SubzonaId=ventaslevel1.SubzonaId and lugares.FilasId=ventaslevel1.FilasId and lugares.LugaresId=ventaslevel1.LugaresId
                        INNER JOIN cruge_user ON (cruge_user.iduser=ventas.UsuariosId)
                        where ventaslevel1.VentasSta not like '%CANCELADO%' $funciones";
                    $dataProvider =  new CSqlDataProvider($query, array(
							'totalItemCount'=>$count,//$count,	
							'pagination'=>array('pageSize'=>15),
					));        
        }
        $this->render('reimpresionboletos',array('data'=>$dataProvider,'region'=>$region));
        
    }

		public function actionDetallarVenta()
		{
			$ventaId=isset($_GET['venta_id'])?$_GET['venta_id']:0;
			$model=new ReportesVentas;
			$this->render('detalle',array('model'=>$model,'ventaId'=>$ventaId));
		}

		public function actionNotificar()
		{
			if (isset($_GET['uid'],$_GET['eid'],$_GET['tipo'],$_GET['token'])) {
				if ($_GET['uid']>0 and $_GET['eid']>0 and $_GET['token']==hash('crc32b',round(time()*.01)) ) {
						$admin=Usuarios::model()->findByAttributes(array('UsuariosId'=>57));
						$admin1=Usuarios::model()->findByAttributes(array('UsuariosId'=>17));
						$evento=Evento::model()->findByPk($_GET['eid']);
						$usuario=Usuarios::model()->findByAttributes(array('UsuariosId'=>$_GET['uid']));
						$texto=	sprintf("
								<div style='background:#d35400;color:#FFF;width:500px;display:block;padding:5px;margin:auto'> 
								<h2>Aviso de %s </h2>
								<div style='background:#fff;color:#2c3e50;padding:7px;'>
								El usuario %s ha hecho una %s en el evento %s el día %s.<br/>
								<br /><p style='color:#95a5a6'>
								Ésta es una notificación automatica generada por el sistema, por favor no reponda a esta dirección.
								</p>
								</div>
								</div>
								",$_GET['tipo'],$usuario->UsuariosNom,
								strtoupper($_GET['tipo']), $evento->EventoNom,date('d/m Y H:i:s')
					   	);
						echo $admin->notificar('Taquillacero/Punto de venta :: Se ha realizado una '.$_GET['tipo'],$texto)?1:0;
						echo $admin1->notificar('Taquillacero/Punto de venta :: Se ha realizado una '.$_GET['tipo'],$texto)?1:0;
						
				}else echo 0;	

			}	else echo 0;
		}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
		public function actionHistorialBoleto()
		{
		//El Id que recibe debe ser una expresion regular formada por el eventoid la funcionid la zonaid la subzonaid la filaid y el lugarid
				$this->validarUsuario();
				$this->validarAjax();
			if (isset($_GET['id']) and preg_match("(\d{2,}-\d{1,}-\d{1,}-\d{1,}-\d{1,}-\d{1,})",$_GET['id'])==1) {
					$ids=explode('-',$_GET['id']);//Contiene todas las id en un arreglo
					$eventoId=$ids[0];
					$funcionesId=$ids[1];
					$zonasId=$ids[2];
					$subzonaId=$ids[3];
					$filasId=$ids[4];
					$lugaresId=$ids[5];
				$model=new ReportesVentas;
				$this->renderPartial('_historialBoleto',compact('eventoId','funcionesId','zonasId','subzonaId','filasId','lugaresId','model'));

			}	
		}
}
