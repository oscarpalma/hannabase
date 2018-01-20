@extends('base')
@section('titulo','Agregar Checada Grupal')
@section('cabezera','Agregar Checada Grupal')
@section('css')
<!--Hacer que los textarea no puedan ser cambiados de tamaño-->
<style type="text/css">
	textarea {
    resize: none;
}
</style>
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">   

@stop
@section('content')

<div class="alert alert-success alert-dismissible" role="alert" hidden="" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Se registraron un total de <span id="cantidadCC"></span> checadas exitosamente
				
</div>
<div class="alert alert-danger alert-dismissible" role="alert" hidden="" id="error">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> Ninguna checada fue registrada, verifique los datos
				
</div>

<form class="form-horizontal" role="form" method="POST" action="{{ route('checadaG_empleados_crtm') }}" id="checada-form">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">		
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
				
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha"  id="fecha" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
					</div>

					<label class="control-label">Empleados <text style="color:red">*</text></label>
					<div >
						<textarea name="empleados" id="empleados" class="form-control" rows="4" cols="71" placeholder="Números de empleado"></textarea>
						<a href="#" id="verificar" class="aModal"  title="Ayuda a verificar que los numeros de empleados esten correctos" >Verificar</a>
					</div>

					<label class="control-label">Incidencia</label>
					<select class="form-control" name="incidencia" id="incidencia">
						<option value="xx">Ninguna</option>
						<option value="falta_justificada">Falta justificada</option>
						<option value="falta_injustificada">Falta injustificada</option>
						<option value="permiso">Permiso</option>
					</select>
				</div>
				<!---->
				<div class="col-sm-2">
					<label class="control-label">Entrada <text style="color:red">*</text></label>
					<div >
					<input   class="form-control"  name="hora_entrada"  id="hora_entrada"  required="">
					</div>

					
				</div>

				<!---->
			    <div class="col-sm-2">
					<label class="control-label">Salida <text style="color:red">*</text></label>
					<div >
						<input   class="form-control" name="hora_salida"  id="hora_salida" required="">
					</div>

					
				</div>
				<div class="col-sm-2">
					<label class="control-label">Horas ordinarias <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias"  id="horas_ordinarias"  required="">
					</div>

				</div>
				<div class="col-sm-2">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra"  id="horas_extra" >
					</div>

					
				</div>
				<div class="col-md-8">
					<label class="control-label">Comentarios</label>
					<textarea class="form-control" rows="4" name="comentarios" id="comentarios"></textarea>
				</div>
			</div>
			<br>
			<div class="form-actions">
					<button type="button" id="registrar" class="btn btn-primary" data-loading-text="Guardando..">
						Guardar
					</button>
				
			</div>
		</div> 
	</div>
</form>

<!-- Modales -->

<!-- Modal verificar empleados -->
<div class="modal fade" id="verificarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal convertir a empleado -->
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-info">
                                            <h4 class="modal-title">Verificar empleados</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> Lista de los empleados a los que se le va a agregar checada </strong></p>
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>CURP</th>
                                            <th>Área</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoVerificar">
                                    
                                    </tbody>
                                    </table>
                                          
                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    
                                                    <button class="btn btn-primary btn-m" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog verificar -->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal verificar -->
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
                     
@stop

@section('js')
<script type="text/javascript">
	$(document).ready(function() {

		
      $("#verificar").click(function(e){
      		e.preventDefault();
      		
      		var empleados = $("#empleados").val();
      		alert(empleados);
      		if(empleados!=""){

		        var dataString = { 
		              empleados : empleados             
		            };
		        $.ajax({
		            type: "GET",
		            url: "{{ URL::to('empleados/crtm/verificar') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		              if(data){
		                //Vaciar las filas previas de la tabla
	            		$("#infoVerificar").html("");
		                $.each(data,function(index,empleado){
	         	
	         	 		$("#infoVerificar").append('<tr>'+
	                                       '<td>'+empleado.id+'</td>'+
	                                       '<td>'+empleado.nombre+'</td>'+
	                                        '<td>'+empleado.curp+'</td>'+
	                                        '<td>'+empleado.area+'</td>'+
	                                    '</tr>"');
	 
	          		 	});
		                $("#verificarModal").modal();
		                
	                              
	              		}  
		          
		            } ,error: function(xhr, status, error) {
		              alert(error);
		            },
		        });
      		}
      });

	$("#registrar").click(function(){
      		
      		var empleados = $("#empleados").val();
      		var fecha = $("#fecha").val(); 
      		var hora_entrada = $("#hora_entrada").val(); 
      		var hora_salida = $("#hora_salida").val(); 
      		var horas_ordinarias = $("#horas_ordinarias").val(); 
      		var horas_extra = $("#horas_extra").val();
      		var incidencia = $("#incidencia").val();  
      		var comentarios = $("#comentarios").val(); 
      		if(empleados!="" && hora_entrada!="" && hora_salida!="" && horas_ordinarias!=""){
		        var $btn = $(this).button('loading');
		        var dataString = { 
		              empleados : empleados,
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
		            url: "{{ URL::to('empleados/crtm/checada/grupal') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		              if(data>0){
		                //Limpiar campos
		                $("#empleados").val("");
		                $("#horas_ordinarias").val("");
		                $("#hora_entrada").val("");
		                $("#hora_salida").val("");
		                $("#horas_extra").val("");
		                $("#comentarios").val("");
		                $("#incidencia").val("xx");
		                $("#cantidadCC").html(data);
		                
		                $("#success").show(600);
		                
                      	$("#success").delay(2000).hide(600);
	                              
	              		}else{
	              			
	              			$("#error").show(600);
	              			$("#error").delay(2000).hide(600);
	              		} 
	              		$btn.button('reset'); 
		          
		            } ,error: function(xhr, status, error) {
		              
		            },
		        });
      		}else{
      			$("#requerirModal").modal();
      		}
      });

	});
</script>
@stop