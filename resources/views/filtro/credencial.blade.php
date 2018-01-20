@extends('base')
@section('cabezera','Nueva Credencial')
@section('content')

<div class ="navbar navbar-default">
	<form class="navbar-form navbar-left" method="post" >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">	
		<div class="form-group">
		    <input type="text" class="form-control"  name="empleadoid" required="" value="" placeholder="No. Empleado"> 
		</div>
		<button type="submit" class="btn btn-primary " ><i class="fa fa-search " aria-hidden="true"></i> Buscar </button> 
	</form>
</div>

<!-- Agregar resultados de busqueda -->
@if(isset($prospectos))
@if(!empty($prospectos))
	<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Datos Localizacion</th>
			<th>Estado</th>
			<th>Observaciones</th>
			<th>Generar Credencial</th>
		</tr>

		@foreach($prospectos as $prospecto)
		<!--La credencial solo se realizara a empleados que puedan trabajar-->
		@if($prospecto['observacion'] != "Lista negra")
			<tr>
				<td>{{$prospecto['noempleado']}}</td>
				<td>{{$prospecto['nombre']}}</td>
				<td>{{$prospecto['localizacion']}}</td>
				<td>{{$prospecto['estado']}}</td>
				<td>{{$prospecto['observacion']}}</td>
				@if(is_null($prospecto['foto']))
				<td><center><p style="color:orange">No se ha subido fotografia</p></center></td>
				@else
				<td><a href="/filtro/detalle_credencial/{{$prospecto['noempleado']}}" data-toggle="modal" class="btn btn-primary" > Ver</a></td>
				@endif
			</tr>
		@endif
		@endforeach
	</table>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Sin resultado!</strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 
@endif
@endif
            
@stop
