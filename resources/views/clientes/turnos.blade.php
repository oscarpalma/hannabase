@extends('layouts.dashboard')
@section('page_heading','Turnos')
@section('section')
           
<form class="form-horizontal" role="form" method="POST" action="{{ route('turnos',$cliente->idCliente) }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel panel-primary">
	<div class="panel-heading"><strong>{{$cliente->nombre}}</strong></div>
		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			    <tr>
			        <th>Entrada</th>
			        <th>Salida</th>
			        <th>Horas</th>
			        <th><center>Acciones</center></th>
			    </tr>

			    @foreach($turnos as $turno) 
				        <tr>
				            <td >{{$turno->hora_entrada}}</td>
				            <td >{{$turno->hora_salida}}</td>
				            <td>{{$turno->horas_trabajadas}}</td>
				            <td><center>
				            	<a href="{{route('eliminar_turno',$turno->idTurno)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
				            </center></td>
				        </tr>
			    @endforeach
			</table>
		</div>
	</div>

	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Agregar Turno</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>

			<div class="row">
			<input hidden="" value="{{$cliente->idCliente}}" name="idCliente">
				<div class="col-sm-4">
					<label class="control-label">Hora de entrada <text style="color:red">*</text></label>
					<input class="form-control" name="hora_entrada" type="time" required="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Hora de salida <text style="color:red">*</text></label>
					<input class="form-control" name="hora_salida" type="time" required="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Horas de trabajo <text style="color:red">*</text></label>
					<input class="form-control" name="horas_trabajadas" required="">
				</div>
			</div>

			<br>

			<center>
				<button class="btn btn-primary" type="submit">Guardar</button>
			</center>
		</div>
	</div>
</form>

@stop