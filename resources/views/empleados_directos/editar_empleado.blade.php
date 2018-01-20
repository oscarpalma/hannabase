@extends('base')
@section('titulo','Editar Empleado')
@section('cabezera','Editar Empleado')
@section('css')

@endsection
@section('content')

@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> Hubo problemas para registrar al empleado.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
@elseif(Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Empleado registrado exitosamente con Numero de Empleado: {{Session::get('success')}}
				
			</div>

@endif

<div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
			
			<form class="form-horizontal" method="POST" action="{{ route('empleado_crtm_editar',$datos['empleado']->idEmpleado) }}" id="registro-form" data-parsley-validate="" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<!---->
				<div class="row-sm">					
					<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				</div>

				<h3>Datos Personales</h3>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Apellido Paterno <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="ap_paterno" required="" value="{{ $datos['empleado'] -> ap_paterno }}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Apellido Materno</label>
						<div >
							<input type="text" class="form-control" name="ap_materno" value="{{ $datos['empleado'] -> ap_materno }}" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Nombre(s) <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="nombres"  required="" value="{{ $datos['empleado'] -> nombres }}" style="text-transform:uppercase" >
						</div>
					</div>
				</div>
				<!---->
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Fecha de nacimiento <text style="color:red">*</text></label>
						<div >
						<input class="form-control" type="date" name="fecha_nacimiento" value="{{ $datos['empleado'] -> fecha_nacimiento }}" required="">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Género <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="genero" required>
  								<option value="">Seleccione</option>
  								<option value="femenino" @if ($datos['empleado'] -> genero == 'femenino') selected="" @endif>Femenino</option>
		  						<option value="masculino" @if ($datos['empleado'] -> genero   == 'masculino') selected="" @endif>Masculino</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
					  <label class="control-label">Estado <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" name="id_estados" required>
					  	<option value="">Seleccione</option>
					  	@foreach($datos['estados'] as $estado)
								  			<option value="{{$estado->id_estados}}" @if ( $datos['empleado'] ->idestado   == $estado->id_estados) selected="" @endif>{{$estado->nombre}}</option>
						@endforeach
					  	</select>
					  </div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div @if($errors->first('curp'))class="has-error"@endif>
							<label class="control-label">CURP </label>
							<input type="text" class="form-control" name="curp" required="" maxlength="18" value="{{ $datos['empleado'] -> curp }}" style="text-transform:uppercase" readonly="" >
						</div>

					</div>
				    <div class="col-sm-4">
						<div @if($errors->first('imss'))class="has-error"@endif>
							<label class="control-label">Seguro Social (IMSS) </label>
							<input type="text" class="form-control" name="imss" value="{{ $datos['empleado'] -> imss }}" maxlength="11" readonly="">
							
						</div>
					</div>
					   <div class="col-sm-4">
					   <div @if($errors->first('no_cuenta'))class="has-error" @endif>
							<label class="control-label">Número de cuenta</label>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1"><i class="fa fa-credit-card"></i></span>
							<input type="text" class="form-control" name="no_cuenta" value="{{ $datos['empleado'] -> no_cuenta }}" maxlength="10" >
							
						</div>	
						</div>
					</div>					
				</div>
				<div class="row">
					<div class="col-sm-4">
						
							
								<label class="control-label">Area <text style="color:red">*</text></label>
								<div>
									<select class="form-control" name="area" required>
										<option value="">Seleccione</option>
										@foreach($datos['area'] as $area)
											<option value="{{$area->idArea}}" @if ($datos['empleado'] -> area == $area->idArea) selected="" @endif>{{$area->nombre}}</option>
										@endforeach
									</select>
														
						</div>
					</div>
				</div>
				
				<hr>
				<h3>Datos de contacto</h3>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Telefono Casa</label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone"></i></span>
						  <input type="text" class="form-control"  name="tel_casa" maxlength="10" value="{{ $datos['contacto'] -> tel_casa }}">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Telefono Celular</label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-mobile fa-2"></i></span>
						  <input type="text"  class="form-control" name="tel_cel" maxlength="10"   value="{{ $datos['contacto'] -> tel_cel }}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Calle <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="calle" required="" value="{{ $datos['contacto'] -> calle }}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-3">
						<label class="control-label">No Interior</label>
						<div >
							<input type="text" class="form-control" name="no_interior" value="{{ $datos['contacto'] -> no_interior }}" style="text-transform:uppercase" >
						</div>	
					</div>
					<div class="col-sm-3">
						<label class="control-label">No Exterior <text style="color:red">*</text></label>
						<div >
						<input type="number" class="form-control" name="no_exterior" value="{{ $datos['contacto'] -> no_exterior }}" required="" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-3">
						<label class="control-label">Colonia <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="idColonia" required>
							<option value="">Seleccione</option>
							@foreach($datos['colonias'] as $colonia)
									<option value="{{$colonia->idColonia}}" 
									@if ($datos['contacto'] -> idColonia == $colonia->idColonia) selected="" @endif>{{$colonia->nombre}}</option>
								@endforeach
							</select>
						</div>		
					</div>
				</div>
				<hr>
				<h3>En caso de emergencia</h3>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Nombre <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="nombre_contacto" required="" value="{{ $datos['contacto'] -> nombre_contacto }}" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Telefono <text style="color:red">*</text></label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone"></i></span>
						  <input type="text" class="form-control"  name="tel_contacto" maxlength="10" required="" value="{{ $datos['contacto'] -> tel_contacto }}">
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Parentesco <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="tipo_parentesco" required>
								<option value="">Seleccione</option>
								<option value="Madre" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'madre') == 0) selected="" @endif>Madre</option>
								<option value="Padre" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'padre') == 0) selected="" @endif>Padre</option>
								<option value="Esposa" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'esposa') == 0) selected="" @endif>Esposa</option>
								<option value="Esposo" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'esposo') == 0) selected="" @endif>Esposo</option>
								<option value="Hermana" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'hermana') == 0) selected="" @endif>Hermana</option>
								<option value="Hermano" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'hermano') == 0) selected="" @endif>Hermano</option>
								<option value="Tia" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'tia') == 0) selected="" @endif>Tia</option>
								<option value="Tio" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'tio') == 0) selected="" @endif>Tio</option>
								<option value="Abuela" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'abuela') == 0) selected="" @endif>Abuela</option>
								<option value="Abuelo" @if (strcasecmp($datos['contacto'] -> tipo_parentesco , 'abuelo') == 0) selected="" @endif>Abuelo</option>
								<option value="No especificado" @if (strcasecmp($datos['contacto'] -> tipo_parentesco, 'no especificado') == 0) selected="" @endif>No especificado</option>
							
							</select>
						</div>
					</div>
				</div>
				<br>
				<div class="form-actions">
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Registro
						</button>
					
				</div>
			</form>
			<!--Fin de Forma -->
			
			
			</div>
		</div>
	</div>
</div>

@stop