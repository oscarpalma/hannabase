@extends('base')
@section('cabezera','Alta de Material')
@section('css')
<link href="/static/select2/select2.css" rel="stylesheet">

@stop
@section('content')



<div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
			@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Alerta!</strong> Hubo problemas al registrar el material.<br><br> 
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@elseif (Session::has('success'))

			<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></strong> {{Session::get('success')}} 
				
			</div>
			@endif
			<form class="form-horizontal" role="form" method="POST" action="{{ route('inventario_alta') }}"  data-parsley-validate="" enctype='multipart/form-data'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<!---->
				<div class="row-sm">					
					<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Nombre <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="nombre"  required="" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Marca <text style="color:red">*</text></label>
						<div>
							<input type="text" class="form-control" name="marca" value="{{old('marca')}}" required="" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Modelo <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="modelo"  required="" value="{{old('modelo')}}" style="text-transform:uppercase" >
						</div>
					</div>
				</div>
				<!---->
				<hr>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Descripcion <text style="color:red">*</text></label>
						<div >
						<textarea name="descripcion" class="form-control" required></textarea>
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Accesorios <text style="color:red">*</text></label>
						<div >
							<input type="text" name="accesorios" value="{{old('accesorios')}}" class="form-control" required/>
						</div>
					</div>
					<div class="col-sm-4">
					  <label class="control-label">Estado <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" id="estado" name="estado" required>
					  		<option value="">Seleccione</option>
					  		<option value="nuevo">Nuevo</option>
					  		<option value="seminuevo">Seminuevo</option>
					  		<option value="">Mal estado</option>
					  	</select>
					  </div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Unidades <text style="color:red">*</text></label>
						<div >
							<input type="number" class="form-control" name="unidades" min="1" required>
						
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Precio Unitario </label>
						<div class="input-group">
						 <span class="input-group-addon" id="basic-addon1"><i class="fa fa-usd"></i></span>
							<input type="text" class="form-control" name="precio"  style="text-transform:uppercase" >
							
						</div>
					</div>
					   <div class="col-sm-4">
						<label class="control-label">Foto </label>
						<div >
							<input type="file" class="form-control" name="image" id="image">
							
						</div>	
					</div>
					
					<div class="col-sm-4">
					  <label class="control-label">Area <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" id="area" name="area" required>
					  		<option value="">Seleccione</option>
					  		@foreach($areas as $area) 
			        			<option value="{{ $area->idArea }}">{{ $area->nombre }}</option>>
			        		@endforeach
					  	</select>
					  </div>
						
					</div>
				</div>

				<div id="sistemas" hidden="">
				<hr>
				<h3>Area de Sistemas</h3>

				<div class="row">
				<div class="col-sm-4">
					  <label class="control-label">Tipo <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" id="tipo" name="tipo" required>
					  		<option value="">Seleccione</option>
					  		    	<option value="computadora">Computadora</option>
					  		    	<option value="otros">Otros</option>
			        		
					  	</select>
					  </div>
						
					</div>
					<div id="computadora" hidden="">
					<div class="col-sm-4">
						<label class="control-label">Contraseña <text style="color:red">*</text></label>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key"></i></span>
						  <input type="text" class="form-control"  name="password" id="password">
						</div>
					</div>
				    <div class="col-sm-1">
						<label class="control-label">Antivirus <text style="color:red">*</text></label>
						
						
						  <input type="checkbox" value="1" class="form-control" name="antivirus" id="antivirus">
						
					</div>
					</div>
				</div>
				</div>
				
				
			
				<br>
				<div class="form-group">
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Registrar
						</button>
					</center>
				</div>
			</form>
			<!--Fin de Forma -->
			
			
			</div>
		</div>
	</div>
</div>




@stop

@section('js')


<script type="text/javascript">

$(document).ready(function(){	

$( "#area" ).change(function() {
  if ($("#area").val()=='7'){
  	$("#sistemas").show();
  	
  	
  	$("#tipo").prop('required', true);
  	
  }else {
  	$("#sistemas").hide();
  	
  	$("#tipo").prop('required', false);
  	
  }
});

$( "#tipo" ).change(function() {
  if ($("#tipo").val()=='computadora'){
  	$("#computadora").show();
  	
  	
  	$("#password").prop('required', true);
  	
  }else {
  	$("#computadora").hide();
  	
  	$("#password").prop('required', false);
  	
  }
});

});
</script>

    @stop