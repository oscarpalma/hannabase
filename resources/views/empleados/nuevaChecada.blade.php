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

<form class="form-horizontal" role="form" method="POST" action="{{ route('nuevaChecada') }}" id="checada-form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empresa <text style="color:red">*</text></label>
					<div >								
						<select class="form-control" name="cliente"  id="cliente" required="">
							<option value="">SELECCIONAR</option>
							@foreach($info['clientes'] as $cliente)
								<option name="{{$cliente->idCliente}}" value="{{$cliente->idCliente}}">{{$cliente->nombre}}</option>
							@endforeach
						</select>
					</div>	 
				</div>
			    <div class="col-sm-4">
					<label class="control-label">Turno <text style="color:red">*</text></label>
					<div >
					<select class="form-control" name="turno" id="turno">
						<option value=""></option>
					</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>" id="" max="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>
			</div>

			<hr>
			<!--SECCOIN -->

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado <text style="color:red">*</text></label>
					<div >
						<select name="empleado" id="empleado" class="form-control" data-live-search="true"  style="text-transform:uppercase">
							@foreach($info['empleados'] as $empleado)
								<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<!---->
				<div class="col-sm-4">
					<label class="control-label">Entrada <text style="color:red">*</text></label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input  name="hora_entrada" class="time_element form-control" id="hora_entrada"  />
					</div>
                
				</div>

				<!---->
			    <div class="col-sm-4">
					<label class="control-label">Salida <text style="color:red">*</text></label>
					<div >
						<input   class="form-control" name="hora_salida"  id="hora_salida" value="">
					</div>
				</div>
			</div>
			<div class ="row">
				<div class="col-sm-4">
					
					<label class="control-label">Horas ordinadias <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias"  id="horas_ordinarias"  value="" >
					</div>
				</div>
				<div class="col-sm-4">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra"  id="" value="0">
					</div>
				
				</div>
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

		$("#empleado").select2();
		$("#cliente").select2();


		$('#cliente').on('change', function(e){
        console.log(e);
        var idCliente = e.target.value;
        $("#cliente option[value='null']").hide();

        $.get('/ajax-cliente?idCliente=' + idCliente, function(data) {
        	//console.log(data);

        	//Muestra los turnos segun el cliente que se ha seleccionado
           	$('#turno').empty();
           	$.each(data,function(index,turnosObj){
//if (idCliente=='10'){
 //          			if (turnosObj.idTurno!='24' && turnosObj.idTurno!='25')
 //          			$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
      //     		}else
           	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
           	});
   
        });

        //es necesario actualizar manualmente los horarios cuando se cambia de empresa
        //cuando se ejecuta el codigo, el valor en el select de turnos no ha sido actualizado, por lo que el ajax debe ser con base al cliente
        $.get('/ajax-cliente-turno?idCliente=' + idCliente, function(data) {
         	$.each(data,function(index,horasObj){
         	$("#hora_entrada").val(horasObj.hora_entrada);
         	$("#hora_salida").val(horasObj.hora_salida);
         	$("#horas_ordinarias").val(horasObj.horas_trabajadas);

         	 $(document).ready(function(){
			    $(".time_element");
			  });
 
           	});
   
        });
        
    });

    //Cuando el horario cambia
      $('#turno').on('change', function(e){
        console.log(e);
        var idTurno = e.target.value;

        $.get('/ajax-turno?idTurno=' + idTurno, function(data) {
        	console.log(data); 
         	$.each(data,function(index,horasObj){
         	$("#hora_entrada").val(horasObj.hora_entrada);
         	$("#hora_salida").val(horasObj.hora_salida);
         	$("#horas_ordinarias").val(horasObj.horas_trabajadas);

         	 $(document).ready(function(){
			    $(".time_element");
			  });
 
           	});
   
        });
        
    });
	});
</script>

<script>
	// $(document).ready(function(){
	// 	$('.time_element').timepicki({
	// 		show_meridian:false,
	// 		min_hour_value:0,
	// 		max_hour_value:23,
	// 		step_size_minutes:5,
	// 		overflow_minutes:true,
	// 		increase_direction:'up',
	// 	});
	// });
</script>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>
<script src="http://kendo.cdn.telerik.com/2016.2.607/js/kendo.all.min.js"></script>

    @stop
@stop