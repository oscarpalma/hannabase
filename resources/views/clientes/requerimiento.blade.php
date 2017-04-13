@extends('layouts.dashboard')
@section('page_heading','Requerimiento')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.common.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.rtl.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.silver.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.mobile.all.min.css"/>

    
    
@stop
@section('section')


@if(Session::has('mensaje'))
    <script type="text/javascript">
        window.onload = function(){ alert("{{Session::get('mensaje')}}");}
    </script>
@endif


<form class="form-horizontal" role="form" method="POST" action="{{ route('requerimiento') }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
			<div class="col-sm-4">
				<label class="control-label">Empresa<text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="cliente" id="cliente" required="">
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
						<option value="">SELECCIONAR</option>
					</select>
				</div>
			</div>	
				<div class="col-sm-4">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha_ingreso" value="<?php echo date('Y-m-d'); ?>" id="" max="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>

				<div class="col-sm-4">
					
					<label class="control-label">Requerimiento <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="requerimiento"  id="requerimiento"  value="" required="">
					</div>
				</div>
				<div class="col-sm-4">
					<label class="control-label">Ingreso<text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="ingreso"  id="ingreso" value="">
					</div>
				
				</div>
				</div>
				<div class="form-group">
				<br>
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Registrar
						</button>
					</center>
				</div>

			</div>

		</div>
	</div>
</form>


<script type="text/javascript">

	$(document).ready(function() {

		//$("#turno").select2();
		//$("#cliente").select2();

	$('#cliente').on('change', function(e){
    
    var idCliente = e.target.value;
	$("#cliente option[value='null']").hide();
	
    if($("#cliente").val() != "null"){

	    $.get('/ajax-cliente?idCliente=' + idCliente, function(data) {
	    	//console.log(data);

	    	//Muestra los turnos segun el cliente que se ha seleccionado
	       	$('#turno').empty();
	       	$.each(data,function(index,turnosObj){
	       	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	       	});

	    });
	}

	else{
		$('#turno').empty();
	}

	});	

});

</script>
@stop




