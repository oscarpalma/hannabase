@extends('layouts.dashboard')
@section('page_heading','Foto')
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
			<div class="panel-heading"><strong>Agregar Foto</strong></div>
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
			<!--<img src='{{url(Auth::user()->foto)}}' class='img-responsive' style='max-width: 150px' />-->
			<form class="form-horizontal" role="form" method="POST" action="#" id="registro-form" data-parsley-validate="" enctype='multipart/form-data'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label">Seleccione a un empleado y cargue una imagen desde su ordenador.</label>
					</div>
				</div>
					<div class="row">
					<div class="col-sm-6">
							<div class="panel-body">
							<label class="control-label">Empleado </label>
								<div >
								@if(isset($empleado))
									<select name="idEmpleado" id="empleado" class="form-control" style='text-transform:uppercase'>
										@foreach($empleado as $empleado)
											<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}}  -  {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
										@endforeach
									</select>
								@else
									<select name="idEmpleado" id="empleado" class="form-control" style='text-transform:uppercase'>
										@foreach($empleadoCt as $empleado)
											<option value="{{$empleado->idEmpleadoCt}}">{{$empleado->idEmpleadoCt}}  -  {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
										@endforeach
									</select>
								@endif
								</div>
							</div>
					</div>
				    
					<div class="col-sm-6">
							<div class="panel-body">
							 <label class="control-label">Foto </label>
							 	<div >
									<input type="file"  class="form-control" name="image"  id="image" >
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