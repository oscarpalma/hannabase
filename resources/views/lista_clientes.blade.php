@extends('layouts.dashboard')
@section('page_heading','Lista de Clientes')
@section('section')
           
<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
		@if ( empty ( $clientes ) ) 
				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay Clientes Registrados<br><br> 
					
				</div>
			@else
		<div class="tabla">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			    <tr>
			        <th>ID</th>
			        <th>Nombre</th>
			        <th>Direccion</th>
			        <th>Telefono</th>
			        <th>Contacto</th>
			        <th><center>Acciones</center></th>
			    </tr>

			    @foreach($clientes as $cliente) 
				        <tr>
				            <td>{{$cliente->idCliente}}</td>
				            <td >{{$cliente->nombre}}</td>
				            <td >{{$cliente->direccion}}</td>
				            <td>{{$cliente->telefono}}</td>
				            <td>{{$cliente->contacto}}</td>
				            <td><center>
				            	<a href="{{route('turnos',$cliente->idCliente)}}" class="btn btn-primary" title="turnos"><i class="fa fa-list-ol"></i></a>
				            	<a href="{{route('editar_cliente',$cliente->idCliente)}}" class="btn btn-primary" title="editar"><i class="fa fa-edit"></i></a>
				            	<a href="{{route('eliminar_cliente',$cliente->idCliente)}}" class="btn btn-danger" title="eliminar"><i class="fa fa-trash"></i></a>
				            </center></td>
			            </tr>
			    @endforeach
			</table>
			</div>
			@endif
		</div>
	</div>
</div>

@stop