@extends('base')
@section('titulo','Editar Candidato')
@section('cabezera','Editar Candidato')
@section('css')
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">   
@endsection
@section('content')

@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> Hubo problemas para registrar al candidato.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
@elseif(Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Candidato registrado exitosamente con Numero de Empleado: {{Session::get('success')}}
				
			</div>

@endif

<div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
			
			<form class="form-horizontal" role="form" method="POST" action="{{ route('editar_candidato',$empleado->idEmpleado) }}"  data-parsley-validate="" >
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
							<input type="text" class="form-control" name="ap_paterno" required="" value="{{ $empleado -> ap_paterno }}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Apellido Materno</label>
						<div >
							<input type="text" class="form-control" name="ap_materno" value="{{ $empleado -> ap_materno }}" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Nombre(s) <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="nombres"  required="" value="{{ $empleado -> nombres }}" style="text-transform:uppercase" >
						</div>
					</div>
				</div>
				<!---->
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Fecha de nacimiento <text style="color:red">*</text></label>
						<div >
						<input class="form-control" type="date" name="fecha_nacimiento" value="{{ $empleado -> fecha_nacimiento }}" required="">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Género <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="genero" required>
  								<option value="">Seleccione</option>
  								<option value="femenino" @if ($empleado -> genero == 'femenino') selected="" @endif>Femenino</option>
  								<option value="masculino" @if ($empleado -> genero == 'masculino') selected="" @endif>Masculino</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
					  <label class="control-label">Estado {{$empleado->id_estados}}<text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" name="id_estados" required>
					  	<option value="">Seleccione</option>
					  	@foreach($estados as $estado)
					  			<option value="{{$estado->id_estados}}" @if ($empleado -> idestado == $estado->id_estados) selected="" @endif>{{$estado->nombre}}</option>
					  		@endforeach	
					  	</select>
					  </div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div @if($errors->first('curp'))class="has-error"@endif>
							<label class="control-label">CURP</label>
							<input type="text" class="form-control" name="curp" required="" maxlength="18" value="{{$empleado -> curp}}"  readonly="" >
						</div>

					</div>
				    <div class="col-sm-4">
						<div @if($errors->first('imss'))class="has-error"@endif>
							<label class="control-label">Seguro Social (IMSS) </label>
							<input type="text" class="form-control" name="imss" value="{{$empleado -> imss}}" maxlength="11" readonly="">
							
						</div>
					</div>
					   <div class="col-sm-4">
					   <div @if($errors->first('no_cuenta'))class="has-error" @endif>
							<label class="control-label">Número de cuenta</label>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1"><i class="fa fa-credit-card"></i></span>
							<input type="text" class="form-control" name="no_cuenta" value="{{$empleado -> no_cuenta}}" maxlength="10" >
							
						</div>	
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Perfil <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="tipo_perfil">
								<option value="">Seleccione</option>
								<option value="a" @if ($empleado -> tipo_perfil == "a") selected="" @endif>Tipo A</option>
								<option value="b" @if ($empleado -> tipo_perfil == "b") selected="" @endif>Tipo B</option>
								<option value="c" @if ($empleado -> tipo_perfil == "c") selected="" @endif>Tipo C</option>
							</select>
						</div>
						<a href="#perfiles" class="aModal" data-toggle="modal" data-target="#perfiles">Ayúdame a decidir</a>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Visa <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="visa" required="">
								<option  value="" >Seleccione</option>
								<option value="si" @if ($empleado -> visa == 'si') selected="" @endif>Si</option>
								<option value="no" @if ($empleado -> visa == 'no') selected="" @endif>No</option>
								
							</select>
						</div>
						
					</div>
				</div>

				<div id="perfiles" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header modal-header-primary">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Tipos de perfil</h4>
				      </div>
				      <div class="modal-body">
				        <p><strong>Perfil A:</strong> No usa lentes/buena vista, complexió delgada, mínimo secundaria, menor de 40 años, no tatuajes, no aretes y cabello corto.</p>

				        <p><strong>Perfil B:</strong> Visión poco limitada y usa lentes, menor de 45 años, no aretes y cabello corto. Vestimenta normal, complexión poco robusta. Mínimo primaria, que sepa leer y escribir y sin tatuajes visibles.</p>

				        <p><strong>Perfil C:</strong> Menor de 50 años, usa lentes gruesos, aretes en orejas y cejas. Cabello largo, rapado o pelón. Vestimenta suelta. Complexión muy robusta. No sabe leer ni escribir y tiene tatuajes visibles en cara y brazos.</p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				      </div>
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
						  <input type="text" class="form-control"  name="tel_casa" maxlength="10" value="{{$contacto -> tel_casa}}">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Telefono Celular</label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-mobile fa-2"></i></span>
						  <input type="text"  class="form-control" name="tel_cel" maxlength="10"   value="{{$contacto -> tel_cel}}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Calle <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="calle" required="" value="{{$contacto -> calle}}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-3">
						<label class="control-label">No Interior</label>
						<div >
							<input type="text" class="form-control" name="no_interior" value="{{$contacto -> no_interior}}" style="text-transform:uppercase" >
						</div>	
					</div>
					<div class="col-sm-3">
						<label class="control-label">No Exterior <text style="color:red">*</text></label>
						<div >
						<input type="number" class="form-control" name="no_exterior" value="{{$contacto -> no_exterior}}" required="" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-3">
						<label class="control-label">Colonia <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="idColonia" required>
							<option value="">Seleccione</option>
							@foreach($colonias as $colonia)
									<option value="{{$colonia->idColonia}}" 
									@if ($contacto -> idColonia == $colonia->idColonia) selected="" @endif>{{$colonia->nombre}}</option>
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
							<input type="text" class="form-control" name="nombre_contacto" required="" value="{{$contacto -> nombre_contacto}}" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Telefono <text style="color:red">*</text></label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone"></i></span>
						  <input type="text" class="form-control"  name="tel_contacto" maxlength="10" required="" value="{{$contacto -> tel_contacto}}">
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Parentesco <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="tipo_parentesco">
								<option value="">Seleccione</option>
								<option value="Madre" @if (strcasecmp($contacto -> tipo_parentesco , 'madre') == 0) selected="" @endif>Madre</option>
								<option value="Padre" @if (strcasecmp($contacto -> tipo_parentesco , 'padre') == 0) selected="" @endif>Padre</option>
								<option value="Esposa" @if (strcasecmp($contacto -> tipo_parentesco , 'esposa') == 0) selected="" @endif>Esposa</option>
								<option value="Esposo" @if (strcasecmp($contacto -> tipo_parentesco , 'esposo') == 0) selected="" @endif>Esposo</option>
								<option value="Hermana" @if (strcasecmp($contacto -> tipo_parentesco , 'hermana') == 0) selected="" @endif>Hermana</option>
								<option value="Hermano" @if (strcasecmp($contacto -> tipo_parentesco , 'hermano') == 0) selected="" @endif>Hermano</option>
								<option value="Tia" @if (strcasecmp($contacto -> tipo_parentesco , 'tia') == 0) selected="" @endif>Tia</option>
								<option value="Tio" @if (strcasecmp($contacto -> tipo_parentesco , 'tio') == 0) selected="" @endif>Tio</option>
								<option value="Abuela" @if (strcasecmp($contacto -> tipo_parentesco , 'abuela') == 0) selected="" @endif>Abuela</option>
								<option value="Abuelo" @if (strcasecmp($contacto -> tipo_parentesco , 'abuelo') == 0) selected="" @endif>Abuelo</option>
								<option value="No especificado" @if (strcasecmp($contacto -> tipo_parentesco, 'no especificado') == 0) selected="" @endif>No especificado</option>
							
							</select>
						</div>
					</div>
				</div>
				<br>
				<div class="form-actions">
				   
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Guardar
						</button>
					
				</div>
			</form>
			<!--Fin de Forma -->
			
			
			</div>
		</div>
	</div>
</div>

@stop