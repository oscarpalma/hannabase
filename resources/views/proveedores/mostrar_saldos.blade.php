@extends('base')
@section('cabezera','Transacciones')
@section('content')



<form class="form-horizontal" role="form" method="POST" action=" {{ route('convertirsaldo', $transaccion->id) }} ">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Transaccion</label>
					<input class="form-control" name="" readonly="" value="{{$transaccion->id}}">
				</div>
				<div class="col-sm-4">
						<label class="control-label">Proveedor</label>
						<input class="form-control" name="proveedor" id="proveedor" readonly="" value="{{$transaccion->proveedor}}">
				</div>
				<div class="col-sm-4">
					<label class="control-label">Saldo</label>
					<input class="form-control" name="saldo" id="saldo" readonly="" value="{{$transaccion->saldo}}">
				</div>
			</div>
			<br>
			<center>
				<button class="btn btn-primary" type="submit">Convertir</button>
			</center>
		</div>
		
	</div>

@endsection