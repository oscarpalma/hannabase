@extends('layouts.dashboard')
@section('page_heading','Buscar empleados')
@section('head')

	@stop
@section('section')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('buscar_empleados') }}" id="buscar_checada">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Filtros</strong></div>
		<div class="panel-body">
			<h3>Consulta rapida</h3>
			<div class="row">
				<div class="col-sm-2">
					<center>
						<a class="btn btn-primary" href="{{action('EmpleadoController@sinCurp')}}">Sin CURP</a>
					</center>
				</div>

				<div class="col-sm-2">
					<center>
						<a class="btn btn-primary" href="{{action('EmpleadoController@noImss')}}">Sin IMSS</a>
					</center>
				</div>

				<div class="col-sm-2">
					<center>
						<a class="btn btn-primary" href="{{action('EmpleadoController@sinCuenta')}}">Sin cuenta bancaria</a>
					</center>
				</div>

				<div class="col-sm-2">
					<center>
						<a class="btn btn-primary" href="{{action('EmpleadoController@noRfc')}}">Sin RFC</a>
					</center>
				</div>

				<div class="col-sm-2">
					<center>
						<a class="btn btn-primary" href="{{action('EmpleadoController@incompletos')}}">Datos incompletos</a>
					</center>
				</div>

				<div class="col-sm-2">
					<center>
						<a class="btn btn-primary" href="{{action('EmpleadoController@cumple')}}">Cumpleañeros</a>
					</center>
				</div>
			</div>

			<hr>
			<h3>Busqueda avanzada</h3>
			<div class="row">
				<div class="col-sm-2" align="left">
					<label class="control-label">Documentacion:</label><br>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-9">
				<!--checkbox para la documentacion con la que cuenta el empleado-->
					<div class="form-group" align="left">
						<div class="col-sm-2" >					
							<input type="checkbox" name="curp" value="true" checked> <label class="control-label">CURP</label>
						</div>
						<div class="col-sm-2" >					
							<input type="checkbox" name="imss" value="true" checked> <label class="control-label">IMSS</label>
						</div>
						<div class="col-sm-2" >					
							<input type="checkbox" name="rfc" value="true" checked> <label class="control-label">RFC</label>
						</div>
						<div class="col-sm-3" >					
							<input type="checkbox" name="no_cuenta" value="true" checked> <label class="control-label">Numero de cuenta</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Estado:</label>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-9">
					<div class="form-group">
						<div class="col-sm-2">
							<input type="checkbox" name="candidato" value="true" checked=""> <label class="control-label">Candidato</label>
						</div>

						<div class="col-sm-2">
							<input type="checkbox" name="empleado" value="true" checked=""> <label class="control-label">Empleado</label>
						</div>

						<div class="col-sm-4" hidden="">
							<input type="checkbox" name="no_contratable" value="true" > <label class="control-label">Mostrar no contratable</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Perfiles:</label>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<div class="col-sm-3">
							<input type="checkbox" name="perfil_a" value="true" checked=""> <label class="control-label">A</label>
						</div>

						<div class="col-sm-3">
							<input type="checkbox" name="perfil_b" value="true" checked=""> <label class="control-label">B</label>
						</div>

						<div class="col-sm-3">
							<input type="checkbox" name="perfil_c" value="true" checked=""> <label class="control-label">C</label>
						</div>
					</div>	
				</div>
			</div>

			<br>
			<center>
				<button type="submit" class="btn btn-primary">Buscar</button>
			</center>
		</div>
	</div>
</form>

