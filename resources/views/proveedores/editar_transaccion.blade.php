@extends('layouts.dashboard')
@section('page_heading','Modificar Transaccion')
@section('section')

@if(Session::has('mensaje'))
    <script type="text/javascript">
        window.onload = function(){ alert("{{Session::get('mensaje')}}");}
    </script>
@endif


<form class="form-horizontal" role="form" method="POST" action="{{route('proveedores/guardar-cambios',$transaccion->id)}}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				<center><label>Semana Actual {{date("W")}}</label></center>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Factura <text style="color:red">*</text></label>
					<input class="form-control" name="factura" value="{{$transaccion->factura}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Proveedor <text style="color:red">*</text></label>
					<select class="form-control" name="proveedor">
						@foreach($proveedores as $proveedor)
							<option value="{{$proveedor->id}}" @if ($proveedor->id == $transaccion->proveedor) selected="" @endif>{{$proveedor->nombre}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Concepto <text style="color:red">*</text></label>
					<input class="form-control" name="concepto" required="" value="{{$transaccion->concepto}}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<select class="form-control" name="semana">
						@for($i = 1; $i < 53; $i++)
							<option value="{{$i}}" @if ($transaccion->semana == $i) selected="" @endif>Semana {{$i}}</option>
						@endfor
					</select>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha captura <text style="color:red">*</text></label>
					<input class="form-control" name="fecha_captura" required="" type="date" value="{{$transaccion->fecha_captura}}">
				</div>				

				<div class="col-sm-4">
					<label class="control-label">Fecha agendada <text style="color:red">*</text></label>
					<input class="form-control" name="fecha_agendada" required="" type="date" value="{{$transaccion->fecha_agendada}}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class='control-label'>Cargo <text style="color:red">*</text></label>
					<input class="form-control" name="cargo" required="" value="{{$transaccion->cargo}}">
				</div>

				<div class="col-sm-4">
					<label class='control-label'>Abono</label>
					<input class="form-control" name="abono" value="{{$transaccion->abono}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Saldo</label>
					<input class="form-control" name="saldo" value="{{$transaccion->saldo}}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Fecha programada</label>
					<input class="form-control" name="fecha_programada" type="date" value="{{$transaccion->fecha_programada}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha de traspaso</label>
					<input class="form-control" name="fecha_traspaso" type="date" value="{{$transaccion->fecha_traspaso}}">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Cheque</label>
					<input class="form-control" name="cheque" value="{{$transaccion->cheque}}">
				</div>
			</div>

			<br>
			<center>
				<button class="btn btn-primary" type="submit">Guardar</button>
			</center>		
		</div>
	</div>
</form>
@stop
