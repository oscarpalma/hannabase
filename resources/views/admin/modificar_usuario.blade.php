@extends('layouts.dashboard')
@section('page_heading','Modificar usuario')
@section('section')

<div class="panel panel-primary">
	<div class="panel-heading"><strong>Informacion de usuario</strong></div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('cambiar_privilegios', $usuario->id) }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Nombre</label>
					<input type="text" class="form-control" name="name" readonly="" value="{{$usuario->nombre}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">E-Mail</label>
					<input type="email" class="form-control" name="email" readonly="" value="{{$usuario->email}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Tipo de usuario</label>
					<select class="form-control" name="role">
						<option value="administrador" @if($usuario->role == 'administrador') selected="" @endif>Administrador</option>
						<option value="supervisor" @if($usuario->role == 'supervisor') selected="" @endif>Supervisor</option>
						<option value="recepcion" @if($usuario->role == 'recepcion') selected="" @endif>Recepcion</option>
						<option value="filtro" @if($usuario->role == 'filtro') selected="" @endif>Filtro</option>
						<option value="enfermeria" @if($usuario->role == 'enfermeria') selected="" @endif>Enfermeria</option>
						<option value="contabilidad" @if($usuario->role == 'contabilidad') selected="" @endif>Contabilidad</option>
					</select>
				</div>
			</div>

			<div class="row">
				<center>
					<br>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</center>
			</div>
		</form>
	</div>
</div>
@stop