@if(isset($empleados))
@if(count($empleados)>0)
	@if(isset($sin_cuenta))
	<div class="container-fluid">
		<div class="row">
			<div class="panel-body">
				<div class="tabla">
					<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tblExport" >
					    <thead>
					    	<th><center>#</center></th>
					        <th><center>ID</center></th>
					        <th>Ap. Paterno</th>
					        <th>Ap. Materno</th>
					        <th>Nombre</th>
					        <th><center>Fecha de nacimiento</center></th>
					        <th><center>Calle</center></th>
					        <th><center># de casa</center></th>
					        <th><center>Colonia</center></th>
					        <th><center>CP</center></th>
					        <th><center>RFC</center></th>
					        <th><center>Sexo</center></th>
					    </thead>

					    <tbody>
					    	<?php $num = 1; ?>
						    @foreach($empleados as $empleado) 
						        <tr>
						        	<td><center>{{$num++}}</center></td>
						            <td>{{ $empleado->idEmpleado }}</td>
						            <td style="max-width:250px;">{{ $empleado->ap_paterno}}</td>
                                                            <td>{{ $empleado->ap_materno}}</td>
                                                            <td>{{$empleado->nombres}}</td>
							            <?php 
							            	$fecha = new DateTime($empleado->fecha_nacimiento);
							            ?>
						            <td ><center>{{ $fecha->format('Ymd') }}</center></td>
						            <td><center>{{$datosLocalizacion[$empleado->idEmpleado]->calle}}</center></td>
						            <td><center>{{$datosLocalizacion[$empleado->idEmpleado]->no_exterior}} @if($datosLocalizacion[$empleado->idEmpleado]->no_interior != null) - {{$datosLocalizacion[$empleado->idEmpleado]->no_interior}} @endif</center></td>
						            <td><center>{{$colonias[$datosLocalizacion[$empleado->idEmpleado]->idColonia]->nombre}}</center></td>
						            <td><center>{{$colonias[$datosLocalizacion[$empleado->idEmpleado]->idColonia]->codigo_postal}}</center></td>
						            <td ><center> {{ $empleado->rfc}}</center></td>
						            <td><center>
						            @if($empleado->genero == 'masculino')
						            	M
						            @else
						            	F
						            @endif
						            </center></td>
						        </tr>
						    @endforeach
					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="container-fluid">
		<div class="row">
			<div class="panel-body">
				<div class="tabla">
					<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tblExportt" >
					    <thead>
					        <th>ID</th>
					        <th>Nombre</th>
					        <th><center>Fecha de nacimiento</center></th>
					        <th>CURP</th>
					        <th>IMSS</th>
					        <th>RFC</th>
					        <th><center># de cuenta</center></th>
					        <th><center>Perfil</center></th>
					        <th><center>Estado</center></th>
					    </thead>

					    <tbody>
						    @foreach($empleados as $empleado) 
						        <tr>
						            <td>{{ $empleado->idEmpleado }}</td>
						            <td style="max-width:250px;">{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}}, {{$empleado->nombres}}</td>
						            <td ><center>{{ $empleado->fecha_nacimiento }}</center></td>
						            <td >{{ $empleado->curp}}</td>
						            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
						            <td>@if($empleado->rfc != null) {{$empleado->rfc}} @else N/A @endif</td>
						            <td><center>@if($empleado->no_cuenta != null) {{$empleado->no_cuenta}} @else N/A @endif</center></td>
						            <td ><center> {{ $empleado->tipo_perfil}}</center></td>
						            <td>
						            @if($empleado->contratable)
						            	{{$empleado->estado}}
						            @else
						            	No contratable
						            @endif
						            </td>
						        </tr>
						    @endforeach
					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endif

	<button name="boton" type="button" id="btnExport" class="btn btn-success"> Exportar <img src="../../imagenes/excel.ico" height="25px" width="25px"></button>

	
	<script type="text/javascript">
	$(document).ready(function () {
        $("#btnExport").click(function () {
        	var worksheet= "Resultados";
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'resultados'
               , nombre: worksheet
               
            });
        });
    });
	</script>
@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Sin resultado!</strong> No se obtuvo ningun resultado.<br><br> 
				
			</div>
@endif
@endif
@section('scripts')
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>
    @stop
@stop