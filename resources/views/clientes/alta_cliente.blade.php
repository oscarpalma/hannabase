@extends('base')
@section('titulo','Alta Cliente')
@section('cabezera','Alta Cliente')

@section('content')

@if(isset($success))
	<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Cliente registrado con exito
				
	</div>
@elseif(isset($error))
<div class="alert alert-danger alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> Ya existe un cliente con ese nombre
				
	</div>
@endif

<form class="form-horizontal" method="POST" action="{{ route('alta_cliente') }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Nombre <text style="color:red">*</text></label>
					<input class="form-control" name="nombre" required="">
				</div>

				<div class="col-sm-3">
					<label class="control-label">Direccion <text style="color:red">*</text></label>
					<input class="form-control" name="direccion" required="">
				</div>

				<div class="col-sm-3">
					<label class="control-label">Contacto <text style="color:red">*</text></label>
					<input class="form-control" name="contacto" required="">
				</div>

				<div class="col-sm-3">
					<label class="control-label">Telefono <text style="color:red">*</text></label>
					<input class="form-control" name="telefono" required="">
				</div>
			</div>

			<hr>
			<h3>Informacion del turno</h3>
			<div class="row">
				<div class="col-sm-4">
					
					<div>
						<a href="#" class="btn btn-sm btn-success" id="mas" title="Agregar turno"><span class="glyphicon glyphicon-plus"></span>  </a>
						<a href="#" class="btn btn-sm btn-danger" id="menos" title="Eliminar turno"><span class="glyphicon glyphicon-minus"></span>  </a>
					</div>
				</div>
			</div>
			<div id="turnos">
			<div class="row" id="fila_1">
				<div class="col-sm-4">
					<label class="control-label">Hora de entrada <text style="color:red">*</text></label>
					<input class="form-control" name="hora_entrada[]" type="time" required="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Hora de salida <text style="color:red">*</text></label>
					<input class="form-control" name="hora_salida[]" type="time" required="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Horas de trabajo <text style="color:red">*</text></label>
					<input class="form-control" name="horas_trabajadas[]" required="">
				</div>
				
			</div></div>

			<br>

			<div class="form-actions">
				<button class="btn btn-primary" type="submit">Guardar</button>
			</div>

		</div>
	</div>
</form>

@stop

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		
		
		$("#success").delay(2000).hide(600);

		var filas=1;
		$("#mas").click(function (e) {
			e.preventDefault();
			if(filas<5){
				$("#turnos").append('<div class="row" id="fila_'+(filas+1)+'">'+
					'<div class="col-sm-4">'+
					'	<label class="control-label">Hora de entrada <text style="color:red">*</text></label>'+
					'	<input class="form-control" name="hora_entrada[]" type="time" required="">'+
					'</div>'+

					'<div class="col-sm-4">'+
					'	<label class="control-label">Hora de salida <text style="color:red">*</text></label>'+
					'	<input class="form-control" name="hora_salida[]" type="time" required="">'+
					'</div>'+

					'<div class="col-sm-4">'+
					'	<label class="control-label">Horas de trabajo <text style="color:red">*</text></label>'+
					'	<input class="form-control" name="horas_trabajadas[]" required="">'+
					'</div>'+
					
				'</div>');
	            filas++;
        }
		});

		$("#menos").click(function (e) {
			e.preventDefault();
			if (filas>1) {
				$("#fila_"+filas).remove();
				filas--;
			};
		});
	});
</script>
@stop
