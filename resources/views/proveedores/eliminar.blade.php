@extends('base')
@section('cabezera','Eliminar Proveedor')
@section('content')



<form class="form-horizontal" role="form" method="POST" action="{{route('eliminar_proveedor',$proveedor->id)}}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Nombre</label>
					<input class="form-control" name="nombre" required="" value="{{$proveedor->nombre}}" readonly>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Contacto</label>
					<input class="form-control" name="contacto" required="" value="{{$proveedor->contacto}}" readonly>
				</div>

				<div class="col-sm-4">
					<label class="control-label">E-Mail</label>
					<input class="form-control" name="email" required="" value="{{$proveedor->email}}" readonly>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Telefono</label>
					<input class="form-control" name="telefono" required="" value="{{$proveedor->telefono}}" readonly>
				</div>				

				<div class="col-sm-4">
					<label class="control-label">Credito</label>
					<input class="form-control" name="credito" required="" value="{{$proveedor->credito}}" readonly>
				</div>

				<div class="col-sm-4">
					<br>
					<center>
						<button class="btn btn-danger" type="submit">Eliminar</button>
					</center>
				</div>
			</div>
		</div>
	</div>
</form>
@stop
