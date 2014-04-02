<?php
//echo "DI:".$descuentosId."-CC:".$cuponesCod;
//print_r($data);
echo "<ul class='treeview nodo_padre' id='treeview' >";
    foreach($model as $key => $evento):
        echo "<li>";
            echo "Selecciona una opci&oacute;n para el evento ";
            echo $evento->EventoNom;
            echo "<ul> Funciones";
                foreach($evento->funciones as $key => $funcion):
                    echo "<li id='nodo_funcion$key'>";
                        //Seleccion de funcion actual
                        if(!empty($data[$funcion->EventoId]['FuncionesId']) AND array_key_exists($funcion->FuncionesId,$data[$funcion->EventoId]['FuncionesId'])){
                            $selected_funcion = $funcion->FuncionesId;
                            $disabled_zona = '';
                        }else{$selected_funcion="";$disabled_zona = 'disabled';}   
                        echo CHtml::checkBox("check_funcion",$selected_funcion,array('value'=>$key,'check-data-cuponescod'=>$cuponesCod,'check-data-descuentosid'=>$descuentosId,'check-data-eventoid'=>$funcion->EventoId,'check-data-funcionesid'=>$funcion->FuncionesId))."&nbsp;".$funcion->funcionesTexto;
                        echo "<ul> Zonas";    
                            foreach($funcion->zonas as $key => $zona):
                                echo "<li id='nodo_zona$key'>";
                                    //Seleccion de zona actual
                                    if(!empty($data[$zona->EventoId]['FuncionesId'][$zona->FuncionesId]) AND array_key_exists($zona->ZonasId,$data[$zona->EventoId]['FuncionesId'][$zona->FuncionesId])){
                                        $selected_zona = $zona->ZonasId;
                                        $disabled_subzona = '';
                                    }else{ $selected_zona = "";$disabled_subzona = 'disabled';}
                                    
                                        echo CHtml::checkBox("check_zona", $selected_zona,array('disabled'=>$disabled_zona,'id'=>'check_zona','check-data-cuponescod'=>$cuponesCod,'check-data-descuentosid'=>$descuentosId,'check-data-eventoid'=>$zona->EventoId,'check-data-funcionesid'=>$zona->FuncionesId,'check-data-zonasid'=>$zona->ZonasId))."&nbsp;".$zona->ZonasAli;
                                        if($zona->ZonasTipo!="1"){
                                            echo "<ul> Subzonas";
                                                foreach($zona->subzonas as $key => $subzona):
                                                    echo "<li id='nodo_subzona$key'>";
                                                        //Seleccion de subzona actual
                                                        if(!empty($data[$subzona->EventoId]['FuncionesId'][$subzona->FuncionesId][$subzona->ZonasId]) AND array_key_exists($subzona->SubzonaId,$data[$subzona->EventoId]['FuncionesId'][$subzona->FuncionesId][$subzona->ZonasId])){
                                                            $selected_subzona = $subzona->SubzonaId;
                                                            $disabled_fila = '';
                                                        }else{$selected_subzona = '';$disabled_fila = 'disabled';}
                                                        echo CHtml::checkBox("check_subzona",$selected_subzona,array('disabled'=>$disabled_subzona,'id'=>'check_subzona','check-data-cuponescod'=>$cuponesCod,'check-data-descuentosid'=>$descuentosId,'check-data-eventoid'=>$subzona->EventoId,'check-data-funcionesid'=>$subzona->FuncionesId,'check-data-zonasid'=>$subzona->ZonasId,'check-data-subzonaid'=>$subzona->SubzonaId))."&nbsp;".$subzona->SubzonaId;
                                                        echo "<ul> Filas";    
                                                            foreach($subzona->filas as $key => $fila):
                                                                echo "<li id='nodo_fila$key'>";
                                                                //Seleccion de la fila actual
                                                                    if(!empty($data[$fila->EventoId]['FuncionesId'][$fila->FuncionesId][$fila->ZonasId][$fila->SubzonaId]) AND array_key_exists($fila->FilasId,$data[$fila->EventoId]['FuncionesId'][$fila->FuncionesId][$fila->ZonasId][$fila->SubzonaId])){
                                                                        $selected_fila = $fila->FilasId;
                                                                        $disabled_lugar ='';
                                                                    }else{$selected_fila ="";$disabled_lugar ='disabled';}
                                                                    echo CHtml::checkBox("check_fila", $selected_fila,array('disabled'=> $disabled_fila,'id'=>'check_fila','check-data-cuponescod'=>$cuponesCod,'check-data-descuentosid'=>$descuentosId,'check-data-eventoid'=>$fila->EventoId,'check-data-funcionesid'=>$fila->FuncionesId,'check-data-zonasid'=>$fila->ZonasId,'check-data-subzonaid'=>$fila->SubzonaId,'check-data-filasid'=>$fila->FilasId))."&nbsp;".$fila->FilasAli;
                                                                    echo "<ul> Lugares";
                                                                        foreach($fila->lugares as $key =>$lugar):
                                                                        //Seleccion del lugar actual
                                                                            if(!empty($data[$lugar->EventoId]['FuncionesId'][$lugar->FuncionesId][$lugar->ZonasId][$lugar->SubzonaId][$lugar->FilasId]) AND array_key_exists($lugar->LugaresId,$data[$lugar->EventoId]['FuncionesId'][$lugar->FuncionesId][$lugar->ZonasId][$lugar->SubzonaId][$lugar->FilasId])){
                                                                                $selected_lugar = $lugar->LugaresId;
                                                                            }else{$selected_lugar ='';}
                                                                            echo "<li id='nodo_lugar$key'>";
                                                                                echo CHtml::checkBox("check_lugar",$selected_lugar,array('disabled'=>$disabled_lugar,'id'=>'check_lugar','check-data-cuponescod'=>$cuponesCod,'check-data-descuentosid'=>$descuentosId,'check-data-eventoid'=>$lugar->EventoId,'check-data-funcionesid'=>$lugar->FuncionesId,'check-data-zonasid'=>$lugar->ZonasId,'check-data-subzonaid'=>$lugar->SubzonaId,'check-data-filasid'=>$lugar->FilasId,'check-data-lugaresid'=>$lugar->LugaresId))."&nbsp;".$lugar->LugaresId;
                                                                            echo "</li>";    
                                                                        endforeach;
                                                                    echo "</ul>";    
                                                                echo "</li>";    
                                                            endforeach;
                                                        echo "</ul>";        
                                                    echo "</li>";        
                                                endforeach;
                                            echo "</ul>"; 
                                        }      
                                echo "</li>";        
                            endforeach;
                        echo "</ul>";        
                    echo "</li>";        
                endforeach;
            echo "</ul>";        
        echo "</li>";        
    endforeach;
echo "</ul>";
?>