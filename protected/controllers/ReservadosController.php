<?php

class ReservadosController extends Controller
{
	public function actionIndex()
	{
        $model=new Lugares;
        
        if(Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->request->baseUrl);

        if(isset($_POST['Lugares']))
        {
            $evento = $_POST[evento_id];
            $funcion = $_POST[funcion_id];
            $zona = $_POST[zona_id];
            $fila = $_POST[Lugares][filas];
            $asiento = $_POST[Lugares][lugares];
        } 
        else
            $evento = '******';
        $dataProvider = new CActiveDataProvider('Lugares', 
                                array('criteria'=>array(
                'select'   =>" 
                    templugares.TempLugaresFecHor,
                    lugares.LugaresStatus,
                    zonas.ZonasAli,
                    filas.FilasAli,
                    lugares.LugaresLug,
                    templugares.DescuentosId,
                    descuentos.DescuentosDes,
                    templugares.UsuariosId,
                    lugares.EventoId,
                    lugares.FuncionesId,
                    lugares.ZonasId,
                    lugares.SubzonaId,
                    lugares.FilasId,
                    lugares.LugaresId,
                    if(templugares.TempLugaresTipUsr = 'usuarios',(SELECT usuarios.UsuariosNom FROM usuarios WHERE UsuariosId = templugares.UsuariosId), if((SELECT clientes.ClientesNom FROM logonline INNER JOIN templugares temp ON temp.TempLugaresClaVis = logonline.IdClaveVisita INNER JOIN clientes ON clientes.ClientesId = logonline.idUsuario where temp.EventoId = templugares.EventoId and temp.FuncionesId = templugares.FuncionesId AND temp.ZonasId = templugares.ZonasId and temp.SubzonaId = templugares.SubzonaId AND temp.FilasId = templugares.FilasId and temp.LugaresId = templugares.LugaresId and templugares.TempLugaresClaVis = temp.TempLugaresClaVis) is null, 'no logeado',(SELECT clientes.ClientesNom FROM logonline INNER JOIN templugares temp ON temp.TempLugaresClaVis = logonline.IdClaveVisita INNER JOIN clientes ON clientes.ClientesId = logonline.idUsuario where temp.EventoId = templugares.EventoId and temp.FuncionesId = templugares.FuncionesId AND temp.ZonasId = templugares.ZonasId and temp.SubzonaId = templugares.SubzonaId AND temp.FilasId = templugares.FilasId and temp.LugaresId = templugares.LugaresId and templugares.TempLugaresClaVis = temp.TempLugaresClaVis))) AS quienvende
", 
                'alias'=>'lugares',
                'join'=>"LEFT OUTER JOIN templugares ON (lugares.EventoId = templugares.EventoId)
                          AND (templugares.FuncionesId = lugares.FuncionesId)
                          AND (lugares.ZonasId = templugares.ZonasId)
                          AND (templugares.SubzonaId = lugares.SubzonaId)
                          AND (lugares.FilasId = templugares.FilasId)
                          AND (templugares.LugaresId = lugares.LugaresId)
                          LEFT OUTER JOIN descuentos ON (descuentos.DescuentosId = templugares.DescuentosId)
                          LEFT OUTER JOIN filas ON (filas.EventoId = lugares.EventoId)
                          AND (filas.ZonasId = lugares.ZonasId)
                          AND (filas.SubzonaId = lugares.SubzonaId)
                          AND (filas.FuncionesId = lugares.FuncionesId)
                          AND (filas.FilasId = lugares.FilasId)
                          LEFT OUTER JOIN zonas ON (zonas.EventoId = filas.EventoId)
                          AND (zonas.FuncionesId = filas.FuncionesId)
                          AND (zonas.ZonasId = filas.ZonasId)
",
                  'condition'=>"
                  lugares.EventoId = '$evento' AND lugares.ZonasId = '$zona' AND filas.FilasAli LIKE '%$fila%' AND lugares.LugaresLug LIKE '%$asiento%' AND lugares.LugaresStatus != 'OFF'",
                  //'order'=>'lugares.FilasId, lugares.LugaresLug, ventas.VentasFecHor',
                    'limit'=>'150'),
                    'pagination'=>false));    

        $this->render('index',array('model'=>$model, 'dataProvider'=>$dataProvider));
	
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