@extends('base')
@section('titulo','Nuevo Empleado')
@section('cabezera','Nuevo Empleado')
@section('css')
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">   
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

		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
			
			<form class="form-horizontal" role="form" method="POST" action="{{ route('alta_empleado_proyecto') }}" id="registro-form" data-parsley-validate="" >
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
							<input type="text" class="form-control" name="ap_paterno" required="" value="{{old('ap_paterno')}}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Apellido Materno</label>
						<div >
							<input type="text" class="form-control" name="ap_materno" value="{{old('ap_materno')}}" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Nombre(s) <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="nombres"  required="" value="{{old('nombres')}}" style="text-transform:uppercase" >
						</div>
					</div>
				</div>
				<!---->
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Fecha de nacimiento <text style="color:red">*</text></label>
						<div >
						<input class="form-control" type="date" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" required="">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Género <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="genero" required>
  								<option value="">Seleccione</option>
  								<option value="femenino" @if (Input::old('genero') == "femenino") selected="" @endif>Femenino</option>
  								<option value="masculino" @if (Input::old('genero') == "masculino") selected="" @endif>Masculino</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
					  <label class="control-label">Estado <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" name="id_estados" required>
					  	<option value="">Seleccione</option>
					  	@foreach($estados as $estado)
					  			<option value="{{$estado->id_estados}}" @if (Input::old('id_estados') == $estado->id_estados) selected="" @endif>{{$estado->nombre}}</option>
					  		@endforeach	
					  	</select>
					  </div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div @if($errors->first('curp'))class="has-error"@endif>
							<label class="control-label">CURP <text style="color:red">*</text></label>
							<input type="text" class="form-control" name="curp" required="" maxlength="18" value="{{old('curp')}}" style="text-transform:uppercase" >
						</div>

					</div>
				    <div class="col-sm-4">
						<div @if($errors->first('imss'))class="has-error"@endif>
							<label class="control-label">Seguro Social (IMSS) </label>
							<input type="text" class="form-control" name="imss" value="{{old('imss')}}" maxlength="11">
							
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
						  <input type="text" class="form-control"  name="tel_casa" maxlength="10" value="{{old('tel_casa')}}">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Telefono Celular</label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-mobile fa-2"></i></span>
						  <input type="text"  class="form-control" name="tel_cel" maxlength="10"   value="{{old('tel_cel')}}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Calle <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="calle" required="" value="{{old('calle')}}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-3">
						<label class="control-label">No Interior</label>
						<div >
							<input type="text" class="form-control" name="no_interior" value="{{old('no_interior')}}" style="text-transform:uppercase" >
						</div>	
					</div>
					<div class="col-sm-3">
						<label class="control-label">No Exterior <text style="color:red">*</text></label>
						<div >
						<input type="number" class="form-control" name="no_exterior" value="{{old('no_exterior')}}" required="" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-3">
						<label class="control-label">Colonia <text style="color:red">*</text></label>
						<div >
							<select class="form-control" name="idColonia" required>
							<option value="">Seleccione</option>
							@foreach($colonias as $colonia)
									<option value="{{$colonia->idColonia}}" 
									@if (Input::old('idColonia') == $colonia->idColonia) selected="" @endif>{{$colonia->nombre}}</option>
								@endforeach
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
	

@stop