@extends('layouts.dashboard')
@section('page_heading','Agregar Checada')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />

<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.common.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.rtl.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.silver.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.mobile.all.min.css"/>
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

<form class="form-horizontal" role="form" method="POST" action="{{ route('agregar_checada_ct') }}" id="checada-form">
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
			</div>

			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Entrada <text style="color:red">*</text></label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input  name="hora_entrada" class="time_element form-control" id="hora_entrada" value="" required="" />
					</div>
                
				</div>

				<!---->
			    <div class="col-sm-3">
					<label class="control-label">Salida <text style="color:red">*</text></label>
					<div >
						<input   class="form-control" name="hora_salida"  id="hora_salida" value="" required="">
					</div>
				</div>

				<div class="col-sm-3">
					
					<label class="control-label">Horas ordinadias <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias"  id="horas_ordinarias"  value="" required="">
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra"  id="" value="0">
					</div>
				
				</div>
			</div>
			<!--SECCOIN -->

			<hr>
			<div class="row">
				
				<!---->
				<div class="col-sm-3">
					<label class="control-label">Entrada</label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input  name="hora_entrada2" class="time_element form-control" id="hora_entrada2" value="" />
					</div>
                
				</div>

				<!---->
			    <div class="col-sm-3">
					<label class="control-label">Salida</label>
					<div >
						<input   class="form-control" name="hora_salida2"  id="hora_salida2" value="">
					</div>
				</div> 

				<div class="col-sm-3">
					
					<label class="control-label">Horas ordinadias</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias2"  id="horas_ordinarias"  value="" >
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra2"  id="" value="0">
					</div>
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Incidencia</label>
					<select class="form-control" name="incidencia">
						<option value="xx">Ninguna</option>
						<option value="falta_justificada">Falta justificada</option>
						<option value="falta_injustificada">Falta injustificada</option>
						<option value="permiso">Permiso</option>
					</select>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">Comentarios</label>
					<textarea class="form-control" name="comentarios"></textarea>
				</div>
			</div>
			
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

<!--script para busqueda en los select-->

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

		$("#empleado").select2();
	});
</script>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>

<script src="http://kendo.cdn.telerik.com/2016.2.607/js/kendo.all.min.js"></script>
    @stop
@stop