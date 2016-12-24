@extends('layouts.dashboard')
@section('page_heading','Modificar Empleado CT')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')

@if(Session::has('success'))
<script type="text/javascript">
window.onload = function(){ alert("¡Empleado modificado exitosamente!");}
</script>
@endif
           
<div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Datos Personales.</strong></div>
			<div class="panel-body">
			@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Alerta!</strong> Hubo problemas para registrar al candidato.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<form class="form-horizontal" role="form" method="POST" action="{{ route('modificar_empleadoct', $datos['empleado']->idEmpleadoCt) }}" id="registro-form" data-parsley-validate="" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="row-sm">					
					<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				</div>
				<img src="{{url($datos['empleado']->foto)}}" width="105" height="136" class="foto" />
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Apellido Paterno <text style="color:red">*</text></label>
							<div >
								<input type="text" class="form-control" name="ap_paterno"  id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" required="" value="{{ $datos['empleado'] -> ap_paterno }}" style="text-transform:uppercase" >
							</div>
								
							</div>
						</div>
					</div> 
				    <div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
								<label class="control-label">Apellido Materno <text style="color:red">*</text></label>
								<div >
									<input type="text" class="form-control" name="ap_materno" id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" @if($datos['empleado'] -> ap_materno ==null)
									value="XX" @else  value="{{$datos['empleado'] -> ap_materno}}" @endif style="text-transform:uppercase" >
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Nombre(s) <text style="color:red">*</text></label>
							<div >
								<input type="text" class="form-control" name="nombres"  id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" required="" value="{{ $datos['empleado'] -> nombres }}" style="text-transform:uppercase" >
							</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Fecha de nacimiento <text style="color:red">*</text></label>
								<div >
									<input class="form-control" type="date" name="fecha_nacimiento" value="{{ $datos['empleado'] -> fecha_nacimiento }}" required="">
								</div>
							</div>
						</div>
					</div>
				    <div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Género <text style="color:red">*</text></label>
								<div >
									<select class="form-control" name="genero">
		  								<option value="femenino" @if ($datos['empleado'] -> genero == 'femenino') selected="" @endif>Femenino</option>
		  								<option value="masculino" @if ($datos['empleado'] -> genero   == 'masculino') selected="" @endif>Masculino</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Estado <text style="color:red">*</text></label>
								<div >
									<select class="form-control" id="estado" name="id_estados" required>
								  		@foreach($datos['estados'] as $estado)
								  			<option value="{{$estado->id_estados}}" @if ( $datos['empleado'] ->idestado   == $estado->id_estados) selected="" @endif>{{$estado->nombre}}</option>
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
								<label class="control-label">CURP <text style="color:red">*</text></label>
								<div >
									<input type="text" class="form-control" name="curp" required="" maxlength="18" value="{{ $datos['empleado'] -> curp }}" style="text-transform:uppercase"  readonly="">
									<div class="error"><span class="label label-danger">{{ $errors->first('curp') }}</span></div>
								</div>
							</div>
						</div>
					</div>
				    <div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Seguro Social (IMSS) </label>
							<div >
								<input type="text" class="form-control" name="imss" value="{{ $datos['empleado'] -> imss }} " id="NumbersOnly" onkeypress="return inputLimiter(event,'Numbers')"  maxlength="11"  style="text-transform:uppercase" >
								<div class="error"><span class="label label-danger">{{ $errors->first('imss') }}</span></div>
							</div>
								
							</div>
						</div>
					</div>

					   <div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Número de cuenta</label>
							<div >
								<input type="text" class="form-control" name="no_cuenta" value="{{ $datos['empleado'] -> no_cuenta }}" maxlength="10" >
								<div class="error"><span class="label label-danger">{{ $errors->first('no_cuenta') }}</span></div>
							</div>
								
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
								<label class="control-label">RFC <text style="color:red">*</text></label>
								<div >
									<input type="text" class="form-control" name="rfc" maxlength="13" value="{{ $datos['empleado'] -> rfc }} " style="text-transform:uppercase" >
									<div class="error"><span class="label label-danger">{{ $errors->first('rfc') }}</span></div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
								<label class="control-label">Area <text style="color:red">*</text></label>
								<div>
									<select class="form-control" name="area" required>
										@foreach($datos['area'] as $area)
											<option value="{{$area->idAreaCt}}" @if ( $datos['empleado'] -> area   == $area->idAreaCt) selected="" @endif>{{$area->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<hr>
				<h3>Datos de contacto</h3>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Telefono Casa <text style="color:red">*</text></label>
								<div class="input-group">
								  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-home"></i></span>
								  <input type="text" class="form-control"  name="tel_casa" id="NumbersOnly" onkeypress="return inputLimiter(event,'Numbers')"  maxlength="10" required="" value="{{ $datos['contacto'] -> tel_casa }} ">
								</div>
							</div>
						</div>
					</div>
				    <div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
								<label class="control-label">Telefono Celular</label>
								<div class="input-group">
								  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-mobile fa-2"></i></span>
								  <input type="text"  class="form-control" name="tel_cel" id="NumbersOnly" onkeypress="return inputLimiter(event,'Numbers')" maxlength="10"  required="" value="{{ $datos['contacto'] -> tel_cel }}">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Calle <text style="color:red">*</text></label>
								<div >
									<input type="text" class="form-control" name="calle" required="" value="{{ $datos['contacto'] -> calle }}" style="text-transform:uppercase" >
								</div>
							</div>
						</div>
					</div>
				    <div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">No Interior</label>
								<div >
									<input type="text" class="form-control" name="no_interior" value="{{ $datos['contacto'] -> no_interior }}" style="text-transform:uppercase" >
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							 <label class="control-label">No Exterior <text style="color:red">*</text></label>
							 	<div >
									<input type="number" class="form-control" name="no_exterior" value="{{ $datos['contacto'] -> no_exterior }}" required="" style="text-transform:uppercase" >
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div class="panel-body">
							 <label class="control-label">Colonia <text style="color:red">*</text></label>
							 	<div >
							 		<select class="form-control" id="colonia" name="idColonia" required>
										@foreach($datos['colonias'] as $colonia)
											<option value="{{$colonia->idColonia}}" 
											@if ( $datos['contacto'] -> idColonia  == $colonia->idColonia) selected="" @endif>{{$colonia->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<h3>En caso de emergencia</h3>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Nombre <text style="color:red">*</text></label>
							<div >
								<input type="text" class="form-control" name="nombre_contacto"  id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" required="" value="{{ $datos['contacto'] -> nombre_contacto }}" style="text-transform:uppercase" >
							</div>
								
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
							<label class="control-label">Telefono <text style="color:red">*</text></label>
								<div class="input-group">
								  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone"></i></span>
								  <input type="text" class="form-control"  name="tel_contacto" id="NumbersOnly" onkeypress="return inputLimiter(event,'Numbers')"  maxlength="10" required="" value="{{ $datos['contacto'] -> tel_contacto }}">
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="panel-body">
								<label class="control-label">Parentesco <text style="color:red">*</text></label>
								<div >
									<select class="form-control" name="tipo_parentesco">
										<option value="esposa" @if ($datos['contacto'] -> tipo_parentesco  == 'esposa') selected="" @endif>Esposa</option>
										<option value="esposo" @if ($datos['contacto'] -> tipo_parentesco == 'esposo') selected="" @endif>Esposo</option>
										<option value="madre" @if ($datos['contacto'] -> tipo_parentesco == 'madre') selected="" @endif>Madre</option>
										<option value="padre" @if ($datos['contacto'] -> tipo_parentesco == 'padre') selected="" @endif>Padre</option>
										<option value="hermana" @if ($datos['contacto'] -> tipo_parentesco == 'hermana') selected="" @endif>Hermana</option>
										<option value="hermano" @if ($datos['contacto'] -> tipo_parentesco == 'hermano') selected="" @endif>Hermano</option>
										<option value="tia" @if ($datos['contacto'] -> tipo_parentesco == 'tia') selected="" @endif>Tia</option>
										<option value="tio" @if ($datos['contacto'] -> tipo_parentesco == 'tio') selected="" @endif>Tio</option>
										<option value="abuela" @if ($datos['contacto'] -> tipo_parentesco == 'abuela') selected="" @endif>Abuela</option>
										<option value="abuelo" @if ($datos['contacto'] -> tipo_parentesco == 'abuelo') selected="" @endif>Abuelo</option>
										<option value="no especificado" @if ($datos['contacto'] -> tipo_parentesco == 'no especificado') selected="" @endif>No especificado</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Modificar
						</button>
					</center>
				</div>
			</form>
			<!--Fin de Forma -->
			<!-- <script type="text/javascript">
				$(function () {
				  $('#registro-form').parsley().on('field:validated', function() {
				    var ok = $('.parsley-error').length === 0;
				    $('.bs-callout-info').toggleClass('hidden', !ok);
				    $('.bs-callout-warning').toggleClass('hidden', ok);
				  })
				});
			</script> -->
			<script type="text/javascript">
				function inputLimiter(e,allow) {
			    var AllowableCharacters = '';

			    if (allow == 'Letters'){AllowableCharacters=' ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz';}
			    if (allow == 'Numbers'){AllowableCharacters='1234567890';}
			    if (allow == 'NameCharacters'){AllowableCharacters=' ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.\'';}

			    var k = document.all?parseInt(e.keyCode): parseInt(e.which);
			    if (k!=13 && k!=8 && k!=0){
			        if ((e.ctrlKey==false) && (e.altKey==false)) {
			        return (AllowableCharacters.indexOf(String.fromCharCode(k))!=-1);
			        } else {
			        return true;
			        }
			    } else {
			        return true;
			    }
			} 
			</script>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#colonia").select2();
		$("#estado").select2();
	});
</script>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>



    @stop
@stop