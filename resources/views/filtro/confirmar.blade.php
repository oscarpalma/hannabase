@extends('layouts.dashboard')
@section('page_heading','Confirmar datos')
@section('section')

<div class="container-fluid">
	<div class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('Celiminar_descuento', $id)}}" id="confirmar-form"  >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="panel-body">
			<h3>Confirmar</h3>
				<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
					<tr>
						<th>No. Empleado</th>
						<th>Nombre</th>
						<th>Material</th>
						<th>Precio</th>
						<th>Fecha</th>
					</tr>

					<tr>
						<td>{{$descuento['no_empleado']}}</td>
						<td >{{$descuento['nombre']}}</td>
						<td >{{$descuento['material']}}</td>
						<td >{{$descuento['precio']}}</td>
						<td>{{$descuento['fecha']}}</td>
					</tr>
				</table>


				<div class="form-group">
				    <center>
						<input type="submit" class="btn btn-danger" style="margin-right: 15px;" value="Eliminar"/>
							 
						
					</center>
				</div>

			</div>
		</form>
	</div>
</div>

@stop