@extends('base')
@section('titulo','Descuento')
@section('cabezera','Descuento')
@section('css')

 <link href="/static/select2/select2.css" rel="stylesheet"> 
  
 
@endsection
@section('content')
@if(isset($success))
	<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Descuento registrado con exito
				
			</div>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{route('descuento_empleados_crtm')}}" id="descuento-form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Empleado <text style="color:red">*</text></label>
					<div >
						<select name="empleado" id="empleado" class="form-control" data-live-search="true" required>
							<option value="">Seleccione</option>
							@foreach($empleados as $empleado)
								<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-3">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>" id="" max="<?php echo date('Y-m-d'); ?>" required>
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Monto <text style="color:red">*</text></label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input type="number" name="monto"  step="0.01" class="time_element form-control" id="monto" value="" required="" min="0" />
					</div>
                
				</div>
				<div class="col-sm-3">
					<label class="control-label">Concepto <text style="color:red">*</text></label>
					<div >
						<input type="text"  class="form-control" name="concepto"  id="concepto" value="" required="">
					</div>
				</div>
			</div>

			<div class="row"><div class="form-actions">
			<br>
			    
					<button type="submit" class="btn btn-primary" >
						Enviar
					</button>
				
			</div></div>
			
		</div>
	</div>
</form>



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
