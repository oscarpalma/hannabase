@extends('base')
@section('cabezera','Verificar')
@section('content')
<div class ="navbar navbar-default">
<form class="navbar-form navbar-left">
	<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
		<tr>
			<th>Nombre</th>
			<th>CURP</th>
			<th>Estado</th>
			<th>Observaciones</th>
		</tr>

		<tr>
			<td>{{$prospectos['nombre']}}</td>
			<td>{{$prospectos['curp']}}</td>
			<td>{{$prospectos['estado']}}</td>
			<td>{{$prospectos['observacion']}}</td>
		</tr>
	</table>

  
  <button type="submit" class="btn btn-default">Buscar</button>
</form>
</div>

@stop
