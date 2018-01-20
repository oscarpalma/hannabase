@extends('base')
@section('titulo','Agregar Checada')
@section('cabezera','Agregar Checada')
@section('css')
<link href="/static/select2/select2.css" rel="stylesheet"> 
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
  
<!--Hacer que los textarea no puedan ser cambiados de tamano-->
<style type="text/css">
	textarea {
    resize: none;
}
</style>  
    
@endsection
@section('content')
<div class="alert alert-success alert-dismissible" role="alert" hidden="" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Se registró la checada exitosamente
				
</div>
<div class="alert alert-danger alert-dismissible" role="alert" hidden="" id="error">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> El empleado ya se encontraba trabajando en el horario especificado
				
</div>

<form class="form-horizontal" role="form" method="POST" action="{{ route('alta_checada_proyecto') }}" id="checada-form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empresa <text style="color:red">*</text></label>
					<div >								
						<select class="form-control" name="cliente"  id="cliente" required="">
							<option value="">Seleccione</option>
							@foreach($clientes as $cliente)
								<option name="{{$cliente->idCliente}}" value="{{$cliente->idCliente}}">{{$cliente->nombre}}</option>
							@endforeach
						</select>
					</div>	 
				</div>
			    <div class="col-sm-4">
					<label class="control-label">Turno <text style="color:red">*</text></label>
					<div >
					<select class="form-control" name="turno" id="turno">
						<option value="">-------</option>
					</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>" id="fecha" max="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>
			</div>
			
		
			<hr>
			

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado <text style="color:red">*</text></label>
					<div>
						<select name="empleado" id="empleado" class="form-control" data-live-search="true">
							@if (count ($empleados)>0){
							<option value="">Seleccione</option>
							@foreach($empleados as $empleado)
								<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
							@else
							<option value="">-------</option>
							@endif
						</select>
					</div>
				</div>
				<!---->
				<div class="col-sm-4">
					<label class="control-label">Entrada <text style="color:red">*</text></label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input  name="hora_entrada" class="time_element form-control" id="hora_entrada"  />
					</div>
                
				</div>

				<!---->
			    <div class="col-sm-4">
					<label class="control-label">Salida <text style="color:red">*</text></label>
					<div >
						<input   class="form-control" name="hora_salida"  id="hora_salida" value="">
					</div>
				</div>
			</div>
			<div class ="row">
				<div class="col-sm-4">
					
					<label class="control-label">Horas Ordinarias <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias"  id="horas_ordinarias"  value="" >
					</div>
				</div>
				<div class="col-sm-4">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra"  id="horas_extra" >
					</div>
				
				</div>
				
			</div>
			
			<br>
			<div class="form-actions">
					<button type="button" class="btn btn-primary" id="registrar" data-loading-text="Guardando.." >
						Guardar
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- Modal requerir campos -->
<div class="modal fade" id="requerirModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <!-- Contenido Modal requerir campos -->
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-danger">
                                            <h4 class="modal-title">Campos requeridos</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong>Llena todos los campos marcados con <text style="color:red">*</text> para continuar</strong></p>
                                           

                                            
                                          </div>
                                    <!-- /.modal-content -->
                                </div></div>
                                <!-- /.modal-dialog requerir campos-->
                               

                            </div>
                            <!-- /.modal requerir todos los campos-->











@endsection
@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#empleado").select2();
		$('#cliente').on('change', function(e){
        
        var idCliente = e.target.value;
        var dataString = { 
              idCliente : idCliente             
            };
        $.ajax({
            type: "GET",
            url: "{{ URL::to('empleados_proyecto/ajax/turnos') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $('#turno').empty();
				$("#hora_entrada").val(""); 
				$("#hora_salida").val(""); 
				$("#horas_ordinarias").val(""); 
				$("#horas_extra").val("");             
              if(data.length >0){
                
	            $("#cliente option[value='']").hide();
	           	$('#turno').append('<option value="">Seleccione</option>');
	           	$.each(data,function(index,turnosObj){
	           	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	               });               
              }else{
              	$('#turno').append('<option value="">-------</option>');
	           	$("#hora_entrada").val("");
	         	$("#hora_salida").val("");
	         	$("#horas_ordinarias").val("");	
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
        
   
        });

       
       
        
    

    //Cuando el horario cambia
      $('#turno').on('change', function(e){
        
        var idTurno = e.target.value;

        $.get('/ajax-turno?idTurno=' + idTurno, function(data) {
        	$("#turno option[value='']").hide();
         	$.each(data,function(index,horasObj){
         	$("#hora_entrada").val(horasObj.hora_entrada);
         	$("#hora_salida").val(horasObj.hora_salida);
         	$("#horas_ordinarias").val(horasObj.horas_trabajadas);

         	 
 
           	});
   
        });
        
    });

$("#registrar").click(function(){
      		
      		var empleado = $("#empleado").val();
      		var cliente = $("#cliente").val(); 
      		var turno = $("#turno").val(); 
      		var fecha = $("#fecha").val(); 
      		var hora_entrada = $("#hora_entrada").val(); 
      		var hora_salida = $("#hora_salida").val(); 
      		var horas_ordinarias = $("#horas_ordinarias").val(); 
      		var horas_extra = $("#horas_extra").val();
      		var incidencia = $("#incidencia").val();  
      		var comentarios = $("#comentarios").val(); 
      		if(empleado!="" && cliente!="" && turno!="" && hora_entrada!="" && hora_salida!="" && horas_ordinarias!=""){
		        var $btn = $(this).button('loading');
		        var dataString = { 
		              empleado : empleado,
		              cliente : cliente,
		              turno : turno,
		              fecha : fecha,
		              hora_entrada : hora_entrada,
		              hora_salida : hora_salida,
		              horas_ordinarias : horas_ordinarias,
		              horas_extra : horas_extra,
		              incidencia : incidencia,
		              comentarios : comentarios,
		              _token : '{{ csrf_token() }}'
		            };
		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('empleados_proyecto/checada/alta') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		              if(data){
		                //Limpiar campos
		                $("#horas_extra").val("");
		                $("#comentarios").val("");
		                $("#incidencia").val("xx");
		                //$("#empleado").val("");
		                $btn.button('reset');
	            		$("#success").show(600);
		                
                      	$("#success").delay(2000).hide(600);
		                
	                              
	              		}else{
	              			$("#error").show(600);
	              			$("#error").delay(3000).hide(600);
	              		}  
		          
		            } ,error: function(xhr, status, error) {
		              
		            },
		        });
      		}else{
      			$("#requerirModal").modal();
      		}
      		$btn.button('reset');
      });

	});
</script>
    @endsection