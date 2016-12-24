@extends('layouts.dashboard')
@section('page_heading','Buscar checadas')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')



<form class="form-horizontal" role="form" method="POST" action="{{ route('buscar_checadas') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado</label>
					<div>
						<select class="form-control" name="empleado" id="empleado">
							<!--en caso de no especificar ninguno-->
							<option value="null">Todos</option>
							@foreach($parametros['empleados'] as $empleado)
								<option value="{{$empleado->idEmpleado}}" style="text-transform:uppercase">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Empresa</label>
					<div>
						<select class="form-control" name="cliente" id="cliente">
							<!--en caso de no especificar ninguno-->
							<option value="null">Todas</option>
							@foreach($parametros['clientes'] as $cliente)
								<option value="{{$cliente->idCliente}}">{{$cliente->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Turno</label>
					<div>
						<select class="form-control" name="turno" id="turno">
							<!--en caso de no especificar ninguno-->
							<option value="null">Todos</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Desde <text style="color:red">*</text></label>
					<div>
						<input class="form-control" name="fecha1" type="date" value="0001-01-01" max="<?php echo date('Y-m-d'); ?>">
						<!--La fecha 1 o inicial sera 1-enero-0001, para asegurar de encontrar todos los valores posibles -->
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Hasta <text style="color:red">*</text></label>
					<div>
						<input class="form-control" name="fecha2" type="date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
						<!--La fecha 2 o final sera el dia actual por defecto-->
					</div>
				</div>

				<div class="col-sm-4">
					<br>
				    <center>

						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Buscar
						</button>
					</center>
				</div>

			</div>
		</div>
	</div>
</form>

@if(isset($parametros['checadas']))
@if(!empty($parametros['empleadosPorChecada']))
	<br>
	<h1>Resultados de búsqueda</h1>
	<br>

	<!--Muestra una lista de los filtros de busqueda activos
	*****El intervalo de fechas siempre esta definido*****-->
	Filtros Activos:
	@foreach($parametros['filtrosActivos'] as $filtro)
		<li >{{$filtro}}</li>
	@endforeach

	<br>
	<form name="eliminar" action="{{ route('eliminar_checada') }}">
	<!--Tabla con los resultados de la busqueda-->
	<div class="form-group right">
				    <div class="pull-right" style="display: block;">

						<button type="submit" class="btn btn-danger" style="margin-right: 15px;">
							Eliminar 
						</button>

						</div>
					
				</div>
				<br>	<br>
	<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
		<tr>
			<th><center>#</center></th>
			<th><center>Cliente</center></th>
			<th><center>Empleado</center></th>
			<th><center>Fecha</center></th>
			<th><center>Entrada</center></th>
			<th><center>Salida</center></th>
			<th><center>Incidencia</center></th>
			<th><center>Seleccionar</center></th>
		</tr>

		<?php $cont = 1; ?>
		@foreach($parametros['checadas'] as $checada)
			<tr>
				<td><center>{{$cont++}}</center></td>
				<td><center>{{$parametros['clientesPorChecada'][$checada->idChecada]}}</center></td>
				<td><center>{{$parametros['empleadosPorChecada'][$checada->idChecada]}}</center></td>
				<td><center>{{$checada->fecha}}</center></td>
				<td><center>{{$checada->hora_entrada}}</center></td>
				<td><center>{{$checada->hora_salida}}</center></td>

				<!--mostrar N/A si no hay incidencia-->
				@if($checada->incidencia != null)
					@if($checada->incidencia == 'falta injustificada')
						<td><center><b><p style="color:red">{{$checada->incidencia}}</p></b></center></td>
					@else
						<td><center><b><p style="color:green">{{$checada->incidencia}}</p></b></center></td>
					@endif
				@else
					<td><center>N/A</center></td>
				@endif

				<!--No permite enviar el objeto como tal, hay que buscar otra manera de referenciarlo (agregar columna idChecada?)-->
				<td><center>
				<input type="checkbox" name="checadas[]" value="{{$checada->idChecada}}" class="btn-danger" onclick=""> 
				<!-- <a class="btn btn-danger btn-xs" href="{{ route('eliminar_checada',$checada->idChecada) }}" ><i class="fa fa-trash"></i></a> --></center></td>
			</tr>
		@endforeach
	</table>
	</form>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Sin resultado!</strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 
@endif
@endif      




<script type="text/javascript">
	$(document).ready(function() {
		$("#empleado").select2();
		$("#cliente").select2();

$('#cliente').on('change', function(e){
    console.log(e);
    var idCliente = e.target.value;
    if($('#cliente').value != "null"){

	    $.get('/ajax-cliente?idCliente=' + idCliente, function(data) {
	    	//console.log(data);

	    	//Muestra los turnos segun el cliente que se ha seleccionado
	       	$('#turno').empty();
	       	$('#turno').append('<option value="null">Todos</option>');
	       	$.each(data,function(index,turnosObj){
	       	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	       	});

	    });
	}

	else{
		$('#turno').empty();
	    $('#turno').append('<option value="null">Todos</option>');
	}
});
	});
</script>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>


    @stop

@stop