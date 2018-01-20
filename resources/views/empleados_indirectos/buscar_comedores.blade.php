@extends('base')
@section('cabezera','Buscar comedores')
@section('css')
<link href="/static/select2/select2.css" rel="stylesheet">
@stop
@section('content')
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->

<form class="form-horizontal" role="form" method="POST" action="{{ route('buscar_comedores') }}" id="buscar_comedores">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				<center><label>Semana Actual {{date("W")}}</label></center>
			</div>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado</label>
					<div>
						<select class="form-control" id="empleado" name="empleado">
							<!--en caso de no especificar ninguno-->
							@foreach($parametros['empleados'] as $empleado)
								<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana">
							@for($s = 1; $s < 53; $s++)
								<option value="{{$s}}">Semana {{$s}}</option>
							@endfor
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Año <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="year">
							@for($a = 2017; $a < 2018; $a++)
								<option value="{{$a}}">{{$a}}</option>
							@endfor
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
</form>

@if(isset($parametros['comedores']))
@if(!empty($parametros['comedores']))
	<br>
	
	<h1>Comedores semana {{$parametros['semana']}} - {{$parametros['empleado']->ap_paterno}} {{$parametros['empleado']->ap_materno}} {{$parametros['empleado']->nombres}}</h1>
	
	<br>

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

	<!--Tabla con los resultados de la busqueda-->
	<div id="dvData" style="overflow:scroll; overflow:auto;">
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' >
			<thead >
				<tr>
					<th colspan="2" style="" >Semana {{$parametros['semana']}}</th>
					<th colspan="2" style="" >Del {{$fecha1->format('j')}} de {{$meses[$fecha1->format('F')]}} @if($fecha1->format('Y') != $fecha2->format('Y')) del {{$fecha1->format('Y')}} @endif al {{$fecha2->format('j')}} de {{$meses[$fecha2->format('F')]}} del {{$fecha2->format('Y')}}</th>
					<th colspan="8" align="right" style="" ><center>Comedores</center></th>
				</tr>
				<tr>
					<th style="" >ID</th>
					<th style="" >A. Paterno</th>
					<th style="" >A. Materno</th>
					<th style="" >Nombre</th>
					<th style="" >Lunes {{$parametros['comedores'][1]['dia']}}</th>
					<th style="" >Martes {{$parametros['comedores'][2]['dia']}}</th>
					<th style="" >Miercoles {{$parametros['comedores'][3]['dia']}}</th>
					<th style="" >Jueves {{$parametros['comedores'][4]['dia']}}</th>
					<th style="" >Viernes {{$parametros['comedores'][5]['dia']}}</th>
					<th style="" >Sabado {{$parametros['comedores'][6]['dia']}}</th>
					<th style="" >Domingo {{$parametros['comedores'][7]['dia']}}</th>
					<th style="" >Total</th>
				</tr>

				<tr>
					<td style="" >{{$parametros['empleado']->idEmpleado}}</td>
					<td style="" >{{$parametros['empleado']->ap_paterno}}</td>
					<td style="" >{{$parametros['empleado']->ap_materno}}</td>
					<td style="" >{{$parametros['empleado']->nombres}}</td>

					<?php
						$total = 0;
					?>

					@for($i = 1; $i < 8; $i++)
						<td style="" ><center>{{$parametros['comedores'][$i]['cantidad']}} 
						<!--se genera una forma para cada uno de los dias, con todos los inputs ocultos para asi enviar los datos al controlador-->
							<form class="form-horizontal" role="form" method="POST" action="{{ route('eliminar_comedores') }}" id="buscar_comedores">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">	
								<input type="hidden" name="empleado" value="{{$parametros['empleado']->idEmpleado}}">
								<input type="hidden" name="dia" value="{{$i}}">
								<input type="hidden" name="year" value="{{$fecha1->format('Y')}}">
								<input type="hidden" name="semana" value="{{$parametros['semana']}}">
								@if($parametros['comedores'][$i]['cantidad']>0)
								<button type="submit" class='btn btn-danger btn-xs'><i class="fa fa-trash"></i></button> 
								@endif
							</form>
						</center></td>
						<?php $total += $parametros['comedores'][$i]['cantidad']; ?>
					@endfor

					<td style="" ><center>{{$total}}</center></td>
					
				</tr>
			</thead>

		</table>



	</div>

	@endif
@endif



@stop
@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function () {		
 		$("#empleado").select2();
 	});
</script>
    @stop