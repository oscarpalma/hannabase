<html>
<head>
<!-- Bootstrap Core CSS -->
    <link href="/static/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
<style>
	body {
	    width: 100%;
	    height: 100%;
	    margin: 0;
	    padding: 0;
	    font: 10pt "Arial";
	}
	* {
	    box-sizing: border-box;
	    -moz-box-sizing: border-box;
	}
	.page {
	    width: 210mm;
	    min-height: 297mm;
	    padding: 20mm;
	    margin: 10mm auto;
	    background: white;

	}
	.subpage {

	    height: 200mm;
	}

	@page {
	    size: A4;
	    margin: 0;
	}
	@media print {
	    html, body {
	        width: 210mm;
	        height: 290mm;
	    }
	    .page {
	        margin: 0;
	        width: initial;
	        min-height: initial;
	        page-break-after: always;
	    }
	}

	.wrapper-images {

	position: relative;

	}

	.texto {
		color: #000;
		height:130px;
		width: 32%;
		position:absolute;
		top: 55px;
		left: 129px;
		bottom:0px;
		text-transform: capitalize;
	}
	.direccion {
		color: #fff;
		
		width: 100%;
		position:absolute;
		top: 168px;
		left: 10px;
		bottom:0px;
		text-transform: capitalize;
		font: 8.5pt "Arial";

	}
	.telefono {
		color: #fff;
		
		width: 100%;
		position:absolute;
		top: 188px;
		left: 10px;
		bottom:0px;
		text-transform: capitalize;
		font: 8.5pt "Arial";

	}
	.texto2 {
		color: #000;
		height:250px;
		width: 105%;
		position:absolute;
		top: 290px;
		left: -169px;
		bottom:0px;
		text-transform: capitalize;
		font: 8pt "Arial";
	}
	.foto {
  position: absolute;
  top:  42px; 
  left: 9px;
	}
	.logocover {
  position: absolute;
  top:  7px; 
  left: 230px;
	}
	.logorecover {
  position: absolute;
  top:  404px; 
  left: 10px;
	}
</style>
</head>
    <div class="page">
        <div class="subpage">
@if(isset($credencial))

 		<div class="wrapper-images">
			<img src="/static/imagenes/cover.png" width="351" height="224"/>
			<img src="/static/imagenes/logomexico.png" width="110" class="logocover" />
			<img src="{{url($credencial['foto'])}}" width="85" height="106" class="foto img-circle" />
			<div class="texto">

			
				<strong>No.Empleado:</strong> {{$credencial['noempleado']}} <br>
				<strong>Nombre:</strong>{{$credencial['nombre']}} <br> {{$credencial['apellidos']}}<br><br>
				<!--Modificar para el personal de oficina-->
				<strong>Puesto:</strong>Operador
			
			</div>
			<div class="direccion">

			
				<strong>Plaza Wahoo Florido 1era. Seccion Tijuana, Baja California.</strong> 
				
			</div>
			<div class="telefono">

			
				<strong>Tel: 3-81-51-32</strong> 
				
			</div>
			<br><br>
			<img src="/static/imagenes/recoverxp.png" width="351" height="224"/>
			<img src="/static/imagenes/logocrtm.png" width="45" class="logorecover" />
			<div class="texto2">
			<center>
				<strong>CURP: </strong>{{$credencial['curp']}}<br> 
				<strong>RFC: </strong>{{$credencial['rfc']}}<br> 
				<strong>No.IMSS:</strong>{{$credencial['noimss']}}<br> <br> <br> 
				<strong>En Emergencia llamar a: </strong><br>
				{{$credencial['nombre_contacto']}} <br>
				<strong>Telefono: </strong>{{$credencial['tel_contacto']}}<br> <br> 
				<!--Modificar para el personal de oficina-->
				<!--<strong>Area:</strong> Area <br>
				<strong>Encargado:</strong> Encargado-->
			</center>
			</div>
		</div>
@endif    
        </div>
    </div>

<script>
window.print();
</script>
</html>