<?php $this->widget( 'ext.EChosen.EChosen', array(
  'target' => 'select',
)); ?>
<div class="controles">
    <h1>Cortes Diarios</h1>
    <div id="cargador"  style="position:absolute; width:40px; height:40px;left:30%; top:150px; border:0px; margin-left:-40px; margin-top:-40px;" >
    </div>
    <div class="form">
    
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
       'id'=>'usuarios-form',
       //'action'=>$this->createUrl('/asiento/main'),
       //'htmlOptions'=>array('target'=>'gridFrame'),
       'enableAjaxValidation'=>false,
       'clientOptions' => array('validateOnSubmit' => false)
    ));
    
    ?>
    <div class='span4' style="float:none;display:block;margin:auto;">
            <div class="row">
                Taquilleros:
                <?php
                $verTodos = @$_POST['ver_usuarios']=='todos' ?"":"AND UsuariosStatus <> 'INACTIVO' AND  UsuariosStatus <> 'BAJA'  AND UsuariosStatus <> ''";
                $modeloUsuarios = Usuarios::model()->findAll(array('condition' => "TipUsrId IN(1,3) $verTodos",'order'=>'	UsuariosNom'));
                $listusr = CHtml::listData($modeloUsuarios,'UsuariosId','UsuariosNom');
                echo CHtml::dropDownList('usuario_id',@$_POST['usuario_id'],$listusr);
                ?>
                <input type="hidden" name="ver_usuarios" id="ver-usuarios" value="<?php echo @$_POST['ver_usuarios'];?>"/>
                <a class="btn btn-info" href="#" id="ver-todos-usuarios" style="margin-top: -20px;">Ver Todos</a>
        	</div>
            <div class="row">
            Desde:
             <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(          
                      'name'=>'desde',
                      'value'=>empty($_POST['desde'])?date('Y-m-d'):$_POST['desde'],
                      'attribute'=>'fecha_revision',  
                      'language' => 'es',             
                      'htmlOptions' => array(         
                                    'readonly'=> 'readonly',
                        ),
                      'options'=>array(                  
                        'defaultDate'=>'date("Y-m-d")', 
                        'autoSize'=>false,
                        'dateFormat'=>'yy-mm-dd',       
                        'selectOtherMonths'=>true,      
                        'showAnim'=>'fade',            
                        'showButtonPanel'=>false,       
                        'showOn'=>'focus',             
                        'showOtherMonths'=>true,        
                        'changeMonth' => true,          
                        'changeYear' => true,
                        'minDate'=>'2010-01-01', //fec\ha minima
                        'maxDate'=>"+1Y", //fecha maxima
                        ),
                      )
                );
                ?> 
                <span class='fa fa-2x fa-calendar text-info'></span>
            </div>
            <div class="row">
            Hasta:
            <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(          
                        'name'=>'hasta',
                        'value'=> empty($_POST['hasta'])?date('Y-m-d'):$_POST['hasta'],
                        'attribute'=>'fecha_revision',  
                        'language' => 'es',             
                        'htmlOptions' => array(         
                                        'readonly'=> 'readonly',
                            ),
                        'options'=>array(               
                            'autoSize'=>false,              
                            //'defaultDate'=>$hasta, 
                            'dateFormat'=>'yy-mm-dd',       
                            'selectOtherMonths'=>true,      
                            'showAnim'=>'fade',            
                            'showButtonPanel'=>false,       
                            'showOn'=>'focus',             
                            'showOtherMonths'=>true,        
                            'changeMonth' => true,          
                            'changeYear' => true,
                            'minDate'=>'2010-01-01', //fec\ha minima
                            'maxDate'=>"+1Y", //fecha maxima
                                    ),
                        )
                    );
                echo CHtml::hiddenField('por');
            ?>
            <span class='fa fa-2x fa-calendar text-info'></span>
            </div>
        	<div class="row">
               <div class="imprimir" style="display: inline-block;">
               <?php 
                $this->widget('application.extensions.print.printWidget', array(                   
                               'cssFile' => 'print.css',
                               'coverElement' => '#wrap',
                               'printedElement'=>'#corte',
                               )
                             
                           ); 
                ?>
               </div>
               <div class=" buttons" style="display: inline-block;">
                <?php echo CHtml::submitButton('Buscar',array('class'=>'btn btn-primary btn-medium','style'=>'margin:auto;display:block')); ?>
               </div>
            
         </div> 
    </div>
    
    <?php $this->endWidget(); ?>
    
    </div><!-- form -->
