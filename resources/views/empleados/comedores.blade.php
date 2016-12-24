@extends('layouts.dashboard')
@section('page_heading','Descuentos de comedor')
@section('section')
 
@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("Descuentos de comedor guardados exitosamente");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('comedores') }}" id="comedores-form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Agregar descuento</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
				<label class="control-label">Empleados <text style="color:red">*</text></label>
				<div >
						<textarea name="empleados" class="form-control" rows="4" cols="71" placeholder="Números de empleado"></textarea>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<input class="form-control" type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">

					<label class="control-label">Semana <text style="color:red">*</text></label>
					<select class="form-control" name="semana">
					@for($i = 1; $i <= 52; $i++)
						<option value="{{$i}}">Semana {{$i}}</option>
					@endfor
					</select>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Cantidad de comedores <text style="color:red">*</text></label>
					<input class="form-control" type="number" name="cantidad">

					<br>
					<center>
						<button class="btn btn-primary" type="submit">
						Guardar
						</button>
					</center>
				</div>
			</div>

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