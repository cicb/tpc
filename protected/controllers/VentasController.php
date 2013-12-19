<?php

class VentasController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
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
}