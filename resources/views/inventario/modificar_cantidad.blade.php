@extends('base')
@section('cabezera','Actualizar Cantidad')
@section('css')
<link href="/static/select2/select2.css" rel="stylesheet">

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
@section('content')


<div id="load">Espere un momento ...</div>

	
		<div class="alert alert-danger alert-dismissible" role="alert" id="error" hidden="">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> <span id="errorMensaje"></span>
				
			</div>
			<div class="alert alert-success alert-dismissible" role="alert" id="success" hidden="">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> <span id="mensajeSuccess"></span> 
				
			</div>
		<div class="panel panel-primary"  id="material">
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
			<form class="form-horizontal" role="form" method="POST" action="{{ route('inventario_cantidad') }}"  data-parsley-validate="" enctype='multipart/form-data'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<!---->
				<div class="row-sm">					
					<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				</div>
				
				<div class="row">
				<div class="col-sm-4">
					  <label class="control-label">Opcion <text style="color:red">*</text></label>
					  <div >
					  	<select class="form-control" id="opcion" name="opcion" required>
					  		<option value="">Seleccione</option>
					  		<option value="aumentar">Aumentar</option>
					  		<option value="disminuir">Disminuir</option>
					  	</select>
					  </div>
						
					</div>
					<div class="col-sm-4">
						<label class="control-label">Cantidad <text style="color:red">*</text></label>
						<div >
							<input type="number" class="form-control" name="unidades" id="unidades" min="1"  required>
						
						</div>
					</div>
				   <div class="col-sm-4">
				   <label class="control-label">Codigo <text style="color:red">*</text></label>
					    <div class="">
					      <input type="text" class="form-control" name="codigo" id="codigo" required="">
					      
					    </div>
  					</div>
					  
					
					
				</div>

				


				<br>
				
				<div class="row">
					
				    <div class="form-group">
				    <center>
						<button type="button" id="actualizar" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Actualizar
						</button>
					</center>
				</div>
					
				</div>
				<!---->
				
				

				
				
				
			
				
				
			</form>
			<!--Fin de Forma -->
			
			
			</div>
		</div>
	




@stop

@section('js')


<script type="text/javascript">
	

$(document).ready(function(){

		$("#load").hide();

		

$( "#codigo" ).keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
     actualizar();
  }
});

     $("#actualizar").on("click",function() {
      
      actualizar();

    });

    function actualizar(){
    	var codigo = $.trim($("#codigo").val());
    	var unidades = $("#unidades").val();
    	var opcion = $("#opcion").val();
    	if (codigo!="" && unidades>0 && opcion!=""){
		       $( "#load" ).show();

		       var dataString = { 
		              codigo : codigo,
		              cantidad: unidades,
		              opcion: opcion,
		              _token : '{{ csrf_token() }}'
		            };

		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('inventario/cantidad') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){

		              $( "#load" ).hide();
		              
		              
		              if(data){
		              	if(!data.excedente){
			              	$("#error").hide();
			              	
			                	                
			                $("#cantidadActual").html(data.unidades);
			                 $(".cantidad").val(data.unidades);
			                                
			                	                
			                $("#unidades").val("");
			                $("#codigo").val("");
			                $("#mensajeSuccess").html("El material "+data.nombre+" de marca "+data.marca+" se actualizo correctamente. Cantidad restante: "+data.cantidad);
			                $("#success").show();

			              }else{
			              	$("#errorMensaje").html(data.excedente);
			              	 $("#error").show();
			              	 $("#success").hide();
			              }

			          }else{
			              	 $("#errorMensaje").html("El codigo ingresado no coincide con ningun material registrado! ");
			              	 $("#error").show();
			              	 $("#success").hide();
			              
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