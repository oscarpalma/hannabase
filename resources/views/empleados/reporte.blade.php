@extends('layouts.dashboard')
@section('page_heading','Generar Reporte')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('reporte') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				<center><label>Semana Actual {{date("W")}}</label></center>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado</label>
					<div>
						<select class="form-control" id="empleado" name="empleado" style="text-transform:uppercase">
							<!--en caso de no especificar ninguno-->
							<option value="null">Todos</option>
							@foreach($parametros['empleados'] as $empleado)
								<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Empresa <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="cliente" id="cliente">
							<!--en caso de no especificar ninguno-->
							<option value="null">SELECCIONAR</option>
							@foreach($parametros['clientes'] as $cliente)
								<option value="{{$cliente->idCliente}}">{{$cliente->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Turno <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="turno" id="turno">
							<!--en caso de no especificar ninguno-->
							<option value="null">SELECCIONAR</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
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

				<div class="col-sm-4">
					<label class="control-label">Año <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="year">
						<!--desde 2013 hasta el anio actual, como en coen-->
							@for($i = date('Y'); $i >= 2013; $i--)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
					</div>
				</div>

				<div class="col-sm-4">
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

@if(isset($parametros['reporte']))
@if(!empty($parametros['reporte']['empleados']))
	<br>
	
	<h1>Reporte - Semana {{$parametros['semana']}}</h1>
	
	<br>

	<!--Tabla con los resultados de la busqueda-->
	<div id="dvData" style="overflow:scroll; overflow:auto;">
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' >
			<thead >
				<tr>
					<th colspan="28" style="" ></th>
					<th colspan="6" align="right" style="" ><center>TOTAL</center></th>
				</tr>

				<tr>
					<th colspan="4" style=""  value="{{$parametros['reporte']['cliente']}}" id="clienteT">Cliente: {{$parametros['reporte']['cliente']}}</th>
					<th colspan="3" style="" >Horario: {{$parametros['reporte']['turno']}}</th>
					@for($i = 1; $i <= 7; $i++)
						<th colspan="2" style="" >Personas</th>
						<th style="" >{{$parametros['reporte']['dias'][$i]['personas']}}</th>
					@endfor
					<th style="" >{{$parametros['reporte']['total_dias']}}</th>
					<th style="" >{{$parametros['reporte']['total_horas_ordinarias']}}</th>
					<th style="" >{{$parametros['reporte']['total_horas_extra']}}</th>
					<th style="" ><center>{{$parametros['reporte']['total_descuentos']}}</center></th>
					<th style="" ><center>{{$parametros['reporte']['total_reembolsos']}}</center></th>
					<th style="" > <center>{{$parametros['reporte']['total_comedores']}}</center></th>
				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					$fecha1 = new DateTime($parametros['fecha1']);
					$fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$meses =[
					'January' => 'Enero',
					'February' => 'Febrero',
					'March' => 'Marzo',
					'April' => 'Abril',
					'May'   => 'Mayo',
					'June'  => 'Junio',
					'July'  => 'Julio',
					'August' => 'Agosto',
					'September' => 'Septiembre',
					'October' => 'Octubre',
					'November' => 'Noviembre',
					'December' => 'Diciembre'];
				?>

				<tr>
					<th colspan="4" style="" >Semana {{$parametros['semana']}}</th>
					<th colspan="3" style="" >Del {{$fecha1->format('j')}} de {{$meses[$fecha1->format('F')]}} @if($fecha1->format('Y') != $fecha2->format('Y')) del {{$fecha1->format('Y')}} @endif al {{$fecha2->format('j')}} de {{$meses[$fecha2->format('F')]}} del {{$fecha2->format('Y')}}</th>
					<th colspan="3" style="" >Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="3" style="" >Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="3" style="" >Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="3" style="" >Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="3" style="" >Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="3" style="" >Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="3" style="" >Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="3" style="" >Total trabajado</th>
					<th rowspan="2" style="" >Descuentos</th>
					<th rowspan="2" style="" >Reembolsos</th>
					<th rowspan="2" style="" >Comedores</th>
				</tr>

				<tr>
					<th style="" >#</th>
					<th style="" >ID</th>
					<th style="" >A. Paterno</th>
					<th style="" >A. Materno</th>
					<th style="" >Nombre</th>
					<th style="" >Puesto</th>
					<th style="" ># de Cuenta</th>

					@for($i = 0; $i < 7; $i++)
						<th style="" >C.P</th>
						<th style="" >R/T</th>
						<th style="" >O/T</th>
					@endfor

					<th style="" >Dias</th>
					<th style="" >R/T</th>
					<th style="" >O/T</th>
					
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 1;
				?>
				@foreach($parametros['reporte']['empleados'] as $empleado)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$empleado['id']}}</td>
						<td>{{strtoupper($empleado['ap_paterno'])}}</td>
						<td>{{strtoupper($empleado['ap_materno'])}}</td>
						<td>{{strtoupper($empleado['nombre'])}}</td>
						<td>OPERADOR</td>

					        @if($empleado['no_cuenta'] === null)
							<td><center></center></td>
						@else
							<td><center>{{$empleado['no_cuenta']}}</center></td>
						@endif

						<!--se usara como contador para los dias trabajados-->
						<?php
						$diasTrabajados = 0;
						?>
						@foreach($empleado['checadas'] as $checada)
							@if($checada != null)
								<td>{{$parametros['reporte']['cliente']}}</td>
								<td>{{$checada->horas_ordinarias}}</td>
								<td>{{$checada->horas_extra}}</td>
								<?php $diasTrabajados++;?>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif
						@endforeach
						<td>{{$diasTrabajados}}</td>
						<td>{{$empleado['horas_ordinarias']}}</td>
						<td>{{$empleado['horas_extra']}}</td>
						<td><center>{{$empleado['descuentos']}}</center></td>
						<td><center>{{$empleado['reembolsos']}}</center></td>
						<td><center>{{$empleado['comedores']}}</center></td>		
					</tr>
			@endforeach
			</tbody>

		</table>



	</div>
	<div>
