@extends('layouts.dashboard')
@section('page_heading','Agregar Cliente Nuevo')
@section('section')

@if(Session::has('mensaje'))
    <script type="text/javascript">
        window.onload = function(){ alert("{{Session::get('mensaje')}}");}
    </script>
@endif
<!--
<script>
  $(document).ready(function(){
    $(".time_element").timepicki();
  });
</script>
-->

<form class="form-horizontal" role="form" method="POST" action="{{ route('agregar_cliente') }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
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
