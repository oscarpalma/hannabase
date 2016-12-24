@extends('layouts.dashboard')
@section('page_heading','Buscar checadas')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->

<form class="form-horizontal" role="form" method="POST" action="{{ route('buscar_checada_ct') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado</label>
					<div>
						<select class="form-control" id="empleado" name="empleado">
							<!--en caso de no especificar ninguno-->
							<option value="null">Todos</option>
							@foreach($parametros['empleados'] as $empleado)
								<option value="{{$empleado->idEmpleadoCt}}">{{$empleado->idEmpleadoCt}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>
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
			</div>

			<div class="row">
				<br>
			    <center>
					<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
						Buscar
					</button>
				</center>
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
		<li>{{$filtro}}</li>
	@endforeach

	<br>
	
	<!--Tabla con los resultados de la busqueda-->
	<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
		<tr>
			<th><center>#</center></th>
			<th><center>Empleado</center></th>
			<th><center>Fecha</center></th>
			<th><center>Entrada</center></th>
			<th><center>Salida</center></th>
			<th><center>Incidencia</center></th>
			<th><center>Acción</center></th>
		</tr>

		<?php $cont = 1; ?>
		@foreach($parametros['checadas'] as $checada)
			<tr>
				<td><center>{{$cont++}}</center></td>
				<td><center>{{$parametros['empleadosPorChecada'][$checada->idChecadaCt]}}</center></td>
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
				<td><center><a class="btn btn-danger" href="{{ route('eliminar_checada_ct',$checada->idChecadaCt) }}" title="eliminar"><i class="fa fa-trash"></i></a></center></td>
			</tr>
		@endforeach
	</table>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Sin resultado!</strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 
@endif
@endif
<!--script para busqueda en los select-->

<script type="text/javascript">
	$(document).ready(function() {
		$("#empleado").select2();
	});
</script>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>


    @stop
@stop