<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Taquillacero :: Registro de corredores</title>
    <script src="js/jquery.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <link href="css/themes/default.css" id="theme_base" rel="stylesheet">
    <link href="css/themes/default.date.css" id="theme_base" rel="stylesheet">
  <script>
  // $(function() {
  //   $( "#datepicker" ).pickdate();
  // });
  </script>
  </head>

  <body>
  <div class="navbar navbar-info panel-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
                <img src="images/taq-p.png" height="50px" class="brand" style="margin:2px;" alt="">
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
<!--             <li><a href="#">Compra tus boletos</a></li>
            <li><a href="#">Ayuda</a></li> -->
          </ul>

        </div>
      </div>
    </div>
<div class="header">

 </div>
    <div class="container " id="ingreso">

      <div class="form-signin" role="form">
        <img src="images/carrera_udlap.png"  alt="">

        <h3 class="form-signin-heading">Registro de corredores.</h3>
        <div class="alert alert-danger hidden">Número de boleto/referencia invalido por favor verifique sus datos.</div>
        <div class="form-group">
          <input type="text" id="numero" class="form-control" placeholder="Numero de boleto o referencia" required autofocus>
          <p class="help-block">Si tienes un boleto impreso, ingresa el codigo de barras y 
          si realizaste tu compra desde web ingresa el número de referencia.</p>
        </div>
        <?php echo CHtml::link('Validar número',array('site/validarBoletos'),
        array('class'=>'btn btn-primary btn-lg', 'id'=>'validar')) ?>
      </div>

    </div> <!-- /container -->


    <div class="container" style="display:none" id="formulario">
      <div class="row">
        <div class="col-xs-4">
        <img src="images/carrera_udlap.png"  alt="">
        <br>
        <br>
        <br>
        <img src="images/inst.png"  alt="">
          
        </div>
        <div class="col-xs-7" id="formularios">
          <!-- -------------------------------------------------------Corredor -->

        </div>
      </div>


    </div> <!-- /container -->

    <div class="container" style="display:none" id="resultado" >
    <div class="row">
      <div class="col-xs-5">
                <img src="images/carrera_udlap.png"  alt="">
      </div>
      <div class="col-xs-5">
        <div class="panel panel-success">
          <div class="panel-heading">Registro completo</div>
          <div class="panel-body">
            <p>El registro se ha completado exitosamente. </p>
            <h1 class="center text-success">Eres el corredor <strong>#305</strong></h1>
          </div>
          <div class="panel-footer">
            <p class="help-block">
              Anota tu numero de corredor.
            </p>
          </div>
        </div>
      </div>
    </div>




    </div>

    <script src="js/picker.js"></script>
    <script src="js/picker.date.js"></script>
    <script src="js/picker.time.js"></script>
    <script src="js/legacy.js"></script>
        <script>
        $(document).ready(function() {  

    $('#Corredor_nacimiento').pickadate({
    selectYears: true,
    selectMonths: true
});
    $('#validar').on('click',function(){
      var url=$(this).attr('href');
      var numero=$('#numero').val();
      $.ajax({
        url:url,
        type:'get',
        dataType:'html',
        data:{boleto:numero},
        success:function(data){
          // if(data.length>0){
            // for (var boleto in data){
            //   console.log(data.VentasId);
            // }
            $('#formularios').html(data);
            $('#ingreso').hide();
            $('#formulario').fadeIn();
          }
          // else{
          //   $('.alert').removeClass('hidden');
          // }
        // }
      });
    return false;
    });
    $('#enviar').bind("click",function(){
      alert('xxxxx');
      // var id=$(this).data('id');
      // // console.log($('#formulario-'+id).serialize());
      // // $.ajax({
      // //   url:url,
      // //   type:'get',
      // //   dataType:'html',
      // //   data:{corredor:$('#formulario-'+id).serialize()},
      // //   success:function(data){
      // //     // if(data.length>0){
      // //       // for (var boleto in data){
      // //         console.log(data);
      // //       // }
      // //       $('#formularios').html(data);
      // //       $('#ingreso').hide();
      // //       $('#formulario').fadeIn();
      // //     }

      // // });      
      // $('#formulario').hide();
      // $('#resultado').fadeIn();
    return false;
    });
        });

    </script>

    <?php Yii::app()->clientScript->registerScript('acciones',"

       $('.registrar').bind('click',function(){ alert(1)});
") ?>
<style>
  
  body {
  padding-top: 40px;
  padding-bottom: 40px;
  background: #eee url(images/bedge_grunge.png);
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.navbar-info{
background:rgba(200,200,200,.5);
color:#FFF;}

.required {background-color: #d9534f;
  display: inline;
padding: .2em .6em .3em;
font-size: 75%;
font-weight: 700;
line-height: 1;
color: #fff;
text-align: center;
white-space: nowrap;
vertical-align: baseline;
border-radius: .25em;}
</style>


  </body>
</html>
