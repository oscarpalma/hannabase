@extends('layouts.dashboard')
@section('page_heading','Confirmar Eliminar Transaccion')
@section('section')

@if(Session::has('mensaje'))
    <script type="text/javascript">
        window.onload = function(){ alert("{{Session::get('mensaje')}}");}
    </script>
@endif
<!--
<script>
  $(document).ready(function(){
    $(".time_element").timepicki();
  });
</script>
-->

<form class="form-horizontal" role="form" method="POST" action="{{route('celiminar_transaccion',$transaccion->id)}}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Factura <text style="color:red">*</text></label>
					<input class="form-control" name="factura" value="{{$transaccion->factura}}" readonly="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Proveedor <text style="color:red">*</text></label>
					<input class="form-control" name="proveedor" value="{{$proveedor->nombre}}" readonly="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Concepto <text style="color:red">*</text></label>
					<input class="form-control" name="concepto" required="" value="{{$transaccion->concepto}}" readonly="">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<input class="form-control" value="{{$transaccion->semana}}" readonly="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha captura <text style="color:red">*</text></label>
					<input class="form-control" name="fecha_captura" required="" type="date" value="{{$transaccion->fecha_captura}}" readonly="">
				</div>				

				<div class="col-sm-4">
					<label class="control-label">Fecha agendada <text style="color:red">*</text></label>
					<input class="form-control" name="fecha_agendada" required="" type="date" value="{{$transaccion->fecha_agendada}}" readonly="">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class='control-label'>Cargo <text style="color:red">*</text></label>
					<input class="form-control" name="cargo" required="" value="{{$transaccion->cargo}}" readonly="">
				</div>

				<div class="col-sm-4">
					<label class='control-label'>Abono</label>
					<input class="form-control" name="abono" value="{{$transaccion->abono}}" readonly="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Saldo</label>
					<input class="form-control" name="saldo" value="{{$transaccion->saldo}}" readonly="">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Fecha programada</label>
					<input class="form-control" name="fecha_programada" type="date" value="{{$transaccion->fecha_programada}}" readonly="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha de traspaso</label>
					<input class="form-control" name="fecha_traspaso" type="date" value="{{$transaccion->fecha_traspaso}}" readonly="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Cheque</label>
					<input class="form-control" name="cheque" value="{{$transaccion->cheque}}" readonly="">
				</div>
			</div>

			<br>
			<center>
				<button class="btn btn-danger" type="submit">Eliminar</button>
			</center>		
		</div>
	</div>
</form>
@stop
