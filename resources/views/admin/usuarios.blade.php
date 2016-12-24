@extends('layouts.dashboard')
@section('page_heading','Lista de Usuarios')
@section('section')

<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			    <tr>
			        <th>ID</th>
			        <th>Nombre</th>
			        <th><center>E-Mail</center></th>
			        <th><center>Tipo de usuario</center></th>
			        <th><center>Acciones</center></th>
			    </tr>

			    @foreach($usuarios as $usuario) 
@if ($usuario->role != '')				        
<tr>
				            <td>{{$usuario->id}}</td>
				            <td >{{$usuario->nombre}}</td>
				            <td ><center>{{$usuario->email}}</center></td>
				            @if ($usuario->role == 'sinasignar')
				            <td style="color:red;"><center>{{$usuario->role}}</center></td>
				            @else
				            <td><center>{{$usuario->role}}</center></td>
				            @endif
				            @if($usuario == Auth::user())
				            	<td style="color:gray;"><center>Usuario Actual</center></td>
				            @else
				            	<td><center>					            	
			            			<a class="btn btn-warning" href="{{ route('cambiar_privilegios',$usuario->id) }}" title="cambiar privilegios" ><i class="fa fa-shield"></i></a>

				            		<a class="btn btn-danger" href="{{ route('eliminar_usuario',$usuario->id) }}" title="eliminar" ><i class="fa fa-trash"></i></a>
				            	</center></td>
				            @endif
			            </tr>
  @endif
			    @endforeach
			</table>
		</div>
	</div>
</div>

@stop