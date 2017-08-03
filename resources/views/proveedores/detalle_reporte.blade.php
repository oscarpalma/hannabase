<html>
<head>
<meta charset="utf-8"/>
	<title>Centro de Trabajo </title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>


	<link rel="stylesheet" href="{{ asset('assets/stylesheets/styles.css') }}" />
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
	    width: 100%;
	    min-height: 100%;
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
<style type="text/css" media="print">
div.container { 
writing-mode: tb-rl;
height: 80%;
margin: 10% 0%;
}
img {
      transform: scale(1.2) rotate(90deg) translate(0, -150px);
   }

</style>

</head>
    <div class="container">
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

<div class="row">
  <div class="col-md-8 col-md-offset-3">
  	<center><LABEL >CORE RESOURCES TRADING AND MANAGEMENT </LABEL></center>
  </div>
 
</div>
<div class="row">
  <div class="col-md-8 col-md-offset-3">
  	<center><LABEL>ACAD-09 HISTORIAL DE FACTURAS DE PROVEEDORES </LABEL></center>
  </div>
 
</div>
<div class="row">
  <div class="col-md-4 ">
  		<br>

  	<strong>PROVEEDOR: ESPECIFICAR</strong>
  	<br>
  		<strong>CONTACTO: ESPECIFICAR</strong>
  		<br>
  		<strong>TELEFONO:</strong>
  		<br>
  		<strong>EMAIL:</strong>
  		<br>

  		<strong>CREDITO: </strong>
  </div>
  <div class="col-md-4 ">
  		<br>
  
  	
  	<br>
  		<strong>Grafica</strong>

  		<br>
  		  	<center><img src="https://pixabay.com/static/uploads/photo/2012/04/16/12/26/chart-35773_960_720.png" width="200px" height="100px"></center>
  		
  </div>

</div>
<div class="row">
<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="exportTable">
			<thead >
				

				<tr>
					<th>#</th>
					<th>factura</th>
					<th>Concepto</th>
					<th>Semana</th>
					<th NOWRAP>fecha de captura</th>
					<th NOWRAP>fecha agendada</th>
					<th>cargo</th>
					<th>abono</th>
					<th>saldo</th>
					<th NOWRAP>fecha progr. de pago</th>
					<th NOWRAP>fecha de pago</th>
					<th># cheque</th>


				</tr>
</thead>
				</table>

</div>
	
</div>
        </div>
    </div>

<script>
//window.print();
</script>
</html>