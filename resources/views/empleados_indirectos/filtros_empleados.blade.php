@extends('base')
@section('titulo','Buscar empleados')
@section('cabezera','Buscar empleados')

@section('content')


<form class="form-horizontal" role="form" method="POST" action="{{ route('filtros_empleados') }}" id="buscar_checada">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<h3>Consulta rapida</h3>
			<div class="row">
				<div class="col-sm-2">
					<div class="form-actions">
						<a class="btn btn-primary" href="{{action('EmpleadoController@sinCurp')}}">Sin CURP</a>
					</div>
				</div>

				<div class="col-sm-2">
					<div class="form-actions">
						<a class="btn btn-primary" href="{{action('EmpleadoController@noImss')}}">Sin IMSS</a>
					</div>
				</div>

				<div class="col-sm-2">
					<div class="form-actions">
						<a class="btn btn-primary" href="{{action('EmpleadoController@sinCuenta')}}">Sin cuenta bancaria</a>
					</div>
				</div>

				

				<div class="col-sm-2">
					<div class="form-actions">
						<a class="btn btn-primary" href="{{action('EmpleadoController@incompletos')}}">Datos incompletos</a>
					</div>
				</div>

				<div class="col-sm-2">
					<div class="form-actions">
						<a class="btn btn-primary" href="{{action('EmpleadoController@todos')}}">Todos</a>
					</div>
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
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Buscar</button>
			</div>
		</div>
	</div>
</form>

@if(isset($empleados))
@if(count($empleados)>0)
	<div class="container-fluid">
		<div class="row">
			<div class="panel-body">
				<div class="tabla">
					<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tblExport" >
					    <thead>
					        <th>ID</th>
					        <th>Nombre</th>
					        <th>CURP</th>
					        <th>IMSS</th>
					        <th><div class="form-actions"># de cuenta</div></th>
					        <th><div class="form-actions">Perfil</div></th>
					        <th><div class="form-actions">Estado</div></th>
					    </thead>

					    <tbody>
						    @foreach($empleados as $empleado) 
						        <tr>
						            <td>{{ $empleado->idEmpleado }}</td>
						            <td style="max-width:250px;">{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}}, {{$empleado->nombres}}</td>
						            <td >{{ $empleado->curp}}</td>
						            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
						            <td><div class="form-actions">@if($empleado->no_cuenta != null) {{$empleado->no_cuenta}} @else N/A @endif</div></td>
						            <td ><div class="form-actions"> {{ $empleado->tipo_perfil}}</div></td>
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

@stop
