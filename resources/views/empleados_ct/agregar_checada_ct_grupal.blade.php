@extends('layouts.dashboard')
@section('page_heading','Agregar Checada Grupal')
@section('head')

<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.common.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.rtl.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.silver.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.mobile.all.min.css"/>

    
    
@stop
@section('section')
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->


@if(Session::has('success'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('success')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('checada_grupal_ct') }}" id="checada-form">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">		
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha"  id="" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
					</div>

					<label class="control-label">Empleados <text style="color:red">*</text></label>
					<div >
						<textarea name="empleados" class="form-control" rows="4" cols="71" placeholder="Números de empleado"></textarea>
					</div>

					<label class="control-label">Incidencia</label>
					<select class="form-control" name="incidencia">
						<option value="xx">Ninguna</option>
						<option value="falta_justificada">Falta justificada</option>
						<option value="falta_injustificada">Falta injustificada</option>
						<option value="permiso">Permiso</option>
					</select>
				</div>
				<!---->
				<div class="col-sm-2">
					<label class="control-label">Entrada <text style="color:red">*</text></label>
					<div >
					<input   class="form-control"  name="hora_entrada"  id="hora_entrada"  required="">
					</div>

					<label class="control-label">Entrada</label>
					<div >
					<input   class="form-control"  name="hora_entrada2"  id="hora_entrada2" >
					</div>
				</div>

				<!---->
			    <div class="col-sm-2">
					<label class="control-label">Salida <text style="color:red">*</text></label>
					<div >
						<input   class="form-control" name="hora_salida"  id="hora_salida" required="">
					</div>

					<label class="control-label">Salida</label>
					<div >
						<input   class="form-control" name="hora_salida2"  id="hora_salida2" >
					</div>
				</div>
				<div class="col-sm-2">
					<label class="control-label">Horas ordinadias <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias"  id="horas_ordinarias"  required="">
					</div>


					<label class="control-label">Horas ordinadias</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias2"  id="horas_ordinarias2"  >
					</div>
				</div>
				<div class="col-sm-2">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra"  id="" value="0">
					</div>

					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra2"  id="horas_extra2" value="0">
					</div>
				</div>
				<div class="col-md-8">
					<label class="control-label">Comentarios</label>
					<textarea class="form-control" rows="4" name="comentarios"></textarea>
				</div>
			</div>
			<br>
			<div class="form-group">
			    <center>
					<button type="submit" class="btn btn-primary" >
						Enviar
					</button>
				</center>
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

<script type="text/javascript">
$(document).ready(function() {
	$("#hora_entrada").kendoTimePicker({
 			 
 			format: "HH:mm",
 			animation: {
			   open: {
			     effects: "zoom:in",
			     duration: 300
			   }
 				 },
		});

		$("#hora_salida").kendoTimePicker({
 			 
 			format: "HH:mm",
 			animation: {
			   open: {
			     effects: "zoom:in",
			     duration: 300
			   }
 			 },
		});

		$("#hora_entrada2").kendoTimePicker({
 			 
 			format: "HH:mm",
 			animation: {
			   open: {
			     effects: "zoom:in",
			     duration: 300
			   }
 				 },
		});

		$("#hora_salida2").kendoTimePicker({
 			 
 			format: "HH:mm",
 			animation: {
			   open: {
			     effects: "zoom:in",
			     duration: 300
			   }
 			 },
		});

	});
</script>

@section('scripts')

<script src="http://kendo.cdn.telerik.com/2016.2.607/js/kendo.all.min.js"></script>

    @stop

@stop