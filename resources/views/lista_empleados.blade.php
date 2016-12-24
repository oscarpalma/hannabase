@extends('layouts.dashboard')
@section('page_heading','Lista de Empleados')
@section('section')

<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
			@if ( empty ( $empleados ) ) 
				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay Empleados Registrados<br><br> 
				</div>

			@else
				<div class="row">
					<div class="col-sm-6">
						<input id="buscar" class="form-control" placeholder="Busqueda">
					</div>
				</div>
				<br>
				<div class="tabla">
				<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
				    <thead>
				        <th>ID</th>
				        <th>Nombre</th>
				        <th>CURP</th>
				        <th>IMSS</th>
				        <th>RFC</th>
				        <th><center># de Cuenta</center></th>
                                        <th><center>Codigo Postal</center></th>
				        <th><center>Acciones</center></th>
				    </thead>

				    <tbody>
					    @foreach($empleados as $empleado) 
					        <tr>
					            <td>{{ $empleado->idEmpleado }}</td>
					            <td style="max-width:250px;">{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}}, {{$empleado->nombres}}</td>
					            <td >{{ $empleado->curp}}</td>
					            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
					            <td>{{$empleado->rfc}}</td>
					            <td ><center> {{ $empleado->no_cuenta}}</center></td>
<td ><center> {{$empleado->codigopostal}}</center></td>
					            @if(in_array(Auth::user()->role,['administrador','supervisor','recepcion']))
						            <td ><center>
										<a class="btn btn-primary btn-sm" href="{{ route('modificar_empleado',$empleado->idEmpleado) }}" title="editar" ><i class="fa fa-edit"></i></a>
						            	<a class="btn btn-danger btn-sm" href="{{ route('confirmar_eliminarE',$empleado->idEmpleado) }}" title="eliminar" ><i class="fa fa-trash"></i></a>
										<a class="btn btn-danger btn-sm" href="{{route('lista_negra_agregar',$empleado->idEmpleado)}}" title="lista negra"><i class="glyphicon glyphicon-remove"></i></a>
						            </center></td>
						        @else
						        	<td><center>
						        		<a class="btn btn-primary btn-sm" href="{{route('ver_empleado',$empleado->idEmpleado)}}" title="ver empleado"><i class="fa fa-info-circle"></i></a>
						        	</center></td>
						        @endif
					        </tr>
					    @endforeach
				    </tbody>
				</table>
				</div>
			@endif
		</div>
	</div>
</div>

<script type="text/javascript">
$( document ).ready(function() {

var $rows = $('#tabla tbody tr');
	$('#buscar').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});

});
</script>

@stop