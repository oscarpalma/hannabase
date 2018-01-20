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

<form class="form-horizontal" role="form" method="POST" action="" id="checada-form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Empleado <text style="color:red">*</text></label>
					<div >
						<select name="empleado" id="empleado" class="form-control" data-live-search="true" required>
							<option value="">Seleccione</option>
							@foreach($empleados as $empleado)
								<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-3">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>" id="fecha" max="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Entrada <text style="color:red">*</text></label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input  name="hora_entrada" class="time_element form-control" id="hora_entrada" value="" required="" />
					</div>
                
				</div>

				<!---->
			    <div class="col-sm-3">
					<label class="control-label">Salida <text style="color:red">*</text></label>
					<div >
						<input   class="form-control" name="hora_salida"  id="hora_salida" value="" required="">
					</div>
				</div>

				<div class="col-sm-3">
					
					<label class="control-label">Horas ordinarias <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias"  id="horas_ordinarias"  value="" required="">
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra"  id="horas_extra" value="0">
					</div>
				
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Entrada </label>
					<div >
					<!--<input type="time"  class="form-control" name="hora_entrada"  id="hora_entrada" value=""  >-->
					<input  name="hora_entrada2" class="time_element form-control" id="hora_entrada2" value="" />
					</div>
                
				</div>

				<!---->
			    <div class="col-sm-3">
					<label class="control-label">Salida </label>
					<div >
						<input   class="form-control" name="hora_salida2"  id="hora_salida2" value="">
					</div>
				</div>

				<div class="col-sm-3">
					
					<label class="control-label">Horas ordinarias </label>
				 	<div >
						<input type="text"  class="form-control" name="horas_ordinarias2"  id="horas_ordinarias2"  value="" >
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Horas Extras</label>
				 	<div >
						<input type="text"  class="form-control" name="horas_extra2"  id="horas_extra2" value="0">
					</div>
				
				</div>
			</div>
			<!--SECCOIN -->

			<hr>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Incidencia</label>
					<select class="form-control" name="incidencia">
						<option value="xx">Ninguna</option>
						<option value="falta_justificada">Falta justificada</option>
						<option value="falta_injustificada">Falta injustificada</option>
						<option value="permiso">Permiso</option>
					</select>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">Comentarios</label>
					<textarea class="form-control" name="comentarios"></textarea>
				</div>
			</div>
			
			<div class="form-actions">
					<button type="button" id="registrar" class="btn btn-primary" data-loading-text="Guardando.." >
						Guardar
					</button>
					
				
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




@stop

@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {

$("#empleado").select2();	
$("#registrar").click(function(){
      		
      		var empleado = $("#empleado").val(); 
      		var fecha = $("#fecha").val(); 
      		var hora_entrada = $("#hora_entrada").val(); 
      		var hora_salida = $("#hora_salida").val(); 
      		var horas_ordinarias = $("#horas_ordinarias").val(); 
      		var horas_extra = $("#horas_extra").val();
      		var hora_entrada2 = $("#hora_entrada2").val(); 
      		var hora_salida2 = $("#hora_salida2").val(); 
      		var horas_ordinarias2 = $("#horas_ordinarias2").val(); 
      		var horas_extra2 = $("#horas_extra2").val();
      		var incidencia = $("#incidencia").val();  
      		var comentarios = $("#comentarios").val(); 
      		if(empleado!="" && hora_entrada!="" && hora_salida!="" && horas_ordinarias!=""){
		        var $btn = $(this).button('loading');
		        var dataString = { 
		              empleado : empleado,
		              fecha : fecha,
		              hora_entrada : hora_entrada,
		              hora_salida : hora_salida,
		              horas_ordinarias : horas_ordinarias,
		              horas_extra : horas_extra,
		              hora_entrada2 : hora_entrada2,
		              hora_salida2 : hora_salida2,
		              horas_ordinarias2 : horas_ordinarias2,
		              horas_extra2 : horas_extra2,
		              incidencia : incidencia,
		              comentarios : comentarios,
		              _token : '{{ csrf_token() }}'
		            };
		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('empleados/crtm/checada/individual') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		              if(data){
		                //Limpiar campos
		                //$("#hora_entrada").val("");
		                //$("#hora_salida").val("");
		                //$("#horas_ordinarias").val("");
		                //$("#horas_extra").val("");
		                $("#comentarios").val("");
		                $("#incidencia").val("xx");
		                //$("#empleado").val("");
		                
	            		$("#success").show(600);
		                
                      	$("#success").delay(2000).hide(600);
		                
	                              
	              		}else{
	              			$("#error").show(600);
	              			$("#error").delay(3000).hide(600);
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