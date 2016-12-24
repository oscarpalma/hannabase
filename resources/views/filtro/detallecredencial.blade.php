<html>
<head>
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
		bottom:0px;
		text-transform: capitalize;
	}
	.texto2 {
		color: #000;
		height:250px;
		width: 105%;
		position:absolute;
		bottom:0px;
		text-transform: uppercase;
		font: 8pt "Arial";
	}
	.foto {
  position: absolute;
  top:  69px; 
  left: 59px;
	}
</style>
</head>
    <div class="page">
        <div class="subpage">
@if(isset($credencial))

 		<div class="wrapper-images">
			<img src="../../imagenes/Credencial1.png" width="224" height="351"/>
			<img src="{{url($credencial['foto'])}}" width="105" height="136" class="foto" />
			<div class="texto">

			<center>
				<strong>No.Empleado:</strong> {{$credencial['noempleado']}} <br>
				<strong>Nombre:</strong>{{$credencial['nombre']}} <br> {{$credencial['apellidos']}}<br><br>
				<!--Modificar para el personal de oficina-->
				<strong>Puesto:</strong>Operador
			</center>
			</div>
			<img src="../../imagenes/Credencial2.png" width="224" height="351"/>
			<div class="texto2">
			<center>
				<strong>Curp: </strong>{{$credencial['curp']}}<br> 
				<strong>RFC: </strong>{{$credencial['rfc']}}<br> 
				<strong>No.IMSS:</strong>{{$credencial['noimss']}}<br> <br> <br> 
				<strong>En Emergencia llamar a: </strong><br>
				{{$credencial['nombre_contacto']}} <br>
				<strong>Telefono: </strong>{{$credencial['tel_contacto']}}<br> <br> 
				<!--Modificar para el personal de oficina-->
				<strong>Area:</strong> Area <br>
				<strong>Encargado:</strong> Encargado
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