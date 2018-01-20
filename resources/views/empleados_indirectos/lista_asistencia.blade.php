@extends('base')
@section('cabezera','Lista Asistencia')
@section('css')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('content')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('lista_asistencia') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<label class="control-label">Empleado</label>
					<div>
						<textarea name="empleados" class="form-control" rows="4" placeholder="Números de empleado"></textarea>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Empresa <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="cliente" id="cliente">
							@foreach($clientes as $cliente)
								<option value="{{$cliente->idCliente}}">{{$cliente->nombre}}</option>
							@endforeach
						</select>
					</div>

					<label class="control-label">Turno <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="turno" id="turno">
						<option value="null">SELECCIONAR</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<br>
			    <center>
					<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
						Buscar
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

@if(isset($empleados))

<div>
	<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'  id="tblExport">
		<thead>
			<tr>
				<th colspan="9"><center>Centro de Trabajo</center></th>
			</tr>
			<tr>
				<th colspan="5">{{$empresa->nombre}}</th>
				<th colspan="4">Supervisor:</th>
			</tr>
			<tr>
				<th colspan="5">Turno: {{$horario}}</th>
				<th colspan="4">Fecha: </th>
			</tr>
		</thead>
	</table>

	<br>
	<br>

	<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
		<tbody>
			<tr>
				<th>#</th>
				<th>ID</th>
				<th>Nombre</th>
				<th>Puesto</th>
				<th>Entrada</th>
				<th>Salida</th>
				<th>Firma</th>
				<th>Comedor</th>
				<th>Horas Extra</th>
			</tr>
			<?php $cont = 1; ?>
			@foreach($empleados as $empleado)
			<tr>
				<td>{{$cont++}}</td>
				<td>{{$empleado->idEmpleado}}</td>
				<td>{{$empleado->ap_paterno}} {{$empleado->ap_materno}} {{$empleado->nombres}}</td>
				<td>Operador</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			@endforeach

			@for($i = 0; $i < 10; $i++)
			<tr rowspan="2">
				<td >{{$cont++}}</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			@endfor
		</tbody>
	</table>

	<br>
	<br>

	<table hidden="">
		<thead>
			<tr>
				<td></td>
				<td></td>
				<td><center>___________________</center></td>
				<td></td>
				<td></td>				
				<td colspan="3"><center>___________________</center></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><center>Firma Supervisor Interno</center></td>
				<td></td>
				<td></td>				
				<td colspan="3"><center>Firma Supervisor</center></td>
			</tr>
		</thead>
	</table>
</div>

<br>
<button name="boton" type="button" id="btnExport" class="btn btn-success"> Exportar <img src="../../imagenes/excel.ico" height="25px" width="25px"></button>

@endif

 






@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("static/js/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("static/js/jquery.base64.js") }}" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
        	var cliente= "@if(isset($empresa)) {{$empresa->nombre}} @endif";
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'lista '+cliente
               
            });
        });

         $("#btnCliente").click(function () {
        	var cliente= "@if(isset($parametros['reporte'])){{$parametros['semana']}} {{$parametros['reporte']['cliente']}}@endif";
        	var worksheet= "@if(isset($parametros['reporte'])){{$parametros['reporte']['cliente']}}@endif"
            $("#tblExport").btechco_excelexport({
                containerid: "tablaCliente"
               , datatype: $datatype.Table
               , filename: 'semana '+cliente
               , nombre: worksheet
               
            });
        });
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
	       	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	       	});

	    });

});
    });

   
</script>

    @stop