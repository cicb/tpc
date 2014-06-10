<?php
	 //print_r($data);
     $detallePorZonaIndividual = $model->getVentasDetallePorZonaIndividual($data['eventoId'],$data['funcionId'],$data['usuarioId'],$data['desde'],$data['hasta']);
     $detallePorZonaIndividual = $detallePorZonaIndividual->getData();
     //print_r($detallePorZonaIndividual);
     $totalIndividual = $model->getTotalIndividual($data['eventoId'],$data['funcionId'],$data['usuarioId'],$data['desde'],$data['hasta']);
     $totalIndividual = $totalIndividual->getData();
     //print_r($detalle->getData());
?>
<br />
<!--Detalle de boletos en ventas Normales-->
<?php if(!empty($detallePorZonaIndividual)):?>
    <div class="row" style="background: silver;">
        <div class="span7">
        Ventas
        </div>
        <div class="span4">Cantidad: <?php echo $totalIndividual[0]['cantidad'] ?></div>
        <div class="span4">Total: $<?php echo number_format($totalIndividual[0]['VentasCosBolT']+$totalIndividual[0]['VentasCarSerT'],2) ?></div>
    </div>
    <?php foreach($detallePorZonaIndividual as $key => $zona): ?>
    <table class="table">
        <thead style="background: none;color: black;">
            <tr>
                <th style="text-align: left !important;">Zona</th>
                <th style="text-align: left !important;">Costo</th>
                <th style="text-align: left !important;">Cargo</th>
                <th style="text-align: left !important;">Cantidad</th>
                <th style="text-align: left !important;">Importe</th>
                <th style="text-align: left !important;">Cargo por Servicio</th>
                <th style="text-align: left !important;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $zona['ZonasAli']?></td>
                <td>$<?php echo number_format($zona['VentasCosBol'],2)?></td>
                <td>$<?php echo number_format($zona['VentasCarSer'],2)?></td>
                <td><?php echo $zona['cantidad']?></td>
                <td>$<?php echo number_format($zona['VentasCosBolT'],2)?></td>
                <td>$<?php echo number_format($zona['VentasCarSerT'],2)?></td>
                <td>$<?php echo number_format($zona['VentasCosBolT']+$zona['VentasCarSerT'],2)?></td>
            </tr>
        </tbody>
    </table>
    <?php
    $detalleIndividual = $model->getVentasDetalleIndividual($zona['EventoId'],$zona['FuncionesId'],$zona['ZonasId'],$data['usuarioId'],$data['desde'],$data['hasta'],$zona['DescuentosId']);
	$detalleIndividual =  $detalleIndividual->getData();
    //echo $zona['EventoId'].'-'.$zona['FuncionesId'].'-'.$zona['ZonasId'];
    ?>
       <table class="table">
           <tbody>
                <tr>
                    <td class="span3">Zona</td>
                    <td class="span3">Tipo</td>
                    <td class="span3">Fila</td>
                    <td class="span3">Asiento</td>
                </tr>
            <?php foreach($detalleIndividual as $key => $individual): ?>
                <tr>
                    <td><?php echo $zona['ZonasAli']?></td>
                    <td><?php echo $individual['VentasBolTip']?></td>
                    <td><?php echo $individual['FilasAli']?></td>
                    <td><?php echo $individual['LugaresLug']?></td>
                </tr>
            <?php endforeach?>
            </tbody>
       </table> 
    <?php endforeach?>
    <table class="span4" style="border: 1px solid black;color:black;font-weight: bold; float: right;text-align: right;">
            <tbody>
                <?php 
                    $efectivo = $model->getTotalEfectivo($data['eventoId'],$data['funcionId'],$data['usuarioId'],$data['desde'],$data['hasta']);
                    $efectivo = $efectivo->getData();
                    $visaYmaster = $model->getTotalVentasVisaMaster($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
                    $visaYmaster = $visaYmaster->getData();
                    $visaYmaster = empty($visaYmaster[0]['total'])?"0":$visaYmaster[0]['total'];
      
                    $american = $model->getTotalVentasAmerican($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
                    $american = $american->getData();
                    $american = empty($american[0]['total'])?"0":$american[0]['total'];
                    
                    $terminal = $model->getTotalVentasTerminal($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
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
        
<?php endif?>
<!--Detalle de BOLETOS DUROS-->
<?php 
    $boletoDuro = $model->getTotalTipo($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId'],"BOLETO DURO");
    $boletoDuro =  $boletoDuro->getData();
    $boletoDuroIndividual = $model->getTotalTipoIndividual($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId'],"BOLETO DURO");
    $boletoDuroIndividual = $boletoDuroIndividual->getData();
?>

<?php if(!empty($boletoDuro[0]['cantidad'])):?>
    <div class="row" style="background: silver;">
        <div class="span7">
        Boleto Duros
        </div>
        <div class="span4">Cantidad: <?php echo $boletoDuro[0]['cantidad'] ?></div>
        <div class="span4">Total: $<?php echo number_format($boletoDuro[0]['VentasCosBolT']+$boletoDuro[0]['VentasCarSerT'],2) ?></div>
    </div>
    <?php foreach($boletoDuroIndividual as $key => $boletoDuroIndividual): ?>
    <table class="table">
        <thead style="background: none;color: black;">
            <tr>
                <th style="text-align: left !important;">Zona</th>
                <th style="text-align: left !important;">Costo</th>
                <th style="text-align: left !important;">Cargo</th>
                <th style="text-align: left !important;">Cantidad</th>
                <th style="text-align: left !important;">Importe</th>
                <th style="text-align: left !important;">Cargo por Servicio</th>
                <th style="text-align: left !important;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $boletoDuroIndividual['ZonasAli']?></td>
                <td>$<?php echo number_format($boletoDuroIndividual['VentasCosBol'],2)?></td>
                <td>$<?php echo number_format($boletoDuroIndividual['VentasCarSer'],2)?></td>
                <td><?php echo $boletoDuroIndividual['cantidad']?></td>
                <td>$<?php echo number_format($boletoDuroIndividual['VentasCosBolT'],2)?></td>
                <td>$<?php echo number_format($boletoDuroIndividual['VentasCarSerT'],2)?></td>
                <td>$<?php echo number_format($boletoDuroIndividual['VentasCosBolT']+$boletoDuroIndividual['VentasCarSerT'],2)?></td>
            </tr>
        </tbody>
    </table>
    <?php
    $detalleBoletoDuroIndividual = $model->getVentasDetalleIndividualTipo($boletoDuroIndividual['EventoId'],$boletoDuroIndividual['FuncionesId'],$boletoDuroIndividual['ZonasId'],$data['usuarioId'],$data['desde'],$data['hasta'],'BOLETO DURO');
	$detalleBoletoDuroIndividual =  $detalleBoletoDuroIndividual->getData();
    //echo $zona['EventoId'].'-'.$zona['FuncionesId'].'-'.$zona['ZonasId'];
    ?>
       <table class="table">
           <tbody>
                <tr>
                    <td class="span3">Zona</td>
                    <td class="span3">Tipo</td>
                    <td class="span3">Fila</td>
                    <td class="span3">Asiento</td>
                </tr>
            <?php foreach($detalleBoletoDuroIndividual as $key => $individual): ?>
                <tr>
                    <td><?php echo $boletoDuroIndividual['ZonasAli']?></td>
                    <td><?php echo $individual['VentasBolTip']?></td>
                    <td><?php echo $individual['FilasAli']?></td>
                    <td><?php echo $individual['LugaresLug']?></td>
                </tr>
            <?php endforeach?>
            </tbody>
       </table>     
    <?php endforeach?>
    <table class="span4" style="border: 1px solid black;color:black;font-weight: bold; float: right;text-align: right;">
            <tbody>
                <?php 
                    $efectivo = $model->getTotalEfectivo($data['eventoId'],$data['funcionId'],$data['usuarioId'],$data['desde'],$data['hasta']);
                    $efectivo = $efectivo->getData();
                    $visaYmaster = $model->getTotalVentasVisaMaster($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
                    $visaYmaster = $visaYmaster->getData();
                    $visaYmaster = empty($visaYmaster[0]['total'])?"0":$visaYmaster[0]['total'];
      
                    $american = $model->getTotalVentasAmerican($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
                    $american = $american->getData();
                    $american = empty($american[0]['total'])?"0":$american[0]['total'];
                    
                    $terminal = $model->getTotalVentasTerminal($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
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
<?php endif?>
<!--Detalle de boletos CORTESIAS-->
<?php 
    $cortesia = $model->getTotalTipo($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId'],"CORTESIA");
    $cortesia =  $cortesia->getData();
    //print_r($cortesia);
    $cortesiaIndividual = $model->getTotalTipoIndividual($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId'],"CORTESIA");
    $cortesiaIndividual = $cortesiaIndividual->getData();
?>

<?php if(!empty($cortesia[0]['cantidad'])):?>
    <div class="row" style="background: silver;">
        <div class="span7">
        Cortesías
        </div>
        <div class="span4">Cantidad: <?php echo $cortesia[0]['cantidad'] ?></div>
        <div class="span4">Total: $<?php echo number_format($cortesia[0]['VentasCosBolT']+$cortesia[0]['VentasCarSerT'],2) ?></div>
    </div>
    <?php foreach($cortesiaIndividual as $key => $cortesiaIndividual): ?>
    <table class="table">
        <thead style="background: none;color: black;">
            <tr>
                <th style="text-align: left !important;">Zona</th>
                <th style="text-align: left !important;">Costo</th>
                <th style="text-align: left !important;">Cargo</th>
                <th style="text-align: left !important;">Cantidad</th>
                <th style="text-align: left !important;">Importe</th>
                <th style="text-align: left !important;">Cargo por Servicio</th>
                <th style="text-align: left !important;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $cortesiaIndividual['ZonasAli']?></td>
                <td>$<?php echo number_format($cortesiaIndividual['VentasCosBol'],2)?></td>
                <td>$<?php echo number_format($cortesiaIndividual['VentasCarSer'],2)?></td>
                <td><?php echo $cortesiaIndividual['cantidad']?></td>
                <td>$<?php echo number_format($cortesiaIndividual['VentasCosBolT'],2)?></td>
                <td>$<?php echo number_format($cortesiaIndividual['VentasCarSerT'],2)?></td>
                <td>$<?php echo number_format($cortesiaIndividual['VentasCosBolT']+$cortesiaIndividual['VentasCarSerT'],2)?></td>
            </tr>
        </tbody>
    </table>
    <?php
    $detalleCortesiaIndividual = $model->getVentasDetalleIndividualTipo($cortesiaIndividual['EventoId'],$cortesiaIndividual['FuncionesId'],$cortesiaIndividual['ZonasId'],$data['usuarioId'],$data['desde'],$data['hasta'],'CORTESIA');
	$detalleCortesiaIndividual =  $detalleCortesiaIndividual->getData();
    //echo $zona['EventoId'].'-'.$zona['FuncionesId'].'-'.$zona['ZonasId'];
    ?>
       <table class="table">
           <tbody>
                <tr>
                    <td class="span3">Zona</td>
                    <td class="span3">Tipo</td>
                    <td class="span3">Fila</td>
                    <td class="span3">Asiento</td>
                </tr>
            <?php foreach($detalleCortesiaIndividual as $key => $individual): ?>
                <tr>
                    <td><?php echo $cortesiaIndividual['ZonasAli']?></td>
                    <td><?php echo $individual['VentasBolTip']?></td>
                    <td><?php echo $individual['FilasAli']?></td>
                    <td><?php echo $individual['LugaresLug']?></td>
                </tr>
            <?php endforeach?>
            </tbody>
       </table>     
    <?php endforeach?>
    <table class="span4" style="border: 1px solid black;color:black;font-weight: bold; float: right;text-align: right;">
            <tbody>
                <?php 
                    $efectivo = $model->getTotalEfectivo($data['eventoId'],$data['funcionId'],$data['usuarioId'],$data['desde'],$data['hasta']);
                    $efectivo = $efectivo->getData();
                    $visaYmaster = $model->getTotalVentasVisaMaster($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
                    $visaYmaster = $visaYmaster->getData();
                    $visaYmaster = empty($visaYmaster[0]['total'])?"0":$visaYmaster[0]['total'];
      
                    $american = $model->getTotalVentasAmerican($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
                    $american = $american->getData();
                    $american = empty($american[0]['total'])?"0":$american[0]['total'];
                    
                    $terminal = $model->getTotalVentasTerminal($data['usuarioId'],$data['desde'],$data['hasta'],$data['eventoId'],$data['funcionId']);
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
<?php endif?>
