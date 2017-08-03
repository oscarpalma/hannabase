@extends('layouts.dashboard')
@section('page_heading','Lista de Autorizaciones')
@section('section')
@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@stop
@section('section')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<!-- Se identifica el codigo html en el cual se muestra una tabla con las autorizaciones existenes al momento, se declara la variable $autorizaciones la cual recibe los parametros que se guardan en la base de datos,si no se encuentra ningun parametro la vista no muestra la tabla ya que la variable esta vacia  -->         
<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
		@if ( empty ( $autorizaciones ) ) 
				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay autorizaciones Registrados<br><br> 
					
				</div>
			@else
		<div class="tabla">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			    <tr>
			        <th>#</th>
			        <th>Solicitante</th>
			        <th>Fecha</th>
			        <th>Area</th>
			        <th>Responsable</th>
			        <th>Concepto</th>
			        <th>Tipo de Pago</th>
			        <th>Proveedor</th>
			        <th>Descripcion</th>
			        <th>Precio Unitario</th>
			        <th>Cantidad</th>
			        <th>Total</th>
			        <th>Exportar a</th>
			    </tr>

			    @foreach($autorizaciones as $autorizacion) 
				        <tr>
				            <td>{{$autorizacion->idAutorizacion}}</td>
				            <td >{{$autorizacion->solicitante}}</td>
				            <td >{{$autorizacion->fecha}}</td>
				            <td>{{$autorizacion->idarea}}</td>
				            <td>{{$autorizacion->responsable}}</td>
				            <td>{{$autorizacion->concepto}}</td>
				            <td>{{$autorizacion->tipo_pago}}</td>
				            <td>{{$autorizacion->idproveedor}}</td>
				            <td>{{$autorizacion->descripcion}}</td>
				            <td>{{$autorizacion->precio_unitario}}</td>
				            <td>{{$autorizacion->cantidad}}</td>
				            <td>{{$autorizacion->total}}</td>
                           	<td><a class="btn btn-primary" href="{{route ('verautorizacion' , $autorizacion->idAutorizacion)}}">VER</a></td>
			            </tr>
			    @endforeach
			</table>
			</div>
			@endif
		</div>
	</div>
</div>

@stop