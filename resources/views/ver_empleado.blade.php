@extends('layouts.dashboard')
@section('page_heading','Ver Empleado')
@section('section')
<div class="container-fluid">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Datos Personales.</strong></div>
			<div class="panel-body">
			
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Apellido Paterno</label>
						<div >
							<input type="text" class="form-control" name="ap_paterno"  id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" readonly="" value="{{ $empleado['ap_paterno']}}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Apellido Materno</label>
						<div >
							<input type="text" class="form-control" name="ap_materno" readonly="" id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" value="{{ $empleado['ap_materno']}}" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Nombre(s)</label>
						<div >
							<input type="text" class="form-control" name="nombres"  id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" readonly="" value="{{ $empleado['nombres']}}"  style="text-transform:uppercase" >
						</div>
					</div>
				</div>
				<!---->
				<hr>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Fecha de nacimiento</label>
						<div >
						<input class="form-control" type="date" name="fecha_nacimiento" value="{{ $empleado['fecha_nacimiento']}}" readonly="">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Género</label>
						<input class="form-control" readonly="" value="{{$empleado['genero']}}">
					</div>
					<div class="col-sm-4">
					  <label class="control-label">Estado</label>
					  <div >
					  	<input class="form-control" readonly="" value="{{$empleado['estado']}}">
					  </div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">CURP</label>
						<div >
							<input type="text" class="form-control" name="curp" readonly="" maxlength="18" value="{{$empleado['curp']}}" style="text-transform:uppercase" readonly="">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Seguro Social (IMSS) </label>
						<div >
							<input type="text" class="form-control" name="imss" value="{{$empleado['imss']}}" id="NumbersOnly" readonly="" style="text-transform:uppercase" >
						</div>
					</div>
					   <div class="col-sm-4">
						<label class="control-label">Número de cuenta</label>
						<div >
							<input type="text" class="form-control" name="no_cuenta" value="{{$empleado['no_cuenta']}}" maxlength="10" readonly="" >
						</div>	
					</div>
					<div class="col-sm-4">
						<label class="control-label">RFC</label>
						<div >
							<input type="text" class="form-control" name="rfc" maxlength="13" value="{{$empleado['rfc']}}" style="text-transform:uppercase" readonly="">
						</div>
					</div>

					<div class="col-sm-4">
						<label class="control-label">Perfil</label>
						<input class="form-control" readonly="" value="{{$empleado['tipo_perfil']}}">
					</div>
				</div>
				<hr>
				<h3>Datos de contacto</h3>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Telefono Casa</label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-home"></i></span>
						  <input type="text" class="form-control"  name="tel_casa" id="NumbersOnly" onkeypress="return inputLimiter(event,'Numbers')" readonly="" maxlength="10" value="{{$empleado['tel_casa']}}">
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Telefono Celular</label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-mobile fa-2"></i></span>
						  <input type="text"  class="form-control" name="tel_cel" id="NumbersOnly" onkeypress="return inputLimiter(event,'Numbers')" maxlength="10" readonly="" value="{{$empleado['tel_cel']}}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Calle</label>
						<div >
							<input type="text" class="form-control" name="calle" readonly="" value="{{$empleado['calle']}}" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-3">
						<label class="control-label">No Interior</label>
						<div >
							<input type="text" class="form-control" name="no_interior" value="{{$empleado['no_interior']}}" readonly="" style="text-transform:uppercase" >
						</div>	
					</div>
					<div class="col-sm-3">
						<label class="control-label">No Exterior</label>
						<div >
						<input type="number" class="form-control" name="no_exterior" value="{{$empleado['no_exterior']}}" readonly="" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-3">
						<label class="control-label">Colonia</label>
						<div >
							<input class="form-control" readonly="" value="{{$empleado['colonia']}}">
						</div>		
					</div>
				</div>
				<hr>
				<h3>En caso de emergencia</h3>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Nombre</label>
							<input type="text" class="form-control" name="nombre_contacto"  id="LettersOnly" onkeypress="return inputLimiter(event,'Letters')" readonly="" value="{{$empleado['nombre_contacto']}}" style="text-transform:uppercase" >
						</div>
					<div class="col-sm-4">
						<label class="control-label">Telefono</label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone"></i></span>
						  <input type="text" class="form-control"  name="tel_contacto" id="NumbersOnly" onkeypress="return inputLimiter(event,'Numbers')"  maxlength="10" readonly="" value="{{$empleado['tel_contacto']}}">
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Parentesco</label>
						<input class="form-control" value="{{$empleado['tipo_parentesco']}}" readonly="">
					</div>
				</div>
				</div>
@stop
