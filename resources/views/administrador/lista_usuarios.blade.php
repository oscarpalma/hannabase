@extends('base')
@section('titulo','Administrar Usuarios')
@section('cabezera','Administrar Usuarios')
@section('css')
<style type="text/css">
    
</style>  
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
     
@endsection
@section('content')


	
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
			        <th><p class="text-center">E-Mail</p></th>
			        <th><p class="text-center">Tipo de usuario</p></th>
			        <th><p class="text-center">Acciones</p></th>
			    </tr>

			    @foreach($usuarios as $usuario) 
@if ($usuario->role != '')		

<tr id="{{$usuario->id}}">						
<td>@if(!($usuario == Auth::user())) <input type="checkbox" name="seleccionado" class="select" />@endif </td>
                            
				            <td>{{$usuario->id}}</td>
				            <td >{{$usuario->name}} {{$usuario->last_name}} </td>
				            <td ><p class="text-center">{{$usuario->email}}</p></td>
				            @if ($usuario->role == 'noAsignado')
				            <td style="color:red;"><p class="text-center">{{$usuario->role}}</p></td>
				            @else
				            <td><p class="text-center">{{$usuario->role}}</p></td>
				            @endif
				            @if($usuario == Auth::user())
				            	<td style="color:gray;"><p class="text-center">Usuario Actual</p></td>
				            @else
				            	<td>
                      <div class="form-actions">
				            		<button type="button" class="btn btn-warning btn-sm btn-circle cambiarPrivilegios" title="Cambiar Privilegios" >
                                         <i class="fa fa-shield"></i> 
                                    </button>
                        <!--<button type="button" class="btn btn-primary btn-sm btn-circle verPassword" title="Ver Contraseña" >
                                         <i class="fa fa-key"></i> 
                                    </button>-->
                                    </div>
				            						            	
			            			</td>
				            @endif
			            </tr>
  @endif
			    @endforeach
			</table>
			</div>
      </div>
      </div>
		
	

<!-- Modal eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-danger">
                                            <h4 class="modal-title">Eliminar Usuarios</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> ¿Esta seguro de eliminar al(los) siguiente(s) usuarios(s)?</strong></p>
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoEliminar">
                                    
                                    </tbody>
                                    </table>

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


         <!-- Modal Privilegios -->
<div class="modal fade" id="privilegiosModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-info">
                                            <h4 class="modal-title">Cambiar Privilegios</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong>Usuario </strong></p>
                                           <table class="table table-striped table-bordered table-hover" style='text-transform:uppercase' >
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Privilegio</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoPrivilegios">
                                    
                                    </tbody>
                                    </table>
                                    <hr>
                                     <p><strong>Cambiar Privilegio </strong></p>
                                     <div class="row">
                                     <input class="form-control" name="idUsuario" type="hidden" id="idUsuario" required="">
										
										<div class="col-sm-4">
										<label class="control-label">Tipo de usuario</label>
										<select class="form-control" name="role" id="role">
                      <option value="superusuario">Super Usuario</option>
                      <option value="gerente">Gerente</option>
											<option value="administrador">Administrador</option>
											<option value="coordinador">Coordinador</option>
											<option value="recepcion">Recepcion</option>
											<option value="filtro">Filtro</option>
											<option value="enfermeria">Enfermeria</option>
											<option value="contabilidad">Contabilidad</option>
										</select>
									</div>
									</div>
									<br>
                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="cambiar">Cambiar Privilegio</button>
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
<!-- Pendiente su desarrollo-->
<!-- Modal contraseña -->
<div class="modal fade" id="contraseñaModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-info">
                                            <h4 class="modal-title">Contraseña</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong>La contraseña es:</strong><span id="password"></span></p>
                                           <table class="table table-striped table-bordered table-hover" >
                                    
                                    
                                          <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-primary btn-m" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog contraseña-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal contraseña -->

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
            url: "{{ URL::to('usuarios/baja') }}",
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

    $(".cambiarPrivilegios").click(function(){

        
        var id;
        var nombre;
        var correo;
        var privilegio;
        $(this).parents("tr").each(function(){
                id=$(this).find("td").eq(1).html();
                nombre=$(this).find("td").eq(2).html();
                correo=$(this).find("td").eq(3).html();
                privilegio=$(this).find("td").eq(4).children().html();
                
                });  
        $("#infoPrivilegios").html("");
        $("#infoPrivilegios").append('<tr>'+
                               '<td>'+nombre+'</td>'+
                               '<td>'+correo+'</td>'+
                                '<td id="priv">'+privilegio+'</td>'+
                                '</tr>"'); 
        
        $("#role option").attr("selected",false);
        $("#role option[value="+ privilegio +"]").attr("selected",true);
         $('#idUsuario').val(id);
         $('#privilegiosModal').modal();
       
            
            });

    /*$(".verPassword").click(function(){

        
        var id;
        
        $(this).parents("tr").each(function(){
                id=$(this).find("td").eq(1).html();
                              
                });  
        var dataString = { 
              id : id,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "GET",
            url: "{{ URL::to('usuarios/password') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
                           
              if(data){
                $("#password").html(data);
        
                $('#privilegiosModal').modal();
                                       
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
        
       
            
            });*/

$("#cambiar").click(function(){

        
        var id = $('#idUsuario').val();
        var privilegio = $('#role').val();
        
         
       var dataString = { 
              id : id,
              role:privilegio,
              _token : '{{ csrf_token() }}'
             
            };
            
        if (privilegio!="" ){
        $.ajax({
            type: "POST",
            url: "{{ URL::to('usuarios/privilegio') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
                        
              if(data){
              	
              	
                $("#priv").html(data.role);
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