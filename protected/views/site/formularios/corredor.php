<?php echo CHtml::openTag('div',array('id'=>"div-formulario-".$lugar->llaveCompuesta)) ?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'id'=>'formulario-'.$lugar->llaveCompuesta,
    // 'htmlOptions'=>array('id'=>'formulario')
)); ?>
<div class="form-signin" role="form">

            <h3 class="form-signin-heading">Datos del corredor:</h3>
            <div class="form-group">
            <?php 
              echo  CHtml::hiddenField('Corredores[boleto]',$lugar->llaveCompuesta);            
              echo $form->textField($corredor,'nombre',
                array('class'=>'form-control','placeholder'=>'Nombre(s)'));
              echo $form->textField($corredor,'paterno',
                array('class'=>'form-control','placeholder'=>'Apellido paterno'));
              echo $form->textField($corredor,'materno',
                array('class'=>'form-control','placeholder'=>'Apellido materno'));
             ?>
<!--               <input type="text" class="form-control" placeholder="Nombre(s)" required autofocus />
              <input type="text" class="form-control" placeholder="Apellido paterno" required autofocus />
              <input type="text" class="form-control" placeholder="Apellido materno" required autofocus /> -->
             </div>
            <div class="form-group">
              <?php echo $form->dropDownListControlGroup($corredor, 'sexo', array(
                'f'=>'Femenino',
                'm'=>'Masculino',
                ), array('class'=>'form-control')); ?>
<!--               <div class="radio">
                      <span class="label label-danger ">Sexo:</span> 
                <label>
                  <input type="radio" name="optionsRadios" id="sexo" value="F">
                  Femenino
                </label>
                <label>
                  <input type="radio" name="optionsRadios" id="sexo" value="M">
                  Masculino
                </label>
              </div> -->
             </div>
              <div class="form-group">
                <span class="label label-danger">Fecha de nacimiento: </span>
                    <?php echo $form->textField($corredor,'nacimiento',array('class'=>'picker form-control', 'placeholder'=>'Clic o tap')) ;?>
                <!-- <input type="text" id="dater" class="form-control col-md-9" placeholder="Haz click o tap"> -->
              </div>              
              <br>
              <br>
            <div class="form-group">
                      <!-- <p class="label label-danger ">Categoria:</p> <br> -->
                     <?php echo $form->dropDownListControlGroup($corredor, 'categoria',
        array('varonil'=>'Varonil', 'femenil'=>'Femenil'), array('class'=>'form-control')); ?>
<!--                       <select class="form-control">
                        <option>General femenil</option>
                        <option>General varonil</option>
                      </select> -->
             </div>
            <div class="form-group">
                      <!-- <p class="label label-danger ">Distancia:</p> <br> -->
                     <?php echo $form->dropDownListControlGroup($corredor, 'distancia', array('5k'=>'5K','10k'=>'10K'),array('class'=>'form-control')); ?>

                     <!-- <select class="form-control"> -->
             </div>
              <div class="form-group">
               <?php echo $form->textField($corredor,'equipo',array('class'=>'form-control col-md-9', 'placeholder'=>'Equipo (opcional)')) ;?>
<!--                 <input type="text" id="equipo" class="form-control col-md-9" placeholder="Equipo (opcional)">
 -->              
              </div>    
              <br><br>
              <div class="form-group">
                      <p class="label label-default ">Dirección(es). (Opcional)</p> <br>
                      <?php 
                      echo $form->textField($corredor,'direccion1',array(
                       'class'=>'form-control col-md-9', 'placeholder'=>'Direccion 1')) ;
                      echo $form->textField($corredor,'direccion2',array(
                       'class'=>'form-control col-md-9', 'placeholder'=>'Direccion 2')) ;
                      echo $form->textField($corredor,'direccion3',array(
                       'class'=>'form-control col-md-9', 'placeholder'=>'Direccion 3'));
                      echo $form->textField($corredor,'cp',array(
                       'class'=>'form-control col-md-9', 'placeholder'=>'Codigo postal'));
                       ?>
<!--                 <input type="text" id="direccion2" class="form-control col-md-9" placeholder="Direccion 2">
                <input type="text" id="direccion3" class="form-control col-md-9" placeholder="Direccion 3"> -->
                <!-- <input type="number" id="cp" class="form-control col-md-9" placeholder="Codigo Postal"> -->
              </div>    
            <div class="form-group">
              <p class="label label-default ">Ciudad: (Opcional)</p> <br>
              <?php echo $form->textField($corredor,'ciudad',array(
              'class'=>'form-control col-md-9', 'placeholder'=>'Ciudad')) ;?>
             </div>
             <div class="form-group">
             <p class="label label-danger ">Datos de contacto</p> <br>
              <?php echo $form->textField($corredor,'telefono',array(
              'class'=>'form-control col-md-9', 'placeholder'=>'Telefono')) ;
              echo $form->emailFieldControlGroup($corredor,'email',array(
              'class'=>'form-control col-md-9', 'placeholder'=>'Email')) ;
              ?>
<!--                <input type="text" id="email" class="form-control col-md-9" placeholder="E-mail">
 -->            </div>
            <br/>
            <br/>
            <br/>
            <?php 
            echo  CHtml::link('Registrar competidor',array('site/registrarCorredor'),
              array('class'=>'btn btn-lg btn-primary btn-block registrar',
                'data-id'=>$lugar->llaveCompuesta,
                'id'=>"enviar-".$lugar->llaveCompuesta 
                )) ?>
              <!-- <button class="btn btn-lg btn-primary btn-block registrar"  data-id= id="enviar">Registrar datos.</button> -->
            </div>
            <?php $this->endWidget(); ?>
<?php 
// Yii::app()->clientScript->registerScript('acciones',"

//        $('.registrar').on('click',function(){ alert(1)});
// ");
 ?>

<script>
         // $('.registrar').on('click',function(){ alert(1)});

//       $('#Corredor_nacimiento').pickadate({
//     selectYears: true,
//     selectMonths: true
// });
</script>
</div>