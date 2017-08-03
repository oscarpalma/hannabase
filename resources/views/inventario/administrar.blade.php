@extends('layouts.dashboard')
@section('page_heading','Administrar Material')
@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="{{ asset('assets/scripts/barcode/JsBarcode.all.js') }}"></script>
<script>
		Number.prototype.zeroPadding = function(){
			var ret = "" + this.valueOf();
			return ret.length == 1 ? "0" + ret : ret;
		};
	</script>

	<style>
 
  
  #load { height: 100%; width: 100%; }
  #load {
    position    : fixed;
    z-index     : 99999; /* or higher if necessary */
    top         : 0;
    left        : 0;
    overflow    : hidden;
    text-indent : 100%;
    font-size   : 0;
    opacity     : 0.6;
    background  : #E0E0E0  url({!! asset('imagenes/load.gif') !!}) center no-repeat;
  }
  
  .RbtnMargin { margin-left: 5px; }
  
  </style>
@stop
@section('section')


<div id="load">Espere un momento ...</div>
<div class="container-fluid">
<div class="row">
	
			<div class="row">
					<div class="col-lg-4">
					    <div class="input-group">
					      <input type="text" class="form-control" id="codigoBuscar">
					      <span class="input-group-btn">

					        <button class="btn btn-default" type="button" id="buscar"><span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span></button>
					      </span>
					    </div>
  					</div>
			</div>

					
	<br>
</div>
	<div class="row">
	<div class="alert alert-info alert-dismissible" role="alert" id="mensajeInicial">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> Ingrese el codigo del producto 
				
			</div>
		<div class="alert alert-danger alert-dismissible" role="alert" id="error" hidden="">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> El codigo ingresado no coincide con ningun material registrado! 
				
			</div>
			
		<div class="panel panel-primary" hidden="" id="material">
			<div class="panel-heading"><strong>Material</strong></div>
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
					<label class="control-label">Codigo de barras</label>
						<div>
						<img id="barcode1"/>
						</div>

					</div>
					<div class="col-sm-4">
					<label class="control-label">Fotografia</label>
						<div>
						<img id="fotografia" src="" width="130" height="130"/>
						</div>

					</div>
				</div>



				<div class="row">
					<div class="col-sm-4">
						<input type="hidden" class="form-control" name="id"  id="id">
						<label class="control-label">Nombre <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="nombre"  id="nombre" required="" style="text-transform:uppercase" >
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Marca <text style="color:red">*</text></label>
						<div>
							<input type="text" class="form-control" name="marca" id="marca"  value="{{old('marca')}}" required="" style="text-transform:uppercase" >
						</div>
					</div>
					<div class="col-sm-4">
						<label class="control-label">Modelo <text style="color:red">*</text></label>
						<div >
							<input type="text" class="form-control" name="modelo" id="modelo" required="" value="{{old('modelo')}}" style="text-transform:uppercase" >
						</div>
					</div>
				</div>
				<!---->
				<hr>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Descripcion <text style="color:red">*</text></label>
						<div >
						<textarea name="descripcion" class="form-control" id="descripcion" required></textarea>
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Accesorios <text style="color:red">*</text></label>
						<div >
							<input type="text" name="accesorios" id="accesorios" value="{{old('accesorios')}}" class="form-control" required/>
						</div>
					</div>
					<div class="col-sm-4">
					  <label class="control-label">Estado <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" id="estado" name="estado" required>
					  		<option value="">Seleccione</option>
					  		<option value="nuevo">Nuevo</option>
					  		<option value="seminuevo">Seminuevo</option>
					  		<option value="malestado">Mal estado</option>
					  	</select>
					  </div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Unidades <text style="color:red">*</text></label>
						<div >
							<input type="number" class="form-control" name="unidades" id="unidades" min="1" required>
						
						</div>
					</div>
				    <div class="col-sm-4">
						<label class="control-label">Precio Unitario </label>
						<div class="input-group">
						 <span class="input-group-addon" id="basic-addon1"><i class="fa fa-usd"></i></span>
							<input type="text" class="form-control" name="precio" id="precio" style="text-transform:uppercase" >
							
						</div>
					</div>
					   <div class="col-sm-4">
						<label class="control-label">Foto </label>
						<div >
							<input type="file" class="form-control" name="image" id="image" required>
							
						</div>	
					</div>
					
					<div class="col-sm-4">
					  <label class="control-label">Area <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" id="area" name="area" required>
					  		<option value="">Seleccione</option>
					  		@foreach($areas as $area) 
			        			<option value="{{ $area->idArea }}">{{ $area->nombre }}</option>
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
						<button type="button" id="actualizar" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Actualizar
						</button>
					</center>
				</div>
			</form>
			<!--Fin de Forma -->
			
			
			</div>
		</div>
	</div>
