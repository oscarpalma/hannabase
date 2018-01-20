<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link href="/css/app.css" rel="stylesheet">
		 <link href="/static/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 48px;
				margin-bottom: 40px;
			}

			.icon {
				font-size: 84px;
				color:red;
			}

			.link{
				font-weight: bold;
				font-size: 36px;

			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<center>
				<div class="icon"><i class="fa fa-exclamation-triangle"></i> <text style="font-size:98px;">Error 500</text></div>
				<div class="title" style="color:black">Ocurrio un problema en el servidor, si el problema persiste contacte con el administrador.</div>
				<div class="link"><a class="btn btn-primary" href="{{route('home')}}" style="color:white"><text style="color:white; font-weight: bolder; font-size:24px;">Regresar a Inicio</text></a></div>
				</center>
			</div>
		</div>
	</body>
</html>