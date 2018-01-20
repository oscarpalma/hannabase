@extends('base')
@section('titulo','Descuentos de comedor')
@section('cabezera','Descuentos de comedor')
@section('css')
<link href="/static/select2/select2.css" rel="stylesheet"> 
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">   
@stop
@section('content')



<form class="form-horizontal" role="form" method="POST" action="{{ route('comedores') }}" id="comedores-form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
				<label class="control-label">Empleados <text style="color:red">*</text></label>
				<div>
						<textarea name="empleados" id="empleados" class="form-control" rows="4" cols="40" placeholder="Números de empleado"></textarea>
						<a href="#" class="aModal" id="verificar"  title="Ayuda a verificar que los numeros de empleados esten correctos" >Verificar</a>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<input class="form-control" type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
					<br>
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">
						Guardar
						</button>
					</div>
					
				</div>

				<div class="col-sm-4">
					<label class="control-label">Cantidad de comedores <text style="color:red">*</text></label>
					<input class="form-control" type="number" name="cantidad">

					
				</div>
			</div>

		</div>
	</div>
</form>

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
                                            <th>Estado</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoVerificar">
                                    
                                    </tbody>
                                    </table>
                                    <p class="text-warning"><strong><span class="fa fa-warning" aria-hidden="true"></span> Recuerde que a los candidatos no se les registrará el comedor </strong></p>
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

<!--Hacer que los textarea no puedan ser cambiados de tamano-->
<style type="text/css">
	textarea {
    resize: none;
}
</style>

@endsection

@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script type="text/javascript">
	$("#empleado").select2();
	$("#verificar").click(function(e){
      		e.preventDefault();
      		var empleados = $("#empleados").val();
      		if(empleados!=""){
		        var dataString = { 
		              empleados : empleados             
		            };
		        $.ajax({
		            type: "GET",
		            url: "{{ URL::to('empleados/verificar') }}",
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
	                                        '<td>'+empleado.estado+'</td>'+
	                                    '</tr>"');
	 
	          		 	});
		                $("#verificarModal").modal();
		                
	                              
	              		}  
		          
		            } ,error: function(xhr, status, error) {
		              
		            },
		        });
      		}
      });
</script>
@endsection