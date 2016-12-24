@extends('layouts.dashboard')
@section('page_heading','Generar Reporte')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')

 
<form class="form-horizontal" role="form" method="POST" action="{{ route('reporte_ct') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
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
							<option value="null">Todos</option>
							@foreach($parametros['empleados'] as $empleado)
								<option value="{{$empleado->idEmpleadoCt}}">{{$empleado->idEmpleadoCt}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana">
							@for($i = 1; $i<=52; $i++)
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

@if(isset($parametros['reporte']))
@if(!empty($parametros['reporte']['empleados']))
	<br>
	<h1>Reporte Interno - Semana {{$parametros['semana']}}</h1>
	<br>

	<div id="dvData" style="overflow:scroll; overflow:auto;">
	<!--Tabla con los resultados de la busqueda-->
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="tblExport">
			<thead>
				<tr>
					<th colspan="21"></th>
					<th><center>{{$parametros['reporte']['total_dias']}}</center></th>
					<th><center>{{$parametros['reporte']['total_horas']}}</center></th>
					<th><center>{{$parametros['reporte']['total_horas_extra']}}</center></th>
					<th><center>{{$parametros['reporte']['total_prestamos']}}</center></th>
					<th><center>{{$parametros['reporte']['total_descuentos']}}</center></th>
				</tr>

				<tr>
					<th colspan="4">Centro de Trabajo</th>
					<th colspan="3">Del {{$parametros['fecha1']}} al {{$parametros['fecha2']}}</th>
					<th colspan="2">Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="2">Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="2">Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="2">Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="2">Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="2">Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="2">Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="5"><center>Total</center></th>
					</tr>
			</thead>

			<tr>
				<th>#</th>
				<th>ID</th>
				<th><center>A. Paterno</center></th>
				<th><center>A. Materno</center></th>
				<th><center>Nombre</center></th>
				<th><center>Área</center></th>
				<th># de Cuenta</th>
				@for($i = 0; $i < 7; $i++)
					<th>R/T</th>
					<th>O/T</th>
				@endfor
				<th>Dias</th>
				<th>R/T</th>
				<th>O/T</th>
				<th><center>Prestamos</center></th>
				<th><center>Descuentos</center></th>
				
			</tr>

			<?php
				$i = 1;
			?>
			@foreach($parametros['reporte']['empleados'] as $empleado)
				<tr>
					<td>{{$i++}}</td>
					<td>{{array_search($empleado, $parametros['reporte']['empleados'])}}</td>
					<td>{{$empleado['ap_paterno']}}</td>
					<td>{{$empleado['ap_materno']}}</td>
					<td>{{$empleado['nombre']}}</td>
					<td>{{$empleado['area']}}</td>
					@if($empleado['no_cuenta'] != null)
						<td>{{$empleado['no_cuenta']}}</td>
					@else
						<td>N/A</td>
					@endif
					<?php
					$dias = 0;
					?>
					@foreach($empleado['checadas'] as $checada)
						@if($checada != null)
							<td>{{$checada->horas_ordinarias}}</td>
							<td>{{$checada->horas_extra}}</td>
							<?php $dias++;?>
						@else
							<td>0</td>
							<td>0</td>
						@endif
					@endforeach
					<td><center>{{$dias}}</center></td>
					<td><center>{{$empleado['horas_ordinarias']}}</center></td>
					<td><center>{{$empleado['horas_extra']}}</center></td>		
					<td><center>{{$empleado['prestamos']}}</center></td>
					<td><center>{{$empleado['descuentos']}}</center></td>				
				</tr>
			@endforeach

		</table>
	</div>

	<br>
	<button name="boton" type="button" id="btnExport" class="btn btn-success"> Exportar <img src="../../imagenes/excel.ico" height="25px" width="25px"></button>
	<br><br>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Sin resultado!</strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 
@endif
@endif

<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'semana '+@if(isset($parametros['reporte'])){{$parametros['semana']}}@endif
            });
        });
    });
</script>

<!--script para busqueda en los select-->

<script type="text/javascript">
	$(document).ready(function() {
		$("#empleado").select2();
	});
</script>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>


    @stop
@stop