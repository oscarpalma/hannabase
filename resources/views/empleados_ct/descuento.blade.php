@extends('layouts.dashboard')
@section('page_heading','Descuento')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')

<script src="bower_components/chained/jquery.chained.min.js"></script>
<!--
<script>
  $(document).ready(function(){
    $(".time_element").timepicki();
  });
</script>
-->
@if(Session::has('success'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('success')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('descuento-empleado') }}" id="descuento-form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Empleado <text style="color:red">*</text></label>
					<div >
						<select name="empleado" id="empleado" class="form-control" data-live-search="true"  style="text-transform:uppercase">
							@foreach($empleados as $empleado)
								<option value="{{$empleado->idEmpleadoCt}}">{{$empleado->idEmpleadoCt}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-3">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>" id="" max="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Monto <text style="color:red">*</text></label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input type="number" name="monto"  step="0.01" class="time_element form-control" id="monto" value="" required="" min="0" />
					</div>
                
				</div>
			</div>

			<div class="row">
				

				<!---->
			    <div class="col-sm-3">
					<label class="control-label">Concepto <text style="color:red">*</text></label>
					<div >
						<input type="text"  class="form-control" name="concepto"  id="concepto" value="" required="">
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana" >
							@for($i = 1; $i<=53; $i++)
								<option value="{{$i}}">Semana {{$i}}</option>
							@endfor
						</select>
					</div>
				</div>
				
			</div>
			<!--SECCOIN -->

			

			

			
			<div class="row"><div class="form-group">
			<br>
			    <center>
					<button type="submit" class="btn btn-primary" >
						Enviar
					</button>
				</center>
			</div></div>
			
		</div>
	</div>
</form>

<!--Hacer que los textarea no puedan ser cambiados de tamano-->
<style type="text/css">
	textarea {
    resize: none;
}
</style>


@stop