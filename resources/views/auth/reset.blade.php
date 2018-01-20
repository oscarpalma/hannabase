<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('static/imagenes/hana.png') }}">
  <title>CRTM México</title>
  

<link href='/static/cssLogin/css/raleway.css' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/static//cssLogin/css/reset.min.css">

  
  <link rel="stylesheet" href="/static/cssLogin/css/style.css">

  
</head>

<body>
  <div class="container">

  <div class="info">
  <img src="/static/imagenes/logocrtm.png" width="70px" height="70px">
  </div>
  <div class="info2">
  <img src="/static/imagenes/hana.png"  alt="HanaBase" >
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="/static/imagenes/profile.png"/></div>
 
					<form class="form-horizontal" role="form" method="POST" action="/password/reset">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="token" value="{{ $token }}">

							<input type="email" class="form-control" placeholder="Correo" name="email" value="{{ old('email') }}">
							

								<input type="password" class="form-control" placeholder="Contraseña" name="password">
								<input type="password" class="form-control" placeholder="Confirmar" name="password_confirmation">
							

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Cambiar Contraseña
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>



   <!-- jQuery -->
    <script src="/static/bower_components/jquery/dist/jquery.min.js"></script>

      <!-- <script src="/cssLogin/js/index.js"></script>-->
<script type="text/javascript">
  
  $(document).ready(function(){
  $('#registrar').on('click', function (e) {

    e.preventDefault();
   
      $('#login-form').slideUp(function(){$('#register-form').slideDown();});

});

  $('#login').on('click', function (e) {

    e.preventDefault();
   
      $('#register-form').slideUp(function(){$('#login-form').slideDown();});

});

  $('#recuperar').on('click', function (e) {

    e.preventDefault();
   
      $('#login-form').slideUp(function(){$('#recuperar-form').slideDown();});

});

  $('#login-r').on('click', function (e) {

    e.preventDefault();
   
      $('#recuperar-form').slideUp(function(){$('#login-form').slideDown();});

});

});

</script>
</body>
</html>