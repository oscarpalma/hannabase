@extends('base')
@section('cabezera','Lista de Proveedores')
@section('content')
           

		@if ( empty ( $proveedores ) ) 
				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No hay proveedores Registrados<br><br> 
					
				</div>
			@else
			  <div class="panel panel-primary">
                        <div class="panel-heading"></div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
		<div class="tabla">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			    <tr>
			        <th>ID</th>
			        <th>Nombre</th>
			        <th>Contacto</th>
			        <th>Telefono</th>
			        <th>E-Mail</th>
			        <th>Credito</th>
			        <th><center>Acciones</center></th>
			    </tr>

			    @foreach($proveedores as $proveedor) 
				        <tr>
				            <td>{{$proveedor->id}}</td>
				            <td >{{$proveedor->nombre}}</td>
				            <td >{{$proveedor->contacto}}</td>
				            <td>{{$proveedor->telefono}}</td>
				            <td>{{$proveedor->email}}</td>
				            <td>{{$proveedor->credito}}</td>
				            <td><center>
				            	<a href="{{route('editar_proveedor',$proveedor->id)}}" class="btn btn-primary btn-sm btn-circle" title="editar"><i class="fa fa-edit"></i></a>
				            	<a href="{{route('eliminar_proveedor',$proveedor->id)}}" class="btn btn-danger btn-sm btn-circle" title="eliminar"><i class="fa fa-trash"></i></a>
				            </center></td>
			            </tr>
			    @endforeach
			</table>
			</div>
			</div>
			</div>
			@endif
	

@stop