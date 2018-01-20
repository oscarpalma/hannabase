<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <meta name="description" content="CRTM Mexico">
  <meta name="keywords" content="CRTM Mexico, CRTM, Centro de Trabajo, CT, hana, hannabase">
  <meta name="author" content="CRTM Mexico">
  <link rel="icon" type="image/png" href="{{ asset('static/imagenes/hana.png') }}">
  <title>CRTM México</title>
  

<link href='/static/cssLogin/css/raleway.css' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/static/cssLogin/css/reset.min.css">

  
  <link rel="stylesheet" href="/static/cssLogin/css/style.css">
<!-- Bootstrap Core CSS -->
    <link href="/static/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

  
</head>

<body>
  <div class="container">

  <div class="info">
  <img src="/static/imagenes/logocrtm.png" alt="CRTM México" >
  </div>
  <div class="info2">
  <img src="/static/imagenes/hana.png"  alt="HanaBase" >
  </div>
</div>
          
<div class="form" data-toggle="popover" data-placement="right" data-content="Correo no registrado" id="email-login" >
  <div class="thumbnail"><img src="/static/imagenes/profile2.png" alt="" /></div>
  
  
  <form class="register-form" id="register-form" method="POST" action="/auth/register">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" placeholder="nombre" name="name" value="{{ old('name') }}"/>
   <!-- <input type="text" placeholder="apellidos" name="last_name" value="{{ old('last_name') }}" /> -->
    <input type="email" placeholder="correo" name="email" value="{{ old('email') }}"/>
    <input type="password" placeholder="contraseña" name="password" />
    <input type="password" placeholder="confirmación" name="password_confirmation" />
    <button>Registrar</button>
    <p class="message">¿Ya estas registrado? <a href="#" id="login">Iniciar Sesion</a></p>
  </form>
  <form class="login-form" id="login-form" method="POST" action="/auth/login">
   
    @if(Session::has('errorLogin'))
 <div class="alert alert-danger alert-dismissible" id="errorLogin">
  <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
    {{ Session::get('errorLogin') }}
    </div>
     
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="email" placeholder="correo" name="email" value="{{ old('email') }}" required/>
    <input type="password" placeholder="contraseña" name="password" data-toggle="popover" data-placement="right" data-content="Contraseña incorrecta" id="password-login" required/>
    <button>Entrar</button>
    <p class="message">¿No tienes cuenta? <a href="#" id="registrar">Crear una cuenta</a></p>
    <p class="message">¿Olvidaste tu contraseña? <a href="#" id="recuperar">Recuperar Contraseña</a></p>
  </form>
<form class="recuperar-form" id="recuperar-form" method="POST" action="/password/email">
    @if(Session::has('errorReset'))
         <div class="alert alert-danger alert-dismissible" id="errorReset">
  <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
    {{ Session::get('errorReset') }}
    </div> 
  @elseif(Session::has('send'))
         <div class="alert alert-success alert-dismissible" id="send">
  <strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong>
    {{ Session::get('send') }}
    </div>    
  @endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
    <input type="email" placeholder="correo" name="email" value="{{ old('email') }}"/>
    
    <button>Recuperar</button>
    <p class="message">¿Ya estas registrado? <a href="#" id="login-r">Iniciar Sesion</a></p>
  </form>

</div>



   <!-- jQuery -->
    <script src="/static/bower_components/jquery/dist/jquery.min.js"></script>
 <!-- Bootstrap Core JavaScript -->
    <script src="/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

      
<script type="text/javascript">
  
  $(document).ready(function(){
@if(Session::has('errorReset') || Session::has('send'))
      $('#login-form').hide();
      $('#recuperar-form').show();       
@endif

function ocultar(){
  $("#errorReset").hide();
  $("#errorLogin").hide();
  $("#send").hide();
}

  $('#registrar').on('click', function (e) {

    e.preventDefault();
      
      $('#login-form').slideUp(function(){$('#register-form').slideDown();});
      ocultar.delay(200).hide();
});

  $('#login').on('click', function (e) {

    e.preventDefault();
    
      $('#register-form').slideUp(function(){$('#login-form').slideDown();});
      ocultar.delay(200).hide();
});

  $('#recuperar').on('click', function (e) {

    e.preventDefault();
   
      $('#login-form').slideUp(function(){$('#recuperar-form').slideDown();});
      ocultar.delay(200).hide();
});

  $('#login-r').on('click', function (e) {

    e.preventDefault();
    
      $('#recuperar-form').slideUp(function(){$('#login-form').slideDown();});
      ocultar.delay(200).hide();
});

});

</script>
</body>
</html>
