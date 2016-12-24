@extends('layouts.dashboard')
@section('page_heading','Blank')
@section('section')
@foreach($prospectos as $prospecto)
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			<tr>
				<th>Nombre</th>
				<th>CURP</th>
				<th>Estado</th>
				<th>Observaciones</th>
			</tr>

			<tr>
				<td>{{$prospecto['nombre']}}</td>
				<td>{{$prospecto['curp']}}</td>
				<td>{{$prospecto['estado']}}</td>
				<td>{{$prospecto['observacion']}}</td>
			</tr>
		</table>
	@endforeach
@stop
