@extends('layouts.dashboard')
@section('page_heading','Transacciones')
@section('section')



<form class="form-horizontal" role="form" method="POST" action="{{ route('transacciones')}}">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Filtros</strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<div class="col-sm-6">
					<label class="control-label">Proveedor</label>
					<select class="form-control" name="proveedor">
						<option value="todos">TODOS</option>
						@foreach($proveedores as $proveedor)
							<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-sm-6">
				<br>
				<br>
					<center>
						<button class="btn btn-primary" type="submit">Buscar</button>
					</center>
				</div>
			</div>
		</div>
	</div>
</form>

@if(isset($transacciones))
	<h2>Resultados</h2>
	<div class="tabla">
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
		    <thead>
		        <th>ID</th>
		        <th><center>Factura</center></th>
		        <th><center>Proveedor</center></th>
		        <th><center>Concepto<center></th>
		        <th><center>Semana</center></th>
		        <th><center>Fecha de captura</center></th>
		        <th><center>Fecha agendada</center></th>
		        <th><center>Cargo</center></th>
		        <th><center>Abono</center></th>
		        <th><center>Saldo</center></th>
		        <th><center>Fecha programada</center></th>
		        <th><center>Fecha de traspaso</center></th>
		        <th><center># de cheque</center></th>
		        <th><center>Acciones</center></th>
		    </thead>

		    <tbody>
			    @foreach($transacciones as $transaccion) 
			        <tr>
			        	<td>{{$transaccion->id}}</td>
			        	<td>{{$transaccion->factura}}</td>
			        	<td>{{$lista_proveedores[$transaccion->proveedor]}}</td>
			        	<td>{{$transaccion->concepto}}</td>
			        	<td>{{$transaccion->semana}}</td>
			        	<td>{{$transaccion->fecha_captura}}</td>
			        	<td>{{$transaccion->fecha_agendada}}</td>
			        	<td>${{$transaccion->cargo}}</td>
			        	<td>${{$transaccion->abono}}</td>
			        	<td>${{$transaccion->saldo}}</td>
			        	<td>{{$transaccion->fecha_programada}}</td>
			        	<td>{{$transaccion->fecha_traspaso}}</td>
			        	<td>{{$transaccion->cheque}}</td>
			        	<td><center>
<a class="btn btn-primary btn-sm" href="{{ route('proveedores/editar-transaccion',$transaccion->id) }}" title="editar" ><i class="fa fa-edit"></i></a>
<br>

			        		<a href="{{route('celiminar_transaccion', $transaccion->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
			        	</center></td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>
@endif
@stop