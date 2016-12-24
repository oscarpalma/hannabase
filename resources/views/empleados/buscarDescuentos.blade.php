@extends('layouts.dashboard')
@section('page_heading','Buscar Descuentos de Comedor')
@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@stop
@section('section')



<form class="form-horizontal" role="form" method="POST" action="{{ route('buscar_descuentos') }}" id="buscar_descuento">
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
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div>
						<input class="form-control" name="fecha" type="date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
						<!--La fecha 2 o final sera el dia actual por defecto-->
					</div>


				</div>
				
				

			
		</div>
		<div class="row"><div class="col-sm-10">
					<br>
				    <center>

						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Buscar
						</button>
					</center>
				</div></div>
	</div></div>
</form>

@if(isset($parametros['descuentos']))
{{$parametros['fecha']}}
@if(count($parametros['descuentos'])>0)
	<br>
	<h1>Resultados de búsqueda</h1>
	<br>

	
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
			<th><center>ID</center></th>
			
			<th><center>Semana</center></th>
			<th><center>Fecha</center></th>
			<th><center>Cantidad</center></th>
			<th><center>Seleccionar</center></th>
			
		</tr>

		<?php $cont = 1; ?>
		@foreach($parametros['descuentos'] as $descuento)
			<tr>
				<td><center>{{$cont++}}</center></td>
				<td><center>{{$descuento->idEmpleado}}</center></td>
				<td><center>{{$descuento->semana}}</center></td>
				<td><center>{{$descuento->fecha}}</center></td>
				<td><center>{{$descuento->cantidad}}</center></td>
				

				

				
				<td><center>
				<input type="checkbox" name="descuentos[]" value="{{$descuento->id}}" class="btn-danger"> 
				</center></td>
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
		
	});
</script>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>



    @stop

@stop