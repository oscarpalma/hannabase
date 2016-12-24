@extends('layouts.dashboard')
@section('page_heading','Lista Negra')
@section('section')
           
<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
			@if ( empty ( $empleados ) ) 
				<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay Nadie en Lista Negra<br><br> 
					
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
					        <th>CURP</th>
					        <th>IMSS</th>
					        <th>RFC</th>
					        <th><center>Perfil</center></th>
					    </thead>

					    <tbody>
						    @foreach($empleados as $empleado) 
						        <tr>
						            <td>{{ $empleado->idEmpleado }}</td>
						            <td >{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}} , {{$empleado->nombres}}</td>
						            <td >{{ $empleado->curp}}</td>
						            <td>{{$empleado->imss}}</td>
						            <td>{{$empleado->rfc}}</td>
						            <td ><center> {{ $empleado->tipo_perfil}}</center></td>
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