<!-- Tabla identica a la anterior para descargar con color -->
<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="tblExport" hidden="">
			<thead >
				<tr>
					<th colspan="28" style="" class="color"></th>
					<th colspan="6" align="right" style="" class="color"><center>TOTAL</center></th>
				</tr>

				<tr>
					<th colspan="4" style="" class="color" value="{{$parametros['reporte']['cliente']}}" id="clienteT">Cliente: {{$parametros['reporte']['cliente']}}</th>
					<th colspan="3" style="" class="color">Horario: {{$parametros['reporte']['turno']}}</th>
					@for($i = 1; $i <= 7; $i++)
						<th colspan="2" style="" class="color">Personas</th>
						<th style="" class="color">{{$parametros['reporte']['dias'][$i]['personas']}}</th>
					@endfor
					<th style="" class="color">{{$parametros['reporte']['total_dias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_ordinarias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_extra']}}</th>
					<th style="" class="color"><center>{{$parametros['reporte']['total_descuentos']}}</center></th>
					<th style="" class="color"><center>{{$parametros['reporte']['total_reembolsos']}}</center></th>
					<th style="" class="color"> <center>{{$parametros['reporte']['total_comedores']}}</center></th>
				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					$fecha1 = new DateTime($parametros['fecha1']);
					$fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$meses =[
					'January' => 'Enero',
					'February' => 'Febrero',
					'March' => 'Marzo',
					'April' => 'Abril',
					'May'   => 'Mayo',
					'June'  => 'Junio',
					'July'  => 'Julio',
					'August' => 'Agosto',
					'September' => 'Septiembre',
					'October' => 'Octubre',
					'November' => 'Noviembre',
					'December' => 'Diciembre'];
				?>

				<tr>
					<th colspan="4" style="" class="color">Semana {{$parametros['semana']}}</th>
					<th colspan="3" style="" class="color">Del {{$fecha1->format('j')}} de {{$meses[$fecha1->format('F')]}} @if($fecha1->format('Y') != $fecha2->format('Y')) del {{$fecha1->format('Y')}} @endif al {{$fecha2->format('j')}} de {{$meses[$fecha2->format('F')]}} del {{$fecha2->format('Y')}}</th>
					<th colspan="3" style="" class="color">Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="3" style="" class="color">Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="3" style="" class="color">Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="3" style="" class="color">Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="3" style="" class="color">Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="3" style="" class="color">Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="3" style="" class="color">Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="3" style="" class="color">Total trabajado</th>
					<th rowspan="2" style="" class="color">Descuentos</th>
					<th rowspan="2" style="" class="color">Reembolsos</th>
					<th rowspan="2" style="" class="color">Comedores</th>
				</tr>

				<tr>
					<th style="" class="color">#</th>
					<th style="" class="color">ID</th>
					<th style="" class="color">A. Paterno</th>
					<th style="" class="color">A. Materno</th>
					<th style="" class="color">Nombre</th>
					<th style="" class="color">Puesto</th>
					<th style="" class="color"># de Cuenta</th>

					@for($i = 0; $i < 7; $i++)
						<th style="" class="color">C.P</th>
						<th style="" class="color">R/T</th>
						<th style="" class="color">O/T</th>
					@endfor

					<th style="" class="color">Dias</th>
					<th style="" class="color">R/T</th>
					<th style="" class="color">O/T</th>
					
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 1;
				?>
				@foreach($parametros['reporte']['empleados'] as $empleado)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$empleado['id']}}</td>
						<td>{{strtoupper($empleado['ap_paterno'])}}</td>
						<td>{{strtoupper($empleado['ap_materno'])}}</td>
						<td>{{strtoupper($empleado['nombre'])}}</td>
						<td>OPERADOR</td>

						@if($empleado['no_cuenta'] === null)
							<td><center></center></td>
						@else
							<td><center>{{$empleado['no_cuenta']}}</center></td>
						@endif

						<!--se usara como contador para los dias trabajados-->
						<?php
						$diasTrabajados = 0;
						?>
						@foreach($empleado['checadas'] as $checada)
							@if($checada != null)
								<td>{{$parametros['reporte']['cliente']}}</td>
								<td>{{$checada->horas_ordinarias}}</td>
								<td>{{$checada->horas_extra}}</td>
								<?php $diasTrabajados++;?>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif
						@endforeach
						<td>{{$diasTrabajados}}</td>
						<td>{{$empleado['horas_ordinarias']}}</td>
						<td>{{$empleado['horas_extra']}}</td>
						<td><center>{{$empleado['descuentos']}}</center></td>
						<td><center>{{$empleado['reembolsos']}}</center></td>
						<td><center>{{$empleado['comedores']}}</center></td>		
					</tr>
			@endforeach
			</tbody>

		</table>