</div>
<div class="corte-diario" id="corte" style="padding:0 10px ;">
<?php if(!empty($eventos)): ?>
    <?php
      
      $totalBoletosCancelados = $model->getTotalBoletosCancelados($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $totalBoletosCancelados = $totalBoletosCancelados->getData();
      
      $totalVentasMiasNormal  = $model->getTotalVentasMiasNormal($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $totalVentasMiasNormal  = $totalVentasMiasNormal->getData();
      
      $totalVentasMiasNormalDesc  = $model->getTotalVentasMiasNormalDesc($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $totalVentasMiasNormalDesc  = $totalVentasMiasNormalDesc->getData();
      
      $totalVentas            = $model->getTotalVentas($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $totalVentas            = $totalVentas->getData();
      
      $cortesia = $model->getTotalTipo($_POST['usuario_id'],$_POST['desde'],$_POST['hasta'],"","","CORTESIA");
      $cortesia =  $cortesia->getData();
      
      $boletosDuros = $model->getTotalBoletosDuros($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $boletosDuros = $boletosDuros->getData();
      
      $visaYmaster = $model->getTotalVentasVisaMaster($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $visaYmaster = $visaYmaster->getData();
      $visaYmaster = empty($visaYmaster[0]['total'])?"0":$visaYmaster[0]['total'];
      
      $american = $model->getTotalVentasAmerican($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $american = $american->getData();
      $american = empty($american[0]['total'])?"0":$american[0]['total'];
      
      $terminal = $model->getTotalVentasTerminal($_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
      $terminal = $terminal->getData();
      $terminal = empty($terminal[0]['total'])?"0":$terminal[0]['total'];
      //print_r($totalVentasMiasNormal);
    ?>
    <?php if(!empty($totalVentasMiasNormal)):?>
    <h5>RESUMEN GENERAL</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: center;">Efectivo</td>
                <td></td>
                <td style="text-align: center;">Tarjeta</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Boletos Vendidos:</td>
                <td style="text-align: center;"><?php echo empty($totalVentasMiasNormal[0]['cantidad'])?"0":$totalVentasMiasNormal[0]['cantidad']?></td>
                <td style="text-align: left;">$<?php echo number_format(empty($totalVentasMiasNormal[0]['total'])?"0":$totalVentasMiasNormal[0]['total'],2)?></td>
                <td>Efectivo sin Cargo:</td>
                <td style="text-align: left;">$<?php echo number_format($totalVentas[0]['VentasCosBol'],2) ?></td>
                <td>Visa y Mastercard:</td>
                <td style="text-align: left;">$<?php echo number_format($visaYmaster,2)?></td>
                <td rowspan="5" style="vertical-align: middle;text-align: center;font-size: 18pt;"><strong>Efectivo a Entregar<br />$<?php echo number_format($totalVentas[0]['VentasCosBol']+$totalVentas[0]['VentasCarSer'],2) ?></strong></td>
            </tr>
            <tr>
                <td>Descuentos Vendidos:</td>
                <td style="text-align: center;"><?php echo $totalVentasMiasNormalDesc[0]['cantidad']?></td>
                <td style="text-align: left;">$<?php echo number_format($totalVentasMiasNormalDesc[0]['total'],2)?></td>
                <td>Cargo por Servicio:</td>
                <td style="text-align: left;">$<?php echo number_format($totalVentas[0]['VentasCarSer'],2) ?></td>
                <td>American Express:</td>
                <td style="text-align: left;">$<?php echo number_format($american,2)?></td>
            </tr>
            <tr>
                <td>Boletos Duros:</td>
                <td style="text-align: center;"><?php echo empty($boletosDuros[0]['cantidad'])?"0":$boletosDuros[0]['cantidad']?></td>
                <td style="text-align: left;">$<?php echo number_format(empty($boletosDuros[0]['total'])?"0":$boletosDuros[0]['total'],2)?></td>
                <td>Total Efectivo:</td>
                <td style="text-align: left;">$<?php echo number_format($totalVentas[0]['VentasCosBol']+$totalVentas[0]['VentasCarSer'],2) ?></td>
                <td>Terminal PV:</td>
                <td>$<?php echo number_format($terminal,2)?></td>
            </tr>
            <tr>
                <td>Boletos Cortesías:</td>
                <td style="text-align: center;"><?php echo empty($cortesia[0]['cantidad'])?"0":$cortesia[0]['cantidad']?></td>
                <td ></td>
                <td></td>
                <td></td>
                <td>Total Tarjeta:</td>
                <td>$<?php echo number_format($visaYmaster+$american+$terminal,2)?></td>
            </tr>
            <tr>
                <td>Boletos Cancelados:</td>
                <td style="text-align: center;"><?php echo empty($totalBoletosCancelados[0]['cantidad'])?"0":$totalBoletosCancelados[0]['cantidad']?></td>
                <td style="text-align: right;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <?php endif;?>
    <br />
    <?php foreach($eventos->getData() as $key => $evento):?>
        Evento:<strong><?php echo $evento['EventoNom'] ?></strong><br />
        Función:<strong><?php echo $evento['funcionesTexto'] ?></strong>
        <?php $detallePorZonas = $model->getVentasDetallePorZona($evento['EventoId'],$evento['FuncionesId'],$_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
              $detallePorZonas = $detallePorZonas->getData()
        ?>
     <br /> <br />  
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Zona/Tipo</th>
                    <th>Costo por Boleto</th>
                    <th>Núm. de boletos</th>
                    <th>Total Costo por boleto</th>
                    <th>Total Cargo por servicio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $countBoletos               = 0;
                $countTotalPorBoleto        = 0;
                $countTotalCargoPorServicio = 0;
                $countTotal                 = 0;
                ?>
                <?php foreach($detallePorZonas as $key => $detalleZona):?>
                <?php 
                $countBoletos               += $detalleZona['cantidad'];
                $countTotalPorBoleto        += $detalleZona['VentasCosBolT'];
                $countTotalCargoPorServicio += $detalleZona['VentasCarSerT'];
                $countTotal                 += $detalleZona['VentasCosBolT']+$detalleZona['VentasCarSerT'];
                ?>
                    <tr>
                        <td><?php echo $detalleZona['ZonasAli']?></td>
                        <td style="text-align: right;">$<?php echo number_format($detalleZona['VentasCosBol'],2)?></td>
                        <td style="text-align: center;"><?php echo $detalleZona['cantidad']?></td>
                        <td style="text-align: right;">$<?php echo number_format($detalleZona['VentasCosBolT'],2)?></td>
                        <td style="text-align: right;">$<?php echo number_format($detalleZona['VentasCarSerT'],2)?></td>
                        <td style="text-align: right;">$<?php echo number_format($detalleZona['VentasCosBolT']+$detalleZona['VentasCarSerT'],2)?></td>
                    </tr>
                <?php endforeach?>
            </tbody>
            <tfoot>
            </tfoot>
                <tr>
                    <td></td>
                    <td style="background: silver;">SubTotal</td>
                    <td style="background: silver;text-align: center;"><?php echo $countBoletos ?></td>
                    <td style="background: silver;text-align: right;">$<?php echo number_format($countTotalPorBoleto,2) ?></td>
                    <td style="background: silver;text-align: right;">$<?php echo number_format($countTotalCargoPorServicio,2) ?></td>
                    <td style="background: silver;text-align: right;">$<?php echo number_format($countTotal,2) ?></td>
                </tr>
                <?php $cortesias = $model->getTotalTipo($_POST['usuario_id'],$_POST['desde'],$_POST['hasta'],$evento['EventoId'],$evento['FuncionesId'],"CORTESIA");
                          $cortesias = $cortesias->getData();?>
                <?php if (!empty($cortesias[0]['VentasCarSer'])):?>
                <tr>
                    
                        <td><?php echo empty($cortesias[0]['VentasCarSer'])?"&nbsp;":"CORTESIAS"?></td>
                        <td style="text-align: right;"><?php echo empty($cortesias[0]['VentasCosBol'])?"":"$".$cortesias[0]['VentasCosBol']?></td>
                        <td style="text-align: center;"><?php echo empty($cortesias[0]['cantidad'])?"":$cortesias[0]['cantidad']?></td>
                        <td style="text-align: right;"><?php echo empty($cortesias[0]['VentasCosBolT'])?"":"$".$cortesias[0]['VentasCosBolT']?></td>
                        <td style="text-align: right;"><?php echo empty($cortesias[0]['VentasCarSerT'])?"":"$".$cortesias[0]['VentasCarSerT']?></td>
                        <td style="text-align: right;"><?php echo empty($cortesias[0]['total'])?"":"$".$cortesias[0]['total'] ?></td>
                 </tr>
                 <tr>
                    <td></td>
                    <td style="background: silver;">SubTotal</td>
                    <td style="background: silver;text-align: center;"><?php echo empty($cortesias[0]['cantidad'])?"":$cortesias[0]['cantidad']?></td>
                    <td style="background: silver;text-align: right;"><?php echo empty($cortesias[0]['VentasCosBolT'])?"":"$".$cortesias[0]['VentasCosBolT']?></td>
                    <td style="background: silver;text-align: right;"><?php echo empty($cortesias[0]['VentasCarSerT'])?"":"$".$cortesias[0]['VentasCarSerT']?></td>
                    <td style="background: silver;text-align: right;"><?php echo empty($cortesias[0]['total'])?"":"$".$cortesias[0]['total'] ?></td>
                </tr>
                <?php endif?>
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr style="color: white;">
                 <?php 
                          $countBoletos               += $cortesias[0]['cantidad'];
                          $countTotalPorBoleto        += $cortesias[0]['VentasCosBolT'];
                          $countTotalCargoPorServicio += $cortesias[0]['VentasCarSerT'];
                          $countTotal                 += $cortesias[0]['total'];
                    ?>
                    <td style="border: none;"></td>
                    <td style="background: black;">Total</td>
                    <td style="background: black;text-align: center;"><?php echo $countBoletos ?></td>
                    <td style="background: black;text-align: right;">$<?php echo number_format($countTotalPorBoleto,2) ?></td>
                    <td style="background: black;text-align: right;">$<?php echo number_format($countTotalCargoPorServicio,2) ?></td>
                    <td style="background: black;text-align: right;">$<?php echo number_format($countTotal,2) ?></td>
                </tr>
        </table>
        <table class="table span2" style="border: 1px solid black;float: left;width: 170px;">
            <tbody>
                <?php
	               $boletosCancelados = $model->getTotalBoletosCancelados($_POST['usuario_id'],$_POST['desde'],$_POST['hasta'],$evento['EventoId'],$evento['FuncionesId']);
                   $boletosCancelados = $boletosCancelados->getData();
                ?>
                <tr>
                    <td style="border: 1px solid black;">CANCELADOS</td>
                    <td style="border: 1px solid black;"><?php echo $boletosCancelados[0]['cantidad']?></td>
                </tr>
            </tbody>
        </table>
        <table class="span4" style="border: 1px solid black;background: silver;color:black;font-weight: bold; float: right;text-align: right;">
            <tbody>
                <?php 
                    $efectivo = $model->getTotalEfectivo($evento['EventoId'],$evento['FuncionesId'],$_POST['usuario_id'],$_POST['desde'],$_POST['hasta']);
                    $efectivo = $efectivo->getData();
                    $visaYmaster = $model->getTotalVentasVisaMaster($_POST['usuario_id'],$_POST['desde'],$_POST['hasta'],$evento['EventoId'],$evento['FuncionesId']);
                    $visaYmaster = $visaYmaster->getData();
                    $visaYmaster = empty($visaYmaster[0]['total'])?"0":$visaYmaster[0]['total'];
      
                    $american = $model->getTotalVentasAmerican($_POST['usuario_id'],$_POST['desde'],$_POST['hasta'],$evento['EventoId'],$evento['FuncionesId']);
                    $american = $american->getData();
                    $american = empty($american[0]['total'])?"0":$american[0]['total'];
                    
                    $terminal = $model->getTotalVentasTerminal($_POST['usuario_id'],$_POST['desde'],$_POST['hasta'],$evento['EventoId'],$evento['FuncionesId']);
                    $terminal = $terminal->getData();
                    $terminal = empty($terminal[0]['total'])?"0":$terminal[0]['total'];
                ?>
                <tr>
                    <td >Total Efectivo:</td>
                    <td >$<?php echo number_format($efectivo[0]['VentasCosBolT']+$efectivo[0]['VentasCarSerT'],2) ?></td>
                </tr>
                <tr>
                    <td>Efectivo sin Cargo:</td>
                    <td>$<?php echo number_format($efectivo[0]['VentasCosBolT'],2) ?></td>
                </tr>
                <tr>
                    <td>Visa y Mastercard:</td>
                    <td>$<?php echo number_format($visaYmaster,2)?></td>
                </tr>
                <tr>
                    <td>American Express:</td>
                    <td>$<?php echo number_format($american,2)?></td>
                </tr>
                <tr>
                    <td>Terminal PV:</td>
                    <td>$<?php echo number_format($terminal,2)?></td>
                </tr>
            </tbody>
        </table>
        <br /><br /><br /><br /><br /><br />
        <div class="info">
            <a id="boton-show-info"  data-cargado="0" data-eventoId="<?php echo $evento['EventoId']?>" data-funcionId="<?php echo $evento['FuncionesId']?>" class="btn btn-info" data-toggle="collapse" data-target="#show-info<?php echo $evento['EventoId'].$evento['FuncionesId']?>">
                Mostrar detalle del evento <?php echo $evento['EventoNom']?>
            </a>
 
            <div id="show-info<?php echo $evento['EventoId'].$evento['FuncionesId']?>" class="collapse">
                <?php echo CHtml::image(Yii::app()->baseUrl."/images/loading.gif","cargando...");?>
            </div>
            <br />
        </div>
    <?php endforeach;?>
    <script>
$("a#boton-show-info").click(function(){
    var eventoId  = $(this).attr("data-eventoId");
    var funcionId = $(this).attr("data-funcionId");
    var usuarioId = '<?php echo $_POST['usuario_id']?>'
    var desde     = '<?php echo $_POST['desde'] ?>';
    var hasta     = '<?php echo $_POST['hasta'] ?>';
    var cargado   = $(this).attr("data-cargado");
    if(cargado==0){
        console.log(eventoId);
        $.ajax({
            url    : '<?php echo Yii::app()->createUrl("reportes/DetalleVentasAjax");?>',
            data   : {eventoId:eventoId,funcionId:funcionId,usuarioId:usuarioId,desde:desde,hasta:hasta},
            type   : 'post',
            success: function(data){
                $("#show-info"+eventoId+""+funcionId).html(data);
                $(this).attr("data-cargado",'1');
            }
        });
       
    }
    
});
</script>
<?php endif;?>
</div>
<script>
$("#ver-todos-usuarios").click(function(){    
    $("#ver-usuarios").val("todos");
    $("#usuarios-form").submit();
    return false;
});
</script>