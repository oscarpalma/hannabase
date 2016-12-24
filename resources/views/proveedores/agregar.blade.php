@extends('layouts.dashboard')
@section('page_heading','Agregar Proveedor')
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

<form class="form-horizontal" role="form" method="POST" action="{{route('nuevo_proveedor')}}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Nombre <text style="color:red">*</text></label>
					<input class="form-control" name="nombre" required="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Contacto <text style="color:red">*</text></label>
					<input class="form-control" name="contacto" required="">
				</div>

				<div class="col-sm-4">
					<label class="control-label">E-Mail <text style="color:red">*</text></label>
					<input class="form-control" name="email" required="">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Telefono <text style="color:red">*</text></label>
					<input class="form-control" name="telefono" required="">
				</div>				

				<div class="col-sm-4">
					<label class="control-label">Credito <text style="color:red">*</text></label>
					<input class="form-control" name="credito" required="">
				</div>

				<div class="col-sm-4">
					<br>
					<center>
						<button class="btn btn-primary" type="submit">Guardar</button>
					</center>
				</div>
			</div>
		</div>
	</div>
</form>
@stop
