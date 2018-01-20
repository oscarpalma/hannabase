@extends('base')
@section('titulo','Reembolso')
@section('cabezera','Reembolso')
@section('css')

 <link href="/static/select2/select2.css" rel="stylesheet"> 
  
 
@endsection
@section('content')
@if(Session::has('success'))
	<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Reembolso registrado con exito
				
			</div>
@endif

		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
			
			<form class="form-horizontal" role="form" method="POST" action="" id="registro-form" data-parsley-validate="" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<div class="row-sm">					
					<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				</div>
				
					<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Empleado <text style="color:red">*</text></label>
								<div >
									<select name="idEmpleado" id="empleado" class="form-control">
										<option value="">Seleccione</option>
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
								<select name="idDescuento" class="form-control" style='text-transform:uppercase'>
									@foreach($informacion['descuentos'] as $descuento)
										<option value="{{$descuento->idTipoDescuento}}">{{$descuento->nombre_descuento}} (${{$descuento->precio}})</option>
									@endforeach
									
								</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							 <label class="control-label">Fecha <text style="color:red">*</text></label>
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
				
				<div class="form-actions">
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Guardar
						</button>
					
				</div>
			</form>
			<!--Fin de Forma -->
			</div>
		</div>
	

@stop

@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#empleado").select2();
		$("#success").delay(2000).hide(600);
	});
</script>
@stop