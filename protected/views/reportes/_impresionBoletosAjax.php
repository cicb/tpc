<?php
$comprobante   = "";
$total         = 0;
$asientos      = "";
$zonas         = array();
foreach($data as $key => $boleto):
    $total = $total + $boleto['cosBolCargo'];
    $asientos.= " ".$boleto['FilasAli']." ".$boleto["LugaresLug"].",";
    if(empty($zonas))
        $zonas[]=$boleto['ZonasAli'];
    else
        in_array($boleto['ZonasAli'],$zonas)?"":$zonas[]=$boleto['ZonasAli'];
    
    $comprobante==""?$comprobante=$boleto['VentasNumRef']:"";
     //print_r($boleto);
        ?>
            <div style="position:relative;border: none;width: 75mm;height: 160mm; font-size: 7pt;">
                <div style=" position: absolute;top:<?php echo $formato[0]->FormatoY; ?>px ;left:<?php echo $formato[0]->FormatoX;?>px ;<?php echo $formato[0]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['SubzonaAcc']; ?></div> 
                <div style=" position: absolute;top:<?php echo $formato[1]->FormatoY; ?>px ;left:<?php echo $formato[1]->FormatoX;?>px ;<?php echo $formato[1]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['EventoDesBol']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[2]->FormatoY; ?>px ;left:<?php echo $formato[2]->FormatoX;?>px ;<?php echo $formato[2]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['EventoNom']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[3]->FormatoY; ?>px ;left:<?php echo $formato[3]->FormatoX;?>px ;<?php echo $formato[3]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ForoNom']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[4]->FormatoY; ?>px ;left:<?php echo $formato[4]->FormatoX;?>px ;<?php echo $formato[4]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['fnc']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[5]->FormatoY; ?>px ;left:<?php echo $formato[5]->FormatoX;?>px ;<?php echo $formato[5]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip'];  ?></div>
                <div style=" position: absolute;top:<?php echo $formato[6]->FormatoY; ?>px ;left:<?php echo $formato[6]->FormatoX;?>px ;<?php echo $formato[6]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[7]->FormatoY; ?>px ;left:<?php echo $formato[7]->FormatoX;?>px ;<?php echo $formato[7]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasBolTip']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[8]->FormatoY; ?>px ;left:<?php echo $formato[8]->FormatoX;?>px ;<?php echo $formato[8]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasCon']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[9]->FormatoY; ?>px ;left:<?php echo $formato[9]->FormatoX;?>px ;<?php echo $formato[9]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasCon']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[10]->FormatoY; ?>px ;left:<?php echo $formato[10]->FormatoX;?>px ;<?php echo $formato[10]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['cosBol']; ?></div>       
                <div style=" position: absolute;top:<?php echo $formato[11]->FormatoY; ?>px ;left:<?php echo $formato[11]->FormatoX;?>px ;<?php echo $formato[11]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['cosBol']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[12]->FormatoY; ?>px ;left:<?php echo $formato[12]->FormatoX;?>px ;<?php echo $formato[12]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['cosBol']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[13]->FormatoY; ?>px ;left:<?php echo $formato[13]->FormatoX;?>px ;<?php echo $formato[13]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[14]->FormatoY; ?>px ;left:<?php echo $formato[14]->FormatoX;?>px ;<?php echo $formato[14]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[15]->FormatoY; ?>px ;left:<?php echo $formato[15]->FormatoX;?>px ;<?php echo $formato[15]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['ZonasAli']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[16]->FormatoY; ?>px ;left:<?php echo $formato[16]->FormatoX;?>px ;<?php echo $formato[16]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[17]->FormatoY; ?>px ;left:<?php echo $formato[17]->FormatoX;?>px ;<?php echo $formato[17]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[18]->FormatoY; ?>px ;left:<?php echo $formato[18]->FormatoX;?>px ;<?php echo $formato[18]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['FilasAli']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[19]->FormatoY; ?>px ;left:<?php echo $formato[19]->FormatoX;?>px ;<?php echo $formato[19]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[20]->FormatoY; ?>px ;left:<?php echo $formato[20]->FormatoX;?>px ;<?php echo $formato[20]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[21]->FormatoY; ?>px ;left:<?php echo $formato[21]->FormatoX;?>px ;<?php echo $formato[21]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['LugaresLug']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[22]->FormatoY; ?>px ;left:<?php echo $formato[22]->FormatoX;?>px ;<?php echo $formato[22]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasCarSer']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[23]->FormatoY; ?>px ;left:<?php echo $formato[23]->FormatoX;?>px ;<?php echo $formato[23]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasCarSer']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[24]->FormatoY; ?>px ;left:<?php echo $formato[24]->FormatoX;?>px ;<?php echo $formato[24]->FormatoVisible=="true"?"":"display:none;"; ?>"> <?php echo $boleto['VentasCarSer']; ?></div>
                <div style=" position: absolute;top:<?php echo $formato[25]->FormatoY; ?>px ;left:<?php echo $formato[25]->FormatoX;?>px ;<?php echo $formato[25]->FormatoVisible=="true"?"":"display:none;"; ?>"><?php echo  CHtml::image ( ($boleto['EventoImaBol']==""?'..' . Yii::app ()->baseUrl . '/imagesbd/blanco.jpg':'..' . Yii::app ()->baseUrl . '/imagesbd/'.$boleto['EventoImaBol']) , '', array () ); ?> </div>
                <div style=" position: absolute;top:<?php echo $formato[26]->FormatoY; ?>px ;left:<?php echo $formato[26]->FormatoX;?>px ;<?php echo $formato[26]->FormatoVisible=="true"?"":"display:none;"; ?>text-align:center;"> <?php  $this->widget('application.extensions.cbarras.CBarras',array('text'=>$boleto['LugaresNumBol'].$this->generarCodigo(12),'size'=>30));?><br /> <?php echo $boleto['LugaresNumBol'].$this->generarCodigo(12); ?></div>                                                                                                                                                                                                                                      
            </div> 
        <?php
     if (array_key_exists($key+1, $data)) {
        if($data[$key]['VentasNumRef']!=$data[$key+1]['VentasNumRef']){
            //echo $comprobante."-".$data[$key+1]['VentasNumRef'];
            ?>
            <div id="comprobante" class="comprobante" style="position:relative;border: none;width: 75mm;height: 160mm; font-size: 7pt;">
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
                    FIRMA:________________________________________
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
                <div style="text-align: right; padding-right: 3px;position: absolute;bottom: 0;right: 0;"><?php echo $boleto['id']." ".$boleto['PuntosventaId'];?></div>
            </div>
            <?php
            $comprobante = $data[$key+1]['VentasNumRef'];
            $total = 0;
            $asientos = "";
            unset($zonas);
        }
    }else{
        ?>
        <div id="comprobante" class="comprobante" style="position:relative;border: none;width: 75mm;height: 160mm; font-size: 7pt;">
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
                    FIRMA:________________________________________
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
                <div style="text-align: right; padding-right: 3px;position: absolute;bottom: 0;right: 0;"><?php echo $boleto['id']." ".$boleto['PuntosventaId'];?></div>
            </div>
            <?php
    }   
endforeach;
?>