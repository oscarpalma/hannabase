@extends('base')
@section('titulo','Lista Negra')
@section('cabezera','Lista Negra')
@section('css')
 <style type="text/css">
    
    .tabla {
        max-height:500px;overflow-y: auto;
    }
</style>
@endsection
@section('content')
           

		
			@if ( count ( $empleados ) < 1 ) 
				<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No hay Nadie en Lista Negra<br><br> 
					
				</div>
			@else
				<div class="row">
					<div class="col-sm-4">
						<input id="buscar" class="form-control" placeholder="Busqueda">
					</div>
				</div>

				<br>
				<div class="panel panel-primary">
				<div class="panel-heading"></div>
				<div class="panel-body">
				<div class="tabla">
					<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="tabla">
					    <thead>
					        <th>ID</th>
					        <th>Nombre</th>
					        <th>CURP</th>
					        <th>IMSS</th>
					        <th><div class="form-actions">Perfil</div></th>
					    </thead>

					    <tbody>
						    @foreach($empleados as $empleado) 
						        <tr>
						            <td>{{ $empleado->idEmpleado }}</td>
						            <td >{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}} , {{$empleado->nombres}}</td>
						            <td >{{ $empleado->curp}}</td>
						            <td>{{$empleado->imss}}</td>
						            <td ><div class="form-actions"> {{ $empleado->tipo_perfil}}</div></td>
						        </tr>
						    @endforeach
						</tbody>
					</table>
				</div>
				</div>
				</div>
			@endif
		




@stop

@section('js')
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
@endsection