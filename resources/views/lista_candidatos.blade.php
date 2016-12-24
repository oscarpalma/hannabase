@extends('layouts.dashboard')
@section('page_heading','Lista de Candidatos')
@section('section')

@if(Session::has('error'))
<script type="text/javascript">
window.onload = function(){ alert("{{Session::get('error')}}");}
</script>
@endif
          
<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
			@if ( empty ( $informacion ) ) 
			<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay Candidatos Registrados<br><br> 
					
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
				        <th><center>Acciones</center></th>
				    </thead>

				    <tbody>
					    @foreach($informacion as $empleado) 
					        <tr>
					            <td>{{ $empleado['empleado']->idEmpleado }}</td>
					            <td >{{ $empleado['empleado']->ap_paterno}} {{ $empleado['empleado']->ap_materno}} , {{$empleado['empleado']->nombres}}</td>
					            <td >{{ $empleado['empleado']->curp}}</td>
					            <td>@if($empleado['empleado']->imss != null) {{$empleado['empleado']->imss}} @else N/A @endif</td>
					            <td>{{$empleado['empleado']->rfc}}</td>
					            <td ><center> {{ $empleado['empleado']->tipo_perfil}}</center></td>
					            <td ><center>
					           @if($empleado['examen'] == null)
@if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion']))
						            	<a class="btn btn-success btn-sm" href="{{ route('convertir_empleado',$empleado['empleado']->idEmpleado) }}" title="convertir a empleado" ><i class="fa fa-share"></i></a>
						            @endif
						            	<!--el icono de la tacha se cambio para agregar a lista negra,
						            		el bote de basura es eliminar ahora-->
					            @elseif($empleado['examen'] === null)
					            	<p style="color:orange">No ha realizado examen médico</p>
					            @else
					            	<p style="color:red">No aprobó el examen médico</p>
					            @endif

				            	@if(in_array(Auth::user()->role, ['administrador','supervisor','recepcion']))
					            	<a class="btn btn-primary btn-sm" href="{{ route('modificar_candidato',$empleado['empleado']->idEmpleado) }}" title="modificar"><i class="fa fa-edit"></i></a>
					            	<a class="btn btn-danger btn-sm" href="{{ route('confirmar_eliminarE',$empleado['empleado']->idEmpleado) }}" title="eliminar" ><i class="fa fa-trash"></i></a>
				            		<a class="btn btn-danger btn-sm" href="{{route('lista_negra_agregar', $empleado['empleado']->idEmpleado)}}" title="lista negra"><i class="glyphicon glyphicon-remove"></i></a>

			            		@else
					        		<a class="btn btn-primary btn-sm" href="{{route('ver_empleado',$empleado['empleado']->idEmpleado)}}" title="ver empleado"><i class="fa fa-info-circle"></i></a>
					            @endif
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