@extends('base')
@section('titulo','Lista de Clientes')
@section('cabezera','Lista de Clientes')
@section('css')
<style type="text/css">
    
</style>  
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
    
@endsection
@section('content')

		
		@if ( empty ( $clientes ) ) 
				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No hay Clientes Registrados<br><br> 
					
				</div>
			@else
			<div class="row">
                    <div class="col-sm-4">
                        <input id="buscar" class="form-control" placeholder="Busqueda">
                    </div>
                    <div class="form-group right">
                    <div class="pull-right" >
                         
                        <button type="button" class="btn btn-danger" id="eliminar" title="Eliminar" style="margin-right: 15px;">
                         <i class="fa fa-trash"></i> 
                        </button>

                        </div>
                    
                </div>
                    <br><br>
                </div>
      <div class="panel panel-primary">
                        <div class="panel-heading"></div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
		<div class="tabla">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
			    <tr>
			    	<th><input type="checkbox" id="selecTodo" /></th>
                                     
			        <th>#</th>
			        <th>Nombre</th>
			        <th>Direccion</th>
			        <th>Telefono</th>
			        <th>Contacto</th>
			        <th><div class="form-actions">Acciones</div></th>
			    </tr>

			    @foreach($clientes as $cliente) 
				        <tr id="{{$cliente->idCliente}}">
				        	<td> <input type="checkbox" name="seleccionado" class="select" /> </td>
                            <td>{{$cliente->idCliente}}</td>
				            <td >{{$cliente->nombre}}</td>
				            <td >{{$cliente->direccion}}</td>
				            <td>{{$cliente->telefono}}</td>
				            <td>{{$cliente->contacto}}</td>
				            <td><div class="form-actions">
				            	<button type="button" class="btn btn-primary btn-sm btn-circle verTurno" title="Turnos" >
                                         <i class="fa fa-list-ol"></i> 
                                    </button>
				            	</div></td>
			            </tr>
			    @endforeach
			</table>
			</div>
      </div>
      </div>
			@endif
		
	

<!-- Modal eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-danger">
                                            <h4 class="modal-title">Eliminar Clientes</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> ¿Esta seguro de eliminar al(los) siguiente(s) clientes(s)?</strong></p>
                                          <div class="tabla-modal">
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoEliminar">
                                    
                                    </tbody>
                                    </table>
                                    </div>

                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="confirmacionEliminar">Si</button>
                                                    <button class="btn btn-danger btn-m" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog eliminar-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal eliminar -->

         <!-- Modal Turnos -->
<div class="modal fade" id="turnosModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-info">
                                            <h4 class="modal-title">Agregar Turnos</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong>Lista de turnos </strong></p>
                                          <div class="tabla-modal">
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Horas Trabajadas</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoTurnos">
                                    
                                    </tbody>
                                    </table>
                                    </div>
                                    <hr>
                                     <p><strong>Agregar Turno </strong></p>
                                     <div class="row">
                                     <input class="form-control" name="idCliente" type="hidden" id="idCliente" required="">
										
										<div class="col-sm-4">
											<label class="control-label">Hora de entrada <text style="color:red">*</text></label>
											<input class="form-control" name="hora_entrada" id="hora_entrada" type="time" required="">
										</div>

										<div class="col-sm-4">
											<label class="control-label">Hora de salida <text style="color:red">*</text></label>
											<input class="form-control" name="hora_salida" id="hora_salida" type="time" required="">
										</div>

										<div class="col-sm-4">
											<label class="control-label">Horas de trabajo <text style="color:red">*</text></label>
											<input class="form-control" name="horas_trabajadas" id="horas_trabajadas" required="">
										</div>
									</div>
									<br>
                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="agregar">Agregar</button>
                                                    <button class="btn btn-primary btn-m" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog eliminar-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal eliminar -->

@endsection

@section('js')

    <script>
    $(document).ready(function() {
       
     var ids=[];
     var i=0;
     $("#eliminar").click(function(){
            
            //Vaciar las filas previas de la tabla
            $("#infoEliminar").html("");
            //vaciar arreglo de ids
            ids=[];
            i=0;
            // Obtenemos todos los valores contenidos en los <td> de las fila
            // seleccionadas
            $(".select:checked").parents("tr").each(function(){
               ids[i]=$(this).find("td").eq(1).html();
                $("#infoEliminar").append('<tr>'+
                                       '<td>'+$(this).find("td").eq(1).html()+'</td>'+
                                       '<td>'+$(this).find("td").eq(2).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(3).html()+'</td>'+
                                        '</tr>"');
                i++;
                });
            if(i>0)
                $('#eliminarModal').modal();
            });


$("#confirmacionEliminar").on("click",function() {
      
      $( "#load" ).show();
       var dataString = { 
              id : ids,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('clientes/baja') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
             
              if(data){
                $('#eliminarModal').modal('toggle');
                $.each(ids, function(key,value){
                    $("#"+value).fadeOut();
                });
                              
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });



    $("#selecTodo").click(function(){
        if($(".select").prop("checked")){
            $(".select").prop("checked", false);
        }else{
            $(".select").prop("checked", true);
        }
        
    });

    $(".verTurno").click(function(){

        
        var id;
        $(this).parents("tr").each(function(){
                id=$(this).find("td").eq(1).html();
                
                });   
       var dataString = { 
              id : id
             
            };
        $.ajax({
            type: "GET",
            url: "{{ URL::to('clientes/turnos') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
                        
              if(data){
              	$("#infoTurnos").html("");
              	$.each(data,function(index,turno){
                $("#infoTurnos").append('<tr>'+
                                       '<td>'+turno.hora_entrada+'</td>'+
                                       '<td>'+turno.hora_salida+'</td>'+
                                        '<td>'+turno.horas_trabajadas+'</td>'+
                                        '</tr>"');
                });
                $('#idCliente').val(id);
                $('#turnosModal').modal();
                
                              
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
            
            });

$("#agregar").click(function(){

        
        var id = $('#idCliente').val();
        var hora_entrada = $('#hora_entrada').val();
        var hora_salida = $('#hora_salida').val();
        var horas_trabajadas = $('#horas_trabajadas').val();
         
       var dataString = { 
              id : id,
              hora_entrada,hora_entrada,
              hora_salida, hora_salida,
              horas_trabajadas,horas_trabajadas,
              _token : '{{ csrf_token() }}'
             
            };
           
        if (hora_entrada!="" && hora_salida!="" && horas_trabajadas!=""){
        $.ajax({
            type: "POST",
            url: "{{ URL::to('clientes/turnos') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
                        
              if(data){
              	
              	
                $("#infoTurnos").append('<tr>'+
                                       '<td>'+data.hora_entrada+'</td>'+
                                       '<td>'+data.hora_salida+'</td>'+
                                        '<td>'+data.horas_trabajadas+'</td>'+
                                        '</tr>"');
          	}
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    }
            
            });

  });

    </script>

    
@endsection