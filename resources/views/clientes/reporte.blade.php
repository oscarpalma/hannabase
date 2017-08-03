@extends('layouts.dashboard')
@section('page_heading','Generar Reporte')
@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@stop
@section('section')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('clientes/reporte') }}" id="detalle_reporte" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
			<div class="col-sm-4">
				<label class="control-label">Empresa<text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="cliente" id="cliente" required="">
							<option value="">SELECCIONAR</option>
							@foreach($info['clientes'] as $clientes)
								<option  value="{{$clientes->idCliente}}">{{$clientes->nombre}}</option>
							@endforeach
						</select>	
					</div>
			</div>	
			<div class="col-sm-4">
					<label class="control-label">Turno <text style="color:red">*</text></label>
				<div >
					<select class="form-control" name="turno" id="turno">
						<option value="">SELECCIONAR</option>
					</select>
				</div>
			</div>	
				<div class="col-sm-4">
					<label class="control-label">Por <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="por" id="por">
							
								<option value="semana">Semana </option>
								<option value="mes">Mes </option>
								<option value="anual">Año</option>
							
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label" id="etiqueta">Semana <text style="color:red">*</text></label>
					<select class="form-control" name="valor" id="selector">
						@for($s = 1; $s <= 53; $s++)
							<option value="{{$s}}">Semana {{$s}}</option>
						@endfor
					</select>
					<text id="nota"><strong>Nota:</strong> se toma en cuenta solo el año actual</text>
				</div>
			</div>
			
			<br>
		    <center>
				<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
					Buscar
				</button>
			</center>

		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		$('#por').on('change', function(e){
	        console.log(e);
	        if(e.target.value == 'semana'){
		        $("#selector").empty();
		        $("#etiqueta").empty();
		        $("#nota").empty();
		        $("#nota").append("<strong>Nota:</strong> se toma en cuenta solo el año actual");
		        $("#etiqueta").append("Semana <text style='color:red'>*</text>");

		        for(var s = 1; s < 54; s++){
		        	$("#selector").append('<option value="' + s + '" >Semana ' + s + '</option>');
		        }

		    }

		    if(e.target.value == 'mes'){
		    	$("#selector").empty();
		    	$("#etiqueta").empty();
		        $("#nota").empty();
		        $("#nota").append("<strong>Nota:</strong> se toma en cuenta solo el año actual");
		    	$("#etiqueta").append("Mes <text style='color:red'>*</text>");
		    	$("#selector").append('<option value="1">Enero</option>');		    	
		    	$("#selector").append('<option value="2">Febrero</option>');
		    	$("#selector").append('<option value="3">Marzo</option>');
		    	$("#selector").append('<option value="4">Abril</option>');
		    	$("#selector").append('<option value="5">Mayo</option>');
		    	$("#selector").append('<option value="6">Junio</option>');
		    	$("#selector").append('<option value="7">Julio</option>');
		    	$("#selector").append('<option value="8">Agosto</option>');
		    	$("#selector").append('<option value="9">Septiembre</option>');
		    	$("#selector").append('<option value="10">Octubre</option>');
		    	$("#selector").append('<option value="11">Noviembre</option>');
		    	$("#selector").append('<option value="12">Diciembre</option>');
		    }

		    if(e.target.value == 'anual'){
		    	$("#selector").empty();
		    	$("#etiqueta").empty();
		        $("#nota").empty();
		    	$("#etiqueta").append("Año <text style='color:red'>*</text>");	    	
		    	$("#selector").append('<option value="2016">2016</option>');
		    	$("#selector").append('<option value="2017">2017</option>');
		    }
	    });


	});
</script>


@if(isset($info['requerimientos']))



	<br>
	
	<h1>Reporte - {{$clientes->nombre}} </h1>
	
	<br>

	<!--Tabla con los resultados de la busqueda-->
	<div id="dvData" style="overflow:scroll; overflow:auto;">
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="exportTable">
			<thead >
				

				<tr>
					<th>Fecha de Captura</th>
					<th>Requerimiento</th>
					<th>Ingreso</th>
					<th>Turno</th>

				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					// $fecha1 = new DateTime($parametros['fecha1']);
					// $fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$dias =[
					'Monday' => 'Lunes',
					'Tuesday' => 'Martes',
					'Wendsday' => 'Miercoles',
					'Thursday' => 'Jueves',
					'Friday'   => 'Viernes',
					'Saturday'  => 'Sabado',
					'Sunday'  => 'Domingo'
					];
				?>

				

				
			</thead>

			<tbody>


				
				@foreach($info['requerimientos'] as $requerimiento)
					<tr>
						<td>{{$requerimiento->fecha_ingreso}}</td>
						<td>{{$requerimiento->requerimiento}}</td>
						<td>{{$requerimiento->ingreso}}</td>
						<td>{{$requerimiento->idturno}}</td>
								
					</tr>
			@endforeach
			</tbody>

		</table>

	</div>
	<br>
	<div class="row">
        <div class="col-lg-8" style="">
        	<h1>Grafica</h1>
    		<canvas id="cbar" ></canvas>
		</div>
	</div>


<br>

	<br><br>


@endif
<script>



       $(document).ready(function () {
       
    
 		//$("#").select2();
		//$("#").select2();

	$('#cliente').on('change', function(e){
    
    var idCliente = e.target.value;
	$("#cliente option[value='null']").hide();
	
    if($("#cliente").val() != "null"){

	    $.get('/ajax-cliente?idCliente=' + idCliente, function(data) {
	    	//console.log(data);

	    	//Muestra los turnos segun el cliente que se ha seleccionado
	       	$('#turno').empty();
	       	$.each(data,function(index,turnosObj){
	       	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	       	});

	    });
	}

	else{
		$('#turno').empty();
	}
});

function get_nombre_dia($fecha)
{
	fechats = strtotime($fecha);

		switch (date('w', $fechats)){
	    case 0: return "Domingo"; break;
	    case 1: return "Lunes"; break;
	    case 2: return "Martes"; break;
	    case 3: return "Miercoles"; break;
	    case 4: return "Jueves"; break;
	    case 5: return "Viernes"; break;
	    case 6: return "Sabado"; break;
	}
}

@if(isset($info['requerimientos']))
var requerimientos=[];
var ingresos=[];
var semanas=[];
var fechas=[];

@foreach ($info['requerimientos'] as $requerimiento)
		fechas.push( {"fecha": "{{$requerimiento->fecha_ingreso}}"});
		requerimientos.push({"requerimiento": "{{$requerimiento->requerimiento}}"});
		
		
@endforeach 
var unicos =$.unique(fechas);
var bdata = {

        labels : fechas.map((el) => el.fecha),
        datasets : [
            
            {
            	label: "life expectancy (years)",
               fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data : requerimientos.map((el) => el.requerimiento),

                
            }
        ]

    }
    var cbar = document.getElementById("cbar").getContext("2d");
    new Chart(cbar).Bar(bdata, {
            responsive : true,
            scaleShowLabels : true,
        });
    @endif


    });

</script>

<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>

<script type="text/javascript">

</script>


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>

<script src="{{ asset("assets/scripts/jspdf.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/scripts/jspdf.min.js") }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.16/jspdf.plugin.autotable.js"></script>
    @stop

@stop