</div>
<div>
		<!-- Tabla para el cliente -->
<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="tablaCliente" hidden="">
			<thead >
				<tr>
					<th colspan="4">Centro de Trabajo</th>
					<th colspan="5">{{$parametros['reporte']['cliente']}}</th>
					<th colspan="12"><center>Reporte de Carga Diaria de Trabajo CT</center></th>
					<th colspan="5"></th>
					<th colspan="4">Fecha: <?php echo date('d/m/Y'); ?></th>
				</tr>

				<tr>
					<th colspan="27" style="" class="color"></th>
					<th colspan="3" align="right" style="" class="color"><center>TOTAL</center></th>
				</tr>

				<tr>
					<th colspan="4" style="" class="color" value="{{$parametros['reporte']['cliente']}}" id="clienteT">Cliente: {{$parametros['reporte']['cliente']}}</th>
					<th colspan="2" style="" class="color">Horario: {{$parametros['reporte']['turno']}}</th>
					@for($i = 1; $i <= 7; $i++)
						<th colspan="2" style="" class="color">Personas</th>
						<th style="" class="color">{{$parametros['reporte']['dias'][$i]['personas']}}</th>
					@endfor
					<th style="" class="color">{{$parametros['reporte']['total_dias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_ordinarias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_extra']}}</th>
					
				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					$fecha1 = new DateTime($parametros['fecha1']);
					$fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$meses =[
					'January' => 'Enero',
					'February' => 'Febrero',
					'March' => 'Marzo',
					'April' => 'Abril',
					'May'   => 'Mayo',
					'June'  => 'Junio',
					'July'  => 'Julio',
					'August' => 'Agosto',
					'September' => 'Septiembre',
					'October' => 'Octubre',
					'November' => 'Noviembre',
					'December' => 'Diciembre'];
				?>

				<tr>
					<th colspan="4" style="" class="color">Semana {{$parametros['semana']}}</th>
					<th colspan="2" style="" class="color">Del {{$fecha1->format('j')}} de {{$meses[$fecha1->format('F')]}} @if($fecha1->format('Y') != $fecha2->format('Y')) del {{$fecha1->format('Y')}} @endif al {{$fecha2->format('j')}} de {{$meses[$fecha2->format('F')]}} del {{$fecha2->format('Y')}}</th>
					<th colspan="3" style="" class="color">Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="3" style="" class="color">Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="3" style="" class="color">Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="3" style="" class="color">Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="3" style="" class="color">Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="3" style="" class="color">Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="3" style="" class="color">Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="3" style="" class="color">Total trabajado</th>
					
				</tr>

				<tr>
					<th style="" class="color">#</th>
					<th style="" class="color">ID</th>
					<th style="" class="color">A. Paterno</th>
					<th style="" class="color">A. Materno</th>
					<th style="" class="color">Nombre</th>
					<th style="" class="color">Puesto</th>
					

					@for($i = 0; $i < 7; $i++)
						<th style="" class="color">C.P</th>
						<th style="" class="color">R/T</th>
						<th style="" class="color">O/T</th>
					@endfor

					<th style="" class="color">Dias</th>
					<th style="" class="color">R/T</th>
					<th style="" class="color">O/T</th>
					
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 1;
				?>
				@foreach($parametros['reporte']['empleados'] as $empleado)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$empleado['id']}}</td>
						<td>{{strtoupper($empleado['ap_paterno'])}}</td>
						<td>{{strtoupper($empleado['ap_materno'])}}</td>
						<td>{{strtoupper($empleado['nombre'])}}</td>
						<td>OPERADOR</td>

						

						<!--se usara como contador para los dias trabajados-->
						<?php
						$diasTrabajados = 0;
						?>
						@foreach($empleado['checadas'] as $checada)
							@if($checada != null)
								<td>{{$parametros['reporte']['cliente']}}</td>
								<td>{{$checada->horas_ordinarias}}</td>
								<td>{{$checada->horas_extra}}</td>
								<?php $diasTrabajados++;?>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif
						@endforeach
						<td>{{$diasTrabajados}}</td>
						<td>{{$empleado['horas_ordinarias']}}</td>
						<td>{{$empleado['horas_extra']}}</td>
								
					</tr>
			@endforeach
			</tbody>

		</table>

		<table hidden="">
			<thead>
			<tr></tr>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
					<th colspan="2">__________________</th>
				<th colspan="11"></th>
				<th colspan="5">__________________</th>
				</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>

						<th colspan="2">Firma de Autorización</th>
				<th colspan="11"></th>
						<th colspan="5">Firma de Supervisor</th>
					</tr>
				<tr></tr>
				<tr>
					<th colspan="3">Comentarios</th>
				</tr>
				<tr>
			</thead>
		</table>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" hidden="">
			<thead>
					<th rowspan="3" colspan="30" class="table table-striped table-bordered table-hover dataTable no-footer" border="2"></th>
				</tr>
			</thead>
		</table>
		</div>
