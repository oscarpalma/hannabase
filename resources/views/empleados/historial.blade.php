@extends('layouts.dashboard')
@section('page_heading','Historial de empleado')
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
					      <input type="text" class="form-control" placeholder="Numero de empleado" id="codigoBuscar">
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
				<strong><span class="glyphicon glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> Ingrese el numero de empleado 
				
			</div>
		<div class="alert alert-danger alert-dismissible" role="alert" id="error" hidden="">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> El numero de empleado ingresado no coincide con ningun empleado registrado! 
				
			</div>
		  <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Informacion personal</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="" src="{{ asset('imagenes/user2.png') }}" class="img-circle img-responsive"> </div>
                
                
                <div class=" col-md-4 col-lg-4 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td><strong>Numero de empleado:</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Nombre:</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Fecha de ingreso:</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Genero:</strong></td>
                        <td></td>
                      </tr>
                         
                          
                      <tr>
                        <td><strong>Fecha de nacimiento</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Estado de nacimiento:</strong></td>
                        <td>
                        </td>
                           
                      </tr>
                      <tr>
                        <td><strong>Estado de nacimiento:</strong></td>
                        <td>
                        </td>
                           
                      </tr>
                      <tr>
                        <td><strong>CURP:</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>IMSS:</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>RFC:</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Perfil:</strong></td>
                        <td></td>
                      </tr>
                     <tr>
                        <td><strong>Visa:</strong></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
                <div class=" col-md-9 col-lg-4 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td><strong>Direccion:</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Telefono(s):</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>En caso de emergencia:</strong></td>
                        <td></td>
                      </tr>
                   
                      
                     
                    </tbody>
                  </table>
                  
                  
                  </div>
              </div>
            </div>
            <div class="panel-heading">
              <h3 class="panel-title">Datos de localizacion</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                
               
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td><strong>Direccion:</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Telefono(s):</strong></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>En caso de emergencia:</strong></td>
                        <td></td>
                      </tr>
                   
                      
                     
                    </tbody>
                  </table>
                  
                  
                  </div>
              </div>
         
					
				</div>
            </div>
            
            
            
          </div>
	</div>
</div>



@section('scripts')


<script type="text/javascript">
	
	function mostrarSistemas(){
		if ($("#area").val()=='24'){
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
		              
		              if(data){
		              	$("#error").hide();
		              	$("#material").show();

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
		                	}else{
		                		$('#tipo> option[value="computadora"]').attr('selected', 'selected');
			                	$("#password").val(data.contrasena);

			                	if(data.antivirus==1)
			                		$("#antivirus").prop('checked', true);
			                }
			                mostrarComputadora();
		                }
		                JsBarcode("#barcode1",codigo );
		                $("#codigoBuscar").val("")
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

  });

</script>

    @stop
@stop