</div>



@section('scripts')


<script type="text/javascript">
	
	function mostrarSistemas(){
		if ($("#area").val()=='7'){
		  	$("#sistemas").show();
		  	
		  	
		  	$("#tipo").prop('required', true);
		  	return true;
		  }else {
		  	$("#sistemas").hide();
		  	
		  	$("#tipo").prop('required', false);
		  	return false;
		  }
	}

	function mostrarComputadora(){
		if ($("#tipo").val()=='computadora'){
		  	$("#computadora").show();
		  	
		  	
		  	$("#password").prop('required', true);
		  	
		  }else {
		  	$("#computadora").hide();
		  	
		  	$("#password").prop('required', false);
		  	
		  }
	}

$( "#area" ).change(function() {
  mostrarSistemas();
});

$( "#tipo" ).change(function() {
  mostrarComputadora();
});


$(document).ready(function(){

		$("#load").hide();

$( "#codigoBuscar" ).keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
     buscar();
  }
});

     $("#buscar").on("click",function() {
      
      buscar();

    });
     $("#actualizar").on("click",function() {
      
      actualizar();

    });

    function buscar(){
    	var codigo = $.trim($("#codigoBuscar").val());

    	if (codigo!=""){
		       $( "#load" ).show();

		       var dataString = { 
		              codigo : codigo,
		              _token : '{{ csrf_token() }}'
		            };

		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('inventario/administrar') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){

		              $( "#load" ).hide();
		              $("#mensajeInicial").hide();
		              $("#success").hide();
		              if(data){
		              	$("#error").hide();
		              	$("#material").show();

		              	$("#id").val(data.id);
		                $("#nombre").val(data.nombre);
		                $("#marca").val(data.marca);
		                $("#modelo").val(data.modelo);
		                $("#descripcion").val(data.descripcion);
		                $("#unidades").val(data.unidades);
		                $("#precio").val(data.precio);
		                $("#accesorios").val(data.accesorios);
		                $('#estado> option[value="'+data.estado+'"]').attr('selected', 'selected');
		                $('#area> option[value="'+data.area+'"]').attr('selected', 'selected');
		                
		                $("#fotografia").attr("src","/"+data.foto);
		                if(mostrarSistemas()){
		                	if(data.otros){
		                		$('#tipo> option[value="otros"]').attr('selected', 'selected');
		                		$("#password").val("");
		                		$("#antivirus").prop('checked', false);
		                	}else{
		                		$('#tipo> option[value="computadora"]').attr('selected', 'selected');
			                	$("#password").val(data.contrasena);

			                	if(data.antivirus==1)
			                		$("#antivirus").prop('checked', true);
			                }
			                mostrarComputadora();
		                }
		                JsBarcode("#barcode1",codigo );
		                $("#codigoBuscar").val("");
		              }else{
		              	 $("#error").show();
		              	 $("#material").hide();
		              }
		          
		            } ,error: function(xhr, status, error) {
		              alert(error);
		            },

		        });
		    }
    }

    //Actualizar

    function actualizar(){
    	var id = $("#id").val();
    	var nombre = $("#nombre").val();
    	var marca = $("#marca").val();
    	var modelo = $("#modelo").val();
    	var descripcion = $("#descripcion").val();
    	var unidades = $("#unidades").val();
    	var precio = $("#precio").val();
    	var accesorios = $("#accesorios").val();
    	var estado = $("#estado").val();
    	var precio = $("#precio").val();
    	var area = $("#area").val();
    	var tipo = $("#tipo").val();
    	var contrasena = $("#password").val();
    	var antivirus = $("#antivirus").val();
    	
    	//alert(id);
		       $( "#load" ).show();

		       var dataString = { 
		              id : id,
		              nombre: nombre,
		              marca: marca,
		              modelo: modelo,
		              descripcion: descripcion,
		              unidades: unidades,
		              precio: precio,
		              accesorios: accesorios,
		              estado: estado,
		              precio: precio,
		              area: area,
		              tipo: tipo,
		              password: contrasena,
		              antivirus: antivirus,
		              _token : '{{ csrf_token() }}'
		            };

		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('inventario/actualizar') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){

		              $( "#load" ).hide();
		              
		              
		              if(data){
		              	
		              	$("#success").show();

		                
		              }else{
		              	 $("#error").show();
		              	 $("#material").hide();
		              }
		          
		            } ,error: function(xhr, status, error) {
		              alert(error);
		            },

		        });
		    
    }

  });

</script>

    @stop
@stop