<br>
<button name="boton" type="button" id="btnExport" class="btn btn-success"> Exportar <img src="../../imagenes/excel.ico" height="25px" width="25px"></button>
<button name="boton" type="button" id="btnCliente" class="btn btn-success"> Exportar Cliente <img src="../../imagenes/excel.ico" height="25px" width="25px"></button>
	<br><br>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Sin resultado!</strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 


@endif

@endif

 

<script>

window.onload = function(){
	var cliente = $("#clienteT").attr("value");
	var colores = ['#660099','#FF9933','#F7D708','#097054','#CE0909','#089669','#088596','#005DC1','#DAB900','#BE00A8','#00039B','#B24100','#8F0000','#7D7F00','#00B0AD','#464646','#6BA4A3','#AC7207','#FF755A','#AAC65D','#99FFFF','#66FFCC','#CCCC99','#993333','#CC66CC','#009999','#CC99CC','#CCCC99','#FFCC99','#FF9999'];
	var i=0;
	$("#cliente option").each(function(){
		//alert($(this).text());
   if (cliente== $(this).text()){
		$(".color").attr("style", "background-color: "+colores[i-1]+"; color: #fff");
		
		
	}
	i=i+1;
});
	/*if (cliente=="SSD-PINTURA"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}else if (cliente=="SSD-STEAM"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}else if (cliente=="SAMEX"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}else if (cliente=="WOORI"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}*/


}

    $(document).ready(function () {
        $("#btnExport").click(function () {
        	var cliente= "@if(isset($parametros['reporte'])){{$parametros['semana']}} {{$parametros['reporte']['cliente']}}@endif";
        	var worksheet= "@if(isset($parametros['reporte'])){{$parametros['reporte']['cliente']}}@endif"
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'semana '+cliente
               , nombre: worksheet
               
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
    
 		$("#empleado").select2();
		$("#cliente").select2();

	$('#cliente').on('change', function(e){
    console.log(e);
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



@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>


    @stop
@stop