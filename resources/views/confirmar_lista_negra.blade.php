@extends('layouts.dashboard')
@section('page_heading','Enviar a lista negra')
@section('section')
<div class="container-fluid">
	<div class="row">
	<form class="form-horizontal" role="form" method="POST" action="{{ route('lista_negra_agregar', $empleado->idEmpleado) }}"  >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			<h4>El siguiente candidato sera agregado a la lista negra</h4>
			    <tr>
			        <th>ID</th>
			        <th>Nombre</th>
			        <th>CURP</th>
			        <th>IMSS</th>
			        <th>RFC</th>
			        <th><center>Perfil</center></th>
			    </tr>

		        <tr>
		            <td>{{ $empleado->idEmpleado }}</td>
		            <td >{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}} , {{$empleado->nombres}}</td>
		            <td >{{ $empleado->curp}}</td>
		            <td>{{$empleado->imss}}</td>
		            <td>{{$empleado->rfc}}</td>
		            <td ><center> {{ $empleado->tipo_perfil}}</center></td>
		        </tr>
			</table>

			<div class="form-group">
			    <center>
					<button type="submit" class="btn btn-danger" value="validate" style="margin-right: 15px;">
						Aceptar
					</button>
				</center>
			</div>
			</div>
			</form>
		</div>
	</div>
</div>

@stop
