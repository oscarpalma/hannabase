@extends('base')
@section('cabezera','Agregar Proveedor')
@section('content')

@if(Session::has('mensaje'))
    
    <div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> {{Session::get('mensaje')}}
				
	</div>
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
		<div class="panel-heading"></div>
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
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		
		
		$("#success").delay(2000).hide(600);
});
</script>
@endsection
