<?php
foreach($data as $key => $boleto):
 //print_r($boleto);
    ?>
        <div style="position:relative;width: 75mm;height: 160mm; font-size: 7pt;">
            <div style=" position: absolute;top:<?php echo $formato[0]->FormatoY; ?>px ;left:<?php echo $formato[0]->FormatoX;?>px ;"> <?php echo $boleto['SubzonaAcc']; ?></div> 
            <div style=" position: absolute;top:<?php echo $formato[1]->FormatoY; ?>px ;left:<?php echo $formato[1]->FormatoX;?>px ;"> <?php echo $boleto['EventoDesBol']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[2]->FormatoY; ?>px ;left:<?php echo $formato[2]->FormatoX;?>px ;"> <?php echo $boleto['EventoNom']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[3]->FormatoY; ?>px ;left:<?php echo $formato[3]->FormatoX;?>px ;"> <?php echo $boleto['ForoNom']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[4]->FormatoY; ?>px ;left:<?php echo $formato[4]->FormatoX;?>px ;"> <?php echo $boleto['fnc']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[5]->FormatoY; ?>px ;left:<?php echo $formato[5]->FormatoX;?>px ;"> <?php echo $boleto['VentasBolTip'];  ?></div>
            <div style=" position: absolute;top:<?php echo $formato[6]->FormatoY; ?>px ;left:<?php echo $formato[6]->FormatoX;?>px ;"> <?php echo $boleto['VentasBolTip']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[7]->FormatoY; ?>px ;left:<?php echo $formato[7]->FormatoX;?>px ;"> <?php echo $boleto['VentasBolTip']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[8]->FormatoY; ?>px ;left:<?php echo $formato[8]->FormatoX;?>px ;"> <?php echo $boleto['VentasCon']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[9]->FormatoY; ?>px ;left:<?php echo $formato[9]->FormatoX;?>px ;"> <?php echo $boleto['VentasCon']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[10]->FormatoY; ?>px ;left:<?php echo $formato[10]->FormatoX;?>px ;"> <?php echo $boleto['cosBol']; ?></div>       
            <div style=" position: absolute;top:<?php echo $formato[11]->FormatoY; ?>px ;left:<?php echo $formato[11]->FormatoX;?>px ;"> <?php echo $boleto['cosBol']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[12]->FormatoY; ?>px ;left:<?php echo $formato[12]->FormatoX;?>px ;"> <?php echo $boleto['cosBol']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[13]->FormatoY; ?>px ;left:<?php echo $formato[13]->FormatoX;?>px ;"> <?php echo $boleto['ZonasAli']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[14]->FormatoY; ?>px ;left:<?php echo $formato[14]->FormatoX;?>px ;"> <?php echo $boleto['ZonasAli']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[15]->FormatoY; ?>px ;left:<?php echo $formato[15]->FormatoX;?>px ;"> <?php echo $boleto['ZonasAli']; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[16]->FormatoY; ?>px ;left:<?php echo $formato[16]->FormatoX;?>px ;"> <?php echo $formato[16]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[17]->FormatoY; ?>px ;left:<?php echo $formato[17]->FormatoX;?>px ;"> <?php echo $formato[17]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[18]->FormatoY; ?>px ;left:<?php echo $formato[18]->FormatoX;?>px ;"> <?php echo $formato[18]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[19]->FormatoY; ?>px ;left:<?php echo $formato[19]->FormatoX;?>px ;"> <?php echo $formato[19]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[20]->FormatoY; ?>px ;left:<?php echo $formato[20]->FormatoX;?>px ;"> <?php echo $formato[20]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[21]->FormatoY; ?>px ;left:<?php echo $formato[21]->FormatoX;?>px ;"> <?php echo $formato[21]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[22]->FormatoY; ?>px ;left:<?php echo $formato[22]->FormatoX;?>px ;"> <?php echo $formato[22]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[23]->FormatoY; ?>px ;left:<?php echo $formato[23]->FormatoX;?>px ;"> <?php echo $formato[23]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[24]->FormatoY; ?>px ;left:<?php echo $formato[24]->FormatoX;?>px ;"> <?php echo $formato[24]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[25]->FormatoY; ?>px ;left:<?php echo $formato[25]->FormatoX;?>px ;"> <?php echo $formato[25]->FormatoObj; ?></div>
            <div style=" position: absolute;top:<?php echo $formato[26]->FormatoY; ?>px ;left:<?php echo $formato[26]->FormatoX;?>px ;"> <?php echo $formato[26]->FormatoObj; ?></div>                                                                                                                                                                                                                                      
        </div> 
    <?php
endforeach;
?>