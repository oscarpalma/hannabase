@extends('layouts.dashboard')
@section('page_heading','Eliminar Empleado de CT')
@section('section')
<div class="container-fluid">
	<div class="row">
	<form class="form-horizontal" role="form" method="POST" action="{{ route('empleadoCt/destroy', $empleado['empleado']->idEmpleadoCt) }}" id="registro-form"  >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			<h4>El siguiente empleado sera eliminado</h4>
			    <tr>
			        <th>ID</th>
			        <th>Nombre</th>
			        <th>CURP</th>
			        <th>IMSS</th>
			        <th>RFC</th>
			        <th><center>Area</center></th>
			    </tr>

		        <tr>
		            <td>{{ $empleado['empleado']->idEmpleadoCt }}</td>
		            <td >{{ $empleado['empleado']->ap_paterno}} {{ $empleado['empleado']->ap_materno}} , {{$empleado['empleado']->nombres}}</td>
		            <td >{{ $empleado['empleado']->curp}}</td>
		            <td>{{$empleado['empleado']->imss}}</td>
		            <td>{{$empleado['empleado']->rfc}}</td>
		            <td ><center> {{ $empleado['area']->nombre}}</center></td>
		        </tr>
			</table>

			<div class="form-group">
			    <center>
					<button type="submit" class="btn btn-danger" value="validate" style="margin-right: 15px;">
						Eliminar
					</button>
				</center>
			</div>
			</div>
			</form>
		</div>
	</div>
</div>

@stop