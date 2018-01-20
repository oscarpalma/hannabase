@extends('base')
@section('titulo','Subir Foto')
@section('cabezera','Subir Foto')
@section('css')

<link rel="stylesheet" href="/static/select2/select2.css" async/>
@stop
@section('content')
@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> Hubo problemas para guardar la fotografía<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>

@elseif(Session::has('success'))
	<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> La foto se subió exitosamente
				
			</div>
@endif

		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
			
			<!--<img src='{{url(Auth::user()->foto)}}' class='img-responsive' style='max-width: 150px' />-->
			<form class="form-horizontal" role="form" method="POST" action="{{ route('subir_foto_empleado') }}" id="registro-form" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<div class="row-sm">					
					<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				</div>
					<div class="row">
					<div class="col-sm-6">
							<div class="panel-body">
							<label class="control-label">Empleado <text style="color:red">*</text> </label>
								<div >
								
									<select name="idEmpleado" id="empleado" class="form-control" required>
										<option value="">Seleccione</option>
										@foreach($empleado as $empleado)
											<option value="{{$empleado->idEmpleado}}" @if (Input::old('idEmpleado') == $empleado->idEmpleado) selected="" @endif>{{$empleado->idEmpleado}}  -  {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
										@endforeach
									</select>
								
								</div>
							</div>
					</div>
				    
					<div class="col-sm-6">
							<div class="panel-body">
							 <label class="control-label">Foto <text style="color:red">*</text></label>
							 	<div >
									<input type="file"  class="form-control" name="image"  id="image" >
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