@extends('layouts.dashboard')
@section('page_heading','Lista de Inventario')
@section('section')
           
<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
		@if ( empty ( $inventario ) ) 
				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay Inventario Registrado<br><br> 
					
				</div>
			@else
		<div class="tabla">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			    <tr>
			        <th>ID</th>
			        <th>Nombre</th>
			        <th>Modelo</th>
			        <th>Marca</th>
			        <th>Descripcion</th>
			        <th><center>Unidades</center></th>
			        <th><center>Acciones</center></th>
			    </tr>

			    @foreach($inventario as $material) 
				        <tr>
				            <td>{{$material->id}}</td>
				            <td >{{$material->nombre}}</td>
				            <td >{{$material->modelo}}</td>
				            <td>{{$material->marca}}</td>
				            <td>{{$material->descripcion}}</td>
				            <td>{{$material->unidades}}</td>
				            <td><center>
				        
				            	<a href="{{route('eliminar_inventario',$material->id)}}" class="btn btn-danger" title="eliminar"><i class="fa fa-trash"></i></a>
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