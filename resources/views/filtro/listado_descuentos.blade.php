@extends('layouts.dashboard')
@section('page_heading','Lista de Descuentos')

@section('section')
       
<div class="container-fluid">
@if(Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong></strong> Se elimino el descuento exitosamente.<br><br> 
				
			</div>
@endif    
<form class="form-inline" role="form" method="POST" action="" id="inventario">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			
				
				<div class="form-group">
			    <label class="control-label">Semana:</label>
					
						<select class="form-control" name="semana">
							@for($i = 1; $i<=date("W"); $i++)
								<option value="{{$i}}">Semana {{$i}}</option>
							@endfor
						</select>
			  </div>
				
				<button type="submit" class="btn btn-primary" value="validate" >Buscar
					</button>
					
			
				
		

			

		</div>
	</div>
</form>
@if(isset($descuentos))
	<div class="row">
		<div class="panel-body">
		@if ( !count ($descuentos) > 0 ) 

				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay descuentos registrados en la semana especificada<br><br> 
					
				</div>
			@else
			<br>
			<h1>Descuentos - Semana {{$semana}}</h1>
			<br>
				<div class="row">
					<div class="col-sm-6">
						<input id="buscar" class="form-control" placeholder="Busqueda">
					</div>
					
				</div>
				<br>
		<div class="tabla">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id='descuentos'> 
			    <thead>
					<tr>
						<th>No. Empleado</th>
						<th>Nombre</th>
						<th>Material</th>
						<th>Precio</th>
						<th>Fecha</th>
						<th><center>Acciones</center></th>
					</tr>
				</thead>
				
				<tbody>
					@foreach($descuentos as $descuento)
					<tr>
						<td>{{$descuento['no_empleado']}}</td>
						<td >{{$descuento['nombre']}}</td>
						<td >{{$descuento['material']}}</td>
						<td >{{$descuento['precio']}}</td>
						<td>{{$descuento['fecha']}}</td>
						
						<td><center>
						
						<a href="{{ route('Celiminar_descuento',$descuento['id']) }}" class="btn btn-danger" title="eliminar"><i class="fa fa-trash"></i></a>
						</center></td>
					</tr>
				<tbody>
			    @endforeach
			</table>
			</div>
			
			@endif
		</div>
	</div>
</div>

<script type="text/javascript">
$( document ).ready(function() {

var $rows = $('#descuentos tbody tr');
	$('#buscar').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});

});
		</script>
@endif
@stop