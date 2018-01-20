@extends('base')
@section('cabezera','Editar Proveedor')
@section('content')




<form class="form-horizontal" role="form" method="POST" action="{{route('editar_proveedor',$proveedor->id)}}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Nombre <text style="color:red">*</text></label>
					<input class="form-control" name="nombre" required="" value="{{$proveedor->nombre}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Contacto <text style="color:red">*</text></label>
					<input class="form-control" name="contacto" required="" value="{{$proveedor->contacto}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">E-Mail <text style="color:red">*</text></label>
					<input class="form-control" name="email" required="" value="{{$proveedor->email}}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Telefono <text style="color:red">*</text></label>
					<input class="form-control" name="telefono" required="" value="{{$proveedor->telefono}}">
				</div>				

				<div class="col-sm-4">
					<label class="control-label">Credito <text style="color:red">*</text></label>
					<input class="form-control" name="credito" required="" value="{{$proveedor->credito}}">
				</div>

				<div class="col-sm-4">
					<br>
					<center>
						<button class="btn btn-primary" type="submit">Guardar</button>
					</center>
				</div>
			</div>
		</div>
	</div>
</form>
@stop
