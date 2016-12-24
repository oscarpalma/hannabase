@extends('layouts.dashboard')
@section('page_heading','Modificar Cliente')
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

<form class="form-horizontal" role="form" method="POST" action="{{ route('editar_cliente') }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<input hidden="" value="{{$cliente->idCliente}}" name="idCliente">
				<div class="col-sm-3">
					<label class="control-label">Nombre <text style="color:red">*</text></label>
					<input class="form-control" name="nombre" required="" value="{{$cliente->nombre}}" readonly="">
				</div>

				<div class="col-sm-3">
					<label class="control-label">Direccion <text style="color:red">*</text></label>
					<input class="form-control" name="direccion" required="" value="{{$cliente->direccion}}" readonly="">
				</div>

				<div class="col-sm-3">
					<label class="control-label">Contacto <text style="color:red">*</text></label>
					<input class="form-control" name="contacto" required="" value="{{$cliente->contacto}}">
				</div>

				<div class="col-sm-3">
					<label class="control-label">Telefono <text style="color:red">*</text></label>
					<input class="form-control" name="telefono" required="" value="{{$cliente->telefono}}">
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
