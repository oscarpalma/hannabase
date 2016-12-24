@extends('layouts.dashboard')
@section('page_heading','Lista de Empleados de CT')
@section('section')
           
<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
			@if ( empty ( $empleados['areas'] ) ) 
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
				<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="tabla">
				    <thead>
				        <th>ID</th>
				        <th>Nombre</th>
				        <th>Área</th>
				        <th>CURP</th>
				        <th>IMSS</th>
				        <th>RFC</th>
				        <th><center>Acciones</center></th>
				    </thead>

				    <tbody>
					    @foreach($empleados['empleados'] as $empleado) 
					        <tr>
					            <td>{{ $empleado->idEmpleadoCt }}</td>
					            <td >{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}} , {{$empleado->nombres}}</td>
					            <td>{{$empleados['areas'][$empleado->idEmpleadoCt]}}</td>
					            <td >{{ $empleado->curp}}</td>
					            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
					            <td>{{$empleado->rfc}}</td>
					            <td ><center>
					            	<a class="btn btn-success btn-sm" title="editar" href="{{ route('modificar_empleadoct',$empleado->idEmpleadoCt) }}"><i class="fa fa-edit"></i></a> 
					            	<a class="btn btn-danger btn-sm" title="eliminar" href="{{ route('confirmar_eliminarCt',$empleado->idEmpleadoCt) }}"><i class="fa fa-trash"></i></a>
					            </center></td>
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
	var $rows = $('#tabla tbody tr');
	$('#buscar').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});
</script>
@stop