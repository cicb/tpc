<?php
$comprobante   = "";
$total         = 0;
$asientos      = "";
$zonas         = array();
//print_r($data);
foreach($data as $key => $boleto):
    $total = $total + $boleto['cosBolCargo'];
    $asientos.= " ".$boleto['FilasAli']." ".$boleto["LugaresLug"].",";
    if(empty($zonas))
        $zonas[]=$boleto['ZonasAli'];
    else
        in_array($boleto['ZonasAli'],$zonas)?"":$zonas[]=$boleto['ZonasAli'];
    
    $comprobante==""?$comprobante=$boleto['VentasNumRef']:"";
     //print_r($boleto);
       if($formato[0]->FormatoId=="1"){
        ?>
            <?php
                 $foro_coor = 60;
                 $fnc_coor  = 58;   
                 if(strlen($boleto['EventoNom'])>30){
                    $foro_coor = 80;
                     $fnc_coor = 85;
                 }
                 if(strlen($boleto['ForoNom'])>30){
                     $fnc_coor  = 95;
                 }
            ?>
            <div style="margin-bottom: 80px; position:relative;border: black solid 1px;width: 75mm;height: 168mm; font-size: 9pt;font-weight: bold;">
                <div style="border: none solid 1px; width: 48px;text-align: left; position: absolute;top:<?php echo $formato[0]->FormatoY+60; ?>px ;left:<?php echo $formato[0]->FormatoX;?>px ;<?php echo $formato[0]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['SubzonaAcc']; ?></div> 
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[1]->FormatoY+45; ?>px ;left:<?php echo $formato[1]->FormatoX;?>px ;<?php echo $formato[1]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;font-size: 12pt;"> <?php echo $boleto['EventoDesBol']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[2]->FormatoY+60; ?>px ;left:<?php echo $formato[2]->FormatoX;?>px ;<?php echo $formato[2]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;font-size: 14pt;"> <?php echo $boleto['EventoNom']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[3]->FormatoY+$foro_coor; ?>px ;left:<?php echo $formato[3]->FormatoX;?>px ;<?php echo $formato[3]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;font-size: 12pt;"> <?php echo $boleto['ForoNom']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[4]->FormatoY+$fnc_coor; ?>px ;left:<?php echo $formato[4]->FormatoX;?>px ;<?php echo $formato[4]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;"> <?php echo $boleto['fnc']; ?></div>
                <div style="border: none solid 1px; width: 83px;text-align: center; position: absolute;top:<?php echo $formato[5]->FormatoY+20; ?>px ;left:<?php echo $formato[5]->FormatoX-10;?>px ;<?php echo $formato[5]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip'];  ?></div>
                <div style="border: none solid 1px; width: 83px;text-align: left; position: absolute;top:<?php echo $formato[6]->FormatoY+28; ?>px ;left:<?php echo $formato[6]->FormatoX+20;?>px ;<?php echo $formato[6]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip']; ?></div>
                <div style="border: none solid 1px; width: 83px;text-align: left; position: absolute;top:<?php echo $formato[7]->FormatoY+37; ?>px ;left:<?php echo $formato[7]->FormatoX+20;?>px ;<?php echo $formato[7]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[8]->FormatoY+47; ?>px ;left:<?php echo $formato[8]->FormatoX-2;?>px ;<?php echo $formato[8]->FormatoVisible=="true"?"":"display:none;"; ?>width: 80px;height: 40px;"> <?php echo substr($boleto['VentasCon'],0,15)."<br/>".substr($boleto['VentasCon'],15,15); ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[9]->FormatoY+38; ?>px ;left:<?php echo $formato[9]->FormatoX-2;?>px ;<?php echo $formato[9]->FormatoVisible=="true"?"":"display:none;"; ?>width: 80px;height: 40px;"> <?php echo substr($boleto['VentasCon'],0,15)."<br/>".substr($boleto['VentasCon'],15,15); ?></div>
                <div style="border: none solid 1px; width: 80px;text-align: center; position: absolute;top:<?php echo $formato[10]->FormatoY+20; ?>px ;left:<?php echo $formato[10]->FormatoX+20;?>px ;<?php echo $formato[10]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['cosBol'],0,-3); ?></div>       
                <div style="border: none solid 1px; width: 80px;text-align: center; position: absolute;top:<?php echo $formato[11]->FormatoY+28; ?>px ;left:<?php echo $formato[11]->FormatoX+20;?>px ;<?php echo $formato[11]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['cosBol'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 80px;text-align: center; position: absolute;top:<?php echo $formato[12]->FormatoY+37; ?>px ;left:<?php echo $formato[12]->FormatoX+20;?>px ;<?php echo $formato[12]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['cosBol'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 130px;text-align: center; position: absolute;top:<?php echo $formato[13]->FormatoY-30; ?>px ;left:<?php echo $formato[13]->FormatoX;?>px ;<?php echo $formato[13]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style="border: none solid 1px; width: 215px;text-align: center; position: absolute;top:<?php echo $formato[14]->FormatoY+25; ?>px ;left:<?php echo $formato[14]->FormatoX-60;?>px ;<?php echo $formato[14]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style="border: none solid 1px; width: 215px;text-align: center; position: absolute;top:<?php echo $formato[15]->FormatoY+28; ?>px ;left:<?php echo $formato[15]->FormatoX-60;?>px ;<?php echo $formato[15]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[16]->FormatoY-30; ?>px ;left:<?php echo $formato[16]->FormatoX;?>px ;<?php echo $formato[16]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[17]->FormatoY+25; ?>px ;left:<?php echo $formato[17]->FormatoX;?>px ;<?php echo $formato[17]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[18]->FormatoY+28; ?>px ;left:<?php echo $formato[18]->FormatoX;?>px ;<?php echo $formato[18]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[19]->FormatoY-30; ?>px ;left:<?php echo $formato[19]->FormatoX+10;?>px ;<?php echo $formato[19]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style="border: none solid 1px; width: 20px;text-align: center; position: absolute;top:<?php echo $formato[20]->FormatoY+25; ?>px ;left:<?php echo $formato[20]->FormatoX+35;?>px ;<?php echo $formato[20]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style="border: none solid 1px; width: 20px;text-align: center; position: absolute;top:<?php echo $formato[21]->FormatoY+28; ?>px ;left:<?php echo $formato[21]->FormatoX+35;?>px ;<?php echo $formato[21]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style="border: none solid 1px; width: 55px;text-align: center; position: absolute;top:<?php echo $formato[22]->FormatoY+20; ?>px ;left:<?php echo $formato[22]->FormatoX+60;?>px ;<?php echo $formato[22]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['VentasCarSer'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 35px;text-align: center; position: absolute;top:<?php echo $formato[23]->FormatoY+28; ?>px ;left:<?php echo $formato[23]->FormatoX+50;?>px ;<?php echo $formato[23]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['VentasCarSer'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 35px;text-align: center; position: absolute;top:<?php echo $formato[24]->FormatoY+37; ?>px ;left:<?php echo $formato[24]->FormatoX+50;?>px ;<?php echo $formato[24]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['VentasCarSer'],0,-3); ?></div>
                <div style="width: 75mm;height: 69px; text-align: center; border: none solid 1px; position: absolute;top:<?php echo $formato[25]->FormatoY+20; ?>px ;left:<?php echo $formato[25]->FormatoX-40;?>px ;<?php echo $formato[25]->FormatoVisible=="true"?"":"display:none;"; ?>"><?php echo  CHtml::image ( ($boleto['EventoImaBol']==""?"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".Yii::app ()->baseUrl . '/imagesbd/blanco.jpg': "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".Yii::app ()->baseUrl . '/imagesbd/'.$boleto['EventoImaBol']) , '', array () ); ?> </div>
                <div style="border: white solid 1px; position: absolute;top:<?php echo $formato[26]->FormatoY+20; ?>px ;left:<?php echo $formato[26]->FormatoX-10;?>px ;<?php echo $formato[26]->FormatoVisible=="true"?"":"display:none;"; ?>text-align:center;"> <?php Barcode::getCodigo($boleto['LugaresNumBol']."0");//$this->widget('application.extensions.cbarras.CBarras',array('text'=>$boleto['LugaresNumBol'],'size'=>30));?><br /> <?php echo $boleto['LugaresNumBol']; ?></div>                                                                                                                                                                                                                                      
            </div> 
        <?php
       }elseif($formato[0]->FormatoId=="2"){
        ?>
            <?php
                 $foro_coor = 43;
                 $fnc_coor  = 40;   
                 if(strlen($boleto['EventoNom'])>30){
                    $foro_coor = 63;
                     $fnc_coor = 63;
                 }
                 if(strlen($boleto['ForoNom'])>30){
                     $fnc_coor  = 78;
                 }
                ?>
            <div style="margin-bottom: 110px;position:relative;border: white solid 1px;width: 75mm;height: 168mm; font-size: 9pt;font-weight: bold; font-family: Arial;">
                
                <div style="border: none solid 1px; width: 48px;text-align: center; position: absolute;top:<?php echo $formato[0]->FormatoY+55; ?>px ;left:<?php echo $formato[0]->FormatoX;?>px ;<?php echo $formato[0]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['SubzonaAcc']; ?></div> 
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[1]->FormatoY+23; ?>px ;left:<?php echo $formato[1]->FormatoX;?>px ;<?php echo $formato[1]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;font-size: 11pt;"> <?php echo $boleto['EventoDesBol']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[2]->FormatoY+43; ?>px ;left:<?php echo $formato[2]->FormatoX;?>px ;<?php echo $formato[2]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;font-size: 12pt;"> <?php echo $boleto['EventoNom']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[3]->FormatoY+$foro_coor; ?>px ;left:<?php echo $formato[3]->FormatoX;?>px ;<?php echo $formato[3]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;font-size: 11pt;"> <?php echo $boleto['ForoNom']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[4]->FormatoY+$fnc_coor; ?>px ;left:<?php echo $formato[4]->FormatoX;?>px ;<?php echo $formato[4]->FormatoVisible=="true"?"":"display:none;"; ?>width: 70mm;text-align:center;font-size: 10pt;"> <?php echo $boleto['fnc']; ?></div>
                <div style="border: none solid 1px; width: 83px;text-align: left; position: absolute;top:<?php echo $formato[5]->FormatoY+15; ?>px ;left:<?php echo $formato[5]->FormatoX;?>px ;<?php echo $formato[5]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip'];  ?></div>
                <div style="border: none solid 1px; width: 83px;text-align: left; position: absolute;top:<?php echo $formato[6]->FormatoY+43; ?>px ;left:<?php echo $formato[6]->FormatoX;?>px ;<?php echo $formato[6]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip']; ?></div>
                <div style="border: none solid 1px; width: 83px;text-align: left; position: absolute;top:<?php echo $formato[7]->FormatoY+53; ?>px ;left:<?php echo $formato[7]->FormatoX;?>px ;<?php echo $formato[7]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip']; ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[8]->FormatoY+43; ?>px ;left:<?php echo $formato[8]->FormatoX;?>px ;<?php echo $formato[8]->FormatoVisible=="true"?"":"display:none;"; ?>width: 90px;height: 40px;"> <?php echo substr($boleto['VentasCon'],0,15)."<br/>".substr($boleto['VentasCon'],15,20); ?></div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[9]->FormatoY+53; ?>px ;left:<?php echo $formato[9]->FormatoX;?>px ;<?php echo $formato[9]->FormatoVisible=="true"?"":"display:none;"; ?>width: 90px;height: 40px;"> <?php echo substr($boleto['VentasCon'],0,15)."<br/>".substr($boleto['VentasCon'],15,20); ?></div>
                <div style="border: none solid 1px; width: 80px;text-align: center; position: absolute;top:<?php echo $formato[10]->FormatoY+15; ?>px ;left:<?php echo $formato[10]->FormatoX;?>px ;<?php echo $formato[10]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['cosBol'],0,-3); ?></div>       
                <div style="border: none solid 1px; width: 80px;text-align: center; position: absolute;top:<?php echo $formato[11]->FormatoY+43; ?>px ;left:<?php echo $formato[11]->FormatoX;?>px ;<?php echo $formato[11]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['cosBol'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 80px;text-align: center; position: absolute;top:<?php echo $formato[12]->FormatoY+53; ?>px ;left:<?php echo $formato[12]->FormatoX;?>px ;<?php echo $formato[12]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['cosBol'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 130px;text-align: center; position: absolute;top:<?php echo $formato[13]->FormatoY+15; ?>px ;left:<?php echo $formato[13]->FormatoX;?>px ;<?php echo $formato[13]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style="border: none solid 1px; width: 130px;text-align: center; position: absolute;top:<?php echo $formato[14]->FormatoY+43; ?>px ;left:<?php echo $formato[14]->FormatoX;?>px ;<?php echo $formato[14]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style="border: none solid 1px; width: 130px;text-align: center; position: absolute;top:<?php echo $formato[15]->FormatoY+53; ?>px ;left:<?php echo $formato[15]->FormatoX;?>px ;<?php echo $formato[15]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[16]->FormatoY+15; ?>px ;left:<?php echo $formato[16]->FormatoX;?>px ;<?php echo $formato[16]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[17]->FormatoY+43; ?>px ;left:<?php echo $formato[17]->FormatoX;?>px ;<?php echo $formato[17]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[18]->FormatoY+55; ?>px ;left:<?php echo $formato[18]->FormatoX;?>px ;<?php echo $formato[18]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[19]->FormatoY+15; ?>px ;left:<?php echo $formato[19]->FormatoX;?>px ;<?php echo $formato[19]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[20]->FormatoY+43; ?>px ;left:<?php echo $formato[20]->FormatoX;?>px ;<?php echo $formato[20]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style="border: none solid 1px; width: 50px;text-align: center; position: absolute;top:<?php echo $formato[21]->FormatoY+53; ?>px ;left:<?php echo $formato[21]->FormatoX;?>px ;<?php echo $formato[21]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style="border: none solid 1px; width: 95px;text-align: center; position: absolute;top:<?php echo $formato[22]->FormatoY+15; ?>px ;left:<?php echo $formato[22]->FormatoX;?>px ;<?php echo $formato[22]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['VentasCarSer'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 95px;text-align: center; position: absolute;top:<?php echo $formato[23]->FormatoY+43; ?>px ;left:<?php echo $formato[23]->FormatoX;?>px ;<?php echo $formato[23]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['VentasCarSer'],0,-3); ?></div>
                <div style="border: none solid 1px; width: 95px;text-align: center; position: absolute;top:<?php echo $formato[24]->FormatoY+53; ?>px ;left:<?php echo $formato[24]->FormatoX;?>px ;<?php echo $formato[24]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo "$".substr($boleto['VentasCarSer'],0,-3); ?></div>
                <div style="width: 75mm;height: 69px; text-align: center; border: none solid 1px; position: absolute;top:<?php echo $formato[25]->FormatoY; ?>px ;left:<?php echo $formato[25]->FormatoX-10;?>px ;<?php echo $formato[25]->FormatoVisible=="true"?"":"display:none;"; ?>"><?php echo  CHtml::image ( ($boleto['EventoImaBol']==""?"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".Yii::app ()->baseUrl . '/imagesbd/blanco.jpg':"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/". Yii::app ()->baseUrl . '/imagesbd/'.$boleto['EventoImaBol']) , '', array () ); ?> </div>
                <div style="border: none solid 1px; position: absolute;top:<?php echo $formato[26]->FormatoY+5; ?>px ;left:<?php echo $formato[26]->FormatoX-15;?>px ;<?php echo $formato[26]->FormatoVisible=="true"?"":"display:none;"; ?>text-align:center;"> <?php /*Barcode::getCodigo($boleto['LugaresNumBol']."0");*/$this->widget('application.extensions.cbarras.CBarras',array('text_string'=>$boleto['LugaresNumBol'],'code_type'=>'ean13','size'=>30));?><br /> <?php echo $boleto['LugaresNumBol']; ?></div>                                                                                                                                                                                                                                      
            </div> 
        <?php
       }   
     if (array_key_exists($key+1, $data)) {
        if($data[$key]['VentasNumRef']!=$data[$key+1]['VentasNumRef']){
            //echo $comprobante."-".$data[$key+1]['VentasNumRef'];
            ?>
            <div id="comprobante" class="comprobante" style="margin-bottom: 110px;position:relative;border: white solid 1px;width: 75mm;height: 168mm; font-size: 9pt;font-family: Arial;">
                <br /><br /><br /><br /><br /><br /><br />
                <div style="text-align: right; padding-right: 3px;"><?php echo $boleto['id']." ".$boleto['PuntosventaId'];?></div>
                <div style="padding:5px;">
                    BANAMEX<br />
                    47 Pte 501 2<br />
                    Puebla<br />
                    TAQUILLA CERO<br />
                    No. Afiliaci&oacute;n:  3773470<br />
                    Fecha Compra: <?php echo  $boleto['VentasFecHor'];?> hrs.<br />
                    Venta en linea. N&uacute;mero de tarjeta:<br />
                    xxxx xxxx <?php echo  $boleto['VentasNumTar'];?><br />
                    Evento: <?php echo $boleto['EventoNom']; ?><br />
                    Funcion: <?php echo $boleto['fnc']; ?><br />
                    Zona(s):
                    <?php 
                        $zonas_print="";
                        foreach($zonas as $key => $z):
                            $zonas_print.= " ".$z.",";
                        endforeach;
                        echo substr($zonas_print,0,-1);
                    ?>
                    <br />
                    Asientos: <?php echo substr($asientos,0,-1);?><br />
                    Total:$<?php echo  $total;?><br />
                    Copia Negocio<br />
                    Recib&iacute; boletos<br />
                    FIRMA:________________________________
                    <br />
                    <div style="text-align: center;width: 65mm;"><?php echo $boleto['VentasNomDerTar']; ?></div>
                    <p >Por este pagar&eacute; me obligo incondicionalmente a pagar a la orden de la intituci&oacute;n 
                    emisora de la tarjeta relacionada en la presente, la cantidad que aparece en el total de este comprobante 
                    de disposici&oacute;n, el cual suscribo a favor de la intituci&oacute;n emisora de la tarjeta y al amparo 
                    del contrato de dep&oacute;sito, de apertura de cr&eacute;dito en cuenta corriente o en contrato que tengo celebrando
                    con la instituci&oacute;n  emisora para el uso de la tarjeta de d&eacute;bito, cr&eacute;dito y/o servicio
                    y que cuenta con mi firma aut&oacute;grafa o electr&oacute;nica, seg&uacute;n corresponde. El presente pagar&eacute;
                    es negociable &uacute;nicamente con intituciones de cr&eacute;dito.  </p>
                </div>
                <div style="text-align: right; padding-right: 3px;position: absolute;bottom: 10px;right: 0;"><?php echo $boleto['id']." ".$boleto['PuntosventaId'];?></div>
            </div>
            <?php
            $comprobante = $data[$key+1]['VentasNumRef'];
            $total = 0;
            $asientos = "";
            unset($zonas);
        }
    }else{
        ?>
        <div id="comprobante" class="comprobante" style="margin-bottom: 110px;position:relative;border: white solid 1px;width: 75mm;height: 168mm; font-size: 9pt;font-family: Arial;">
                <br /><br /><br /><br /><br /><br /><br />
                <div style="text-align: right; padding-right: 3px;"><?php echo $boleto['id']." ".$boleto['PuntosventaId'];?></div>
                <div style="padding:5px;">
                    BANAMEX<br />
                    47 Pte 501 2<br />
                    Puebla<br />
                    TAQUILLA CERO<br />
                    No. Afiliaci&oacute;n:  3773470<br />
                    Fecha Compra: <?php echo  $boleto['VentasFecHor'];?> hrs.<br />
                    Venta en linea. N&uacute;mero de tarjeta:<br />
                    xxxx xxxx <?php echo  $boleto['VentasNumTar'];?><br />
                    Evento: <?php echo $boleto['EventoNom']; ?><br />
                    Funcion: <?php echo $boleto['fnc']; ?><br />
                    Zona(s):
                    <?php 
                        $zonas_print="";
                        foreach($zonas as $key => $z):
                            $zonas_print.= " ".$z.",";
                        endforeach;
                        echo substr($zonas_print,0,-1);
                    ?>
                    <br />
                    Asientos: <?php echo substr($asientos,0,-1);?><br />
                    Total:$<?php echo  $total;?><br />
                    Copia Negocio<br />
                    Recib&iacute; boletos<br />
                    FIRMA:________________________________
                    <br />
                    <div style="text-align: center;width: 65mm;"><?php echo $boleto['VentasNomDerTar']; ?></div>
                    <p >Por este pagar&eacute; me obligo incondicionalmente a pagar a la orden de la intituci&oacute;n 
                    emisora de la tarjeta relacionada en la presente, la cantidad que aparece en el total de este comprobante 
                    de disposici&oacute;n, el cual suscribo a favor de la intituci&oacute;n emisora de la tarjeta y al amparo 
                    del contrato de dep&oacute;sito, de apertura de cr&eacute;dito en cuenta corriente o en contrato que tengo celebrando
                    con la instituci&oacute;n  emisora para el uso de la tarjeta de d&eacute;bito, cr&eacute;dito y/o servicio
                    y que cuenta con mi firma aut&oacute;grafa o electr&oacute;nica, seg&uacute;n corresponde. El presente pagar&eacute;
                    es negociable &uacute;nicamente con intituciones de cr&eacute;dito.  </p>
                </div>
                <div style="text-align: right; padding-right: 3px;position: absolute;bottom: 10px;right: 0;"><?php echo $boleto['id']." ".$boleto['PuntosventaId'];?></div>
            </div>
            <?php
    }   
endforeach;
?>