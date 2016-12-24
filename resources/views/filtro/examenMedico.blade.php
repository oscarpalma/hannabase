@extends('layouts.dashboard')
@section('page_heading','Examen Medico')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" async/>
@stop
@section('section')

@if(Session::has('success'))
<script type="text/javascript">
window.onload = function(){ alert("¡Datos médicos registrados con éxito!");}
</script>
@endif

<div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Examen</strong></div>
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
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Empleado <text style="color:red">*</text></label>
								<div >
									<select id="empleado" name="idEmpleado" class="form-control" style='text-transform:uppercase'>
										@foreach($empleados as $empleado)
											<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}}  -  {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<div class="panel-body">
						<label class="control-label">Pruebas</label>
						<h4>Antidoping</h4>
						<br>
						<h4>Embarazo</h4>
						<br>
						<h4>Problemas de la vista</h4>
						<br>
						<h4>Enfermedad Cronica</h4>
						<br>
						<h4>¿Aprobó?</h4>
						</div>						
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<div class="panel-body">
						<label class="control-label">Resultado <text style="color:red">*</text></label>
						<!-- Antidoping -->
		                    <select name="antidoping" class="form-control">Positivo>
		                    	<option value="true">Positivo</option>
		                    	<option value="false">Negativo</option>
		                    </select>
			            <br>
			            <!-- Embarazo -->
			                <select class="form-control" name="embarazo">
			                	<option value="true">Positivo</option>
			                	<option value="false">Negativo</option>
			                </select>
			            <br>
			            <!-- Vista -->
			                <select class="form-control" name="vista">			                
			                	<option value="true">Si</option>
			                	<option value="false">No</option>
			                </select>
			            <br>
			            <!-- Enfermedad -->
			                <select class="form-control" name="enfermedad">
			                	<option value="true">Si</option>
			                	<option value="false">No</option>
			                </select>
			            <br>
			            	<select class="form-control" name="aprobado">
			            		<option value="true">Si</option>
			            		<option value="false">No</option>
			            	</select>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<div class="panel-body">
						<label class="control-label">Observacion <text style="color:red">*</text></label>
							<div >
							  <input type="text" class="form-control"  name="antidoping_comentario" required="" value="">
							</div>
							<br>
							<div >
							  <input type="text" class="form-control"  name="embarazo_comentario" required="" value=""
							</div>
							<br>
							<div >
							  <input type="text" class="form-control"  name="vista_comentario" required="" value="">
							</div>
							<br>
							<div >
							  <input type="text" class="form-control"  name="enfermedad_comentario" required="" value="">
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