@extends('layouts.dashboard')
@section('page_heading','Reembolsos')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" async/>
@stop
@section('section')

@if(Session::has('success'))
	<script type="text/javascript">
	window.onload = function(){ alert("{{Session::get('success')}}");}
	</script>
@endif

<div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Agregar Reembolso</strong></div>
			<div class="panel-body">
			@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Alerta!</strong> Hubo problemas para guardar los datos<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif

			<form class="form-horizontal" role="form" method="POST" action="#" id="registro-form" data-parsley-validate="" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<div class="row-sm">					
					<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				</div>
				<div clas="row">
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Semana <text style="color:red">*</text></label>
								<div >
								<select name="semana" class="form-control">
							      <?php for ($i=1;$i<53;$i++){  ?> 
									<option value="<?php echo "$i"; ?>"> Semana <?php echo "$i"; ?>
									</option> <?php }?> 
								</select>
								  
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
					<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Empleado <text style="color:red">*</text></label>
								<div >
									<select name="idEmpleado" id="empleado" class="form-control" style='text-transform:uppercase'>
										@foreach($informacion['empleados'] as $empleado)
											<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}}  -  {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				    <div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Reembolso <text style="color:red">*</text></label>
								<div >
								<select name="id_descuento" class="form-control" style='text-transform:uppercase'>
									@foreach($informacion['descuentos'] as $descuento)
										<option value="{{$descuento->id_descuento}}">{{$descuento->nombre_descuento}} (${{$descuento->precio}})</option>
									@endforeach
									
								</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							 <label class="control-label">Dia <text style="color:red">*</text></label>
							 	<div >
									<input type="date"  class="form-control" name="fecha"  id="" max="<?php echo date('Y-m-d'); ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							 <label class="control-label">Comentario <text style="color:red">*</text></label>
							 	<div >
							 		<input type="text" class="form-control" name="comentario" required="" value="" >
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Guardar
						</button>
					</center>
				</div>
			</form>
			<!--Fin de Forma -->
			</div>
		</div>
	</div>
</div>      


<script type="text/javascript">
	$(document).ready(function() {
		$("#empleado").select2();
	});
</script>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>


    @stop
@stop